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
        $formatter = $formatter ?? $this->formatter;
        $values = $this->column->map(
            function($gen){
                $val = $gen->current();
                $gen->next();
                return $val;
            }
        )->values();
        return static::_format($values, $formatter);
    }

    /**
     * 
     */
    private static function _format(array $values, string|callable $formatter) : string
    {
        if (is_callable($formatter)){
            return call_user_func_array($formatter,$values);
        }
        return vsprintf($formatter, $values);
    }


}