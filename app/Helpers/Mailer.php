<?php
declare(strict_types=1);

namespace App\Helpers;

/**
 * Mailer Helper for Elite Homez
 * Handles luxury transactional email notifications for inbound client enquiries
 */
class Mailer {
    public const NOTIFICATION_EMAIL = 'info@elitehomez.com';

    /**
     * Dispatch an email notification to info@elitehomez.com for newly received enquiries
     */
    public static function sendEnquiryNotification(array $enquiryData, int $enquiryId): bool {
        $refId = '#EH-' . str_pad((string) $enquiryId, 5, '0', STR_PAD_LEFT);
        $subject = "Elite Homez Mandate [{$refId}]: {$enquiryData['name']}";
        $to = self::NOTIFICATION_EMAIL;

        $clientName = Format::e($enquiryData['name']);
        $clientEmail = Format::e($enquiryData['email']);
        $clientPhone = Format::e($enquiryData['mobile']);
        $cleanPhone = preg_replace('/[^0-9\+]/', '', $enquiryData['mobile']);
        $waPhone = preg_replace('/[^0-9]/', '', $enquiryData['mobile']);
        $sourcePage = Format::e($enquiryData['source_page'] ?? 'Website General');
        $messageBody = nl2br(Format::e($enquiryData['message'] ?? ''));
        $timestamp = date('d M Y, h:i A') . ' IST';
        $ip = Format::e($enquiryData['ip_address'] ?? 'N/A');

        // Bespoke Luxury HTML Email
        $html = "<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>{$subject}</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #FAF8F4; color: #171A18; margin: 0; padding: 24px; }
        .email-card { max-width: 620px; margin: 0 auto; background: #ffffff; border: 1px solid #D8CDBA; border-radius: 12px; overflow: hidden; box-shadow: 0 8px 30px rgba(23, 26, 24, 0.08); }
        .email-head { background: #243F34; padding: 36px 30px; text-align: center; border-bottom: 3px solid #B99A62; }
        .brand-title { color: #DFCF9F; font-size: 24px; font-weight: 600; letter-spacing: 0.12em; text-transform: uppercase; margin: 0 0 6px 0; }
        .brand-sub { color: rgba(223, 207, 159, 0.8); font-size: 11px; letter-spacing: 0.15em; text-transform: uppercase; margin: 0; }
        .ref-pill { display: inline-block; background: #B99A62; color: #171A18; font-size: 11px; font-weight: 700; padding: 5px 14px; border-radius: 9999px; letter-spacing: 0.08em; text-transform: uppercase; margin-top: 14px; }
        .email-body { padding: 32px 30px; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        .info-table tr td { padding: 11px 12px; border-bottom: 1px solid #F2ECE0; font-size: 13.5px; }
        .info-table tr:last-child td { border-bottom: none; }
        .label-col { width: 35%; color: #4A504B; font-weight: 600; font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.05em; }
        .val-col { color: #171A18; font-weight: 500; }
        .message-section { background: #FAF8F4; border: 1px solid #EAE3D7; border-left: 4px solid #B99A62; padding: 18px 20px; border-radius: 6px; margin: 18px 0; font-size: 14px; line-height: 1.7; color: #2B2F2C; }
        .btn-wa { display: inline-block; background: #25D366; color: #ffffff !important; text-decoration: none; font-size: 12px; font-weight: 700; padding: 11px 22px; border-radius: 6px; letter-spacing: 0.06em; text-transform: uppercase; margin: 6px 4px; }
        .btn-call { display: inline-block; background: #243F34; color: #DFCF9F !important; text-decoration: none; font-size: 12px; font-weight: 700; padding: 11px 22px; border-radius: 6px; letter-spacing: 0.06em; text-transform: uppercase; margin: 6px 4px; }
        .email-foot { background: #F5F1E8; padding: 22px 24px; text-align: center; font-size: 11px; line-height: 1.6; color: #737874; border-top: 1px solid #D8CDBA; }
    </style>
</head>
<body>
    <div class='email-card'>
        <div class='email-head'>
            <div class='brand-title'>Elite Homez</div>
            <div class='brand-sub'>Bespoke South Delhi Property Advisory</div>
            <div class='ref-pill'>New Mandate: {$refId}</div>
        </div>
        <div class='email-body'>
            <table class='info-table'>
                <tr>
                    <td class='label-col'>Unique Reference ID</td>
                    <td class='val-col'><strong>{$refId}</strong></td>
                </tr>
                <tr>
                    <td class='label-col'>Submission Timestamp</td>
                    <td class='val-col'>{$timestamp}</td>
                </tr>
                <tr>
                    <td class='label-col'>Client Legal Name</td>
                    <td class='val-col'><strong>{$clientName}</strong></td>
                </tr>
                <tr>
                    <td class='label-col'>Direct Mobile</td>
                    <td class='val-col'><a href='tel:{$cleanPhone}' style='color: #243F34; text-decoration: none; font-weight: 600;'>{$clientPhone}</a></td>
                </tr>
                <tr>
                    <td class='label-col'>Confidential Email</td>
                    <td class='val-col'><a href='mailto:{$clientEmail}' style='color: #B99A62; text-decoration: underline;'>{$clientEmail}</a></td>
                </tr>
                <tr>
                    <td class='label-col'>Inbound Channel</td>
                    <td class='val-col'>{$sourcePage}</td>
                </tr>
                <tr>
                    <td class='label-col'>Originating IP</td>
                    <td class='val-col' style='font-family: monospace; font-size: 12px;'>{$ip}</td>
                </tr>
            </table>

            <div style='margin-top: 20px;'>
                <div style='font-size: 11.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #4A504B; margin-bottom: 6px;'>
                    Client Parameters &amp; Message Notes:
                </div>
                <div class='message-section'>
                    {$messageBody}
                </div>
            </div>

            <div style='margin-top: 28px; text-align: center;'>
                <a href='https://wa.me/{$waPhone}?text=Hello%20{$clientName}%2C%20thank%20you%20for%20connecting%20with%20Elite%20Homez.%20Regarding%20your%20inbound%20mandate%20({$refId})...' class='btn-wa' target='_blank'>WhatsApp Client</a>
                <a href='tel:{$cleanPhone}' class='btn-call'>Direct Dial</a>
            </div>
        </div>
        <div class='email-foot'>
            <strong>Elite Homez Private Advisory Desk</strong><br>
            225, 2nd Floor, Square One Mall, Saket, New Delhi - 110017 (India)<br>
            Direct: +91 9811044200 | +91 98112 88400 | info@elitehomez.com
        </div>
    </div>
</body>
</html>";

        // Structured MIME Headers
        $headers = [
            'MIME-Version: 1.0',
            'Content-type: text/html; charset=UTF-8',
            'From: Elite Homez Inbound <' . self::NOTIFICATION_EMAIL . '>',
            'Reply-To: ' . $enquiryData['name'] . ' <' . $enquiryData['email'] . '>',
            'X-Mailer: PHP/' . phpversion()
        ];

        // Audit Trail in Local Logs
        $logFile = dirname(__DIR__, 2) . '/logs/enquiries.log';
        $logEntry = sprintf(
            "[%s] Mandate %s: %s <%s> (%s) | Source: %s | IP: %s\n",
            date('Y-m-d H:i:s'),
            $refId,
            $enquiryData['name'],
            $enquiryData['email'],
            $enquiryData['mobile'],
            $enquiryData['source_page'] ?? 'General',
            $enquiryData['ip_address'] ?? 'N/A'
        );
        @file_put_contents($logFile, $logEntry, FILE_APPEND);

        // Safe mail invocation
        try {
            $sent = @mail($to, $subject, $html, implode("\r\n", $headers));
            return (bool) $sent;
        } catch (\Throwable $e) {
            error_log("Elite Homez Mailer Exception: " . $e->getMessage());
            return false;
        }
    }
}
