<?php

require_once '../vendor/autoload.php';

use Ksu\PHPUtil\Domain;

error_reporting(E_ALL); 
date_default_timezone_set("Asia/Tokyo");

header("Content-type: text/plain; charset=UTF-8");
foreach(Domain::number_range(1, 20, 3, '%03d') as $v){
    echo $v ,PHP_EOL;
}
echo '---------------------', PHP_EOL;

foreach(Domain::date_range('2024-3-1', '2024-3-31', 'P7D') as $v){
    echo $v ,PHP_EOL;
}
echo '---------------------', PHP_EOL;

foreach(Domain::number_range(0x12, 0x84, 12, '%X') as $v){
    echo $v ,PHP_EOL;
}
echo '---------------------', PHP_EOL;