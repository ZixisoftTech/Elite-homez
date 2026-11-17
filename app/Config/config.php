<?php
declare(strict_types=1);

// Detect environment and base URL dynamically
$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || 
           (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) ||
           (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');

$protocol = $isHttps ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';

// Determine subfolder path if running inside a subdirectory like /Antigravity/Elite-Homez/public
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$basePath = str_replace('\\', '/', dirname($scriptName));
if ($basePath === '/' || $basePath === '.') {
    $basePath = '';
}

// If the request was made to the parent directory without /public in the URL, use the parent directory as base path
$requestUri = $_SERVER['REQUEST_URI'] ?? '';
if (str_ends_with($basePath, '/public') && !str_contains($requestUri, '/public')) {
    $parentPath = dirname($basePath);
    $basePath = ($parentPath === '/' || $parentPath === '.') ? '' : $parentPath;
}

$baseUrl = rtrim($protocol . $host . $basePath, '/');

return [
    'app_name' => 'Elite Homez',
    'app_tagline' => 'your trust, our responsibility.',
    'base_url' => $baseUrl,
    'base_path' => $basePath,
    'env' => 'production', // 'development' or 'production'
    'debug' => false,
    'timezone' => 'Asia/Kolkata',
    'session_lifetime' => 7200, // 2 hours
    'upload_dir' => dirname(__DIR__, 2) . '/public/uploads',
    'upload_url' => $baseUrl . '/uploads',
    'max_upload_size' => 5 * 1024 * 1024, // 5MB
    'allowed_image_mimes' => ['image/jpeg', 'image/png', 'image/webp'],
    'allowed_image_exts' => ['jpg', 'jpeg', 'png', 'webp'],
    'admin_lockout_attempts' => 5,
    'admin_lockout_minutes' => 15,
];
