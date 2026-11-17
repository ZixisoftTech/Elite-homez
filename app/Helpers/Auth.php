<?php
declare(strict_types=1);

namespace App\Helpers;

use App\Core\Database;
use PDO;

class Auth {
    private const MAX_ATTEMPTS = 5;
    private const LOCKOUT_SECONDS = 900; // 15 minutes

    public static function attempt(string $email, string $password, string $ip): array {
        if (self::isLockedOut($ip)) {
            $remaining = self::getRemainingLockoutTime($ip);
            return [
                'success' => false,
                'message' => "Too many failed login attempts. Account temporarily locked. Please retry in {$remaining} minutes."
            ];
        }

        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM admins WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => strtolower(trim($email))]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$admin || !password_verify($password, $admin['password_hash'])) {
            self::recordFailedAttempt($ip);
            return [
                'success' => false,
                'message' => 'Invalid email address or credentials provided.'
            ];
        }

        // Authentication successful
        self::clearFailedAttempts($ip);
        Session::regenerate();

        // Update last login timestamp
        $updateStmt = $db->prepare("UPDATE admins SET last_login_at = NOW() WHERE id = :id");
        $updateStmt->execute(['id' => $admin['id']]);

        Session::set('admin_logged_in', true);
        Session::set('admin_id', (int) $admin['id']);
        Session::set('admin_name', $admin['name']);
        Session::set('admin_email', $admin['email']);
        Session::set('admin_role', $admin['role']);

        return [
            'success' => true,
            'admin' => $admin
        ];
    }

    public static function check(): bool {
        return Session::get('admin_logged_in') === true && Session::get('admin_id') !== null;
    }

    public static function user(): ?array {
        if (!self::check()) {
            return null;
        }
        return [
            'id' => Session::get('admin_id'),
            'name' => Session::get('admin_name'),
            'email' => Session::get('admin_email'),
            'role' => Session::get('admin_role')
        ];
    }

    public static function id(): ?int {
        return Session::get('admin_id');
    }

    public static function logout(): void {
        Session::remove('admin_logged_in');
        Session::remove('admin_id');
        Session::remove('admin_name');
        Session::remove('admin_email');
        Session::remove('admin_role');
        Session::regenerate();
    }

    private static function getLockoutKey(string $ip): string {
        return 'login_attempts_' . md5($ip);
    }

    private static function isLockedOut(string $ip): bool {
        $data = Session::get(self::getLockoutKey($ip));
        if (!$data) {
            return false;
        }
        if ($data['count'] >= self::MAX_ATTEMPTS) {
            if (time() - $data['first_attempt'] < self::LOCKOUT_SECONDS) {
                return true;
            }
            // Lockout period has elapsed, reset
            self::clearFailedAttempts($ip);
        }
        return false;
    }

    private static function getRemainingLockoutTime(string $ip): int {
        $data = Session::get(self::getLockoutKey($ip));
        if (!$data) {
            return 0;
        }
        $diff = self::LOCKOUT_SECONDS - (time() - $data['first_attempt']);
        return max(1, (int) ceil($diff / 60));
    }

    private static function recordFailedAttempt(string $ip): void {
        $key = self::getLockoutKey($ip);
        $data = Session::get($key, ['count' => 0, 'first_attempt' => time()]);
        $data['count']++;
        Session::set($key, $data);
    }

    private static function clearFailedAttempts(string $ip): void {
        Session::remove(self::getLockoutKey($ip));
    }
}
