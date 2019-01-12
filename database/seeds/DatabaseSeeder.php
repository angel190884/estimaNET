<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(CompaniesTableSeeder::class);
        $this->call(ContractsTableSeeder::class);
        $this->call(ContractUserTableSeeder::class);
        $this->call(CompanyContractTableSeeder::class);
        $this->call(EstimateTableSeeder::class);
    }
}
