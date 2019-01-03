<?php

use Faker\Generator as Faker;

$factory->define(App\Contract::class, function (Faker $faker) {
    return [
        'code'          =>  $faker->unique()->bothify('##??###000##118'),
        'name'          =>  $faker->text($maxNbChars = 200),
        'short_name'     =>  null,
        'description'   =>  $faker->realText($maxNbChars = 200, $indexSize = 2),
        
        'total'         =>  $faker->randomFloat($nbMaxDecimals = 2, $min = 10000000, $max = 20000000),
        'anticipated'   =>  $faker->randomFloat($nbMaxDecimals = 2, $min = 500000,   $max = 1000000),
        'extension'     =>  $faker->randomFloat($nbMaxDecimals = 2, $min = 1000000,  $max = 3000000),
        'adjustment'    =>  $faker->randomFloat($nbMaxDecimals = 2, $min = 1000000,  $max = 3000000),

        'start'         =>  $faker->date($format = 'Y-m-d', $max = 'now'),
        'finish'        =>  $faker->date($format = 'Y-m-d', $max = 'now'),
        'signature'     =>  $faker->date($format = 'Y-m-d', $max = 'now'),
        'modified'      =>  $faker->date($format = 'Y-m-d', $max = 'now'),
        'covenant'      =>  $faker->date($format = 'Y-m-d', $max = 'now'),

        'active'        =>  $faker->randomElement($array = array ('1','0'))    
    ];
});
