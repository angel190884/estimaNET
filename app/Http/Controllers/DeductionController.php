<?php

namespace App\Http\Controllers;

use App\Deduction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreDeduction;

class DeductionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deductions = auth()->user()->deductions()->get();
        return view('deduction.index', compact('deductions'));
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
    public function store(StoreDeduction $request)
    {
        $user = auth()->user();
        $deduction = Deduction::firstOrCreate([
            'user_id' => $user->id,
            'code' => $request['code'],
            'name' => $request['name'],
            'percentage' => $request['percentage'],
            'type' => $request['type'],
            'description' => $request['description'],
        ]);

        Log::info("add deduction $deduction $user");
        session()->flash('success', 'La deduccion a sido añadida en la base de datos correctamente');
        return redirect(route('deduction.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Deduction  $deduction
     * @return \Illuminate\Http\Response
     */
    public function show(Deduction $deduction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Deduction  $deduction
     * @return \Illuminate\Http\Response
     */
    public function edit(Deduction $deduction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Deduction  $deduction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Deduction $deduction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Deduction  $deduction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deduction $deduction)
    {
        //
    }
}
