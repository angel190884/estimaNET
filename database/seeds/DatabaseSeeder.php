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
        //$this->call(CompanyContractTableSeeder::class);
        $this->call(EstimateTableSeeder::class);
        $this->call(ConceptsTableSeeder::class);
        $this->call(ConceptEstimateTableSeeder::class);
        $this->call(LocationTableSeeder::class);
        $this->call(GeneratorLocationTableSeeder::class);
        $this->call(DeductionTableSeeder::class);
    }
}
