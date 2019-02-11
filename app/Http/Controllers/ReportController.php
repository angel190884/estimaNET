<?php

namespace App\Http\Controllers;

use App\Estimate;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function cumulativeControl(Estimate $estimate)
    {
        foreach ($estimate->generators->sortBy('concept.code') as $generator){
            /*$total = 0;
            foreach ($previousEstimates as $previousEstimate){
                $total+= $previousEstimate
                    ->generators
                    //->select('quantity')
                    ->where('concept_id',$generator->concept_id)
                    ->sum->quantity;
                }*/
            dump([
                //$total
                $generator->concept->code,
                $generator->concept->name,
                $generator->concept->measurement_unit,
                $generator->concept->quantityOk,
                $generator->lastQuantityOk,
                $generator->quantityOk,
                $generator->accumulatedQuantityOk,
                $generator->concept->unitPriceOk,
                $generator->lastAmountOk,
                $generator->amountOk,
                $generator->accumulatedAmount,
            ]);
        }
        //return $estimate;
    }
}
