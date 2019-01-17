<?php

use App\Concept;
use Illuminate\Database\Seeder;

class ConceptsTableSedder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contracts=\App\Contract::all();
        foreach ($contracts as $contract){
            factory(Concept::class,30)->create([
                'contract_id' => $contract->id
            ]);
        }
    }
}
