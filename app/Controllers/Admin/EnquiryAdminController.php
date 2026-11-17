<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Helpers\Csrf;
use App\Helpers\Session;
use App\Models\Enquiry;

class EnquiryAdminController extends Controller {
    public function index(): void {
        $this->requireAuth();
        $enquiryModel = new Enquiry();

        $status = strtolower((string) $this->request->get('status', ''));
        $enquiries = $enquiryModel->allWithContext($status);

        $this->renderAdmin('admin/enquiries/index', [
            'enquiries' => $enquiries,
            'currentStatus' => $status,
            'seo' => ['title' => 'Client Lead Inbox | Elite Homez Admin']
        ]);
    }

    public function show(string $id): void {
        $this->requireAuth();
        $enquiryModel = new Enquiry();
        $enquiry = $enquiryModel->find((int) $id);

        if (!$enquiry) {
            Session::setFlash('error', 'Enquiry record not found.');
            $this->redirect('/admin/enquiries');
            return;
        }

        // If new, mark as contacted or viewed
        $this->renderAdmin('admin/enquiries/show', [
            'enquiry' => $enquiry,
            'seo' => ['title' => "Enquiry from {$enquiry['name']} | Elite Homez"]
        ]);
    }

    public function updateStatus(string $id): void {
        $this->requireAuth();
        $token = (string) $this->request->post('csrf_token', '');
        if (!Csrf::validate($token)) {
            Session::setFlash('error', 'CSRF token invalid.');
            $this->redirect('/admin/enquiries');
            return;
        }

        $status = (string) $this->request->post('status', 'new');
        $enquiryModel = new Enquiry();
        $enquiryModel->updateStatus((int) $id, $status);

        Session::setFlash('success', "Enquiry status updated to " . ucfirst($status) . ".");
        $this->redirect($this->request->post('return_url', '/admin/enquiries'));
    }

    public function delete(string $id): void {
        $this->requireAuth();
        $token = (string) $this->request->post('csrf_token', '');
        if (!Csrf::validate($token)) {
            Session::setFlash('error', 'CSRF token invalid.');
            $this->redirect('/admin/enquiries');
            return;
        }

        $enquiryModel = new Enquiry();
        $enquiryModel->delete((int) $id);
        Session::setFlash('success', 'Enquiry record deleted.');
        $this->redirect('/admin/enquiries');
    }
}
