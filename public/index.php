<?php
declare(strict_types=1);

/**
 * ============================================================
 * ELITE HOMEZ — BESPOKE LUXURY REAL ESTATE PLATFORM
 * Front Controller & Application Entry Point
 * Pure Core PHP Custom MVC Architecture
 * ============================================================
 */

// 1. Set Timezone & Error Handling
date_default_timezone_set('Asia/Kolkata');

// Defense-in-depth: Never expose stack traces to public visitors
ini_set('display_errors', '0');
ini_set('log_errors', '1');
error_reporting(E_ALL);

// 2. Register PSR-4 Style Autoloader
spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    $baseDir = dirname(__DIR__) . '/app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// 3. Initialize Secure Session
\App\Helpers\Session::start();

// 4. Set Defense-in-Depth HTTP Security Headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

// 5. Instantiate Request, Response & Router
$request = new \App\Core\Request();
$response = new \App\Core\Response();
$router = new \App\Core\Router($request, $response);

// ============================================================
// PUBLIC ROUTE DEFINITIONS
// ============================================================

// Home & Errors
$router->get('/', [\App\Controllers\HomeController::class, 'index']);

// Property Catalogue & Detail
$router->get('/properties', [\App\Controllers\PropertyController::class, 'index']);
$router->get('/properties/{slug}', [\App\Controllers\PropertyController::class, 'show']);

// Dynamic Services (Listing & Detail)
$router->get('/services', [\App\Controllers\ServiceController::class, 'index']);
$router->get('/services/{slug}', [\App\Controllers\ServiceController::class, 'show']);

// Dynamic Areas of Expertise / Locations (Listing & Detail)
$router->get('/areas', [\App\Controllers\AreaController::class, 'index']);
$router->get('/locations', [\App\Controllers\AreaController::class, 'index']);
$router->get('/areas/{slug}', [\App\Controllers\AreaController::class, 'show']);
$router->get('/locations/{slug}', [\App\Controllers\AreaController::class, 'show']);

// About Us & Director's Message
$router->get('/about-us', [\App\Controllers\AboutController::class, 'index']);

// Contact Page
$router->get('/contact-us', [\App\Controllers\ContactController::class, 'index']);

// Client Lead Form Processing
$router->post('/enquire', [\App\Controllers\EnquiryController::class, 'store']);

// Legal Notices
$router->get('/privacy-policy', [\App\Controllers\LegalController::class, 'privacy']);
$router->get('/terms-and-disclaimer', [\App\Controllers\LegalController::class, 'terms']);

// Search Engine Discovery
$router->get('/sitemap.xml', [\App\Controllers\SeoController::class, 'sitemap']);
$router->get('/robots.txt', [\App\Controllers\SeoController::class, 'robots']);

// ============================================================
// ADMIN ROUTE DEFINITIONS
// ============================================================

// Authentication
$router->get('/admin', [\App\Controllers\Admin\DashboardController::class, 'index']);
$router->get('/admin/login', [\App\Controllers\Admin\AuthController::class, 'showLogin']);
$router->post('/admin/login', [\App\Controllers\Admin\AuthController::class, 'login']);
$router->post('/admin/logout', [\App\Controllers\Admin\AuthController::class, 'logout']);

// Administrator Profile & Security
$router->get('/admin/profile', [\App\Controllers\Admin\ProfileAdminController::class, 'index']);
$router->post('/admin/profile/update', [\App\Controllers\Admin\ProfileAdminController::class, 'updateProfile']);
$router->post('/admin/profile/password', [\App\Controllers\Admin\ProfileAdminController::class, 'updatePassword']);

// Dashboard
$router->get('/admin/dashboard', [\App\Controllers\Admin\DashboardController::class, 'index']);

// Property Portfolio Management
$router->get('/admin/properties', [\App\Controllers\Admin\PropertyAdminController::class, 'index']);
$router->get('/admin/properties/create', [\App\Controllers\Admin\PropertyAdminController::class, 'create']);
$router->post('/admin/properties/store', [\App\Controllers\Admin\PropertyAdminController::class, 'store']);
$router->get('/admin/properties/edit/{id}', [\App\Controllers\Admin\PropertyAdminController::class, 'edit']);
$router->post('/admin/properties/update/{id}', [\App\Controllers\Admin\PropertyAdminController::class, 'update']);
$router->post('/admin/properties/delete/{id}', [\App\Controllers\Admin\PropertyAdminController::class, 'delete']);
$router->post('/admin/properties/toggle-featured/{id}', [\App\Controllers\Admin\PropertyAdminController::class, 'toggleFeatured']);
$router->post('/admin/properties/toggle-status/{id}', [\App\Controllers\Admin\PropertyAdminController::class, 'toggleStatus']);
$router->post('/admin/properties/delete-image/{id}', [\App\Controllers\Admin\PropertyAdminController::class, 'deleteImage']);

// Master Features & Amenities Library
$router->get('/admin/features', [\App\Controllers\Admin\FeatureAdminController::class, 'index']);
$router->post('/admin/features/store', [\App\Controllers\Admin\FeatureAdminController::class, 'store']);
$router->post('/admin/features/update/{id}', [\App\Controllers\Admin\FeatureAdminController::class, 'update']);
$router->post('/admin/features/toggle-status/{id}', [\App\Controllers\Admin\FeatureAdminController::class, 'toggleStatus']);
$router->post('/admin/features/delete/{id}', [\App\Controllers\Admin\FeatureAdminController::class, 'delete']);

// Advisory Services
$router->get('/admin/services', [\App\Controllers\Admin\ServiceAdminController::class, 'index']);
$router->get('/admin/services/create', [\App\Controllers\Admin\ServiceAdminController::class, 'create']);
$router->post('/admin/services/store', [\App\Controllers\Admin\ServiceAdminController::class, 'store']);
$router->get('/admin/services/edit/{id}', [\App\Controllers\Admin\ServiceAdminController::class, 'edit']);
$router->post('/admin/services/update/{id}', [\App\Controllers\Admin\ServiceAdminController::class, 'update']);
$router->post('/admin/services/toggle-status/{id}', [\App\Controllers\Admin\ServiceAdminController::class, 'toggleStatus']);
$router->post('/admin/services/toggle-home/{id}', [\App\Controllers\Admin\ServiceAdminController::class, 'toggleShowOnHome']);
$router->post('/admin/services/delete/{id}', [\App\Controllers\Admin\ServiceAdminController::class, 'delete']);

// Areas of Expertise
$router->get('/admin/areas', [\App\Controllers\Admin\AreaAdminController::class, 'index']);
$router->get('/admin/areas/create', [\App\Controllers\Admin\AreaAdminController::class, 'create']);
$router->post('/admin/areas/store', [\App\Controllers\Admin\AreaAdminController::class, 'store']);
$router->get('/admin/areas/edit/{id}', [\App\Controllers\Admin\AreaAdminController::class, 'edit']);
$router->post('/admin/areas/update/{id}', [\App\Controllers\Admin\AreaAdminController::class, 'update']);
$router->post('/admin/areas/toggle-status/{id}', [\App\Controllers\Admin\AreaAdminController::class, 'toggleStatus']);
$router->post('/admin/areas/toggle-home/{id}', [\App\Controllers\Admin\AreaAdminController::class, 'toggleShowOnHome']);
$router->post('/admin/areas/delete/{id}', [\App\Controllers\Admin\AreaAdminController::class, 'delete']);

// Home Page Management
$router->get('/admin/home', [\App\Controllers\Admin\HomeAdminController::class, 'index']);
$router->post('/admin/home/update', [\App\Controllers\Admin\HomeAdminController::class, 'update']);

// About Us Page Management
$router->get('/admin/about', [\App\Controllers\Admin\AboutAdminController::class, 'index']);
$router->post('/admin/about/update', [\App\Controllers\Admin\AboutAdminController::class, 'update']);

// Hero Carousel Management
$router->get('/admin/carousel', [\App\Controllers\Admin\CarouselAdminController::class, 'index']);
$router->get('/admin/carousel/create', [\App\Controllers\Admin\CarouselAdminController::class, 'create']);
$router->post('/admin/carousel/store', [\App\Controllers\Admin\CarouselAdminController::class, 'store']);
$router->get('/admin/carousel/edit/{id}', [\App\Controllers\Admin\CarouselAdminController::class, 'edit']);
$router->post('/admin/carousel/update/{id}', [\App\Controllers\Admin\CarouselAdminController::class, 'update']);
$router->post('/admin/carousel/toggle-status/{id}', [\App\Controllers\Admin\CarouselAdminController::class, 'toggleStatus']);
$router->post('/admin/carousel/delete/{id}', [\App\Controllers\Admin\CarouselAdminController::class, 'delete']);

// Lead Inbox
$router->get('/admin/enquiries', [\App\Controllers\Admin\EnquiryAdminController::class, 'index']);
$router->get('/admin/enquiries/show/{id}', [\App\Controllers\Admin\EnquiryAdminController::class, 'show']);
$router->post('/admin/enquiries/update-status/{id}', [\App\Controllers\Admin\EnquiryAdminController::class, 'updateStatus']);
$router->post('/admin/enquiries/delete/{id}', [\App\Controllers\Admin\EnquiryAdminController::class, 'delete']);

// Testimonials
$router->get('/admin/testimonials', [\App\Controllers\Admin\TestimonialAdminController::class, 'index']);
$router->get('/admin/testimonials/create', [\App\Controllers\Admin\TestimonialAdminController::class, 'create']);
$router->post('/admin/testimonials/store', [\App\Controllers\Admin\TestimonialAdminController::class, 'store']);
$router->get('/admin/testimonials/edit/{id}', [\App\Controllers\Admin\TestimonialAdminController::class, 'edit']);
$router->post('/admin/testimonials/update/{id}', [\App\Controllers\Admin\TestimonialAdminController::class, 'update']);
$router->post('/admin/testimonials/delete/{id}', [\App\Controllers\Admin\TestimonialAdminController::class, 'delete']);

// System Settings
$router->get('/admin/settings', [\App\Controllers\Admin\SettingsAdminController::class, 'index']);
$router->post('/admin/settings/update', [\App\Controllers\Admin\SettingsAdminController::class, 'update']);

// ============================================================
// DISPATCH REQUEST
// ============================================================
try {
    $router->resolve();
} catch (\Throwable $e) {
    error_log('[Elite Homez Uncaught Error] ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
    $response->setStatusCode(500);

    $appConfig = require dirname(__DIR__) . '/app/Config/config.php';
    if (!empty($appConfig['debug']) || (isset($_GET['debug']) && $_GET['debug'] === '1')) {
        echo '<!DOCTYPE html><html><head><title>System Error (Debug Mode)</title><meta name="viewport" content="width=device-width, initial-scale=1"></head><body style="font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, sans-serif; background: #0f172a; color: #f8fafc; padding: 2rem; margin: 0;">';
        echo '<div style="max-width: 850px; margin: 2rem auto; background: #1e293b; border-radius: 8px; padding: 2rem; border: 1px solid #334155; box-shadow: 0 10px 25px rgba(0,0,0,0.5);">';
        echo '<h2 style="color: #f87171; margin-top: 0;">Application Diagnostic Notice</h2>';
        echo '<p style="font-size: 16px; line-height: 1.6;"><strong style="color: #94a3b8;">Error:</strong> <span style="color: #fca5a5;">' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '</span></p>';
        echo '<p style="font-size: 14px; color: #94a3b8;"><strong style="color: #cbd5e1;">Location:</strong> ' . htmlspecialchars($e->getFile() . ' : line ' . $e->getLine(), ENT_QUOTES, 'UTF-8') . '</p>';
        echo '<details open style="margin-top: 1.5rem;"><summary style="cursor: pointer; font-weight: 600; color: #38bdf8; margin-bottom: 0.5rem;">Stack Trace</summary>';
        echo '<pre style="background: #0f172a; padding: 1rem; border-radius: 6px; overflow-x: auto; font-size: 13px; color: #e2e8f0; line-height: 1.5;">' . htmlspecialchars($e->getTraceAsString(), ENT_QUOTES, 'UTF-8') . '</pre></details>';
        echo '</div></body></html>';
        exit;
    }

    echo '<!DOCTYPE html><html><head><title>Service Temporarily Unavailable</title></head><body style="font-family:serif;text-align:center;padding:5rem 2rem;"><h2>Elite Homez Property Advisory</h2><p>Our advisory portal is currently undergoing scheduled maintenance. Please telephone our senior advisory desk directly at +91 98110 00000.</p></body></html>';
}
