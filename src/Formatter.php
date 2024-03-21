<?php

/**
 * File-level docblock.
 */

declare(strict_types=1);

namespace Ksu\PHPUtil;

class Formatter
{
    /**
     * 
     */
    static function format(mixed $val, string|callable $formatter) : string
    {
        if (is_callable($formatter)){
            return $formatter($val);
        }
        if ($formatter instanceof \IntlDateFormatter){
            return $formatter->format($val);
        }
        if ($val instanceof \DateTime){
            return $val->format($formatter);
        }
        return sprintf($formatter, $val);
    }

}