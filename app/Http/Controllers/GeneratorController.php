<?php

namespace App\Http\Controllers;

use App\Estimate;
use App\Generator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreGenerator;
use App\Http\Requests\UpdateGenerator;

class GeneratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Estimate  $estimate
     * @return \Illuminate\Http\Response
     */
    public function list(Estimate $estimate)
    {
        $generators=$estimate->generators->sortBy('concept.code')->sortBy('concept.location')->sortByDesc('concept.type');

        return view('generator.index',compact('generators','estimate'));
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
     * @param  \App\Http\Requests\StoreGenerator  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGenerator $request)
    {
        $estimate=Estimate::find($request->estimate_id);
        if ($estimate->concepts->contains($request->concept_id)){
            session()->flash('danger','¡¡¡ No se pudo añadir el generador, existe otro registro con los mismos datos !!!');
            return redirect(route('generator.list', $estimate->id));
        }

        $estimate->concepts()->attach($request->concept_id,[
            'quantity' => 0
        ]);

        $generator=Generator::where('concept_id',$request->concept_id)
            ->where('estimate_id',$estimate->id)->first();

        $locations=$estimate->contract->locations()->get();

        $generator->locations()->attach($locations, [
            'created_at' => Carbon::now()
        ]);

        session()->flash('success','El generador, se añadio correctamente.');
        return redirect(route('generator.list', $estimate->id));
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
     * @param  \App\Http\Requests\UpdateGenerator  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGenerator $request, $id)
    {
        $generator = Generator::find($id);

        if (round(
            $generator->lastQuantity + $request->quantity,
            6,
            PHP_ROUND_HALF_DOWN)
            >
            round(
                $generator->concept->quantityMax,
                6,
                PHP_ROUND_HALF_DOWN)
            ){
            $exceededQuantity = round(
                round($generator->lastQuantity + $request->quantity, 6, PHP_ROUND_HALF_DOWN) -
                round($generator->concept->quantityMax, 6, PHP_ROUND_HALF_DOWN),6,PHP_ROUND_HALF_DOWN);
            session()->flash('danger',"El acumulado anterior + la nueva cantidad, excede del 125% por $exceededQuantity de la cantidad permitida del concepto favor de revisar!!!");
            return redirect(route('generator.list', $generator->estimate->id));
        }

        $generator->quantity = $request->quantity;
        $generator->save();

        $user=auth()->user();
        Log::info("update generator $generator $user");
        session()->flash('success','El generador a sido actualizado en la base de datos correctamente');
        return redirect(route('generator.list', $generator->estimate->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $generator=Generator::find($id);
        $estimateId=$generator->estimate->id;
        Generator::destroy($id);

        $user=auth()->user();
        Log::info("destroy generator $generator $user");
        session()->flash('success','El generador a sido eliminado de la base de datos correctamente');

        return redirect(route('generator.list',$estimateId));
    }
}
