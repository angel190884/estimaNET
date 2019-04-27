<?php

use App\Contract;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class ConceptEstimateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        foreach (Contract::all() as $contract) {
            foreach ($contract->estimates as $estimate) {
                foreach ($contract->concepts->random(5)->all() as $concept) {
                    $estimate->concepts()->attach($concept, [
                        'quantity' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = $concept->quantity * 1.25)
                    ]);
                }
            }
        }
    }
}
