<?php

/**
 * File-level docblock.
 */

declare(strict_types=1);

namespace Ksu\PHPUtil;

class Formatter
{
   /**
    * Return the formatted string of $val
    * IntlDateFormatter pattern characters(locale='ja_JP', 和暦TRADITIONALの場合):
    * G - 年号「昭和」「令和」, GGGGG - 年号略称「S」「R」
    * y - 年号年「6」  
    * M - 月数字「3」, MM - 月数字ゼロ付き「03」
    * d - 日数字「8」, dd - 日数字ゼロ付き「08」
    * E EE - 曜日略称「火」, EEEE　- 曜日全称「火曜日」
    * パターン例：'Gy年M月d日(EE)',
    * 出力例：「令和6年3月10日(日)」

    * @param mixed $val
    * @param string|callable $formatter
    * @return string
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
        if (is_array($val)){
            return vsprintf($formatter, $val);
        }
        return sprintf($formatter, $val);
    }

}