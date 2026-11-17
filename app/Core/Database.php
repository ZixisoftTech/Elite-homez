<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;
use RuntimeException;

class Database {
    private static ?PDO $instance = null;

    /**
     * Load environment file (.env) if present in root or app/Config
     */
    private static function loadEnv(): void {
        static $envLoaded = false;
        if ($envLoaded) {
            return;
        }
        $envLoaded = true;

        $root = dirname(__DIR__, 2);
        $envPaths = [
            $root . '/.env',
            $root . '/app/Config/.env',
            dirname(__DIR__) . '/.env'
        ];

        foreach ($envPaths as $path) {
            if (file_exists($path) && is_readable($path)) {
                $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                if ($lines !== false) {
                    foreach ($lines as $line) {
                        $line = trim($line);
                        if ($line === '' || str_starts_with($line, '#') || str_starts_with($line, ';')) {
                            continue;
                        }
                        if (str_contains($line, '=')) {
                            [$k, $v] = explode('=', $line, 2);
                            $k = trim($k);
                            $v = trim($v, " \t\n\r\0\x0B\"'");
                            if (!array_key_exists($k, $_SERVER) && !array_key_exists($k, $_ENV)) {
                                putenv("{$k}={$v}");
                                $_ENV[$k] = $v;
                                $_SERVER[$k] = $v;
                            }
                        }
                    }
                }
                break;
            }
        }
    }

    /**
     * Resolve configuration with support for arrays, key aliases, and standalone variables
     */
    private static function loadConfig(): array {
        self::loadEnv();

        $configDir = dirname(__DIR__) . '/Config';
        $localConfig = $configDir . '/database.local.php';
        $mainConfig = $configDir . '/database.php';

        $fileToLoad = file_exists($localConfig) ? $localConfig : $mainConfig;
        
        $config = [];
        if (file_exists($fileToLoad)) {
            $loaded = require $fileToLoad;
            if (is_array($loaded)) {
                $config = $loaded;
            } else {
                // If the user defined plain variables without a return statement
                $vars = (function(string $f): array {
                    require $f;
                    return get_defined_vars();
                })($fileToLoad);
                if (!empty($vars)) {
                    $config = $vars;
                }
            }
        }

        return $config;
    }

    public static function getConnection(): PDO {
        if (self::$instance === null) {
            $config = self::loadConfig();

            // Support all common naming conventions for database credentials
            $host = $config['host'] ?? $config['hostname'] ?? $config['db_host'] ?? (getenv('DB_HOST') ?: 'localhost');
            $port = (int) ($config['port'] ?? $config['db_port'] ?? (getenv('DB_PORT') ?: 3306));
            $database = $config['database'] ?? $config['dbname'] ?? $config['db_name'] ?? $config['name'] ?? (getenv('DB_NAME') ?: 'elite_homez');
            $username = $config['username'] ?? $config['user'] ?? $config['db_user'] ?? $config['db_username'] ?? (getenv('DB_USER') ?: 'root');
            
            // Password resolution with fallbacks for pass/password/db_pass and environment variables
            $password = $config['password'] 
                ?? $config['pass'] 
                ?? $config['passwd'] 
                ?? $config['db_pass'] 
                ?? $config['db_password'] 
                ?? getenv('DB_PASS') 
                ?? getenv('DB_PASSWORD') 
                ?? ($_ENV['DB_PASS'] ?? ($_ENV['DB_PASSWORD'] ?? ($_SERVER['DB_PASS'] ?? ($_SERVER['DB_PASSWORD'] ?? ''))));

            if ($password === false || $password === null) {
                $password = '';
            }

            $charset = $config['charset'] ?? 'utf8mb4';
            $options = $config['options'] ?? [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
            ];

            // Host fallback order: try configured host, then alternate socket/TCP host
            $hostsToTry = [$host];
            if ($host === '127.0.0.1') {
                $hostsToTry[] = 'localhost';
            } elseif ($host === 'localhost') {
                $hostsToTry[] = '127.0.0.1';
            }

            $lastException = null;
            foreach ($hostsToTry as $currentHost) {
                $dsn = sprintf(
                    'mysql:host=%s;port=%d;dbname=%s;charset=%s',
                    $currentHost,
                    $port,
                    $database,
                    $charset
                );

                try {
                    self::$instance = new PDO($dsn, (string)$username, (string)$password, $options);
                    return self::$instance;
                } catch (PDOException $e) {
                    $lastException = $e;
                    // Attempt next host (e.g. localhost fallback on Hostinger/cPanel Linux socket)
                }
            }

            // If all host attempts failed
            error_log('[Database Connection Error] ' . ($lastException ? $lastException->getMessage() : 'Unknown connection error'));
            throw new RuntimeException('Database connection failed: ' . ($lastException ? $lastException->getMessage() : 'Unknown error') . '. Please verify database credentials in app/Config/database.php.');
        }

        return self::$instance;
    }
}
