<?php

/**
 * File-level docblock.
 */

declare(strict_types=1);

namespace Ksu\PHPUtil;

use ReverseRegex\Lexer;
use ReverseRegex\Parser;
use ReverseRegex\Generator\Scope;
use ReverseRegex\Random\MersenneRandom;

class Domain
{
    const MAX_INT = PHP_INT_MAX;
    const MAX_FLOAT = PHP_FLOAT_MAX;

    const DEFAULT_DATETIME_STEP = 'P1D';
    const DEFAULT_NUMBER_STEP = 1;

    /**
     * 
     */
    static function numberRange(int|float $start, int|float $end, int|float $step=1, string|callable $formatter='%f') 
    {
        if (\is_numeric($start) and \is_numeric($end)){
            if (!$step) $step = self::DEFAULT_NUMBER_STEP;
            foreach(\range($start, $end, $step) as $val){
                yield static::format($val, $formatter);
            }
        }
    }

    /**
     * 
     */
    static function dateRange(string $start, string $end, string $step='P1D', string|callable $formatter='Y-m-d') 
    {
        $date1 = \date_create($start); 
        $date2 = \date_create($end);
        $date_step = new \DateInterval($step);
        $date_step = $date_step ? $date_step : \DateInterval::createFromDateString($step);
        if ($date_step){
            for ($date = $date1; $date <= $date2; $date->add($date_step)){
                yield $date->format($formatter);
            }
        }
    }

    /**
     * 
     */
    static function charRange(string $start, string $end, int $step=1, string|callable $formatter='%s')
    {
        foreach (\range($start, $end, $step) as $str){
            yield static::format($str, $formatter);
        }
    }

    /**
     * 
     */
    static function format(mixed $val, string|callable $formatter): string
    {
        if (is_callable($formatter)){
            return $formatter($val);
        }
        return sprintf($formatter, $val);
    }

    /**
     * resource: regexp, file, stream
     */
    static function stringDomain($resource, $formatter)
    {
        
    }

}