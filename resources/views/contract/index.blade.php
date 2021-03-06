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
                            <thead class="thead-dark">
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
                            @forelse($contracts as $contract)
                                <tr>
                                    <th>{{ $contract->short_name }}</th>
                                    <td class="d-none d-sm-table-cell">{{ $contract->codeOk }}</td>

                                    <td class="d-none d-md-table-cell">{{ $contract->startOk }}</td>
                                    <td class="d-none d-md-table-cell">{{ $contract->finishOk }}</td>
                                    <td class="d-none d-lg-table-cell">{{ $contract->signatureOk }}</td>
                                    <td class="d-none d-lg-table-cell">{{ $contract->signatureCovenantOk }}</td>
                                    <td class="d-none d-lg-table-cell">{{ $contract->finishModifiedOk }}</td>

                                    <td class="d-none d-sm-table-cell">{{ $contract->originalAmountOk }}</td>
                                    <td class="d-none d-xl-table-cell">{{ $contract->advancePaymentAmountOk }}</td>
                                    <td class="d-none d-xl-table-cell">{{ $contract->extensionAmountOk }}</td>

                                    <td>
                                        <a href="{{ route('contract.edit',$contract) }}"><i class="fas fa-edit fa-2x"></i></a>
                                        <a href="{{ route('report.finalSummary',$contract) }}"><i class="fas fa-file-invoice-dollar fa-2x"></i></a>
                                        <a href="#" data-toggle="modal" data-target="#uploadCatalog" alt="Subir Catálogo"><i class="fas fa-list-alt fa-2x"></i></a>
                                        
                                        <!-- Modal -->
                                        <div class="modal fade" id="uploadCatalog" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="{{ route('catalog.excel.update') }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Subir Catálogo</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                            {!! csrf_field() !!}
                                                            <input type="hidden" name="contract_id" value="{{ $contract->id }}">
                                                            
                                                            <div class="form-group">
                                                                <p class="bg-warning text-black-50">Deberas cargar el catalogo en formato xlsx, 
                                                                    con el formato correcto, si no lo tienes descargalo 
                                                                    <a href="{{ asset('storage/files/catalog.xlsx') }}">aqui</a> respetando los nombres
                                                                    de las columnas.
                                                                </p>
                                                                <label for="exampleFormControlFile1">Upload Excel</label>
                                                                <input name="file" type="file" class="form-control-file form-control-lg" id="exampleFormControlFile1">
                                                            </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                        <button type="submit" class="btn btn-primary">Subir Archivo</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
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
