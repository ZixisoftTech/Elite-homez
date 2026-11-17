<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\Csrf;
use App\Helpers\Session;
use App\Models\Enquiry;

class EnquiryController extends Controller {
    private const RATE_LIMIT_MAX = 3;
    private const RATE_LIMIT_WINDOW = 300; // 5 minutes

    public function store(): void {
        $isAjax = $this->request->isAjax();

        // 1. CSRF Verification
        $token = (string) $this->request->post('csrf_token', '');
        if (!Csrf::validate($token)) {
            $this->respondError('Security validation failed. Please refresh the page and try again.', 403, $isAjax);
            return;
        }

        // 2. Anti-Spam Honeypot Verification
        $honeypot = (string) $this->request->post('website_url_check', '');
        if (!empty($honeypot)) {
            // Silently discard bot spam with successful appearance
            if ($isAjax) {
                $this->json(['success' => true, 'message' => 'Thank you. Your enquiry has been received.']);
            }
            $this->redirect($_SERVER['HTTP_REFERER'] ?? '/');
            return;
        }

        // 3. IP Rate Limiting Check
        $ip = $this->request->ip();
        if ($this->isRateLimited($ip)) {
            $this->respondError('You have submitted multiple enquiries recently. Please wait a few minutes before submitting another.', 429, $isAjax);
            return;
        }

        // 4. Data Extraction & Validation
        $name = trim((string) $this->request->post('name', ''));
        $mobile = trim((string) ($this->request->post('mobile') ?? $this->request->post('phone') ?? ''));
        $email = trim((string) $this->request->post('email', ''));
        $message = trim((string) $this->request->post('message', ''));
        $propertyId = $this->request->post('property_id');
        $areaId = $this->request->post('area_id');
        $sourcePage = trim((string) $this->request->post('source_page', 'Website General'));

        // Extra dynamic context fields from specialized forms
        $enquiryType = trim((string) $this->request->post('enquiry_type', ''));
        $serviceChoice = trim((string) ($this->request->post('service_choice') ?? $this->request->post('service') ?? ''));
        $enclaveChoice = trim((string) ($this->request->post('enclave_choice') ?? $this->request->post('enclave') ?? ''));
        $timelineChoice = trim((string) ($this->request->post('timeline_choice') ?? $this->request->post('timeline') ?? ''));
        $ndaRequested = $this->request->post('nda_requested');

        // Resolve area_id by name if not provided directly
        if (empty($areaId) && !empty($enclaveChoice) && $enclaveChoice !== 'Other South Delhi Enclave') {
            try {
                $areaModel = new \App\Models\Area();
                $foundArea = $areaModel->findBy('name', $enclaveChoice);
                if ($foundArea) {
                    $areaId = (int) $foundArea['id'];
                }
            } catch (\Throwable $e) {
                // Ignore fallback error
            }
        }

        // Prepend structured inquiry parameters to message for full administrative context
        $extraContext = [];
        if (!empty($enquiryType)) $extraContext[] = "Mandate: {$enquiryType}";
        if (!empty($serviceChoice)) $extraContext[] = "Service: {$serviceChoice}";
        if (!empty($enclaveChoice)) $extraContext[] = "Enclave: {$enclaveChoice}";
        if (!empty($timelineChoice)) $extraContext[] = "Timeline: {$timelineChoice}";
        if (!empty($ndaRequested)) $extraContext[] = "Bilateral NDA Requested: Yes";

        if (!empty($extraContext)) {
            $contextHeader = "[" . implode(" | ", $extraContext) . "]\n\n";
            if (!str_contains($message, $extraContext[0])) {
                $message = $contextHeader . $message;
            }
        }

        if (empty($name) || strlen($name) < 2) {
            $this->respondError('Please enter your full legal name.', 422, $isAjax);
            return;
        }

        if (empty($mobile) || !preg_match('/^[0-9\+\-\s\(\)]{8,20}$/', $mobile)) {
            $this->respondError('Please enter a valid telephone or mobile contact number.', 422, $isAjax);
            return;
        }

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->respondError('Please provide a valid email address for confidential correspondence.', 422, $isAjax);
            return;
        }

        if (empty($message) || strlen($message) < 3) {
            $this->respondError('Please provide brief parameters regarding your property requirements.', 422, $isAjax);
            return;
        }

        // 5. Persist Lead to Database
        $enquiryModel = new Enquiry();
        $enquiryData = [
            'name' => $name,
            'mobile' => $mobile,
            'email' => strtolower($email),
            'message' => $message,
            'property_id' => !empty($propertyId) ? (int) $propertyId : null,
            'area_id' => !empty($areaId) ? (int) $areaId : null,
            'source_page' => substr($sourcePage, 0, 255),
            'status' => 'new',
            'ip_address' => $ip,
            'user_agent' => $this->request->userAgent()
        ];
        $enquiryId = $enquiryModel->create($enquiryData);

        // 6. Dispatch Confidential Email Notification to info@elitehomez.com
        \App\Helpers\Mailer::sendEnquiryNotification($enquiryData, $enquiryId);

        $this->recordRateAttempt($ip);

        $refId = '#EH-' . str_pad((string) $enquiryId, 5, '0', STR_PAD_LEFT);
        $successMsg = "Thank you for your enquiry. Your mandate reference is {$refId}. A senior Elite Homez property advisor will contact you shortly under strict bilateral confidentiality.";
        if ($isAjax) {
            $this->json([
                'success' => true, 
                'message' => $successMsg,
                'reference_id' => $refId,
                'enquiry_id' => $enquiryId
            ]);
            return;
        }

        Session::setFlash('success', $successMsg);
        $redirectUrl = (string) $this->request->post('return_url', $_SERVER['HTTP_REFERER'] ?? '/contact-us');
        $this->redirect($redirectUrl);
    }

    private function respondError(string $message, int $code, bool $isAjax): void {
        if ($isAjax) {
            $this->json(['success' => false, 'message' => $message, 'error' => $message], $code);
            return;
        }
        Session::setFlash('error', $message);
        $this->redirect($_SERVER['HTTP_REFERER'] ?? '/contact-us');
    }

    private function isRateLimited(string $ip): bool {
        $key = 'enquiry_rate_' . md5($ip);
        $data = Session::get($key);
        if (!$data) {
            return false;
        }
        if ($data['count'] >= self::RATE_LIMIT_MAX) {
            if (time() - $data['first_attempt'] < self::RATE_LIMIT_WINDOW) {
                return true;
            }
            Session::remove($key);
        }
        return false;
    }

    private function recordRateAttempt(string $ip): void {
        $key = 'enquiry_rate_' . md5($ip);
        $data = Session::get($key, ['count' => 0, 'first_attempt' => time()]);
        $data['count']++;
        Session::set($key, $data);
    }
}
