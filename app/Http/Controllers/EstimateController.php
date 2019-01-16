<?php

namespace App\Http\Controllers;

use App\Estimate;
use App\Http\Requests\StoreEstimate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EstimateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('estimate.index',compact('request'));
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
        if($estimate = Estimate::where('contract_id',$request['contract'])
            ->where('number',$request['number'])
            ->first()){
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
        session()->flash('success','La estimación a sido añadida en la base de datos correctamente');
        return redirect(route('estimate.create'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
