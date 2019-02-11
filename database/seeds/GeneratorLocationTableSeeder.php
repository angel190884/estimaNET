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
        $contracts = Contract::where('split_catalog',true)->get();
        foreach ($contracts as $contract){
            foreach ($contract->estimates as $estimate){
                foreach ($estimate->generators as $generator){
                    $locations = Location::all()->random(5);
                    foreach ($locations as $location){
                        $generator->locations()->attach($location, [
                            'quantity' => $faker->randomFloat($nbMaxDecimals = 2, $min = $generator->quantity / 5, $max = $generator->quantity / 5)
                        ]);
                    }
                }
            }
        }
    }
}
