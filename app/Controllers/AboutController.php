<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\AppBootstrap;
use App\Models\Area;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Testimonial;

class AboutController extends Controller {
    public function index(): void {
        AppBootstrap::init();

        $areaModel = new Area();
        $serviceModel = new Service();
        $settingModel = new Setting();
        $testimonialModel = new Testimonial();

        $areas = $areaModel->getPublished();
        $services = $serviceModel->getPublished();
        $testimonials = $testimonialModel->getPublished();
        $siteSettings = $settingModel->getAllAsMap();
        $about = $settingModel->getAboutSettings();

        $seo = [
            'title' => !empty($about['about_seo_title']) ? $about['about_seo_title'] : 'About Elite Homez | Where Exceptional Homes Meet Exceptional Experiences',
            'description' => !empty($about['about_seo_description']) ? $about['about_seo_description'] : 'Discover Elite Homez — two decades of trusted advisory, unparalleled discretion, and personalised luxury real estate expertise across South Delhi.',
            'canonical' => '/about-us'
        ];

        $this->render('about/index', [
            'seo' => $seo,
            'areas' => $areas,
            'services' => $services,
            'testimonials' => $testimonials,
            'siteSettings' => $siteSettings,
            'about' => $about
        ]);
    }
}
