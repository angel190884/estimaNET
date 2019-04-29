<?php

namespace App\Http\Controllers;

use App\Contract;
use App\Estimate;
use App\Http\Requests\StoreEstimate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Charts\EstimationAmounts;

class EstimateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('estimate.index', compact('request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('estimate.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEstimate  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEstimate $request)
    {
        if ($estimate = Estimate::where('contract_id', $request['contract'])
            ->where('number', $request['number'])
            ->first()) {
            Log::error("Duplicate estimate : $estimate");
            return redirect(route('estimate.create'))->withErrors('La estimación que intentas grabar ya existe favor de verificar número');
        }
        $estimate = Estimate::firstOrCreate([
            'number' => $request['number'],

            'contract_id' => $request['contract'],

            'start' => $request['start'],
            'finish' => $request['finish'],
            'release' => $request['release'],

            'retention' => $request['retention'],

            'type' => $request['type'],

        ]);

        $user=auth()->user();
        Log::info("add estimate $estimate $user");
        session()->flash('success', 'La estimación a sido añadida en la base de datos correctamente');
        return redirect(route('estimate.create'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Estimate $estimate)
    {
        $chart = new EstimationAmounts;
        $chart->labels(['Total x Estimar', 'Estimado Anterior', 'Esta Estimación']);
        $chart->loaderColor('red');
        $chart->height(150);
        $chart->minimalist(true);
        $chart->displayLegend(false);
        $chart->dataset('montos', 'pie', [$estimate->totalForExecuteAmount, $estimate->totalPreviousAmount, $estimate->totalEstimateAmount])->options(['backgroundColor' => ['#FF637D', '#F4F1BB', '#66D7B1']]);
        //$chart->dataset('montos', 'pie', [10, 11, 10])->options(['backgroundColor' => ['#FF637D', '#F4F1BB', '#66D7B1']]);
        
        return view('estimate.show', compact('estimate', 'chart'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Estimate $estimate)
    {
        return view('estimate.edit', compact('estimate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreEstimate  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreEstimate $request, Estimate $estimate)
    {
        $estimate->number = $request['number'];
        $estimate->contract_id = $request['contract'];
        $estimate->start = $request['start'];
        $estimate->finish = $request['finish'];
        $estimate->release = $request['release'];
        $estimate->retention = $request['retention'];
        $estimate->type = $request['type'];


        $estimate->save();
        
        $user=auth()->user();
        
        
        foreach ($user->deductions as $deduction) {
            $nameKey='deduction-' . $deduction->id;
            $factorKey='factor-' . $deduction->id;

            if ($request->has($nameKey)) {
                if ($estimate->deductions()->where('deduction_id', $deduction->id)->first()) {
                    $estimate->deductions()->updateExistingPivot($deduction->id, ['factor'=> $request[ $factorKey ]]);
                } else {
                    $estimate->deductions()->attach($deduction->id, ['factor'=> $request[ $factorKey ]]);
                }
            }
            if (!$request->has($nameKey)) {
                $estimate->deductions()->detach($deduction->id);
            }
        }
        
        Log::info("update estimate $estimate $user");
        session()->flash('success', 'La estimación a sido actualizada en la base de datos correctamente');
        return redirect(route('estimate.index', ['code' => $estimate->contract->codeOk]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function monitoringIndex()
    {
        $contracts = auth()->user()->contracts()->active()->with('estimates', 'deductions', 'concepts')->get();
        return view('estimate.monitoringEstimates', compact('contracts'));
    }
}
