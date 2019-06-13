<?php

namespace App\Http\Controllers;

use App\Concept;
use App\Contract;
use App\Http\Requests\StoreConcept;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ConceptsImport;

class ConceptController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('concept.index', compact('request'));
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
        if (count($concept = Concept::where('code', $request['code'])->first())) {
            Log::error("Duplicate contract : $concept");
            return redirect(route('contract.create'))->withErrors('El contrato que intentas grabar ya existe favor de verificar código');
        }

        $concept = Concept::firstOrCreate([
            'code'      => strtoupper($request['code']),
            'name'      => strtoupper($request['name']),
            'location'  => strtoupper($request['location']),
            'address'   => strtoupper($request['address']),
            'contract_id' => $request['contract'],
            'measurement_unit' => strtoupper($request['measurementUnit']),
            'type'      => strtoupper($request['type']),
            'unit_price' => $request['unitPrice'],
            'quantity'  => $request['quantity'],
        ]);

        $user=auth()->user();
        Log::info("add concept $concept $user");
        session()->flash('success', 'El concepto a sido añadido en la base de datos correctamente');
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
     * @param  \App\Concept  $concept
     * @return \Illuminate\Http\Response
     */
    public function edit(Concept $concept)
    {
        return view('concept.edit', compact('concept'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreConcept  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreConcept $request, $id)
    {
        $concept = Concept::find($id);


        $concept->code = strtoupper($request['code']);

        $concept->name = strtoupper($request['name']);
        $concept->location  = strtoupper($request['location']);
        $concept->address  = strtoupper($request['address']);
        $concept->contract_id = $request['contract'];
        $concept->measurement_unit = strtoupper($request['measurementUnit']);
        $concept->type = strtoupper($request['type']);
        $concept->unit_price = $request['unitPrice'];
        $concept->quantity  = $request['quantity'];

        $concept->save();


        $user=auth()->user();
        Log::info("update concept $concept $user");
        session()->flash('success', 'El concepto a sido actualizado en la base de datos correctamente');
        return redirect(route('concept.index'));
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

    /**
     * Update catalog from excel.
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function updateCatalog(Request $request)
    {
        if (mb_strtolower($request->file('file')->getClientOriginalExtension()) == "xlsx") {

            Excel::import(new ConceptsImport($request->contract_id), request()->file('file'));
            
            Log::info("add catalog excel $this->user");
            session()->flash('success', 'El catalogo a sido agregado en la base de datos correctamente.');
            return redirect(route('contract.index'));
        } 

        session()->flash('danger', 'El archivo que intentas procesar NO es un archivo de Excel con extensión XLSX.');
        return redirect(route('contract.index'));
    }
}
