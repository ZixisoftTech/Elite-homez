<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\AppBootstrap;
use App\Models\Area;
use App\Models\Service;
use App\Models\Setting;

class ContactController extends Controller {
    public function index(): void {
        AppBootstrap::init();

        $areaModel = new Area();
        $serviceModel = new Service();
        $settingModel = new Setting();

        $areas = $areaModel->getPublished();
        $services = $serviceModel->getPublished();
        $siteSettings = $settingModel->getAllAsMap();

        $seo = [
            'title' => 'Contact Our Senior Property Advisors | Elite Homez',
            'description' => 'Connect directly with our senior real estate advisors for confidential property acquisitions, private divestments, and site viewings in Delhi.',
            'canonical' => '/contact-us'
        ];

        $this->render('contact/index', [
            'seo' => $seo,
            'areas' => $areas,
            'services' => $services,
            'siteSettings' => $siteSettings
        ]);
    }
}
