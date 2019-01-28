<?php

use App\Contract;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ConceptEstimateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        foreach (Contract::all() as $contract){
            foreach ($contract->estimates as $estimate){
                foreach ($contract->concepts->random(15)->all() as $concept){
                    $estimate->concepts()->attach($concept, [
                        'quantity' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 999999)
                    ]);
                }
            }
        }
    }
}
