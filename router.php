<?php
declare(strict_types=1);

/**
 * Local Development Server Router
 * Provides seamless routing and asset serving for Elite Homez
 * Usage: php -S 127.0.0.1:8000 router.php
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/');

// 1. Support XAMPP-style subpath: /Antigravity/NEW-ELITE-HOMEZ/public/...
$subpath = '/Antigravity/NEW-ELITE-HOMEZ/public';
if (str_starts_with($uri, $subpath)) {
    $subUri = substr($uri, strlen($subpath)) ?: '/';
    $filePath = __DIR__ . '/public' . $subUri;
    if ($subUri !== '/' && file_exists($filePath) && !is_dir($filePath)) {
        serveStaticFile($filePath);
        return true;
    }
    // Normalize request URI so router handles it like root
    $_SERVER['REQUEST_URI'] = $subUri;
    $uri = $subUri;
}

// 2. Direct public asset: /assets/css/main.css, /assets/images/logo.png, etc.
$filePath = __DIR__ . '/public' . $uri;
if ($uri !== '/' && file_exists($filePath) && !is_dir($filePath)) {
    serveStaticFile($filePath);
    return true;
}

// 3. Normalize SCRIPT_NAME for PHP built-in web server
$_SERVER['SCRIPT_NAME'] = '/index.php';

// Fallback to Front Controller
require_once __DIR__ . '/public/index.php';

function serveStaticFile(string $filePath): void {
    $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    $mimes = [
        'css'   => 'text/css; charset=UTF-8',
        'js'    => 'application/javascript; charset=UTF-8',
        'png'   => 'image/png',
        'jpg'   => 'image/jpeg',
        'jpeg'  => 'image/jpeg',
        'webp'  => 'image/webp',
        'gif'   => 'image/gif',
        'svg'   => 'image/svg+xml',
        'ico'   => 'image/x-icon',
        'woff'  => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf'   => 'font/ttf',
    ];
    if (isset($mimes[$ext])) {
        header('Content-Type: ' . $mimes[$ext]);
    }
    header('Content-Length: ' . filesize($filePath));
    header('Cache-Control: public, max-age=86400');
    readfile($filePath);
    exit;
}
