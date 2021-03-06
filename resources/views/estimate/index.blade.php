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
                                    Estimaciones @if($request->code) del contrato <span class="font-weight-bold">{{ $request->code }}</span> @endif
                                </div>
                                <div class="col-sm-12 col-md-6 text-md-right text-info hidden">
                                    <form action="{{ route('estimate.index') }}" method="get">
                                        <div class="row">
                                            <div class="col">
                                                <label class="sr-only" for="grupoNombre">Usuario</label>
                                                <div class="input-group mb-2 mr-sm-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"><i class="fas fa-snowplow"></i></div>
                                                    </div>
                                                    <select name="code" class="form-control" id="codeContract">
                                                        <option value="" selected>selecciona...</option>
                                                        @foreach(auth()->user()->contracts()->orderBy('code')->get() as $key => $contract)
                                                            <option value="{{ $contract->codeOk }}">{{ $contract->codeOk }}</option>
                                                        @endforeach
                                                    </select>
                                                    @include('layouts.components.alert.field', ['field' => 'code'])
                                                </div>
                                            <!--<input name="code" type="text" value="{{ old('code') }}" class="form-control" placeholder="Filtrar Estimaciones por contrato">-->
                                            </div>
                                            <div class="col-auto">
                                                <button class="btn btn-outline-success" title="Buscar Estimaciones"><i class="fas fa-search"></i></button>
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
                                    <th class="d-none d-md-table-cell">id sistema</th>
                                    <th class="d-none d-md-table-cell">Contrato</th>
                                    <th># Estimación</th>
                                    <th class="d-none d-md-table-cell">Tipo</th>
                                    <th class="d-none d-md-table-cell">Inicio</th>
                                    <th class="d-none d-md-table-cell">Fin</th>
                                    <th class="d-none d-md-table-cell">Impresión</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($request->get('code'))
                                    @forelse(auth()->user()->contracts()->code($request->get('code'))->get() as $contract)
                                        @forelse($contract->estimates()->orderBy('number','asc')->get() as $estimate)
                                            <tr>
                                                <th class="d-none d-md-table-cell">sys_{{ $estimate->id }}</th>
                                                <td class="d-none d-md-table-cell">{{ $contract->short_name }}</td>
                                                <th>{{ $estimate->number }}</th>
                                                <td class="d-none d-md-table-cell">{{ $estimate->typeOk }}</td>
                                                <td class="d-none d-md-table-cell">{{ $estimate->startOk }}</td>
                                                <td class="d-none d-md-table-cell">{{ $estimate->finishOk }}</td>
                                                <td class="d-none d-md-table-cell">{{ $estimate->releaseOk }}</td>
                                                <td>
                                                    <a href="{{ route('estimate.edit',$estimate) }}" class="btn btn-primary btn-sm" role="button" title="Editar Estimación"><i class="fas fa-edit fa-2x"></i></a>
                                                    <a href="{{ route('generator.list',$estimate) }}" class="btn btn-primary btn-sm" role="button" title="Cargar Conceptos"><i class="fas fa-clipboard-list fa-2x"></i></a>

                                                    @if($contract->split_catalog)
                                                        <a href="{{ route('report.cumulativeControlLocations',$estimate) }}" target="_blank" class="btn btn-primary btn-sm" role="button" title="Imprimir Control Acumulativo"><i class="fas fa-file-pdf bg-danger text-white fa-2x"></i></a>
                                                    @else
                                                        <a href="{{ route('report.cumulativeControl',$estimate) }}" target="_blank" class="btn btn-primary btn-sm" role="button" title="Imprimir Control Acumulativo"><i class="fas fa-file-pdf bg-danger text-white fa-2x"></i></a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <p class="text-danger">NO SE ENCONTRARON ESTIMACIONES</p>
                                        @endforelse
                                    @empty
                                        <p class="text-danger">NO SE ENCONTRARON CONTRATOS ASIGNADOS</p>
                                    @endforelse
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
