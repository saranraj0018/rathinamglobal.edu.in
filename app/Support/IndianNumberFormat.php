<?php

namespace App\Support;

/**
 * Indian digit grouping: 4038850 -> "40,38,850".
 */
class IndianNumberFormat
{
    public static function format(int $number): string
    {
        $digits = (string) $number;

        if (strlen($digits) <= 3) {
            return $digits;
        }

        $lastThree = substr($digits, -3);
        $rest = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', substr($digits, 0, -3));

        return $rest.','.$lastThree;
    }
}
