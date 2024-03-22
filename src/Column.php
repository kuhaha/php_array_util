<?php

/**
 * File-level docblock.
 */

declare(strict_types=1);

namespace Ksu\PHPUtil;

use stubbles\sequence\Sequence;

/**
 * A column is composited of one or more domains 
 */
class Column
{
    protected Sequence $column;
    protected string $formatter;

    function __construct(mixed $def, string $formatter="'%s'")
    {
        $def = is_array($def) ? $def : [$def];
        $this->column = Sequence::of($def);
        $this->formatter = $formatter;
    }

    /**
     * 
     */
    function generate()
    {
        $values = $this->column->map(
            function($gen){
                $val = $gen->current();
                $gen->next();
                return $val;
            }
        )->values();
        if (is_callable($this->formatter)){
            return call_user_func_array($this->formatter, $values);
        }
        return vsprintf($this->formatter, $values);
    }
}