<?php

/**
 * File-level docblock.
 */

declare(strict_types=1);

namespace Ksu\PHPUtil;

use stubbles\sequence\Sequence;
use ReverseRegex\{Lexer, Parser};
use ReverseRegex\Generator\Scope;
use ReverseRegex\Random\MersenneRandom;

/**
 * A domain is the entire set of values possible for independent variables  
 */
class Domain
{
    const MAX_INT = PHP_INT_MAX;
    const MAX_FLOAT = PHP_FLOAT_MAX;

    const DEFAULT_DATETIME_STEP = 'P1D';
    const DEFAULT_NUMBER_STEP = 1;

    /**
     * 
     */
    static function number(int|float $start, int|float $end, int|float $step=1, string|callable $formatter='%f') 
    {
        foreach(\range($start, $end, $step) as $val){
            yield static::_format($val, $formatter);
        }
    }

    /**
     * 
     */
    static function date(string $start, string $end, string $step='P1D', string|callable $formatter='Y-m-d') 
    {
        $date_end = date_create($end);
        $date_step = new \DateInterval($step) ?: \DateInterval::createFromDateString($step);
        for ($date = date_create($start); $date <= $date_end; $date->add($date_step)){
            yield static::_format($date, $formatter);
        }
    }

    /**
     * 
     */
    static function regex(string $regex, int $n,  int|float $seed=null)
    {
        $seed = $seed ?? time();
        $gen   = new MersenneRandom($seed);
        $lexer = new Lexer($regex);
        $parser = new Parser($lexer, new Scope(), new Scope());
        for ($i = 0; $i < $n; $i++){
            $result = '';
            $parser->parse()->getResult()->generate($result, $gen);
            yield $result;
        }
    }

    /**
     * 
     */
    private static function _format(mixed $val, string|callable $formatter) : string
    {
        if (is_callable($formatter) or $formatter instanceof \IntlDateFormatter){
            return $formatter($val);
        }
        if ($val instanceof \DateTime){
            return $val->format($formatter);
        }
        return sprintf($formatter, $val);
    }

}