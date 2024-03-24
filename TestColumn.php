<?php

require_once 'vendor/autoload.php';

use Ksu\PHPUtil\Domain;
use Ksu\PHPUtil\Column;
use Ksu\PHPUtil\Tuple;

// Error reporting
// error_reporting(0);   // Product environment, reporting nothing
// error_reporting(E_ERROR | E_PARSE); // Avoid E_WARNING, E_NOTICE, etc
error_reporting(E_ALL); // Development environment, reporting all
date_default_timezone_set("Asia/Tokyo");

header("Content-type: text/plain; charset=UTF-8");

$n= 20;
$domain1 = Domain::number(1, $n*3, 1, 'k23rs%03d');
$domain2 = Domain::date('2024-3-1', '2024-3-31', 'P1D');
$domain3 = Domain::number(1, $n*3, 1, 'k23rs%03d@st.kyusan-u.ac.jp');
$domain4 = Domain::number(0.0, 4.0, 0.015);
$tuple = new Tuple([
    'id'   => new Column($domain1),
    'date' => new Column($domain2),
    'email'=> new Column($domain3),
    'gpa'  => new Column($domain4, "%.3f"),
]);
for($i=0; $i < $n; $i++){
    echo implode(',', $tuple->generate()), PHP_EOL;
}
