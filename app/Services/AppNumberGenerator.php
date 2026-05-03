<?php

namespace App\Services;

class AppNumberGenerator
{
    public static function generate(string $module): string
    {
        $prefix = match ($module) {
            'birth' => 'KLH',
            'mykad' => 'MYK',
            'marriage' => 'KHW',
            'death' => 'KMT',
            'adoption' => 'AAK',
            'citizenship' => 'KWN',
            default => 'INS',
        };
        $year = date('Y');
        $rand = str_pad((string) random_int(1, 999999), 6, '0', STR_PAD_LEFT);
        return "{$prefix}-{$year}-{$rand}";
    }

    public static function generateCertNo(string $module): string
    {
        return self::generate($module);
    }
}
