<?php
declare(strict_types=1);

/**
 * Database Configuration
 * 
 * For Live Servers (Hostinger / cPanel):
 * 1. Create a MySQL database and user in your hosting panel (hPanel / cPanel).
 * 2. Import the database dump: database/full_export_elite_homez.sql
 * 3. Update the credentials below (or create database.local.php on your server with your live credentials).
 */

// Optional: If database.local.php exists (e.g. on your live server), load it
if (file_exists(__DIR__ . '/database.local.php')) {
    return require __DIR__ . '/database.local.php';
}

return [
    'host' => getenv('DB_HOST') ?: '127.0.0.1',
    'port' => (int)(getenv('DB_PORT') ?: 3306),
    'database' => getenv('DB_NAME') ?: 'elite_homez',
    'username' => getenv('DB_USER') ?: 'root',
    'password' => getenv('DB_PASS') !== false ? getenv('DB_PASS') : '',
    'charset' => 'utf8mb4',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
    ]
];
