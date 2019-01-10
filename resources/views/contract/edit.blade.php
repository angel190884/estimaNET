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
                                    Contrato editar
                                </div>
                                <div class="col-sm-12 col-md-6 text-md-right text-info hidden">
                                    *campos requeridos
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{!! route('contract.update',$contract) !!}" method="POST">
                            @csrf
                            <input name="_method" type="hidden" value="PUT">
                            <div class="col-md-10 offset-md-1">
                                <span class="anchor" id="formComplex"></span>
                                <hr class="my-2">
                                <h3 class="text-info">Editar contrato </h3>

                                <div class="form-row mt-4">
                                    <div class="col-sm-5 pb-3">
                                        <label for="contractCode">Código*</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text text-body"><i class="font-weight-bold text-muted">#</i></span></div>
                                            <input name="code" value="{{ $contract->codeOk }}" type="text" class="form-control" id="contractCode" placeholder="----------------" required>
                                            @include('layouts.components.alert.field', ['field' => 'code'])
                                        </div>
                                    </div>
                                    <div class="col-sm-3 pb-3">
                                        <label for="contractShortName">Código corto*</label>
                                        <input name="short_name" value="{{ $contract->short_name }}" type="number" class="form-control" id="contractShortName" placeholder="0000" required>
                                        @include('layouts.components.alert.field', ['field' => 'short_name'])
                                    </div>
                                    <div class="col-sm-4 pb-3">
                                        <label for="contractAmount">Monto Total*</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-dollar-sign text-muted"></i></span></div>
                                            <input name="amount_total" value="{{ $contract->amount_total }}" type="number" class="form-control" id="contractAmount" placeholder="0.00" step="0.01" min="0" required>
                                            @include('layouts.components.alert.field', ['field' => 'amount_total'])
                                        </div>
                                    </div>

                                    <div class="col-sm-4 pb-3">
                                        <label for="contractAnticipated">Anticipo</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-dollar-sign text-muted"></i></span></div>
                                            <input name="amount_anticipated" value="{{ $contract->amount_anticipated }}" type="number" class="form-control" id="contractAnticipated" placeholder="0.00" step="0.01" min="0">
                                            @include('layouts.components.alert.field', ['field' => 'amount_anticipated'])
                                        </div>
                                    </div>
                                    <div class="col-sm-4 pb-3">
                                        <label for="contractExtension">Extension ó Convenio</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-dollar-sign text-muted"></i></span></div>
                                            <input name="amount_extension" value="{{ $contract->amount_extension }}" type="number" class="form-control" id="contractExtension" placeholder="0.00" step="0.01" min="0">
                                            @include('layouts.components.alert.field', ['field' => 'amount_extension'])
                                        </div>
                                    </div>
                                    <div class="col-sm-4 pb-3">
                                        <label for="contractAdjustment">Ajuste<sup>opcional</sup></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-dollar-sign text-muted"></i></span></div>
                                            <input name="amount_adjustment" value="{{ $contract->amount_adjustment }}" type="number" class="form-control" id="contractAdjustment" placeholder="0.00" step="0.01" min="0">
                                            @include('layouts.components.alert.field', ['field' => 'amount_adjustment'])
                                        </div>
                                    </div>

                                    <div class="col-sm-4 pb-3">
                                        <label for="contractDateStart">Fecha de inicio*</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar-alt text-muted"></i></span><span class="oi oi-calendar"></span></div>
                                            <input name="date_start" value="{{ $contract->date_start }}" class="form-control" type="date" id="contractDateStart" required>
                                            @include('layouts.components.alert.field', ['field' => 'date_start'])
                                        </div>
                                    </div>
                                    <div class="col-sm-4 pb-3">
                                        <label for="contractDateFinish">Fecha de término*</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar-alt text-muted"></i></span><span class="oi oi-calendar"></span></div>
                                            <input name="date_finish" value="{{ $contract->date_finish }}" class="form-control" type="date" id="contractDateFinish" required>
                                            @include('layouts.components.alert.field', ['field' => 'date_finish'])
                                        </div>
                                    </div>
                                    <div class="col-sm-4 pb-3">
                                        <label for="contractDateSignature">Fecha firma</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar-alt text-muted"></i></span><span class="oi oi-calendar"></span></div>
                                            <input name="date_signature" value="{{ $contract->date_signature }}" class="form-control" type="date" id="contractDateSignature">
                                            @include('layouts.components.alert.field', ['field' => 'date_signature'])
                                        </div>
                                    </div>
                                    <div class="col-sm-4 pb-3">
                                        <label for="contractCovenant">Firma convenio<sup class="text-muted">opcional</sup></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar-alt text-muted"></i></span><span class="oi oi-calendar"></span></div>
                                            <input name="date_signature_covenant" value="{{ $contract->date_signature_covenant }}" class="form-control" type="date" id="contractCovenant">
                                            @include('layouts.components.alert.field', ['field' => 'date_signature_covenant'])
                                        </div>
                                    </div>
                                    <div class="col-sm-4 pb-3">
                                        <label for="contractModified">Nueva fecha término<sup class="text-muted">opcional</sup></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar-alt text-muted"></i></span><span class="oi oi-calendar"></span></div>
                                            <input name="date_finish_modified" value="{{ $contract->date_finish_modified }}" class="form-control" type="date" id="contractModified">
                                            @include('layouts.components.alert.field', ['field' => 'date_finish_modified'])
                                        </div>
                                    </div>

                                    <div class="col-sm-6 pb-3">
                                        <label for="contractName">Nombre*</label>
                                        <textarea name="name" class="form-control" id="contractName" rows="4">{{ $contract->name }}</textarea>
                                        @include('layouts.components.alert.field', ['field' => 'name'])
                                        <small class="text-info">
                                            Nombre Completo del contrato.
                                        </small>
                                    </div>
                                    <div class="col-sm-6 pb-3">
                                        <label for="contractDescription">Observaciones</label>
                                        <textarea name="description" class="form-control" id="contractDescription" rows="4">{{ $contract->description }}</textarea>
                                        @include('layouts.components.alert.field', ['field' => 'description'])
                                        <small class="text-info">
                                            Las observaciones no apareceran en los reportes.
                                        </small>
                                    </div>

                                    <div class="col-md-4 pb-3">
                                        <label for="exampleAccount">Estatus*</label>
                                        <div class="form-group">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input name="active" class="form-check-input" type="radio" id="contractStatusActivated" value="1" {{($contract->active == '1') ? 'checked' : ''}}> Activado
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input name="active" class="form-check-input" type="radio" id="contractStatusDisable" value="0" {{($contract->active == '0' | null ) ? 'checked' : ''}}> Desactivado
                                                </label>
                                            </div>
                                        </div>
                                        @include('layouts.components.alert.field', ['field' => 'active'])
                                    </div>
                                    <div class="col-sm-8 pb-3">
                                        <label for="contractCompany">Empresa</label>
                                        <select name="company" class="form-control" id="contractCompany">
                                            @foreach($companies as $key => $company)
                                                @if($key == $contract->companies()->first()->id)
                                                    <option value="{{ $key }}" selected>{{ $company }}</option>
                                                @else
                                                    <option value="{{ $key }}">{{ $company }}</option>
                                                @endif
                                            @endforeach
                                        </select>

                                    </div>

                                    <button type="submit" class="btn btn-success btn-lg btn-block mt-5">Update</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
