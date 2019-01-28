<?php

use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
        'quantity'      =>  $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 999999999),
    ];
});
