<?php

require_once 'vendor/autoload.php';

use Ksu\PHPUtil\Domain;

use ReverseRegex\Lexer;
use ReverseRegex\Random\SimpleRandom;
use ReverseRegex\Parser;
use ReverseRegex\Generator\Scope;

// Error reporting
// error_reporting(0);   // Product environment, reporting nothing
// error_reporting(E_ERROR | E_PARSE); // Avoid E_WARNING, E_NOTICE, etc
error_reporting(E_ALL); // Development environment, reporting all
date_default_timezone_set("Asia/Tokyo");

header("Content-type: text/plain; charset=UTF-8");

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