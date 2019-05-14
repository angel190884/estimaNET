<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contract;
use App\Estimate;
use App\Location;
use App\Company;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $contracts = $user->contracts()->active()->get();
        if ($user->isA('admin', 'editor')) {
            $numContracts = $contracts->count();
            $numEstimates = 0;
            $numLocations = 0;
            foreach ($contracts as $contract) {
                if ($contract->split_catalog) {
                    $numLocations += $contract->locations()->count();
                }
                $numEstimates += $contract->estimates()->count();
            }
            $numCompanies = Company::count();
            return view('home', compact('numContracts', 'numEstimates', 'numLocations', 'numCompanies'));
        }
        if ($user->isA('visor')) {
            return view('home', compact('contracts'));
        }
    }
}
