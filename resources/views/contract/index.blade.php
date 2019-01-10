@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Contracts</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Cod</th>
                                <th scope="col"># Contrato</th>
                                <th scope="col">Monto Total</th>
                                <th scope="col">Inicio</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(auth()->user()->contracts()->get() as $contract)
                                <tr>
                                    <th>{{ $contract->short_name }}</th>
                                    <td>{{ $contract->codeOk }}</td>
                                    <td>{{ $contract->totalOk }}</td>
                                    <td>{{ $contract->startOk }}</td>
                                    <td><a href="{{ route('contract.edit',$contract) }}"><i class="fas fa-edit"></i></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
