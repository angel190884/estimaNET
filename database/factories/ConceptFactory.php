<?php

use Faker\Generator as Faker;

$factory->define(App\Concept::class, function (Faker $faker) {
    return [
        'contract_id'		=> 	$faker->numberBetween($min = 3, $max = 50),
        'code'  	=>  $faker->bothify('###??'),
        'location' 			=>  $faker->text($maxNbChars = 30),
        'address'           =>  $faker->address,
        'name'  			=>  $faker->sentence($nbWords = 6, $variableNbWords = true),
        'measurement_unit' 	=>  $faker->bothify('##??'),
        'quantity' 			=>	$faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 100),
        'unit_price' 		=>  $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
    ];
});
