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
                                    Estimación
                                </div>
                                <div class="col-sm-12 col-md-6 text-md-right text-info hidden">
                                    *campos requeridos
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('estimate.store') }}" method="POST">
                            @csrf
                            <div class="col-md-10 offset-md-1">
                                <span class="anchor" id="formComplex"></span>
                                <hr class="my-2">
                                <h3 class="text-info">Nueva estimación </h3>

                                <div class="form-row mt-4">
                                    <div class="col-sm-4 pb-3">
                                        <label for="estimateNumber"># Estimación*</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-sort-numeric-up text-muted"></i></span></div>
                                            <input name="number" value="{{ old('number') }}" type="number" class="form-control" id="estimateNumber" placeholder="0" step="1" min="0" required>
                                            @include('layouts.components.alert.field', ['field' => 'number'])
                                        </div>
                                    </div>
                                    <div class="col-sm-8 pb-3">
                                        <label for="contractId">Contrato</label>
                                        <select name="contract" class="form-control" id="contractId">
                                            <option value=" " {{ old('contract') != null ? ' ' : 'selected' }}>selecciona...</option>
                                            @foreach(auth()->user()->contracts()->get() as $key => $contract)
                                                <option value="{{ $contract->id }}" {{ old('contract') == $contract->id ? 'selected' : ' ' }}>{{ $contract->codeOk }}</option>
                                            @endforeach
                                        </select>
                                        @include('layouts.components.alert.field', ['field' => 'contract'])
                                    </div>

                                    <div class="col-sm-6 col-md-4 pb-3">
                                        <label for="estimateStart">Fecha de inicio*</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar-alt text-muted"></i></span><span class="oi oi-calendar"></span></div>
                                            <input name="start" value="{{ old('start') }}" class="form-control" type="date" id="estimateStart" required>
                                            @include('layouts.components.alert.field', ['field' => 'start'])
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 pb-3">
                                        <label for="estimateFinish">Fecha fin*</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar-alt text-muted"></i></span><span class="oi oi-calendar"></span></div>
                                            <input name="finish" value="{{ old('finish') }}" class="form-control" type="date" id="estimateFinish" required>
                                            @include('layouts.components.alert.field', ['field' => 'finish'])
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 pb-3">
                                        <label for="estimateRelease">Fecha emisión*</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar-alt text-muted"></i></span><span class="oi oi-calendar"></span></div>
                                            <input name="release" value="{{ old('release') }}" class="form-control" type="date" id="estimateRelease" required>
                                            @include('layouts.components.alert.field', ['field' => 'release'])
                                        </div>
                                    </div>
                                    <div class="col-sm-4 pb-3">
                                        <label for="estimateAmountRetention">Monto retención*</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-dollar-sign text-muted"></i></span></div>
                                            <input name="retention" value="{{ old('retention') }}" type="number" class="form-control" id="estimateAmountRetention" placeholder="0.00" step="0.01">
                                            @include('layouts.components.alert.field', ['field' => 'retention'])
                                        </div>
                                    </div>
                                    <div class="col-sm-4 pb-3 text-center">
                                            <table class="table table-sm table-borderless text-center">
                                                <thead>
                                                        <tr>
                                                        <th scope="col">Tipo</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <input name="type" class="form-check-input" type="radio" id="estimateTypeOrdinary" value="1" {{(old('type') == '1') ? 'checked' : ''}}> Normal
                                                                
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><input name="type" class="form-check-input" type="radio" id="estimateTypeExtraordinary" value="2" {{(old('type') == '2' | null ) ? 'checked' : ''}}> Extraordinaria</td>
                                                        </tr>
                                                        <tr>
                                                            <td><input name="type" class="form-check-input" type="radio" id="estimateTypeCombinedEnd" value="4" {{(old('type') == '4' | null ) ? 'checked' : ''}}> Combinada</td>
                                                        </tr>
                                                        <tr>
                                                            <td><input name="type" class="form-check-input" type="radio" id="estimateTypeEnd" value="3" {{(old('type') == '3' | null ) ? 'checked' : ''}}> Final</td>
                                                        </tr>
                                                        <tr>
                                                            <td><input name="type" class="form-check-input" type="radio" id="estimateTypeCombinedEnd" value="5" {{(old('type') == '5' | null ) ? 'checked' : ''}}> Combinada final</td>
                                                        </tr>
                                                    </tbody>
                                            </table>
                                            @include('layouts.components.alert.field', ['field' => 'type'])        
                                    </div>
                                    <div class="col-sm-4 pb-3 text-center">
                                            <table class="table table-sm table-borderless text-left">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Deducciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach (auth()->user()->deductions()->typeEstimate()->get() as $deduction)
                                                        <tr>
                                                            <td>
                                                                <label class="form-inline">
                                                                    <input name="{{ 'deduction-' . $deduction->id }}" class="form-group" type="checkbox" value="1"> {{ $deduction->name}}
                                                                    <input name="{{ 'factor-' . $deduction->id }}" class="form-group" type="number" value="0.00" placeholder="x dias" step="0.01">
                                                                </label>
                                                            </td>    
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>       
                                        </div>

                                    <button type="submit" class="btn btn-success btn-lg btn-block mt-5">Dar de alta</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
