<?php


use App\Location;
use Illuminate\Database\Seeder;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contracts= \App\Contract::all()->random(3);

        foreach ($contracts as $contract){
            factory(Location::class,5)->create([
                'contract_id' => $contract->id
            ]);
        }
    }
}
