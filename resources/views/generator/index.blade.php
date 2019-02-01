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
                                    <a href="{{ url()->previous() }}" class="btn btn-outline-primary">
                                        <i class="fas fa-arrow-left"></i>
                                    </a>
                                    Generadores de la estimacion: <span class="font-weight-bold">{{ $estimate->number }}</span> del contrato <span class="font-weight-bold">{{ $estimate->contract->codeOk }}</span>
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
                                    <th class="text-left">Código</th>
                                    <th class="d-none d-md-table-cell">Concepto</th>
                                    <th class="d-none d-md-table-cell">Ubicación</th>
                                    <th>U.M.</th>
                                    <th>Tipo</th>
                                    <th>Cantidad</th>
                                    <th>125%</th>
                                    <th>Acumulado</th>
                                    <th>Total</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($generators as $generator)
                                    <tr>
                                        <th class="text-left">{{ $generator->concept->code }}</th>
                                        <td class="d-none d-md-table-cell"><small>{{ $generator->concept->nameOk }}</small></td>
                                        <td class="d-none d-md-table-cell"><small>{{ $generator->concept->locationOk }}</small></td>
                                        <td>{{ $generator->concept->measurementUnitOk }}</td>
                                        <td>{{ $generator->concept->type }}</td>
                                        <td>{{ $generator->concept->quantityOk }}</td>
                                        <td>{{ $generator->concept->quantityMax }}</td>
                                        <td>{{ $generator->lastTotal }}</td>
                                        <td>{{ $generator->quantityOk }}</td>
                                        <td class="">
                                            <a href="#"><i class="fas fa-edit"></i></a>
                                            <a href="#"><i class="fas fa-trash-alt text-danger"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <p class="text-danger">NO SE ENCONTRARON GENERADORES EN ESTIMACIÓN</p>
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
