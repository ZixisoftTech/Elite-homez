<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\AppBootstrap;
use App\Helpers\SeoHelper;
use App\Models\Area;
use App\Models\Feature;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\Setting;

class PropertyController extends Controller {
    public function index(): void {
        AppBootstrap::init();

        $propertyModel = new Property();
        $areaModel = new Area();
        $settingModel = new Setting();

        $tab = strtolower((string) $this->request->get('type', 'all'));
        if (!in_array($tab, ['all', 'sale', 'rent'], true)) {
            $tab = 'all';
        }
        $area = (string) $this->request->get('area', '');
        $category = (string) $this->request->get('category', '');
        $search = trim((string) $this->request->get('q', ''));
        $price = (string) $this->request->get('price', '');
        $sort = (string) $this->request->get('sort', 'featured');

        $counts = $propertyModel->getCatalogueCounts();
        $properties = $propertyModel->getCatalogue($tab, $area, $category, $search, $price, $sort);
        $areas = $areaModel->getPublished();
        $siteSettings = $settingModel->getAllAsMap();

        // All properties stream directly into the curated 3-column portfolio grid
        $hasActiveFilter = (!empty($area) && $area !== 'all') || (!empty($category) && $category !== 'all') || !empty($search) || (!empty($price) && $price !== 'all');
        $showcaseProperty = null;
        $gridProperties = $properties;

        $seo = [
            'title' => 'Curated Luxury Properties Catalogue | Elite Homez',
            'description' => 'Explore exceptional residences, private bungalows, and luxury builder floors across South Delhi premier enclaves.',
            'canonical' => '/properties'
        ];

        $this->render('properties/index', [
            'properties' => $properties,
            'showcaseProperty' => $showcaseProperty,
            'gridProperties' => $gridProperties,
            'counts' => $counts,
            'areas' => $areas,
            'currentTab' => $tab,
            'currentArea' => $area,
            'currentCategory' => $category,
            'currentSearch' => $search,
            'currentPrice' => $price,
            'currentSort' => $sort,
            'hasActiveFilter' => $hasActiveFilter,
            'siteSettings' => $siteSettings,
            'seo' => $seo
        ]);
    }

    public function show(string $slug): void {
        AppBootstrap::init();

        $propertyModel = new Property();
        $settingModel = new Setting();
        $property = $propertyModel->findBySlugWithDetails($slug);

        if (!$property || $property['status'] !== 'published') {
            $this->notFound();
            return;
        }

        $imageModel = new PropertyImage();
        $featureModel = new Feature();

        $galleryImages = $imageModel->getByProperty((int) $property['id']);
        $features = $featureModel->getByProperty((int) $property['id']);
        $similarProperties = $propertyModel->getSimilar((int) $property['id'], (int) $property['area_id'], 3);
        $siteSettings = $settingModel->getAllAsMap();

        $seo = [
            'title' => !empty($property['seo_title']) ? $property['seo_title'] : "{$property['title']} | Elite Homez",
            'description' => !empty($property['meta_description']) ? $property['meta_description'] : substr(strip_tags($property['description']), 0, 160),
            'image' => $property['featured_image'],
            'canonical' => '/properties/' . $property['slug'],
            'schema' => SeoHelper::buildPropertySchema($property, $property['area_name'])
        ];

        $this->render('properties/detail', [
            'property' => $property,
            'galleryImages' => $galleryImages,
            'features' => $features,
            'similarProperties' => $similarProperties,
            'siteSettings' => $siteSettings,
            'seo' => $seo
        ]);
    }

    private function notFound(): void {
        $this->response->setStatusCode(404);
        $this->render('errors/404', [
            'seo' => [
                'title' => 'Property Not Found | Elite Homez',
                'description' => 'The luxury property you are inquiring about is no longer listed or has been removed.'
            ]
        ]);
    }
}
