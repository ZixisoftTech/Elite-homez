<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;
use RuntimeException;

class Database {
    private static ?PDO $instance = null;

    public static function getConnection(): PDO {
        if (self::$instance === null) {
            $config = require dirname(__DIR__) . '/Config/database.php';
            
            $dsn = sprintf(
                'mysql:host=%s;port=%d;dbname=%s;charset=%s',
                $config['host'],
                $config['port'],
                $config['database'],
                $config['charset']
            );

            try {
                self::$instance = new PDO(
                    $dsn,
                    $config['username'],
                    $config['password'],
                    $config['options']
                );
            } catch (PDOException $e) {
                // Log technical error securely
                error_log('[Database Connection Error] ' . $e->getMessage());
                throw new RuntimeException('Database connection failed: ' . $e->getMessage() . '. Please verify database credentials (host, dbname, user, pass) in app/Config/database.php.');
            }
        }

        return self::$instance;
    }
}
