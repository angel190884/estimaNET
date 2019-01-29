<?php

use App\Concept;
use App\Contract;
use Illuminate\Database\Seeder;

class ConceptsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contracts= Contract::all();
        foreach ($contracts as $contract){
            factory(Concept::class,30)->create([
                'contract_id' => $contract->id
            ]);
        }
    }
}
