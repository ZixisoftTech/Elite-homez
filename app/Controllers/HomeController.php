<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\AppBootstrap;
use App\Models\Area;
use App\Models\CarouselSlide;
use App\Models\Property;
use App\Models\Service;
use App\Models\Testimonial;

class HomeController extends Controller {
    public function index(): void {
        AppBootstrap::init();

        $propertyModel = new Property();
        $serviceModel = new Service();
        $areaModel = new Area();
        $testimonialModel = new Testimonial();
        $carouselModel = new CarouselSlide();
        $settingModel = new \App\Models\Setting();

        $carouselSlides = $carouselModel->getActive();
        $featuredProperties = $propertyModel->getFeatured();
        $services = $serviceModel->getHomeServices();
        $areas = $areaModel->getHomeAreas();
        $allAreas = $areaModel->getPublished();
        $allServices = $serviceModel->getPublished();
        $testimonials = $testimonialModel->getPublished();
        $siteSettings = $settingModel->getAllAsMap();
        $homeSettings = $settingModel->getHomeSettings();

        $seo = [
            'title' => !empty($homeSettings['home_seo_title']) ? $homeSettings['home_seo_title'] : 'Elite Homez | Premium Luxury Real Estate Property Advisory',
            'description' => !empty($homeSettings['home_seo_description']) ? $homeSettings['home_seo_description'] : 'Elite Homez — your trust, our responsibility. Over 20 years of trusted advisory in prime luxury residences, villas, and builder floors in Vasant Vihar, Jor Bagh, Golf Links, and Chanakyapuri.',
            'canonical' => '/',
            'type' => 'website'
        ];

        $this->render('home/index', [
            'carouselSlides' => $carouselSlides,
            'featuredProperties' => $featuredProperties,
            'services' => $services,
            'areas' => $areas,
            'allAreas' => $allAreas,
            'allServices' => $allServices,
            'testimonials' => $testimonials,
            'siteSettings' => $siteSettings,
            'home' => $homeSettings,
            'seo' => $seo
        ]);
    }

    public function notFound(): void {
        AppBootstrap::init();
        $this->response->setStatusCode(404);
        $seo = [
            'title' => 'Page Not Found | Elite Homez',
            'description' => 'The property or page you requested could not be located.'
        ];
        $this->render('errors/404', ['seo' => $seo]);
    }
}
