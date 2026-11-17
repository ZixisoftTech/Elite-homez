<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Helpers\Csrf;
use App\Helpers\Session;
use App\Helpers\Uploader;
use App\Models\Setting;

class HomeAdminController extends Controller {
    public function index(): void {
        $this->requireAuth();

        $settingModel = new Setting();
        $home = $settingModel->getHomeSettings();
        $generalSettings = $settingModel->getAllAsMap();

        $this->renderAdmin('admin/home/index', [
            'home' => $home,
            'generalSettings' => $generalSettings,
            'seo' => [
                'title' => 'Home Page Editor | Elite Homez Admin'
            ]
        ]);
    }

    public function update(): void {
        $this->requireAuth();

        $token = (string) $this->request->post('csrf_token', '');
        if (!Csrf::validate($token)) {
            Session::setFlash('error', 'Invalid security token. Please refresh and try again.');
            $this->redirect('/admin/home');
            return;
        }

        $settingModel = new Setting();
        $defaults = Setting::getDefaultHomeSettings();
        $current = $settingModel->getHomeSettings();

        // Image file upload processing
        $imageFields = [
            'home_director_image' => 'home_director_image_file',
            'home_cta_image' => 'home_cta_image_file'
        ];

        $uploadedUrls = [];
        foreach ($imageFields as $settingKey => $fileInputName) {
            $file = $this->request->file($fileInputName);
            if ($file && isset($file['error']) && $file['error'] === UPLOAD_ERR_OK) {
                $upload = Uploader::uploadImage($file, 'home');
                if ($upload['success']) {
                    $uploadedUrls[$settingKey] = $upload['url'];
                } else {
                    Session::setFlash('error', 'Image upload failed for ' . $settingKey . ': ' . $upload['message']);
                    $this->redirect('/admin/home');
                    return;
                }
            } else {
                // Check if user manually typed/pasted a URL
                $textUrl = trim((string) $this->request->post($settingKey, ''));
                if (!empty($textUrl)) {
                    $uploadedUrls[$settingKey] = $textUrl;
                } else {
                    $uploadedUrls[$settingKey] = $current[$settingKey] ?? $defaults[$settingKey];
                }
            }
        }

        // Save all settings defined in default schema
        foreach ($defaults as $key => $defaultVal) {
            if (isset($uploadedUrls[$key])) {
                $val = $uploadedUrls[$key];
            } else {
                $val = trim((string) $this->request->post($key, ''));
                if ($val === '' && in_array($key, [
                    'home_manifesto_title', 'home_properties_title', 'home_services_title',
                    'home_why_title', 'home_areas_title', 'home_director_title', 'home_cta_title'
                ], true)) {
                    // Do not allow empty essential headings, fallback to default
                    $val = $defaultVal;
                }
            }
            $settingModel->setVal($key, $val, 'home');
        }

        Session::setFlash('success', 'Home page sections and content updated successfully.');
        $this->redirect('/admin/home');
    }
}
