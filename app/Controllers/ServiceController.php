<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\AppBootstrap;
use App\Models\Service;

class ServiceController extends Controller {
    public function index(): void {
        AppBootstrap::init();

        $serviceModel = new Service();
        $services = $serviceModel->getPublished();

        $settingsModel = new \App\Models\Setting();
        $siteSettings = $settingsModel->getAllAsMap();

        $seo = [
            'title' => 'Private Client Real Estate Advisory Services | Elite Homez',
            'description' => 'Comprehensive buy-side representation, confidential sales mandates, diplomatic leasing, and portfolio asset management across South Delhi prime enclaves.',
            'canonical' => '/services'
        ];

        $this->render('services/index', [
            'services' => $services,
            'siteSettings' => $siteSettings,
            'seo' => $seo
        ]);
    }

    public function show(string $slug): void {
        AppBootstrap::init();

        $serviceModel = new Service();

        // Shorthand and legacy slug mapping for resilience
        $slugAliases = [
            'buy-property' => 'luxury-property-buying-advisory',
            'sell-property' => 'luxury-property-selling-mandate',
            'rent-property' => 'diplomatic-executive-leasing',
            'property-advisory' => 'real-estate-portfolio-advisory'
        ];

        $targetSlug = $slugAliases[$slug] ?? $slug;
        $service = $serviceModel->findBySlug($targetSlug);
        if (!$service) {
            $service = $serviceModel->findBySlug($slug);
        }

        if (!$service || !(int) $service['is_published']) {
            $this->notFound();
            return;
        }

        // Fetch sibling services for related section
        $allServices = $serviceModel->getPublished();
        $relatedServices = array_values(array_filter($allServices, fn($s) => (int) $s['id'] !== (int) $service['id']));

        $areaModel = new \App\Models\Area();
        $allAreas = $areaModel->getPublished();

        $settingsModel = new \App\Models\Setting();
        $siteSettings = $settingsModel->getAllAsMap();

        $seo = [
            'title' => !empty($service['seo_title']) ? $service['seo_title'] : "{$service['name']} | Elite Homez Advisory",
            'description' => !empty($service['meta_description']) ? $service['meta_description'] : substr(strip_tags($service['short_description']), 0, 160),
            'image' => $service['image'],
            'canonical' => '/services/' . $service['slug']
        ];

        $this->render('services/detail', [
            'service' => $service,
            'relatedServices' => $relatedServices,
            'allAreas' => $allAreas,
            'siteSettings' => $siteSettings,
            'seo' => $seo
        ]);
    }

    private function notFound(): void {
        $this->response->setStatusCode(404);
        $this->render('errors/404', [
            'seo' => [
                'title' => 'Service Not Found | Elite Homez',
                'description' => 'The advisory service requested could not be located.'
            ]
        ]);
    }
}
