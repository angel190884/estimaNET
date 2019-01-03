<?php

use App\Contract;
use Illuminate\Database\Seeder;

class ContractsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Contract::class,10)->create();

        //Bouncer::allow('admin')->everything();
        //Bouncer::allow('visor')->to('viewContract', Contract::class);
    }
}
