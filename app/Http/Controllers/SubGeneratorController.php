<?php

namespace App\Http\Controllers;

use App\Generator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubGeneratorController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $user=auth()->user();
        $generator = Generator::find($id);
        $total = 0;

        foreach ($generator->subGenerators()->get() as $subGenerator){
            $textRequest = 'quantitySubGenerator'.$subGenerator->id;
            $total+=$request[$textRequest];
        }

        if (round(
            $generator->lastQuantity + $total,
            6,PHP_ROUND_HALF_DOWN)
            >
            round(
                $generator->concept->quantityMax,
                6,
                PHP_ROUND_HALF_DOWN
            )){
            $exceededQuantity = round(round($generator->lastQuantity + $total,6,PHP_ROUND_HALF_DOWN) -
                round($generator->concept->quantityMax,6,PHP_ROUND_HALF_DOWN),6 ,PHP_ROUND_HALF_DOWN);
            session()->flash('danger',"El acumulado anterior + la suma de la subdivisión, excede del 125% por $exceededQuantity de la cantidad permitida del concepto favor de revisar!!!");
            return redirect(route('generator.list', $generator->estimate->id));
        }

        foreach ($generator->subGenerators()->get() as $subGenerator){
            $textRequest = 'quantitySubGenerator'.$subGenerator->id;
            $subGenerator->quantity = $request[$textRequest];
            $subGenerator->save();

            Log::info("update subGenerator $subGenerator $user");
        }


        $total=$generator->subGenerators()->sum('quantity');
        $generator->quantity = $total;
        $generator->save();

        Log::info("update generator $generator $user");
        session()->flash('success','El generador a sido subdivido correctamente');
        return redirect(route('generator.list',$generator->estimate->id));

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
