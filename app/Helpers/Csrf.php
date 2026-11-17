<?php
declare(strict_types=1);

namespace App\Helpers;

class Csrf {
    public static function getToken(): string {
        $token = Session::get('_csrf_token');
        if (!$token) {
            $token = bin2hex(random_bytes(32));
            Session::set('_csrf_token', $token);
        }
        return $token;
    }

    public static function field(): string {
        $token = self::getToken();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }

    public static function validate(?string $token): bool {
        if (empty($token)) {
            return false;
        }
        $sessionToken = Session::get('_csrf_token');
        if (empty($sessionToken)) {
            return false;
        }
        return hash_equals($sessionToken, $token);
    }
}
