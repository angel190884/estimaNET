<?php

use Faker\Generator as Faker;

$factory->define(App\Estimate::class, function (Faker $faker) {
    return [
        'number'        =>  $faker->numerify('#'),

        'start'         =>  $faker->date($format = 'Y-m-d', $max = 'now'),
        'finish'        =>  $faker->date($format = 'Y-m-d', $max = 'now'),
        'release'       =>  $faker->date($format = 'Y-m-d', $max = 'now'),

        'retention'     =>  $faker->randomFloat($nbMaxDecimals = 2),

        'type'          =>  $faker->randomElement($array = array ('1','2','3','4'))
    ];
});
