<?php

/**
 * File-level docblock.
 */

declare(strict_types=1);

namespace Ksu\PHPUtil;

use stubbles\sequence\Sequence;

/**
 * A tuple is an ordered sequence of values of different types, adhere to some constraints
 * A constraint : unique, range, inequality, func-dependency, multi-dependency  
 */
class Tuple
{
    protected Sequence $tuple;

    function __construct(array $schema=[])
    {
        $this->tuple = Sequence::of($schema);
    }

    function generate()
    {
        return $this->tuple->map(
            function($col){
                return $col->generate(); 
            }
        )->values();
    }

}