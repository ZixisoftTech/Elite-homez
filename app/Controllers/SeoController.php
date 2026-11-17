<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Area;
use App\Models\Property;
use App\Models\Service;

class SeoController extends Controller {
    public function sitemap(): void {
        $config = require dirname(__DIR__) . '/Config/config.php';
        $baseUrl = rtrim($config['base_url'], '/');

        $propertyModel = new Property();
        $areaModel = new Area();
        $serviceModel = new Service();

        $properties = $propertyModel->getCatalogue('all');
        $areas = $areaModel->getPublished();
        $services = $serviceModel->getPublished();

        $this->response->setHeader('Content-Type', 'application/xml; charset=UTF-8');

        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Core Static Pages
        $staticRoutes = [
            ['loc' => '/', 'priority' => '1.0', 'changefreq' => 'daily'],
            ['loc' => '/properties', 'priority' => '0.9', 'changefreq' => 'daily'],
            ['loc' => '/locations', 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['loc' => '/about-us', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => '/contact-us', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => '/privacy-policy', 'priority' => '0.3', 'changefreq' => 'yearly'],
            ['loc' => '/terms-and-disclaimer', 'priority' => '0.3', 'changefreq' => 'yearly'],
        ];

        foreach ($staticRoutes as $page) {
            echo "  <url>\n";
            echo "    <loc>" . htmlspecialchars($baseUrl . $page['loc']) . "</loc>\n";
            echo "    <changefreq>{$page['changefreq']}</changefreq>\n";
            echo "    <priority>{$page['priority']}</priority>\n";
            echo "  </url>\n";
        }

        // Properties
        foreach ($properties as $prop) {
            echo "  <url>\n";
            echo "    <loc>" . htmlspecialchars($baseUrl . '/properties/' . $prop['slug']) . "</loc>\n";
            echo "    <lastmod>" . date('Y-m-d', strtotime($prop['updated_at'] ?? 'now')) . "</lastmod>\n";
            echo "    <changefreq>weekly</changefreq>\n";
            echo "    <priority>0.9</priority>\n";
            echo "  </url>\n";
        }

        // Areas of Expertise / Locations
        foreach ($areas as $area) {
            echo "  <url>\n";
            echo "    <loc>" . htmlspecialchars($baseUrl . '/locations/' . $area['slug']) . "</loc>\n";
            echo "    <lastmod>" . date('Y-m-d', strtotime($area['updated_at'] ?? 'now')) . "</lastmod>\n";
            echo "    <changefreq>weekly</changefreq>\n";
            echo "    <priority>0.85</priority>\n";
            echo "  </url>\n";
            echo "  <url>\n";
            echo "    <loc>" . htmlspecialchars($baseUrl . '/areas/' . $area['slug']) . "</loc>\n";
            echo "    <lastmod>" . date('Y-m-d', strtotime($area['updated_at'] ?? 'now')) . "</lastmod>\n";
            echo "    <changefreq>weekly</changefreq>\n";
            echo "    <priority>0.85</priority>\n";
            echo "  </url>\n";
        }

        // Services
        foreach ($services as $serv) {
            echo "  <url>\n";
            echo "    <loc>" . htmlspecialchars($baseUrl . '/services/' . $serv['slug']) . "</loc>\n";
            echo "    <lastmod>" . date('Y-m-d', strtotime($serv['updated_at'] ?? 'now')) . "</lastmod>\n";
            echo "    <changefreq>monthly</changefreq>\n";
            echo "    <priority>0.8</priority>\n";
            echo "  </url>\n";
        }

        echo '</urlset>';
        exit;
    }

    public function robots(): void {
        $config = require dirname(__DIR__) . '/Config/config.php';
        $baseUrl = rtrim($config['base_url'], '/');

        $this->response->setHeader('Content-Type', 'text/plain; charset=UTF-8');
        echo "User-agent: *\n";
        echo "Allow: /\n";
        echo "Disallow: /admin/\n";
        echo "Disallow: /uploads/temp/\n";
        echo "\n";
        echo "Sitemap: {$baseUrl}/sitemap.xml\n";
        exit;
    }
}
