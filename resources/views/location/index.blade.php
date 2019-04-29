@extends('layouts.app')

@section('content')
    <div class="container-fluid pb-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="container-fluid m-auto p-0">
                            <div class="row">
                                <div class="col-sm-12 col-md-5">
                                    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addLocation" title="Agregar Frente">
                                        <i class="fas fa-plus"></i>
                                    </button> Frentes 
                                    <!-- Modal add-->
                                    <div class="modal fade" id="addLocation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="{{ route('location.store') }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Crear Frente</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="md-form">
                                                            <div class="input-group mb-2 mr-sm-2">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text"><i class="fas fa-snowplow"></i></div>
                                                                </div>
                                                                <select name="contract_id" class="form-control" id="contractId" required>
                                                                    <option value="" selected>selecciona un contrato...</option>
                                                                    @foreach(auth()->user()->contracts()->active()->split()->orderBy('code')->get() as $key => $contract)
                                                                        <option value="{{ $contract->id }}">{{ $contract->codeOk }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="md-form">
                                                            <div class="input-group mb-2 mr-sm-2">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">Frente</div>
                                                                </div>
                                                                <input class="form-control text-uppercase" name="name" placeholder="frente" required>
                                                            </div>
                                                        </div>
                                                        <div class="md-form">
                                                            <div class="input-group mb-2 mr-sm-2">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">Dirección</div>
                                                                </div>
                                                                <input class="form-control text-uppercase" name="address" placeholder="dirección" required>
                                                            </div>
                                                        </div>
                                                        <div class="md-form">
                                                            <div class="input-group mb-2 mr-sm-2">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">Observaciones</div>
                                                                </div>
                                                                <textarea class="form-control text-uppercase" name="observations" placeholder="observaciones" rows="3"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                        <button type="submit" class="btn btn-primary">Crear</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-7 text-right">
                                    <form action="{{ route('location.index') }}" method="get">
                                        <div class="row">
                                            <div class="col">
                                                <label class="sr-only" for="grupoNombre">Contrato</label>
                                                <div class="input-group mb-2 mr-sm-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"><i class="fas fa-snowplow"></i></div>
                                                    </div>
                                                    <select name="contract_id" class="form-control" id="codeContract">
                                                        <option value="" selected>selecciona un contrato dividido por frentes...</option>
                                                        @foreach(auth()->user()->contracts()->active()->split()->orderBy('code')->get() as $key => $contract)
                                                            <option value="{{ $contract->id }}">{{ $contract->codeOk }}</option>
                                                        @endforeach
                                                    </select>
                                                    @include('layouts.components.alert.field', ['field' => 'code'])
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <button class="btn btn-outline-success" title="Buscar Frentes"><i class="fas fa-search"></i></button>
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
                                    <th class="d-none d-md-table-cell text-left">Código</th>
                                    <th>Contrato</th>
                                    <th>Frente</th>
                                    <th class="d-none d-md-table-cell">Ubicación</th>
                                    <!--<th>U.M.</th>
                                    <th>Tipo</th>
                                    <th>Cantidad</th>
                                    <th>125%</th>
                                    <th>Acumulado</th>
                                    <th>Total</th>-->
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($locations))
                                    @forelse($locations as $location)
                                        <tr>
                                            <th class="d-none d-md-table-cell text-left">sys-{{ $location->id }}</th>
                                            <td>{{ $location->contract->short_name }}</td>
                                            <td><small>{{ $location->name }}</small></td>
                                            <td class="d-none d-md-table-cell"><small>{{ $location->address }}</small></td>

                                            <td class="text-center">
                                                <a href="#" data-toggle="modal" data-target="#destroy{{$location->id}}" title="Eliminar Frente"><i class="fas fa-trash-alt text-danger"></i></a>
                                            </td>
                                        </tr>

                                        <!-- Modal destroy-->
                                        <div class="modal fade" id="destroy{{$location->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="{{ route('location.destroy',$location->id) }}" method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Eliminar Frente</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="text-info">¿Estas completamente seguro de ELIMINAR este registro?</p>
                                                            <p class="bg-warning">Si el registro a su vez está enlazado a algun generador se borraran, esta acción no es reversible y se eliminaran de forma permanente por lo cual debes de estar completamente seguro de lo que estas haciendo antes de continuar.</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                            <button type="submit" class="btn btn-custom-1">Eliminar generador</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-danger">NO SE ENCONTRARON FRENTES EN ESTE CONTRATO. RECUERDA QUE ESTE
                                            CONTRATO ES GENERAL Y DENTRO DEL CATÁLOGO SE DIVIDEN LOS FRENTES, ESTA SECCIÓN SOLO
                                            ES PARA LOS CONTRATOS CATALOGADOS "POR FRENTES" Y QUE SU CATÁLOGO NO CORRESPONDE A
                                            LOS FRENTES REALES</p>
                                    @endforelse
                                @else
                                    <p CLASS="text-danger">DEBES SELECCIONAR UN CONTRATO </p>
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
