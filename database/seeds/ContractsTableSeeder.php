<?php

use App\Contract;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class ContractsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=0;$i <= 10;$i++){
            factory(Contract::class)->create([
                'short_name' => $faker->numerify('####')
            ]);
        }

        //Bouncer::allow('admin')->everything();
        //Bouncer::allow('visor')->to('viewContract', Contract::class);
    }
}
