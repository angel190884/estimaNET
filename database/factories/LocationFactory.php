<?php

use App\Location;
use Faker\Generator as Faker;

$factory->define(Location::class, function (Faker $faker) {
    return [
        'name' 			=>  strtoupper($faker->text($maxNbChars = 30)),
        'address'       =>  strtoupper($faker->address),
        'observations'  =>  strtoupper($faker->sentence($nbWords = 6, $variableNbWords = true)),
    ];
});
