<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Helpers\Csrf;
use App\Helpers\Session;
use App\Models\Setting;

class SettingsAdminController extends Controller {
    public function index(): void {
        $this->requireAuth();
        $settingModel = new Setting();
        $settings = $settingModel->getAllAsMap();

        $this->renderAdmin('admin/settings/index', [
            'settings' => $settings,
            'seo' => ['title' => 'System & Brand Settings | Elite Homez']
        ]);
    }

    public function update(): void {
        $this->requireAuth();
        $token = (string) $this->request->post('csrf_token', '');
        if (!Csrf::validate($token)) {
            Session::setFlash('error', 'CSRF token invalid.');
            $this->redirect('/admin/settings');
            return;
        }

        $fields = [
            'site_name' => 'general',
            'site_tagline' => 'general',
            'phone_primary' => 'contact',
            'phone_secondary' => 'contact',
            'whatsapp_number' => 'contact',
            'whatsapp_display' => 'contact',
            'email_primary' => 'contact',
            'office_address' => 'contact',
            'google_maps_url' => 'contact',
            'footer_brand_text' => 'footer',
            'default_seo_title' => 'seo',
            'default_meta_description' => 'seo',
            'experience_years' => 'company'
        ];

        $settingModel = new Setting();
        foreach ($fields as $key => $group) {
            $val = trim((string) $this->request->post($key, ''));
            $settingModel->setVal($key, $val, $group);
        }

        Session::setFlash('success', 'System settings saved successfully.');
        $this->redirect('/admin/settings');
    }
}
