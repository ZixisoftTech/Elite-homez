<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\AppBootstrap;
use App\Models\Area;
use App\Models\Property;
use App\Models\Setting;

class AreaController extends Controller {
    /**
     * Main Service Areas / Locations Listing Page
     * GET /locations and GET /areas
     */
    public function index(): void {
        AppBootstrap::init();

        $areaModel = new Area();
        $areas = $areaModel->getPublishedWithCount();

        $propertyModel = new Property();
        $featuredProperties = $propertyModel->getFeatured();

        $settingsModel = new Setting();
        $siteSettings = $settingsModel->getAllAsMap();

        $seo = [
            'title' => "Prime South Delhi Residential Locations & Enclaves | Elite Homez",
            'description' => "Explore South Delhi's most distinctive residential addresses where Elite Homez advises on luxury properties, independent bungalows, and builder floors.",
            'image' => '/assets/images/areas/vasant-vihar.jpg',
            'canonical' => '/locations'
        ];

        $this->render('areas/index', [
            'areas' => $areas,
            'featuredProperties' => $featuredProperties,
            'siteSettings' => $siteSettings,
            'seo' => $seo
        ]);
    }

    /**
     * Service Area / Location Detail Page
     * GET /locations/{slug} and GET /areas/{slug}
     */
    public function show(string $slug): void {
        AppBootstrap::init();

        $areaModel = new Area();
        $area = $areaModel->findBySlug($slug);

        if (!$area || !(int) $area['is_published']) {
            $this->notFound();
            return;
        }

        // Decode JSON fields safely
        $jsonDecode = function ($val, $default = []) {
            if (empty($val)) return $default;
            if (is_array($val)) return $val;
            $res = json_decode((string)$val, true);
            return is_array($res) ? $res : $default;
        };

        $area['gallery_items'] = $jsonDecode($area['gallery'] ?? null, []);
        $area['property_types_items'] = $jsonDecode($area['property_types'] ?? null, []);
        $area['plot_sizes_items'] = $jsonDecode($area['plot_sizes'] ?? null, []);
        $area['schools_items'] = $jsonDecode($area['schools'] ?? null, []);
        $area['healthcare_items'] = $jsonDecode($area['healthcare'] ?? null, []);
        $area['shopping_items'] = $jsonDecode($area['shopping'] ?? null, []);
        $area['recreation_items'] = $jsonDecode($area['recreation'] ?? null, []);
        $area['faqs_items'] = $jsonDecode($area['faqs'] ?? null, []);
        $area['hero_metrics_items'] = $jsonDecode($area['hero_metrics'] ?? null, []);
        $area['character_highlights_items'] = $jsonDecode($area['character_highlights'] ?? null, []);

        // Retrieve properties located in this specific area
        $properties = $areaModel->getProperties((int) $area['id']);

        // Retrieve adjacent/sibling enclaves for related section
        $allAreas = $areaModel->getPublished();
        $adjacentAreas = array_values(array_filter($allAreas, fn($a) => (int) $a['id'] !== (int) $area['id']));

        $settingsModel = new Setting();
        $siteSettings = $settingsModel->getAllAsMap();

        // Build Schema.org structured data (BreadcrumbList, RealEstateAgent, WebPage, FAQPage)
        $baseUrl = (require dirname(__DIR__, 2) . '/app/Config/config.php')['base_url'] ?? 'http://127.0.0.1:8080';
        $locationUrl = $baseUrl . '/locations/' . $area['slug'];

        $schemaGraph = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => [
                        [
                            '@type' => 'ListItem',
                            'position' => 1,
                            'name' => 'Home',
                            'item' => $baseUrl . '/'
                        ],
                        [
                            '@type' => 'ListItem',
                            'position' => 2,
                            'name' => 'Service Areas',
                            'item' => $baseUrl . '/locations'
                        ],
                        [
                            '@type' => 'ListItem',
                            'position' => 3,
                            'name' => $area['name'],
                            'item' => $locationUrl
                        ]
                    ]
                ],
                [
                    '@type' => 'RealEstateAgent',
                    '@id' => $baseUrl . '/#realestateagent',
                    'name' => 'Elite Homez Private Office',
                    'description' => 'Bespoke ultra-prime real estate advisory and private acquisitions in South Delhi.',
                    'url' => $baseUrl,
                    'areaServed' => [
                        '@type' => 'AdministrativeArea',
                        'name' => $area['name'] . ', New Delhi'
                    ]
                ],
                [
                    '@type' => 'WebPage',
                    '@id' => $locationUrl,
                    'url' => $locationUrl,
                    'name' => !empty($area['seo_title']) ? $area['seo_title'] : "{$area['name']} Luxury Real Estate | Elite Homez",
                    'description' => !empty($area['meta_description']) ? $area['meta_description'] : substr(strip_tags($area['short_description'] ?? ''), 0, 160)
                ]
            ]
        ];

        // Add FAQPage schema if FAQs exist
        if (!empty($area['faqs_items'])) {
            $faqElements = [];
            foreach ($area['faqs_items'] as $faq) {
                if (!empty($faq['question']) && !empty($faq['answer'])) {
                    $faqElements[] = [
                        '@type' => 'Question',
                        'name' => $faq['question'],
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => strip_tags($faq['answer'])
                        ]
                    ];
                }
            }
            if (!empty($faqElements)) {
                $schemaGraph['@graph'][] = [
                    '@type' => 'FAQPage',
                    'mainEntity' => $faqElements
                ];
            }
        }

        $seo = [
            'title' => !empty($area['seo_title']) ? $area['seo_title'] : "{$area['name']} Luxury Real Estate & Homes | Elite Homez",
            'description' => !empty($area['meta_description']) ? $area['meta_description'] : substr(strip_tags($area['short_description'] ?? ''), 0, 160),
            'image' => $area['hero_image'],
            'canonical' => '/locations/' . $area['slug'],
            'og_title' => !empty($area['og_title']) ? $area['og_title'] : ($area['seo_title'] ?? $area['name']),
            'og_description' => !empty($area['og_description']) ? $area['og_description'] : ($area['meta_description'] ?? ''),
            'schema_json' => json_encode($schemaGraph, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        ];

        $this->render('areas/detail', [
            'area' => $area,
            'properties' => $properties,
            'adjacentAreas' => $adjacentAreas,
            'siteSettings' => $siteSettings,
            'seo' => $seo
        ]);
    }

    private function notFound(): void {
        $this->response->setStatusCode(404);
        $this->render('errors/404', [
            'seo' => [
                'title' => 'Area Not Found | Elite Homez',
                'description' => 'The area of expertise requested could not be located.'
            ]
        ]);
    }
}
