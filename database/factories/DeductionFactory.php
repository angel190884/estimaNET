<?php

use Faker\Generator as Faker;

$factory->define(App\Deduction::class, function (Faker $faker) {
    return [
        'code'          =>  $faker->unique()->bothify('##??###'),
        'name'          =>  $faker->realText($maxNbChars = 20),
        'percentage'    =>  $faker->randomFloat($nbMaxDecimals = 1, $min = 0.1, $max = 10),
        'description'   =>  $faker->realText($maxNbChars = 200, $indexSize = 2),
    ];
});
