<?php

/**
 * File-level docblock.
 */

declare(strict_types=1);

namespace Ksu\PHPUtil;

class Generator
{
    /**
     * Returns a random element from a passed array.
     */
    public static function randomElement(array $array)
    {
        if ($array === []) {
            return null;
        }

        return $array[array_rand($array, 1)];
    }

    public static function randomNumber(): int
    {
        return mt_rand();
    }

    public static function randomNumberBetween(int $min, int $max): int
    {
        return mt_rand($min, $max);
    }

    public static function largestRandomNumber(): int
    {
        return mt_getrandmax();
    }    

}