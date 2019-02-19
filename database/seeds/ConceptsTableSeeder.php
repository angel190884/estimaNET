<?php

use App\Concept;
use App\Contract;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class ConceptsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $contracts= Contract::all();
        foreach ($contracts as $contract){
            for ($i=1;$i <= 5;$i++){
                $location = strtoupper($faker->text($maxNbChars = 30));
                factory(Concept::class,5)->create([
                    'contract_id' => $contract->id,
                    'location'  => $location
                ]);
            }
        }
    }
}
