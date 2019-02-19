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
            for ($i=1;$i < 6; $i++){
                factory(Estimate::class)->create([
                    'contract_id' => $contract->id,
                    'number'    => $i,
                    'retention' => 0
                ]);
            }
        }
    }
}
