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
                                Contratos
                            </div>
                            <div class="col-sm-12 col-md-6 text-md-right text-info hidden">
                                lista de contratos asignados
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
                                <th>Cod</th>
                                <th class="d-none d-sm-table-cell"># Contrato</th>

                                <th class="d-none d-md-table-cell">Inicio</th>
                                <th class="d-none d-md-table-cell">Término</th>
                                <th class="d-none d-lg-table-cell">Firma </th>
                                <th class="d-none d-lg-table-cell">Firma Convenio</th>
                                <th class="d-none d-lg-table-cell">Fecha Convenio Mod</th>

                                <th class="d-none d-sm-table-cell">Monto Total</th>
                                <th class="d-none d-xl-table-cell">Anticipo</th>
                                <th class="d-none d-xl-table-cell">Extensión</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse(auth()->user()->contracts()->get() as $contract)
                                <tr>
                                    <th>{{ $contract->short_name }}</th>
                                    <td class="d-none d-sm-table-cell">{{ $contract->codeOk }}</td>

                                    <td class="d-none d-md-table-cell">{{ $contract->startOk }}</td>
                                    <td class="d-none d-md-table-cell">{{ $contract->finishOk }}</td>
                                    <td class="d-none d-lg-table-cell">{{ $contract->signatureOk }}</td>
                                    <td class="d-none d-lg-table-cell">{{ $contract->covenantOk }}</td>
                                    <td class="d-none d-lg-table-cell">{{ $contract->dateModifiedOk }}</td>

                                    <td class="d-none d-sm-table-cell">{{ $contract->totalOk }}</td>
                                    <td class="d-none d-xl-table-cell">{{ $contract->anticipated }}</td>
                                    <td class="d-none d-xl-table-cell">{{ $contract->extension }}</td>

                                    <td>
                                        <a href="{{ route('contract.edit',$contract) }}"><i class="fas fa-edit fa-2x"></i></a>
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
