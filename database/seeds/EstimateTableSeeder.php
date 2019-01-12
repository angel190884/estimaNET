<?php

use App\Contract;
use App\Estimate;
use Illuminate\Database\Seeder;

class EstimateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contract = Contract::all();
        foreach ($contract as $contract){
            factory(Estimate::class,5)->create([
                'contract_id' => $contract->id
            ]);
        }
    }
}
