@extends('layouts.app')

@section('content')
    <div class="container-fluid pb-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="container-fluid m-auto p-0">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    Conceptos @if($request->code) del contrato <span class="font-weight-bold">{{ $request->code }}</span> @endif
                                </div>
                                <div class="col-sm-12 col-md-6 text-md-right text-info hidden">
                                    <form action="{{ route('concept.index') }}" method="get">
                                        <div class="row">
                                            <div class="col-auto">
                                                <a class="btn btn-primary" href="{{ route('concept.create') }}" role="button"><i class="fas fa-plus"></i></a>
                                            </div>
                                            <div class="col">
                                                <label class="sr-only" for="conceptCode">Usuario</label>
                                                <div class="input-group mb-2 mr-sm-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"><i class="fas fa-snowplow"></i></div>
                                                    </div>
                                                    <select name="code" class="form-control" id="conceptCode">
                                                        <option value="" {{ old('code') != null ? '' : 'selected' }}>selecciona...</option>
                                                    @foreach(auth()->user()->contracts()->orderBy('code')->get() as $contract)
                                                            <option value="{{ $contract->code }}" {{ old('code') == $contract->code ? 'selected' : '' }}>{{ $contract->codeOk }}</option>
                                                        @endforeach
                                                    </select>
                                                    @include('layouts.components.alert.field', ['field' => 'code'])
                                                </div>
                                                <!--<input name="code" type="text" value="{{ old('code') }}" class="form-control" placeholder="Filtrar Estimaciones por contrato">-->
                                            </div>
                                            <div class="col-auto">
                                                <button class="btn btn-outline-success"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="table-responsive text-center">
                            <table class="table table-hover table-striped">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Código</th>
                                    <th class="d-none d-lg-table-cell">Contrato</th>
                                    <th class="d-none d-lg-table-cell">Frente</th>
                                    <th class="d-none d-lg-table-cell">Concepto</th>
                                    <th class="d-none d-md-table-cell">U.M.</th>
                                    <th>P.U.</th>
                                    <th>Cantidad</th>
                                    <th>tipo</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if($request->get('code'))
                                        @foreach(auth()->user()->contracts()->code($request['code'])->get() as $contract)
                                            @foreach($contract->concepts()->name($request['name'])->orderBy('name','desc')->get() as $concept)
                                                <tr>
                                                    <th>{{ $concept->codeOk }}</th>
                                                    <td class="d-none d-lg-table-cell">{{ $concept->contract->codeOk }}</td>
                                                    <td class="d-none d-lg-table-cell">{{ $concept->location }}</td>
                                                    <td class="d-none d-lg-table-cell">{{ $concept->name }}</td>
                                                    <td class="d-none d-md-table-cell">{{ $concept->measurement_unit }}</td>
                                                    <td>{{ $concept->unitPriceOk }}</td>
                                                    <td>{{ $concept->quantityOk }}</td>
                                                    <td>{{ $concept->type }}</td>
                                                    <td>
                                                        <a href="{{ route('concept.edit',$concept) }}"><i class="fas fa-edit fa-2x"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @else
                                        <p class="text-danger">SELECCIONA UN CONTRATO</p>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
