<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;
use RuntimeException;

class Database {
    private static ?PDO $instance = null;
    private static array $resolvedConfig = [];
    private static string $configSource = 'default';
    private static array $scannedFilesReport = [];

    /**
     * Load environment file (.env) if present in root, app/Config, or parent directory
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
            $root . '/.env.local',
            $root . '/app/Config/.env',
            dirname(__DIR__) . '/.env',
            dirname($root) . '/.env'
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
     * Inspect and parse configuration details from a candidate PHP or env file
     */
    private static function inspectConfigFile(string $filePath): ?array {
        if (!file_exists($filePath) || !is_readable($filePath)) {
            return null;
        }

        $config = [];

        // 1. Attempt PHP include / require
        try {
            $loaded = (function(string $f) {
                return @include $f;
            })($filePath);

            if (is_array($loaded)) {
                $config = $loaded;
            } else {
                $vars = (function(string $f): array {
                    @include $f;
                    return get_defined_vars();
                })($filePath);
                if (!empty($vars)) {
                    foreach (['db', 'config', 'database', 'db_config', 'dbConfig'] as $arrKey) {
                        if (isset($vars[$arrKey]) && is_array($vars[$arrKey])) {
                            $config = array_merge($config, $vars[$arrKey]);
                        }
                    }
                    $config = array_merge($config, $vars);
                }
            }
        } catch (\Throwable $e) {
            // Require failed or file had errors
        }

        // 2. Fallback: Parse raw content with regex (catches ternary getenv fallbacks, unreturned variables, syntax variants, or mysqli)
        $raw = @file_get_contents($filePath);
        $rawPasswordLiteral = null;

        if ($raw !== false && $raw !== '') {
            // Pattern A: ternary getenv fallback: getenv(...) : 'password' or getenv(...) ?: 'password'
            if (preg_match('/(?:password|pass|passwd|db_pass)[^\r\n;]*:[^\r\n;]*[\'"]([^\r\n\'"]+)[\'"]/i', $raw, $pm)) {
                if (!empty($pm[1]) && !str_contains($pm[1], 'getenv')) {
                    $rawPasswordLiteral = $pm[1];
                }
            }

            // Pattern B: assignment or key: 'password' => 'val' or $password = 'val'
            if ($rawPasswordLiteral === null && preg_match('/(?:[\'"](?:password|pass|passwd|db_pass|db_password)[\'"]|\$(?:password|pass|passwd|db_pass))\s*(?:=>|=)\s*[\'"]([^\r\n\'"]+)[\'"]/i', $raw, $pm)) {
                if (!empty($pm[1])) {
                    $rawPasswordLiteral = $pm[1];
                }
            }

            // Pattern C: define('DB_PASS', 'val')
            if ($rawPasswordLiteral === null && preg_match('/define\s*\(\s*[\'"](?:DB_PASS|DB_PASSWORD)[\'"]\s*,\s*[\'"]([^\r\n\'"]+)[\'"]\s*\)/i', $raw, $pm)) {
                if (!empty($pm[1])) {
                    $rawPasswordLiteral = $pm[1];
                }
            }

            // Pattern D: mysqli_connect('host', 'user', 'pass', 'db')
            if (preg_match('/mysqli(?:_connect)?\s*\(\s*[\'"]([^\'"]*)[\'"]\s*,\s*[\'"]([^\'"]*)[\'"]\s*,\s*[\'"]([^\'"]*)[\'"]\s*,\s*[\'"]([^\'"]*)[\'"]/', $raw, $m)) {
                if (empty($config['host'])) $config['host'] = $m[1];
                if (empty($config['username'])) $config['username'] = $m[2];
                if (!isset($config['password']) || $config['password'] === '') $config['password'] = $m[3];
                if (empty($config['database'])) $config['database'] = $m[4];
            }

            $extract = function(array $names) use ($raw): ?string {
                foreach ($names as $name) {
                    if (preg_match('/[\'"]' . preg_quote($name, '/') . '[\'"]\s*=>\s*[\'"]([^\'"]*)[\'"]/', $raw, $m)) {
                        return $m[1];
                    }
                    if (preg_match('/\$' . preg_quote($name, '/') . '\s*=\s*[\'"]([^\'"]*)[\'"]/', $raw, $m)) {
                        return $m[1];
                    }
                    if (preg_match('/define\s*\(\s*[\'"]' . preg_quote($name, '/') . '[\'"]\s*,\s*[\'"]([^\'"]*)[\'"]\s*\)/i', $raw, $m)) {
                        return $m[1];
                    }
                }
                return null;
            };

            if (empty($config['username']) && empty($config['user'])) {
                $val = $extract(['username', 'user', 'db_user', 'db_username', 'DB_USER', 'DB_USERNAME']);
                if ($val !== null) $config['username'] = $val;
            }
            if (empty($config['database']) && empty($config['dbname'])) {
                $val = $extract(['database', 'dbname', 'db_name', 'name', 'DB_NAME', 'DB_DATABASE']);
                if ($val !== null) $config['database'] = $val;
            }
            if (empty($config['host']) && empty($config['hostname'])) {
                $val = $extract(['host', 'hostname', 'db_host', 'servername', 'DB_HOST', 'DB_SERVER']);
                if ($val !== null) $config['host'] = $val;
            }
        }

        // If PHP include returned empty password, but raw file had a non-empty password literal:
        if ((!isset($config['password']) || $config['password'] === '') && !empty($rawPasswordLiteral)) {
            $config['password'] = $rawPasswordLiteral;
        }

        return !empty($config) ? $config : null;
    }

    /**
     * Resolve configuration by scanning candidate locations and prioritizing production credentials
     */
    private static function loadConfig(): array {
        if (!empty(self::$resolvedConfig)) {
            return self::$resolvedConfig;
        }

        self::loadEnv();

        $root = dirname(__DIR__, 2);
        $candidates = [
            'app/Config/database.local.php' => $root . '/app/Config/database.local.php',
            'app/config/database.local.php' => $root . '/app/config/database.local.php',
            'database.local.php'            => $root . '/database.local.php',
            'database.php'                  => $root . '/database.php',
            'config/database.php'           => $root . '/config/database.php',
            'config/database.local.php'     => $root . '/config/database.local.php',
            'app/Config/database.php'       => $root . '/app/Config/database.php',
            'app/config/database.php'       => $root . '/app/config/database.php',
            'app/Config/config.php'         => $root . '/app/Config/config.php',
            'config.php'                    => $root . '/config.php',
            'db.php'                        => $root . '/db.php',
            'app/database.php'              => $root . '/app/database.php',
        ];

        $bestCandidate = null;
        $highestScore = -1;
        $bestLabel = 'app/Config/database.php';

        foreach ($candidates as $label => $path) {
            if (!file_exists($path)) {
                self::$scannedFilesReport[$label] = 'not found';
                continue;
            }

            $cfg = self::inspectConfigFile($path);
            if ($cfg === null) {
                self::$scannedFilesReport[$label] = 'found but unparseable';
                continue;
            }

            $user = (string)($cfg['username'] ?? $cfg['user'] ?? $cfg['db_user'] ?? $cfg['db_username'] ?? '');
            $pass = (string)($cfg['password'] ?? $cfg['pass'] ?? $cfg['passwd'] ?? $cfg['db_pass'] ?? $cfg['db_password'] ?? '');
            $db   = (string)($cfg['database'] ?? $cfg['dbname'] ?? $cfg['db_name'] ?? '');
            $hasPass = ($pass !== '');

            self::$scannedFilesReport[$label] = sprintf(
                'exists (user=%s, pass=%s, db=%s)',
                $user !== '' ? "'$user'" : 'unset',
                $hasPass ? 'YES' : 'NO',
                $db !== '' ? "'$db'" : 'unset'
            );

            // Scoring system:
            // Non-root username: +100
            // Non-empty password: +50
            // database.local.php file: +30
            // Custom db name: +10
            $score = 0;
            if ($user !== '' && $user !== 'root') {
                $score += 100;
            }
            if ($hasPass) {
                $score += 50;
            }
            if (str_contains($label, 'database.local.php')) {
                $score += 30;
            }
            if ($db !== '' && $db !== 'elite_homez') {
                $score += 10;
            }

            if ($score > $highestScore) {
                $highestScore = $score;
                $bestCandidate = $cfg;
                $bestLabel = $label;
            }
        }

        // If no candidate scored above default, fall back to app/Config/database.php
        if ($bestCandidate === null) {
            $defaultPath = $root . '/app/Config/database.php';
            if (file_exists($defaultPath)) {
                $bestCandidate = self::inspectConfigFile($defaultPath) ?? [];
                $bestLabel = 'app/Config/database.php';
            } else {
                $bestCandidate = [];
                $bestLabel = 'environment fallback';
            }
        }

        // Cross-file fallback: If the best candidate has user/database, but password is missing,
        // check if any other candidate file defined a password!
        if (empty($bestCandidate['password'])) {
            foreach ($candidates as $label => $path) {
                if ($label === $bestLabel || !file_exists($path)) {
                    continue;
                }
                $otherCfg = self::inspectConfigFile($path);
                if (!empty($otherCfg['password'])) {
                    $bestCandidate['password'] = $otherCfg['password'];
                    self::$scannedFilesReport['cross_file_password_source'] = $label;
                    break;
                }
            }
        }

        self::$configSource = $bestLabel;
        self::$resolvedConfig = $bestCandidate;
        return self::$resolvedConfig;
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
                ?? (getenv('DB_PASS') !== false && getenv('DB_PASS') !== '' ? getenv('DB_PASS') : null)
                ?? (getenv('DB_PASSWORD') !== false && getenv('DB_PASSWORD') !== '' ? getenv('DB_PASSWORD') : null)
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

            // Host fallback: on Linux/Hostinger, try 'localhost' first (UNIX socket), then '127.0.0.1'
            $isLinux = (PHP_OS_FAMILY === 'Linux');
            $hostsToTry = [];
            if ($isLinux) {
                if ($host === 'localhost' || $host === '127.0.0.1') {
                    $hostsToTry = ['localhost', '127.0.0.1'];
                } else {
                    $hostsToTry = [$host, 'localhost', '127.0.0.1'];
                }
            } else {
                if ($host === '127.0.0.1' || $host === 'localhost') {
                    $hostsToTry = ['127.0.0.1', 'localhost'];
                } else {
                    $hostsToTry = [$host, '127.0.0.1', 'localhost'];
                }
            }
            $hostsToTry = array_values(array_unique($hostsToTry));

            $lastException = null;
            $connectedHost = null;

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
                    $connectedHost = $currentHost;
                    return self::$instance;
                } catch (PDOException $e) {
                    $lastException = $e;
                }
            }

            // Connection failed: assemble detailed diagnostic summary
            $scanSummary = [];
            foreach (self::$scannedFilesReport as $f => $st) {
                $scanSummary[] = "$f: $st";
            }

            $hasPassword = ($password !== '');
            $diagMsg = sprintf(
                "Database connection failed: %s | Active Config Source: %s | User: '%s' | DB: '%s' | Password Provided: %s | Scanned files: [%s]",
                ($lastException ? $lastException->getMessage() : 'Unknown error'),
                self::$configSource,
                $username,
                $database,
                ($hasPassword ? 'YES (length ' . strlen((string)$password) . ')' : 'NO (empty)'),
                implode(', ', $scanSummary)
            );

            error_log('[Database Connection Error] ' . $diagMsg);
            throw new RuntimeException($diagMsg);
        }

        return self::$instance;
    }
}
