<?php

namespace App\Http\Controllers;

use App\Estimate;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function cumulativeControl(Estimate $estimate)
    {
        /*foreach ($estimate->generators->sortBy('concept.code') as $generator){
            dump([
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
        }*/

        $generatorsPrevious=$estimate->generatorsPrevious()->get();

        $data = collect();

        //dd($estimate->generators->sortBy('concept.location')->groupBy('concept.location'));

        foreach($estimate->generators->sortBy('concept.location')->groupBy('concept.location') as $location)
        {
            //dd($location->first()->concept->location);

            $additions=$location->where('quantity','>',0);

            $deductions=$location->where('quantity','<',0);

            $subTotalAdditions=0;
            $subTotalDeductions=0;

            foreach($additions as $generator){
                $subTotalAdditions += $generator->amount;
            }

            if (count($deductions) > 0){
                foreach($deductions as $generator){
                    $subTotalDeductions += $generator->amount;
                }
            }

            $data->prepend(collect([
                //'location'          =>$location->first()->concept->location,
                'address'          =>$location->first()->concept->address,
                'additions'          =>$additions,
                'deductions'        =>$deductions,
                'subTotalAdditions'  => number_format($subTotalAdditions,2,'.',','),
                'subTotalDeductions'=> number_format($subTotalDeductions,2,'.',','),
                'subTotal'          => number_format($subTotalAdditions+$subTotalDeductions,2,'.',','),

            ]),$location->first()->concept->location);
        }

        //dd($data);
        $pdf = PDF::loadView('reports.cumulativeControl.pdf',compact('estimate','data'));
        $pdf->setPaper('letter','portrait');
        return $pdf->stream('CA.pdf');
    }
}
