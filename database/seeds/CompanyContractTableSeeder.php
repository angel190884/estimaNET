<?php

use App\Company;
use App\Contract;
use Illuminate\Database\Seeder;

class CompanyContractTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = Company::all();
        $contracts = Contract::all();
        foreach ($companies as $company) {
            $company->contracts()->sync($contracts);
        }
    }
}
