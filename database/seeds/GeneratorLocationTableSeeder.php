<?php

use App\Contract;
use App\Location;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class GeneratorLocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        foreach (Contract::all()->random(4) as $contract){
            foreach ($contract->estimates as $estimate){
                foreach ($estimate->generators as $generator){
                    $locations = Location::all()->random(5);
                    $generator->locations()->attach($locations, [
                        'quantity' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 999999)
                    ]);
                }
            }
        }
    }
}
