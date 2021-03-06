<?php

namespace App\Http\Controllers;

use App\Contract;
use App\Estimate;
use App\Generator;
use Illuminate\Support\Arr;
use Barryvdh\DomPDF\Facade as PDF;

class ReportController extends Controller
{
    public function cumulativeControl(Estimate $estimate)
    {
        $data = collect();

        foreach ($estimate->generators->sortBy('concept.location')->groupBy('concept.location') as $location) {
            $additions=$location->where('quantity', '>', 0);

            $deductions=$location->where('quantity', '<', 0);

            $subTotalAdditions=0;
            $subTotalDeductions=0;

            foreach ($additions as $generator) {
                $subTotalAdditions += $generator->amount;
            }

            if (count($deductions) > 0) {
                foreach ($deductions as $generator) {
                    $subTotalDeductions += $generator->amount;
                }
            }

            $data->prepend(collect([
                //'location'          =>$location->first()->concept->location,
                'address'          =>$location->first()->concept->address,
                'additions'          =>$additions,
                'deductions'        =>$deductions,
                'subTotalAdditions'  => number_format($subTotalAdditions, 2, '.', ','),
                'subTotalDeductions'=> number_format($subTotalDeductions, 2, '.', ','),
                'subTotal'          => number_format($subTotalAdditions+$subTotalDeductions, 2, '.', ','),

            ]), $location->first()->concept->location);
        }

        $pdf = PDF::loadView('reports.cumulativeControl.pdf', compact('estimate', 'data'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('ControlAcumulativo.pdf');
    }

    public function cumulativeControlLocations(Estimate $estimate)
    {
        $locations=$estimate->contract->locations()->orderBy('name', 'asc')->get();

        $data = collect();
        $subGenerators = collect();
        $array=array();

        foreach ($estimate->generators as $generator) {
            $subGenerators->push($generator->subGenerators);
        }

        $subGenerators->collapse()->sortBy('location.name');

        $total=0;

        $locationsFiltered = $locations->filter(function ($value, $key) use ($subGenerators) {
            $additions =
                $subGenerators
                    ->collapse()
                    ->sortBy('location.name')
                    ->where('location_id', $value->id)
                    ->where('quantity', '>', 0)
                    ->sortBy('generator.concept.code')->count();
            $deductions =
                $subGenerators
                    ->collapse()
                    ->sortBy('location.name')
                    ->where('location_id', $value->id)
                    ->where('quantity', '<', 0)
                    ->sortBy('generator.concept.code')->count();

            return $additions || $deductions > 0;
        });

        foreach ($locationsFiltered as $key => $location) {
            $additions =
                $subGenerators
                    ->collapse()
                    ->sortBy('location.name')
                    ->where('location_id', $location->id)
                    ->where('quantity', '>', 0)
                    ->sortBy('generator.concept.code');
            $deductions =
                $subGenerators
                    ->collapse()
                    ->sortBy('location.name')
                    ->where('location_id', $location->id)
                    ->where('quantity', '<', 0)
                    ->sortBy('generator.concept.code');

            $subTotalAdditions = 0;
            $subTotalDeductions = 0;

            //dump($additions);
            if ($additions->isEmpty() && $deductions->isEmpty()) {
                $locations->forget($key);
            }

            foreach ($additions as $subGenerator) {
                if ($estimate->contract->type == 2) {
                    if ($estimate->start >= $estimate->contract->date_signature_covenant) {
                        if ($subGenerator->generator->concept->immovable == true) {
                            $unitPrice=$estimate->contract->originalAmount/100;
                            $subGenerator->setAttribute('unit_price', $unitPrice * 100);
                        } else {
                            $unitPrice=($estimate->contract->totalAmount + $estimate->contract->amount_adjustment) / 100;
                            $subGenerator->setAttribute('unit_price', $unitPrice * 100);
                        }
                    } else {
                        $unitPrice=$estimate->contract->originalAmount / 100;
                        $subGenerator->setAttribute('unit_price', $unitPrice * 100);
                    }
                } else {
                    $unitPrice=$subGenerator->generator->concept->unit_price;
                    $subGenerator->setAttribute('unit_price', $unitPrice);
                }

                if (array_key_exists($subGenerator->generator->concept->code, $array)) {
                    $subGenerator->setAttribute('acumuladoAnterior', format($array[$subGenerator->generator->concept->code]));
                    $subGenerator->setAttribute('acumuladoActual', format($array[$subGenerator->generator->concept->code] + ($subGenerator->generator->lastQuantity + $subGenerator->quantity)));
                    $subGenerator->setAttribute('importeAnterior', formatCash(round($unitPrice * $array[$subGenerator->generator->concept->code], 2, PHP_ROUND_HALF_DOWN)));
                    $subGenerator->setAttribute('importeActual', formatCash(round($unitPrice * $subGenerator->quantity, 2, PHP_ROUND_HALF_DOWN)));
                    $subGenerator->setAttribute('importeAcumulado', formatCash(
                        (round($unitPrice * $array[$subGenerator->generator->concept->code], 2, PHP_ROUND_HALF_DOWN))+
                        (round($unitPrice * $subGenerator->quantity, 2, PHP_ROUND_HALF_DOWN))
                    ));
                    //sumarle el valor de total y grabarlo en el arreglo
                    $array[$subGenerator->generator->concept->code] += ($subGenerator->generator->lastQuantity + $subGenerator->quantity);
                } else {
                    //agregar valor a array si no existe aun
                    $array[$subGenerator->generator->concept->code]=$subGenerator->generator->lastQuantity + $subGenerator->quantity;
                    $subGenerator->setAttribute('acumuladoAnterior', format($subGenerator->generator->lastQuantity));
                    $subGenerator->setAttribute('acumuladoActual', format($subGenerator->generator->lastQuantity + $subGenerator->quantity));
                    $subGenerator->setAttribute('importeAnterior', formatCash(round($unitPrice * $subGenerator->generator->lastQuantity, 2, PHP_ROUND_HALF_DOWN)));
                    $subGenerator->setAttribute('importeActual', formatCash(round($unitPrice * $subGenerator->quantity, 2, PHP_ROUND_HALF_DOWN)));
                    $subGenerator->setAttribute('importeAcumulado', formatCash(
                        (round($unitPrice * $subGenerator->generator->lastQuantity, 2, PHP_ROUND_HALF_DOWN))+
                        (round($unitPrice * $subGenerator->quantity, 2, PHP_ROUND_HALF_DOWN))
                    ));
                }

                $subTotalAdditions += round($unitPrice * $subGenerator->quantity, 2, PHP_ROUND_HALF_DOWN);
                $total += round($unitPrice * $subGenerator->quantity, 2, PHP_ROUND_HALF_DOWN);
                //dump($subTotalAdditions);
            }

            if (count($deductions) > 0) {
                //dd($deductivas);
                foreach ($deductions as $subGenerator) {
                    if ($estimate->contract->type == 2) {
                        if ($estimate->start >= $estimate->contract->date_signature_covenant) {
                            if ($subGenerator->generator->concept->immovable == true) {
                                $unitPrice=$estimate->contract->originalAmount/100;
                                $subGenerator->setAttribute('unit_price', $unitPrice * 100);
                            } else {
                                $unitPrice=($estimate->contract->totalAmount + $estimate->contract->amount_adjustment) / 100;
                                $subGenerator->setAttribute('unit_price', $unitPrice * 100);
                            }
                        } else {
                            $unitPrice=$estimate->contract->originalAmount / 100;
                            $subGenerator->setAttribute('unit_price', $unitPrice * 100);
                        }
                    } else {
                        $unitPrice=$subGenerator->generator->concept->unit_price;
                        $subGenerator->setAttribute('unit_price', $unitPrice);
                    }

                    if (array_key_exists($subGenerator->generator->concept->code, $array)) {
                        $subGenerator->setAttribute('acumuladoAnterior', format($array[$subGenerator->generator->concept->code]));
                        $subGenerator->setAttribute('acumuladoActual', format($array[$subGenerator->generator->concept->code] + ($subGenerator->generator->lastQuantity + $subGenerator->quantity)));
                        $subGenerator->setAttribute('importeAnterior', formatCash(round($unitPrice * $array[$subGenerator->generator->concept->code], 2, PHP_ROUND_HALF_DOWN)));
                        $subGenerator->setAttribute('importeActual', formatCash(round($unitPrice * $subGenerator->quantity, 2, PHP_ROUND_HALF_DOWN)));
                        $subGenerator->setAttribute('importeAcumulado', formatCash(
                            (round($unitPrice * $array[$subGenerator->generator->concept->code], 2, PHP_ROUND_HALF_DOWN))+
                            (round($unitPrice * $subGenerator->quantity, 2, PHP_ROUND_HALF_DOWN))
                        ));
                        //sumarle el valor de total y grabarlo en el arreglo
                        $array[$subGenerator->generator->concept->code] += ($subGenerator->generator->lastQuantity + $subGenerator->quantity);
                    } else {
                        //agregar valor a array si no existe aun
                        $array[$subGenerator->generator->concept->code]=$subGenerator->generator->lastQuantity + $subGenerator->quantity;
                        $subGenerator->setAttribute('acumuladoAnterior', format($subGenerator->generator->lastQuantity));
                        $subGenerator->setAttribute('acumuladoActual', format($subGenerator->generator->lastQuantity + $subGenerator->quantity));
                        $subGenerator->setAttribute('importeAnterior', formatCash(round($unitPrice * $subGenerator->generator->lastQuantity, 2, PHP_ROUND_HALF_DOWN)));
                        $subGenerator->setAttribute('importeActual', formatCash(round($unitPrice * $subGenerator->quantity, 2, PHP_ROUND_HALF_DOWN)));
                        $subGenerator->setAttribute('importeAcumulado', formatCash(
                            (round($unitPrice * $subGenerator->generator->lastQuantity, 2, PHP_ROUND_HALF_DOWN))+
                            (round($unitPrice * $subGenerator->quantity, 2, PHP_ROUND_HALF_DOWN))
                        ));
                    }

                    $subTotalDeductions += round($unitPrice * $subGenerator->quantity, 2, PHP_ROUND_HALF_DOWN);
                    $total += round($unitPrice * $subGenerator->quantity, 2, PHP_ROUND_HALF_DOWN);
                }
            }


            $data->push(collect([
                'location'          =>$location->name,
                'address'           =>$location->address,
                'additions'          =>$additions,
                'deductions'        =>$deductions,
                'subTotalAdditions' => formatCash($subTotalAdditions),
                'subTotalDeductions'=> formatCash($subTotalDeductions),
                'subTotal'          => formatCash($subTotalAdditions+$subTotalDeductions),

            ]), $location->name);
        }

        $pdf = PDF::loadView(
            'reports.cumulativeControlLocations.pdf',
            compact('estimate', 'data', 'total')
        );
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('ControlAacumFrentes.pdf', array('Attachment'=>0));
    }

    public function accountingStatement(Estimate $estimate)
    {
        $pdf = PDF::loadView('reports.accountingStatement.pdf', compact('estimate'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('estadoContable.pdf');
    }

    public function finalSummary(Contract $contract)
    {
        $concepts = $contract->concepts()->with('contract.estimates')->orderBy('id', 'asc')->get();
        $numEstimates = $contract->estimates()->count();
        $estimates = $contract->estimates()->with('generators.concept')->get();
        //dump($concepts, $numEstimates, $estimates, $contract);
        foreach ($concepts as $concept) {
            $concept->setAttribute(
                'data',
                Generator::join('concepts', 'concepts.id', '=', 'concept_estimate.concept_id')
                    ->join('estimates', 'estimates.id', '=', 'concept_estimate.estimate_id')
                    ->select(
                        'concepts.code',
                        'concepts.name',
                        'concepts.measurement_unit',
                        'concepts.quantity',
                        'concepts.unit_price',
                        'concept_estimate.quantity',
                        'estimates.number'
                    )
                    ->where('concept_id', $concept->id)
                    ->orderBy('code', 'asc')
                    ->get()
            );
            $concept->setAttribute(
                'total',
                Generator::where('concept_id', $concept->id)
                    ->sum('quantity')
            );
        }
        return view('reports.finalSummary.pdf', compact('contract', 'concepts', 'estimates', 'numEstimates'));
    }
}
