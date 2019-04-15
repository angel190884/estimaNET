<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLocation;
use App\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->contract_id){
            $locations = Location::searchContract($request->contract_id)->orderBy('name','asc')->get();
            return view('location.index', compact('locations'));
        }
        return view('location.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLocation  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLocation $request)
    {
        $user=auth()->user();
        if($location = Location::where('contract_id',$request['contract_id'])
            ->where('name',$request['name'])
            ->first()){
            Log::error("Duplicate location : $location $user");
            return redirect(route('location.index'))->withErrors('La ubicación que intentas grabar ya existe favor de verificar');
        }
        $location = Location::firstOrCreate([
            'name' => strtoupper($request['name']),
            'contract_id' => strtoupper($request['contract_id']),
            'address' => strtoupper($request['address']),
            'observations' => strtoupper($request['observations'])
        ]);

        if ($location){
            $concepts = $location->contract->concepts->all();
            foreach ($concepts as $concept){
                $generators = $concept->generators->all();
                foreach ($generators as $generator){
                    $generator->locations()->attach($location,['quantity' => 0]);
                }
            }
        }

        Log::info("add location $location $user");
        session()->flash('success','La estimación a sido añadida en la base de datos correctamente.');

        return redirect(route('location.index',['contract_id' => $request->contract_id]));
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
        $location= Location::find($id);
        Location::destroy($id);

        //$generator=Generator::find($id);
        //$estimateId=$generator->estimate->id;
        //Generator::destroy($id);

        $user=auth()->user();
        Log::info("destroy location $location $user");
        session()->flash('success','El frente a sido eliminado de la base de datos correctamente.');

        return redirect(route('location.index',['contract_id' => $location->contract->id]));
    }
}
