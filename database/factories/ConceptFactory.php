<?php

use App\Concept;
use Faker\Generator as Faker;

$factory->define(Concept::class, function (Faker $faker) {
    return [
        'contract_id'		=> 	$faker->numberBetween($min = 3, $max = 50),
        'code'  	        =>  strtoupper($faker->bothify('###??')),
        'location' 			=>  strtoupper($faker->text($maxNbChars = 30)),
        'address'           =>  strtoupper($faker->address),
        'name'  			=>  strtoupper($faker->sentence($nbWords = 6, $variableNbWords = true)),
        'measurement_unit' 	=>  strtoupper($faker->randomElement(['M','M2','M3'])),
        'quantity' 			=>	$faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 100),
        'unit_price' 		=>  $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 100000),
        'type'              =>  strtoupper($faker->randomElement(['N','EXC','EXT'])),
    ];
});
