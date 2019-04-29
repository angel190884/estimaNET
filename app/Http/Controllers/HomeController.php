<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contract;
use App\Estimate;
use App\Location;

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
        $numContracts = Contract::active()
            ->count();
        $numEstimates = Estimate::join('contracts', 'contracts.id', '=', 'estimates.contract_id')
            ->where('contracts.active', true)
            ->count();
        $numLocations = Location::join('contracts', 'contracts.id', '=', 'locations.contract_id')
            ->where('contracts.active', true)
            ->where('contracts.split_catalog', true)
            ->count();
        
        return view('home', compact('numContracts', 'numEstimates', 'numLocations'));
    }
}
