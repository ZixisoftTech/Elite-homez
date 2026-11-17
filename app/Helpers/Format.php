<?php
declare(strict_types=1);

namespace App\Helpers;

class Format {
    public static function price(float $amount, string $listingType = 'sale'): string {
        if ($amount <= 0) {
            return 'Price on Request';
        }

        if ($listingType === 'rent') {
            if ($amount >= 100000) {
                $lakhs = $amount / 100000;
                $formatted = ($lakhs == floor($lakhs)) ? number_format($lakhs, 0) : number_format($lakhs, 2);
                return "₹{$formatted} Lakh / month";
            }
            return '₹' . number_format($amount, 0) . ' / month';
        }

        // Sale formatting in Crores / Lakhs (Indian numbering system)
        if ($amount >= 10000000) {
            $crores = $amount / 10000000;
            $formatted = ($crores == floor($crores)) ? number_format($crores, 0) : number_format($crores, 2);
            return "₹{$formatted} Cr";
        } elseif ($amount >= 100000) {
            $lakhs = $amount / 100000;
            $formatted = ($lakhs == floor($lakhs)) ? number_format($lakhs, 0) : number_format($lakhs, 2);
            return "₹{$formatted} Lakh";
        }

        return '₹' . number_format($amount, 0);
    }

    public static function slug(string $text): string {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);

        return empty($text) ? 'n-a' : $text;
    }

    public static function date(string $datetime, string $format = 'M j, Y'): string {
        $time = strtotime($datetime);
        return $time ? date($format, $time) : '';
    }

    public static function truncate(string $text, int $length = 100, string $append = '...'): string {
        $clean = strip_tags($text);
        if (mb_strlen($clean) <= $length) {
            return $clean;
        }
        return mb_substr($clean, 0, $length) . $append;
    }

    public static function e(mixed $val): string {
        return htmlspecialchars((string) ($val ?? ''), ENT_QUOTES, 'UTF-8');
    }
}
