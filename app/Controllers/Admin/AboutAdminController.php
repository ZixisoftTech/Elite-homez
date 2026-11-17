<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Helpers\Csrf;
use App\Helpers\Session;
use App\Helpers\Uploader;
use App\Models\Setting;

class AboutAdminController extends Controller {
    public function index(): void {
        $this->requireAuth();

        $settingModel = new Setting();
        $about = $settingModel->getAboutSettings();
        $generalSettings = $settingModel->getAllAsMap();

        $this->renderAdmin('admin/about/index', [
            'about' => $about,
            'generalSettings' => $generalSettings,
            'seo' => [
                'title' => 'About Us Page Editor | Elite Homez Admin'
            ]
        ]);
    }

    public function update(): void {
        $this->requireAuth();

        $token = (string) $this->request->post('csrf_token', '');
        if (!Csrf::validate($token)) {
            Session::setFlash('error', 'Invalid security token. Please refresh and try again.');
            $this->redirect('/admin/about');
            return;
        }

        $settingModel = new Setting();
        $defaults = Setting::getDefaultAboutSettings();
        $current = $settingModel->getAboutSettings();

        // Image file upload processing
        $imageFields = [
            'about_hero_image' => 'about_hero_image_file',
            'about_story_image_primary' => 'about_story_image_primary_file',
            'about_story_image_secondary' => 'about_story_image_secondary_file',
            'about_philosophy_image' => 'about_philosophy_image_file',
            'about_director_image' => 'about_director_image_file',
            'about_cta_image' => 'about_cta_image_file'
        ];

        $uploadedUrls = [];
        foreach ($imageFields as $settingKey => $fileInputName) {
            $file = $this->request->file($fileInputName);
            if ($file && isset($file['error']) && $file['error'] === UPLOAD_ERR_OK) {
                $upload = Uploader::uploadImage($file, 'about');
                if ($upload['success']) {
                    $uploadedUrls[$settingKey] = $upload['url'];
                } else {
                    Session::setFlash('error', 'Image upload failed for ' . $settingKey . ': ' . $upload['message']);
                    $this->redirect('/admin/about');
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
                    'about_hero_title', 'about_story_title', 'about_stats_title',
                    'about_philosophy_title', 'about_why_title', 'about_areas_title',
                    'about_director_title', 'about_reviews_title', 'about_cta_title'
                ], true)) {
                    // Do not allow empty essential headings, fallback to default
                    $val = $defaultVal;
                }
            }
            $settingModel->setVal($key, $val, 'about');
        }

        Session::setFlash('success', 'About Us page sections and content updated successfully.');
        $this->redirect('/admin/about');
    }
}
