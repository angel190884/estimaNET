<?php

use Faker\Generator as Faker;

$factory->define(App\Company::class, function (Faker $faker) {
    return [
        'rfc'           =>  $faker->unique()->bothify('????######?##'),
        'reason_social' =>  $faker->company,
        'admin_unique'  =>  $faker->name,
        'telephone'     =>  $faker->e164PhoneNumber,
        'address'       =>  $faker->address,
        'logo'          =>  'images/default.png',
        'background'          =>  null,
        'bank_account'  =>  $faker->creditCardNumber,
        'interbank_key' =>  $faker->numerify('#################')
    ];
});
