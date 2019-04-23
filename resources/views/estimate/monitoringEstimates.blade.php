@extends('layouts.app')

@section('content')
    <div class="container-fluid pb-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="container-fluid m-auto p-0">
                            <div class="row">
                                <div class="col-sm-12 col-md-2">
                                    Estimaciones
                                </div>
                                <div class="col-sm-12 col-md-10 text-md-right text-info hidden">
                                    <div class="col-auto">
                                        <label for="status-1" class="d-sm-none d-md-none">Contratista</label>
                                        <button class="btn text-dark" title="Empresa Contratista" id="status-1"><i class="fas fa-snowplow fa-2x"></i></button>

                                        <label for="status-2" class="d-sm-none d-md-none">Super. Externa</label>
                                        <button class="btn btn-outline-primary" title="Supervisión Externa" id="status-2"><i class="fas fa-eye fa-2x"></i></button>

                                        <label for="status-3" class="d-sm-none d-md-none">Super. Interna</label>
                                        <button class="btn btn-outline-secondary" title="Supervisión Interna" id="status-3"><i class="fas fa-clipboard-check fa-2x"></i></button>

                                        <label for="status-4" class="d-sm-none d-md-none">Firma JUD</label>
                                        <button class="btn btn-outline-info" title="JUD para revisión" id="status-4"><i class="fas fa-feather-alt fa-2x"></i></button>

                                        <label for="status-5" class="d-sm-none d-md-none">Firma Dir. Supervisión</label>
                                        <button class="btn btn-outline-warning text-dark" title="Director de Supervisión para revisión" id="status-5"><i class="fas fa-feather fa-2x"></i></button>

                                        <label for="status-6" class="d-sm-none d-md-none">Ctrl. Técnico</label>
                                        <button class="btn btn-outline-danger" title="Control Técnico para revisión" id="status-6"><i class="fas fa-cogs fa-2x"></i></button>

                                        <label for="status-6" class="d-sm-none d-md-none">Finanzas</label>
                                        <button class="btn btn-outline-dark" title="Finanzas para autorización" id="status-6"><i class="fas fa-dollar-sign fa-2x"></i></button>

                                        <label for="status-6" class="d-sm-none d-md-none">Pagada</label>
                                        <button class="btn btn-outline-success" title="Pagada con CLC" id="status-6"><i class="fas fa-hand-holding-usd fa-2x"></i></button>

                                    </div>
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
                                    <th>Contrato</th>
                                    <th class="d-none d-md-table-cell">Empresa</th>
                                    <th>Tipo</th>
                                    <th class="d-none d-md-table-cell">Monto</th>
                                    <th>Estimaciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @forelse($contracts as $contract)
                                        <tr>
                                            <th class="d-none d-md-table-cell">sys_{{ $contract->id }}</th>
                                            <td>{{ $contract->short_name }}</td>
                                            <th class="d-none d-md-table-cell">
                                                @if($contract->companies()->count() > 0)
                                                    {{ strtoupper($contract->companies()->first()->reason_social) }}
                                                @else
                                                    ---
                                                @endif
                                            </th>
                                            <td>
                                                @switch($contract->typeOk)
                                                    @case('builder')
                                                    <i class="fas fa-snowplow"></i>
                                                    @break
                                                    @case('supervision')
                                                    <i class="fas fa-eye"></i>
                                                    @break
                                                    @default
                                                    <i class="fas fa-snowplow"></i>
                                                @endswitch
                                            </td>
                                            <td class="d-none d-md-table-cell">$ {{ $contract->totalAmountOk }}</td>
                                            <td class="text-left">
                                                @forelse($contract->estimates()->orderBy('number','asc')->get() as $estimate)
                                                    @switch($estimate->status)
                                                        @case(1)
                                                        <a href="{{ route('estimate.show',$estimate) }}" class="btn btn-light text-dark" title="Empresa Contratista" id="status-1">{{ $estimate->number }}</a>
                                                        @break
                                                        @case(2)
                                                        <a href="{{ route('estimate.show',$estimate) }}" class="btn btn-primary" title="Supervisión Externa" id="status-2">{{ $estimate->number }}</a>
                                                        @break
                                                        @case(3)
                                                        <a href="{{ route('estimate.show',$estimate) }}" class="btn btn-secondary text-white" title="Supervisión Interna" id="status-3">{{ $estimate->number }}</a>
                                                        @break
                                                        @case(4)
                                                        <a href="{{ route('estimate.show',$estimate) }}" class="btn btn-info" title="JUD para revisión" id="status-4">{{ $estimate->number }}</a>
                                                        @break
                                                        @case(5)
                                                        <a href="{{ route('estimate.show',$estimate) }}" class="btn btn-warning" title="Director de Supervisión para revisión" id="status-5">{{ $estimate->number }}</a>
                                                        @break
                                                        @case(6)
                                                        <a href="{{ route('estimate.show',$estimate) }}" class="btn btn-danger" title="Control Técnico para revisión" id="status-6">{{ $estimate->number }}</a>
                                                        @break
                                                        @case(7)
                                                        <a href="{{ route('estimate.show',$estimate) }}" class="btn btn-dark text-white" title="Finanzas para autorización" id="status-7">{{ $estimate->number }}</a>
                                                        @break
                                                        @case(8)
                                                        <a href="{{ route('estimate.show',$estimate) }}" class="btn btn-success" title="Pagada con CLC" id="status-8">{{ $estimate->number }}</a>
                                                        @break
                                                        @default
                                                        <a href="{{ route('estimate.show',$estimate) }}" class="btn text-dark" title="Empresa Contratista" id="status-1">{{ $estimate->number }}</a>
                                                    @endswitch
                                                @empty
                                                    <p class="text-danger">NO SE ENCONTRARON ESTIMACIONES</p>
                                                @endforelse
                                            </td>
                                        </tr>
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
