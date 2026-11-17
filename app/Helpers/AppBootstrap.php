<?php
declare(strict_types=1);

namespace App\Helpers;

use App\Core\View;
use App\Models\Area;
use App\Models\Service;
use App\Models\Setting;

class AppBootstrap {
    private static bool $bootstrapped = false;

    public static function init(): void {
        if (self::$bootstrapped) {
            return;
        }

        try {
            $settingModel = new Setting();
            $areaModel = new Area();
            $serviceModel = new Service();

            $settings = $settingModel->getAllAsMap();
            $navAreas = $areaModel->getPublished();
            $navServices = $serviceModel->getPublished();

            View::share('siteSettings', $settings);
            View::share('navAreas', $navAreas);
            View::share('navServices', $navServices);
        } catch (\Throwable $e) {
            // If DB is temporarily not ready or during CLI tests, fallback gracefully
            View::share('siteSettings', []);
            View::share('navAreas', []);
            View::share('navServices', []);
        }

        self::$bootstrapped = true;
    }
}
