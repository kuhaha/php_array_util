<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

header("Content-type: text/plain; charset=UTF-8");
// use the factory to create a Faker\Generator instance
$faker = Faker\Factory::create('ja_JP');
// generate data by calling methods
foreach(range(0,9) as $i){
    echo $i*2+1, ' ', $faker->lastName(), $faker->firstNameMale(), $faker->firstKanaNameMale(),' M男性', PHP_EOL;
    echo $i*2+2, ' ', $faker->lastName(), $faker->firstNameFemale(), ' F女性' , PHP_EOL;

}
// 'Vince Sporer'
echo $faker->email(), PHP_EOL;
// 'walter.sophia@hotmail.com'
echo $faker->text(), PHP_EOL;
// 'Numquam ut mollitia at consequuntur inventore dolorem.'