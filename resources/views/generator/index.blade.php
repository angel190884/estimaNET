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
                                    <a href="{{ route('estimate.index',['code' => $estimate->contract->codeOk]) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-arrow-left"></i>
                                    </a>
                                    Generadores( <span class="font-weight-bold">{{ $estimate->generators->count() }}</span> ) de la estimacion ( <span class="font-weight-bold">{{ $estimate->number }}</span> ) del contrato <span class="font-weight-bold">{{ $estimate->contract->codeOk }}</span>
                                </div>
                                <div class="col-sm-12 col-md-6 text-right">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#add" title="Agregar Concepto">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <!-- Modal add-->
                                    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="{{ route('generator.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="estimate_id" value="{{ $estimate->id }}">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Crear Generador</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <select name="concept_id" class="form-control" id="concept">
                                                            <option value="">selecciona...</option>
                                                            @foreach($estimate->contract->concepts->sortBy('code') as $key => $concept)
                                                                <option value="{{ $concept->id }}">
                                                                    {{ $concept->code }}
                                                                </option>
                                                            @endforeach
                                                        </select>
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
                                    <th class="d-none d-md-table-cell">Frente de Catálogo</th>
                                    <th class="d-none d-md-table-cell">U.M.</th>
                                    <th class="d-none d-sm-table-cell">Tipo</th>
                                    <th class="d-none d-sm-table-cell">Según Contrato </th>
                                    <th class="d-none d-sm-table-cell">125%</th>
                                    <th>Acum. Anterior</th>
                                    <th>Esta Estimación</th>
                                    <th>Acum. Actual</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($generators as $generator)
                                    <tr>
                                        <th class="text-left">{{ $generator->concept->code }}</th>
                                        <td class="d-none d-md-table-cell"><small>{{ $generator->concept->nameOk }}</small></td>
                                        <td class="d-none d-md-table-cell"><small>{{ $generator->concept->locationOk }}</small></td>
                                        <td class="d-none d-md-table-cell">{{ $generator->concept->measurementUnitOk }}</td>
                                        <td class="d-none d-sm-table-cell">{{ $generator->concept->type }}</td>
                                        <td class="d-none d-sm-table-cell">{{ $generator->concept->quantityOk }}</td>
                                        <td class="d-none d-sm-table-cell">{{ $generator->concept->quantityMaxOk }}</td>
                                        <td>{{ $generator->lastQuantityOk }}</td>
                                        <td class="{{ $generator->validate() ? 'bg-primary' : 'bg-danger' }} text-white">{{ $generator->quantityOk }}</td>
                                        <td>{{ $generator->accumulatedQuantityOk }}</td>
                                        <td class="text-center">
                                            @if($generator->estimate->contract->split_catalog)
                                                <a href="#" data-toggle="modal" data-target="#separate{{ $generator->id }}" title="Editar Cantidades"><i class="fas fa-align-left"></i></a>
                                            @elseif(!$generator->estimate->contract->split_catalog)
                                                <a href="#" data-toggle="modal" data-target="#update{{ $generator->id }}" title="Editar Cantidad"><i class="fas fa-edit"></i></a>
                                            @endif
                                            <a href="#" data-toggle="modal" data-target="#destroy{{ $generator->id }}" title="Eliminar Concepto"><i class="fas fa-trash-alt text-danger"></i></a>
                                        </td>
                                    </tr>

                                    <!-- Modal update-->
                                    <div class="modal fade" id="update{{$generator->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="{{ route('generator.update',$generator) }}" method="POST">
                                                    @method('PUT')
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Editar Generador</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="text-danger">Cantidad máxima <mark>{{ $generator->maximumQuantityPossibleOk }}</mark> posible.</p>
                                                        <input name=quantity type="number" class="form-control" value="{{ $generator->quantity }}" step='0.000001'>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                        <button type="submit" class="btn btn-primary">Salvar cambios</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal separate-->
                                    <div class="modal fade" id="separate{{$generator->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <form action="{{ route('subGenerator.update',$generator) }}" method="POST">
                                                    @method('PUT')
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Dividir generador</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="text-danger">Cantidad máxima <mark>{{ $generator->maximumQuantityPossibleOk }}</mark> posible.</p>
                                                        @forelse($generator->subGenerators()->get()->sortBy('location.name') as $subGenerator)
                                                            <div class="form-row mt-1">
                                                                <div class="col-sm-12">

                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend"><span class="input-group-text text-body"><i class="font-weight-bold text-muted">{{ $subGenerator->location->name }}</i></span></div>
                                                                        <input name=quantitySubGenerator{{ $subGenerator->id }} id="subGenerator{{ $subGenerator->id }}" type="number" class="form-control" value="{{ $subGenerator->quantity }}" step='0.000001' required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @empty
                                                            <div class="form-row mt-4">
                                                                <div class="col-sm-12">
                                                                    EL CATÁLOGO NO CONTIENE UBICACIONES PARA PODER DIVIDIR LOS CONCEPTOS.
                                                                </div>
                                                            </div>
                                                        @endforelse
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                        <button type="submit" class="btn btn-primary">Salvar cambios</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal destroy-->
                                    <div class="modal fade" id="destroy{{$generator->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="{{ route('generator.destroy',$generator->id) }}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Eliminar Generador</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="text-info">¿Estas completamente seguro de ELIMINAR este registro?</p>
                                                        <p class="bg-warning">Si el registro a su vez está dividido en frentes también se borraran, esta acción no es reversible y se eliminaran de forma permanente por lo cual debes de estar completamente seguro de lo que estas haciendo antes de continuar.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                        <button type="submit" class="btn btn-danger">Eliminar generador</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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
