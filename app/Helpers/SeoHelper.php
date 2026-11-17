<?php
declare(strict_types=1);

namespace App\Helpers;

class SeoHelper {
    public static function renderTags(array $seo = []): string {
        $config = require dirname(__DIR__) . '/Config/config.php';
        $baseUrl = rtrim($config['base_url'], '/');

        $title = !empty($seo['title']) ? $seo['title'] : 'Elite Homez | Luxury Real Estate Advisory Delhi';
        $description = !empty($seo['description']) 
            ? $seo['description'] 
            : 'Elite Homez specializes in prime luxury residential properties, independent villas, builder floors, and estates across Delhi’s most prestigious enclaves.';
        $canonical = !empty($seo['canonical']) ? $seo['canonical'] : $baseUrl . ($_SERVER['REQUEST_URI'] ?? '/');
        $canonical = strtok($canonical, '?'); // strip query parameters for canonical

        $image = !empty($seo['image']) 
            ? (str_starts_with($seo['image'], 'http') ? $seo['image'] : $baseUrl . $seo['image'])
            : $baseUrl . '/assets/images/hero/hero-main.jpg';

        $type = !empty($seo['type']) ? $seo['type'] : 'website';

        $html = "<!-- Primary SEO Meta Tags -->\n";
        $html .= "<title>" . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . "</title>\n";
        $html .= '<meta name="description" content="' . htmlspecialchars($description, ENT_QUOTES, 'UTF-8') . "\">\n";
        $html .= '<link rel="canonical" href="' . htmlspecialchars($canonical, ENT_QUOTES, 'UTF-8') . "\">\n\n";

        $html .= "<!-- Open Graph / Facebook -->\n";
        $html .= '<meta property="og:type" content="' . htmlspecialchars($type, ENT_QUOTES, 'UTF-8') . "\">\n";
        $html .= '<meta property="og:url" content="' . htmlspecialchars($canonical, ENT_QUOTES, 'UTF-8') . "\">\n";
        $html .= '<meta property="og:title" content="' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . "\">\n";
        $html .= '<meta property="og:description" content="' . htmlspecialchars($description, ENT_QUOTES, 'UTF-8') . "\">\n";
        $html .= '<meta property="og:image" content="' . htmlspecialchars($image, ENT_QUOTES, 'UTF-8') . "\">\n\n";

        $html .= "<!-- Twitter -->\n";
        $html .= '<meta name="twitter:card" content="summary_large_image">' . "\n";
        $html .= '<meta name="twitter:title" content="' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . "\">\n";
        $html .= '<meta name="twitter:description" content="' . htmlspecialchars($description, ENT_QUOTES, 'UTF-8') . "\">\n";
        $html .= '<meta name="twitter:image" content="' . htmlspecialchars($image, ENT_QUOTES, 'UTF-8') . "\">\n";

        if (!empty($seo['schema'])) {
            $html .= "\n<!-- Structured Data JSON-LD -->\n";
            $html .= '<script type="application/ld+json">' . "\n";
            $html .= json_encode($seo['schema'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            $html .= "\n</script>\n";
        }

        return $html;
    }

    public static function buildRealEstateAgentSchema(): array {
        $config = require dirname(__DIR__) . '/Config/config.php';
        $baseUrl = rtrim($config['base_url'], '/');

        return [
            '@context' => 'https://schema.org',
            '@type' => 'RealEstateAgent',
            'name' => 'Elite Homez',
            'image' => $baseUrl . '/assets/images/logo.png',
            '@id' => $baseUrl,
            'url' => $baseUrl,
            'telephone' => '+91-9811000000',
            'priceRange' => '₹₹₹₹',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => 'Level 4, Diplomatic Commercial Complex, Malcha Marg, Chanakyapuri',
                'addressLocality' => 'New Delhi',
                'postalCode' => '110021',
                'addressCountry' => 'IN'
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => 28.5983,
                'longitude' => 77.1856
            ],
            'openingHoursSpecification' => [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                'opens' => '09:30',
                'closes' => '19:30'
            ]
        ];
    }

    public static function buildPropertySchema(array $property, string $areaName = ''): array {
        $config = require dirname(__DIR__) . '/Config/config.php';
        $baseUrl = rtrim($config['base_url'], '/');

        $imageUrl = !empty($property['featured_image'])
            ? (str_starts_with($property['featured_image'], 'http') ? $property['featured_image'] : $baseUrl . $property['featured_image'])
            : $baseUrl . '/assets/images/hero/hero-main.jpg';

        return [
            '@context' => 'https://schema.org',
            '@type' => 'SingleFamilyResidence',
            'name' => $property['title'],
            'description' => substr(strip_tags($property['description']), 0, 250),
            'image' => $imageUrl,
            'url' => $baseUrl . '/properties/' . $property['slug'],
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $property['property_location'],
                'addressLocality' => $areaName ?: 'South Delhi',
                'addressRegion' => 'Delhi',
                'addressCountry' => 'IN'
            ],
            'numberOfRooms' => (int) ($property['bedrooms'] ?? 4),
            'numberOfBathroomsTotal' => (int) ($property['bathrooms'] ?? 4),
            'floorSize' => [
                '@type' => 'QuantitativeValue',
                'value' => $property['property_size'] ?? ''
            ]
        ];
    }
}
