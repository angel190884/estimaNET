<?php

namespace App\Http\Controllers;

use App\Company;
use App\Contract;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreContract;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contracts = auth()->user()->contracts()->orderBy('short_name')->get();
        return view('contract.index', compact('contracts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies= Company::orderBy('reason_social')->pluck('reason_social', 'id');
        return view('contract.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreContract  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContract $request)
    {
        if (count($contract = Contract::where('code', $request['code'])->first())) {
            Log::error("Duplicate contract : $contract");
            return redirect(route('contract.create'))->withErrors('El contrato que intentas grabar ya existe favor de verificar código');
        }

        $contract = Contract::firstOrCreate([
            'code' => $request['code'],

            'name' => $request['name'],
            'short_name' => $request['short_name'],
            'description' => $request['description'],
            'location' => $request['location'],

            'amount_total' => $request['amount_total'],
            'amount_anticipated' => $request['amount_anticipated'],
            'amount_extension' => $request['amount_extension'],
            'amount_adjustment' => $request['amount_adjustment'],

            'date_start' => $request['date_start'],
            'date_finish' => $request['date_finish'],
            'date_signature' => $request['date_signature'],
            'date_signature_covenant' => $request['date_signature_covenant'],
            'date_finish_modified' => $request['date_finish_modified'],

            'type' => $request['type'],

            'active' => $request['active'],
            'split_catalog' => $request['split_catalog'],

            'signature_1' => $request['signature1'],
            'signature_2' => $request['signature2'],
            'signature_3' => $request['signature3'],
            'signature_4' => $request['signature4'],
            'signature_5' => $request['signature5'],
            'signature_6' => $request['signature6'],

        ]);

        $contract->users()->attach(auth()->user());


        if ($company = Company::find($request['company'])) {
            $contract->companies()->attach($company);
        }

        $user=auth()->user();

        $arrayDeduction = array();
        foreach ($user->deductions as $deduction) {
            $nameKey='deduction-' . $deduction->id;
            if ($request->has($nameKey)) {
                Arr::push($arrayDeduction, $deduction->id);
            }
        }
        $contract->deductions()->sync($arrayDeduction);


        Log::info("add contract $contract $user");
        session()->flash('success', 'El contrato a sido añadido en la base de datos correctamente');
        return redirect(route('contract.index'));
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
     * @param  $contract
     * @return \Illuminate\Http\Response
     */
    public function edit(Contract $contract)
    {
        //dd($contract->companies()->count());
        $companies= Company::orderBy('reason_social')->pluck('reason_social', 'id');
        return view('contract.edit', compact('contract', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreContract $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreContract $request, $id)
    {
        $contract = Contract::find($id);

        $contract->code = $request['code'];

        $contract->name = $request['name'];
        $contract->short_name = $request['short_name'];
        $contract->description = $request['description'];
        $contract->location = $request['location'];

        $contract->amount_total = $request['amount_total'];
        $contract->amount_anticipated = $request['amount_anticipated'];
        $contract->amount_extension = $request['amount_extension'];
        $contract->amount_adjustment = $request['amount_adjustment'];

        $contract->date_start = $request['date_start'];
        $contract->date_finish = $request['date_finish'];
        $contract->date_signature = $request['date_signature'];
        $contract->date_signature_covenant = $request['date_signature_covenant'];
        $contract->date_finish_modified = $request['date_finish_modified'];

        $contract->type= $request['type'];

        $contract->active = $request['active'];
        $contract->split_catalog = $request['split_catalog'];

        $contract->companies()->sync($request['company']);

        $contract->signature_1 = $request['signature1'];
        $contract->signature_2 = $request['signature2'];
        $contract->signature_3 = $request['signature3'];
        $contract->signature_4 = $request['signature4'];
        $contract->signature_5 = $request['signature5'];
        $contract->signature_6 = $request['signature6'];

        $contract->save();

        $user=auth()->user();

        $arrayDeduction = [];
        foreach ($user->deductions as $deduction) {
            $nameKey='deduction-' . $deduction->id;
            if ($request->has($nameKey)) {
                array_push($arrayDeduction, $deduction->id);
            }
        }
        $contract->deductions()->sync($arrayDeduction);

        Log::info("update contract $contract $user");
        session()->flash('success', 'El contrato a sido actualizado en la base de datos correctamente');
        return redirect(route('contract.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
