<?php

/**
 * File-level docblock.
 */

declare(strict_types=1);

namespace Ksu\PHPUtil;

use ReverseRegex\{Lexer, Parser};
use ReverseRegex\Generator\Scope;
use ReverseRegex\Random\MersenneRandom;

/**
 * A domain is the entire set of values possible for independent variables  
 */
class Domain
{
    /**
     * 
     */
    static function number(int|float $start, int|float $end, int|float $step=1, string|callable $formatter='%f') 
    {
        foreach(\range($start, $end, $step) as $val){
            yield Formatter::format($val, $formatter);
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
            yield Formatter::format($date, $formatter);
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
}