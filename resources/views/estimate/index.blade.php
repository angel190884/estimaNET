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
                                    Estimaciones
                                </div>
                                <div class="col-sm-12 col-md-6 text-md-right text-info hidden">
                                    lista de estimaciones asignadas
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
                                <thead>
                                <tr>
                                    <th>Contrato</th>
                                    <th># Estimación</th>
                                    <th>Inicio</th>
                                    <th>Fin</th>
                                    <th>Impresión</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @forelse(auth()->user()->contracts()->get() as $contract)
                                        @forelse($contract->estimates()->orderBy('number','desc')->get() as $estimate)
                                            <tr>
                                                <th>{{ $contract->short_name }}</th>
                                                <td>{{ $estimate->number }}</td>
                                                <td>{{ $estimate->startOk }}</td>
                                                <td>{{ $estimate->finishOk }}</td>
                                                <td>{{ $estimate->releaseOk }}</td>
                                                <td>
                                                    <a href="{{ route('estimate.edit',$estimate) }}"><i class="fas fa-edit fa-2x"></i></a>
                                                </td>
                                            </tr>
                                        @empty
                                            <p class="text-danger">NO SE ENCONTRARON ESTIMACIONES</p>
                                        @endforelse
                                    @empty
                                        <p class="text-danger">NO SE ENCONTRARON CONTRATOS ASIGNADOS</p>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
