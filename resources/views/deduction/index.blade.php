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
                                Deducciones posibles del usuario: <span class="font-weight-bold">{{ auth()->user()->fullName }}</span>
                            </div>
                            <div class="col-sm-12 col-md-6 text-info  text-right hidden">
                                <button class ="btn btn-primary" href="#" role="button" title="Agregar Dedución y/o Sancion" data-toggle="modal" data-target="#addDeduction" data-whatever="@mdo"><i class="fas fa-plus"></i></button>
                            </div>
                            <div class="modal fade" id="addDeduction" tabindex="-1" role="dialog" aria-labelledby="addDeductionLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form action="{{ route('deduction.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Agregar Dedución ó Sanción</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label class="sr-only" for="code">Código</label>
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                Código
                                                            </div>
                                                        </div>
                                                        <input type="text" class="form-control" id="code" placeholder="Código" name="code" required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="sr-only" for="name">Nombre</label>
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                Nombre
                                                            </div>
                                                        </div>
                                                        <input type="text" class="form-control" id="name" placeholder="Nombre" name="name" required>
                                                    </div>
                                                 </div>
                                                 <div class="form-group">
                                                    <div class="row">
                                                        <div class="col">
                                                            <label class="sr-only" for="percentage">% Porcentaje</label>
                                                            <div class="input-group mb-2">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">
                                                                        % Porcentaje
                                                                    </div>
                                                                </div>
                                                                <input type="number" class="form-control" id="percentage" min="0.1" step="0.1" placeholder="%" name="percentage" required>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <label class="sr-only" for="type">Tipo</label>
                                                            <div class="input-group mb-2">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">
                                                                        Tipo
                                                                    </div>
                                                                </div>
                                                                <select name="type" id="type" class="form-control" required>
                                                                    <option>Selecciona...</option>
                                                                    <option value="1">Contrato</option>
                                                                    <option value="2">Estimación</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="sr-only" for="percentage">Descripción</label>
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                Descripción
                                                            </div>
                                                        </div>
                                                        <textarea class="form-control" id="description" name="description" placeholder="Descripción"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Agregar</button>
                                            </div>
                                        </div>
                                    </form>
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
                                    <th>Código</th>
                                    <th class="d-none d-md-table-cell">Nombre</th>
                                    <th class="d-none d-xs-table-cell">Tipo</th>
                                    <th>Porcentaje %</th>
                                    <th class="d-none d-md-table-cell">Descripción</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($deductions as $deduction)
                                <tr>
                                    <th>{{ $deduction->code }}</th>
                                    <td class="d-none d-md-table-cell">{{ $deduction->name }}</td>
                                    <th class="d-none d-xs-table-cell">{{ $deduction->typeOk }}</th>
                                    <td>{{ $deduction->percentage }}</td>
                                    <td class="d-none d-md-table-cell">{{ $deduction->description }}</td>
                                    <td>
                                        <a href="{{ route('deduction.edit',$deduction) }}" class="btn btn-primary btn-sm" role="button" title="Editar Estimación"><i class="fas fa-edit fa-2x"></i></a>
                                    </td>
                                </tr>
                                @empty
                                <p class="text-danger">NO SE ENCONTRARON DEDUCCIONES PARA ESTE USUARIO</p>
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