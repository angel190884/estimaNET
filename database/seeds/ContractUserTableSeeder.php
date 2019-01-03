<?php

use App\Contract;
use App\User;
use Illuminate\Database\Seeder;

class ContractUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $contracts = Contract::all();
        foreach ($users as $user) {
            $user->contracts()->sync($contracts);
        }
    }
}
