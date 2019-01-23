<?php

namespace App\Http\Controllers;

use App\Concept;
use App\Http\Requests\StoreConcept;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ConceptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('concept.index',compact('request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('concept.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreConcept  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreConcept $request)
    {
        if(count($concept = Concept::where('code',$request['code'])->first())){
            Log::error("Duplicate contract : $concept");
            return redirect(route('contract.create'))->withErrors('El contrato que intentas grabar ya existe favor de verificar código');
        }

        $concept = Concept::firstOrCreate([
            'code'      => $request['code'],
            'name'      => $request['name'],
            'location'  => $request['location'],
            'address'   => $request['address'],
            'contract_id' => $request['contract'],
            'measurement_unit' => $request['measurementUnit'],
            'type'      => $request['type'],
            'unit_price' => $request['unitPrice'],
            'quantity'  => $request['quantity'],
        ]);

        $user=auth()->user();
        Log::info("add concept $concept $user");
        session()->flash('success','El concepto a sido añadido en la base de datos correctamente');
        return redirect(route('concept.create'));
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
        var_dump($id);
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
