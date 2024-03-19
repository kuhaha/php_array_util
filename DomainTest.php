<?php

require_once 'vendor/autoload.php';

use Ksu\PHPUtil\Domain;

use ReverseRegex\Lexer;
use ReverseRegex\Random\SimpleRandom;
use ReverseRegex\Parser;
use ReverseRegex\Generator\Scope;

use Doctrine\Common\Collections\ArrayCollection;

use stubbles\sequence\Sequence;

// Error reporting
// error_reporting(0);   // Product environment, reporting nothing
// error_reporting(E_ERROR | E_PARSE); // Avoid E_WARNING, E_NOTICE, etc
error_reporting(E_ALL); // Development environment, reporting all
date_default_timezone_set("Asia/Tokyo");

header("Content-type: text/plain; charset=UTF-8");

/**
 * You can use the Intl extension to format the date. It will format dates/times 
 * according to the chosen locale, or you can override that with 
 *  `IntlDateFormatter::setPattern()`
 */
echo 'IntlDateFormatter::setPattern()', PHP_EOL;
$dt = new DateTime;
$formatter = new IntlDateFormatter('ja_JP', 
    IntlDateFormatter::SHORT, IntlDateFormatter::SHORT);
$formatter->setPattern('E d.M.yyyy');
echo $formatter->format($dt), PHP_EOL;
echo '----', PHP_EOL;
$formatter = new IntlDateFormatter('ja_JP', 
    IntlDateFormatter::FULL,IntlDateFormatter::FULL, 'Asia/Tokyo', IntlDateFormatter::GREGORIAN);
echo $formatter->format($dt), PHP_EOL;
echo $formatter->getPattern(), PHP_EOL;
echo '----', PHP_EOL;
$formatter = new IntlDateFormatter('ja_JP@calendar=japanese', 
    IntlDateFormatter::FULL,IntlDateFormatter::FULL, 'Asia/Tokyo', IntlDateFormatter::TRADITIONAL);
echo $formatter->format($dt), PHP_EOL;
echo $formatter->getPattern(), PHP_EOL;

echo '---------------------', PHP_EOL;

echo 'range of formatted integers', PHP_EOL;
echo '----', PHP_EOL;
foreach(Domain::numberRange(1, 20, 3, '%03d') as $v){
    echo $v ,PHP_EOL;
}
echo '---------------------', PHP_EOL;

echo 'range of dates', PHP_EOL;
echo '----', PHP_EOL;
foreach(Domain::dateRange('2024-3-1', '2024-3-31', 'P7D') as $v){
    echo $v ,PHP_EOL;
}
/**
 * IntlDateFormatter pattern characters ja_JP, 和暦TRADITIONALの場合:
 * G - 年号「昭和」「令和」, GGGGG - 年号略称「S」「R」
 * y - 年号年6  
 * M - 月数字3,  MM - 月数字ゼロ付き03
 * d - 日数字8,  dd - 日数字ゼロ付き08
 * E EE - 曜日略称「火」, EEEE　- 曜日全称「火曜日」
 * パターン例：'Gy年M月d日(EE)',
 * 出力例：令和6年3月10日(日)
 */
$jpdate = function($dt){
    $formatter = new IntlDateFormatter('ja_JP@calendar=japanese', 
        IntlDateFormatter::FULL,IntlDateFormatter::FULL, 'Asia/Tokyo', IntlDateFormatter::TRADITIONAL);
    $formatter->setPattern('Gy年MM月dd日(EE)');
    return $formatter->format($dt);
};
echo '----', PHP_EOL;
foreach(Domain::dateRange('2024-3-1', '2024-3-31', 'P3D', $jpdate) as $v){
    echo $v ,PHP_EOL;
}
echo '---------------------', PHP_EOL;

echo 'range of hex integers', PHP_EOL;
echo '----', PHP_EOL;
foreach(Domain::numberRange(0x12, 0x84, 12, '%X') as $v){
    echo $v ,PHP_EOL;
}
echo '---------------------', PHP_EOL;

$lexer = new Lexer('[a-zA-Z0-9_#!\?]{10,15}');
$gen   = new SimpleRandom(10007);

$parser = new Parser($lexer,new Scope(),new Scope());

$i = 0;
echo 'random strings', PHP_EOL;
echo '----', PHP_EOL;
while ($i++ < 10){
    $result = '';
    $parser->parse()->getResult()->generate($result, $gen);
    echo $result, PHP_EOL;
}
echo '---------------------', PHP_EOL;

echo 'stubbles/sequence, sequence of numbers', PHP_EOL;
$start = 1;
$n = 20;
$values = Sequence::generate(
    $start,
    function($previous) { return $previous + 2; },
    function($value, $invocations) use($n) { return $value < (PHP_INT_MAX - 1) &&  $n >= $invocations; }
)->values();

echo implode(',', $values), PHP_EOL;
echo '---------------------', PHP_EOL;

echo 'stubbles/sequence, sequence of dates', PHP_EOL;
$n = 20;
$start = '2016-3-20';
$values = Sequence::generate(
    $start,
    function($previous) use ($jpdate) { 
        $dt = new DateTime($previous);
        $dt = $dt->add(new DateInterval('P1Y')); 
        return $dt->format('Y-m-d');
    },
    function($value, $invocations) use($n) { return $n >= $invocations; }
)->values();

$toJp = function ($d){
    $dt = new DateTime($d);
    $formatter = new IntlDateFormatter('ja_JP@calendar=japanese', 
    IntlDateFormatter::FULL,IntlDateFormatter::FULL, 'Asia/Tokyo', IntlDateFormatter::TRADITIONAL);
    $formatter->setPattern('Gy年M月d日(EE)');
    return $formatter->format($dt);
};
echo implode(PHP_EOL, array_map($toJp, $values)), PHP_EOL;
echo '---------------------', PHP_EOL;

echo 'stubbles/sequence, Fibonacci sequence', PHP_EOL;
class Tuple{
    public $val;
    function __construct($array) {
        $this->val= $array;
    }
    function get($i){
        return $this->val[$i];
    }
    function __toString(){
        return '[' . implode(',', $this->val). ']'; 
    }
}
$n = 30;
$start = new ArrayCollection([1,1]);
$values = Sequence::generate(
    $start,
    function($previous) { 
        return new Tuple([$previous->get(1), $previous->get(0)+$previous->get(1)]);
    },
    function($value, $invocations) use($n) { return $n >= $invocations; }
)->values();

echo implode(PHP_EOL, array_map(fn($v)=>$v->get(0), $values)), PHP_EOL;
echo '---------------------', PHP_EOL;