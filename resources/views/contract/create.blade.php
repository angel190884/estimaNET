@extends('layouts.app')

@section('scripts')
    <script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=rkfeq2okjwszjx0fdko4rfo2ur0haquk3dpjo4cco0uqpwcf"></script>
    <script>tinymce.init({
            mode : "specific_textareas",
            editor_selector : "mceEditor",
            menubar:false,
            height: 300,
            formats:false,
        });
    </script>
@endsection

@section('content')
    <div class="container-fluid pb-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="container-fluid m-auto p-0">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    Contrato
                                </div>
                                <div class="col-sm-12 col-md-6 text-md-right text-info hidden">
                                    *campos requeridos
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('contract.store') }}" method="POST">
                            @csrf
                            <div class="col-md-10 offset-md-1">
                                <span class="anchor" id="formComplex"></span>
                                <hr class="my-2">
                                <h3 class="text-info">Dar de alta un nuevo contrato </h3>

                                <div class="form-row mt-4">
                                    <div class="col-sm-5 pb-3">
                                        <label for="contractCode">Código*</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text text-body"><i class="font-weight-bold text-muted">#</i></span></div>
                                            <input name="code" value="{{ old('code') }}" type="text" class="form-control" id="contractCode" placeholder="----------------" required>
                                            @include('layouts.components.alert.field', ['field' => 'code'])
                                        </div>
                                    </div>
                                    <div class="col-sm-3 pb-3">
                                        <label for="contractShortName">Código corto*</label>
                                        <input name="short_name" value="{{ old('short_name') }}" type="number" class="form-control" id="contractShortName" placeholder="0000" required>
                                        @include('layouts.components.alert.field', ['field' => 'short_name'])
                                    </div>
                                    <div class="col-sm-4 pb-3">
                                        <label for="contractAmount">Monto Total*</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-dollar-sign text-muted"></i></span></div>
                                            <input name="amount_total" value="{{ old('amount_total') }}" type="number" class="form-control" id="contractAmount" placeholder="0.00" step="0.01" min="0" required>
                                            @include('layouts.components.alert.field', ['field' => 'amount_total'])
                                        </div>
                                    </div>

                                    <div class="col-sm-4 pb-3">
                                        <label for="contractAnticipated">Anticipo</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-dollar-sign text-muted"></i></span></div>
                                            <input name="amount_anticipated" value="{{ old('amount_anticipated') }}" type="number" class="form-control" id="contractAnticipated" placeholder="0.00" step="0.01" min="0">
                                            @include('layouts.components.alert.field', ['field' => 'amount_anticipated'])
                                        </div>
                                    </div>
                                    <div class="col-sm-4 pb-3">
                                        <label for="contractExtension">Extension ó Convenio</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-dollar-sign text-muted"></i></span></div>
                                            <input name="amount_extension" value="{{ old('amount_extension') }}" type="number" class="form-control" id="contractExtension" placeholder="0.00" step="0.01" min="0">
                                            @include('layouts.components.alert.field', ['field' => 'amount_extension'])
                                        </div>
                                    </div>
                                    <div class="col-sm-4 pb-3">
                                        <label for="contractAdjustment">Ajuste<sup>opcional</sup></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-dollar-sign text-muted"></i></span></div>
                                            <input name="amount_adjustment" value="{{ old('amount_adjustment') }}" type="number" class="form-control" id="contractAdjustment" placeholder="0.00" step="0.01" min="0">
                                            @include('layouts.components.alert.field', ['field' => 'amount_adjustment'])
                                        </div>
                                    </div>

                                    <div class="col-sm-4 pb-3">
                                        <label for="contractDateStart">Fecha de inicio*</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar-alt text-muted"></i></span><span class="oi oi-calendar"></span></div>
                                            <input name="date_start" value="{{ old('date_start') }}" class="form-control" type="date" id="contractDateStart" required>
                                            @include('layouts.components.alert.field', ['field' => 'date_start'])
                                        </div>
                                    </div>
                                    <div class="col-sm-4 pb-3">
                                        <label for="contractDateFinish">Fecha de término*</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar-alt text-muted"></i></span><span class="oi oi-calendar"></span></div>
                                            <input name="date_finish" value="{{ old('date_finish') }}" class="form-control" type="date" id="contractDateFinish" required>
                                            @include('layouts.components.alert.field', ['field' => 'date_finish'])
                                        </div>
                                    </div>
                                    <div class="col-sm-4 pb-3">
                                        <label for="contractDateSignature">Fecha firma</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar-alt text-muted"></i></span><span class="oi oi-calendar"></span></div>
                                            <input name="date_signature" value="{{ old('date_signature') }}" class="form-control" type="date" id="contractDateSignature">
                                            @include('layouts.components.alert.field', ['field' => 'date_signature'])
                                        </div>
                                    </div>
                                    <div class="col-sm-4 pb-3">
                                        <label for="contractCovenant">Firma convenio<sup class="text-muted">opcional</sup></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar-alt text-muted"></i></span><span class="oi oi-calendar"></span></div>
                                            <input name="date_signature_covenant" value="{{ old('date_signature_covenant') }}" class="form-control" type="date" id="contractCovenant">
                                            @include('layouts.components.alert.field', ['field' => 'date_signature_covenant'])
                                        </div>
                                    </div>
                                    <div class="col-sm-4 pb-3">
                                        <label for="contractModified">Nueva fecha término<sup class="text-muted">opcional</sup></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar-alt text-muted"></i></span><span class="oi oi-calendar"></span></div>
                                            <input name="date_finish_modified" value="{{ old('date_finish_modified') }}" class="form-control" type="date" id="contractModified">
                                            @include('layouts.components.alert.field', ['field' => 'date_finish_modified'])
                                        </div>
                                    </div>

                                    <div class="col-sm-6 pb-3">
                                        <label for="contractName">Nombre*</label>
                                        <textarea name="name" class="form-control" id="contractName" rows="4">{{ old('name') }}</textarea>
                                        @include('layouts.components.alert.field', ['field' => 'name'])
                                        <small class="text-info">
                                            Nombre Completo del contrato.
                                        </small>
                                    </div>
                                    <div class="col-sm-6 pb-3">
                                        <label for="contractDescription">Ubicación general*</label>
                                        <textarea name="location" class="form-control" id="contractLocation" rows="4" required>{{ old('location') }}</textarea>
                                        @include('layouts.components.alert.field', ['field' => 'location'])
                                        <small class="text-info">
                                            Ubicación general del contrato.
                                        </small>
                                    </div>
                                    <div class="col-sm-6 pb-3">
                                        <label for="contractDescription">Observaciones</label>
                                        <textarea name="description" class="form-control" id="contractDescription" rows="4">{{ old('description') }}</textarea>
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
                                                    <input name="active" class="form-check-input" type="radio" id="contractStatusActivated" value="1" {{(old('active') == '1') ? 'checked' : ''}}> Activado
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input name="active" class="form-check-input" type="radio" id="contractStatusDisable" value="0" {{(old('active') == '0' | null ) ? 'checked' : ''}}> Desactivado
                                                </label>
                                            </div>
                                        </div>
                                        @include('layouts.components.alert.field', ['field' => 'active'])
                                    </div>
                                    <div class="col-md-6 pb-3">
                                        <label for="exampleAccount">Tipo de catálogo*</label>
                                        <div class="form-group">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input name="split_catalog" class="form-check-input" type="radio" id="contractSplitCatalog" value="0" {{(old('split_catalog') == '0' | null ) ? 'checked' : ''}}> General
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input name="split_catalog" class="form-check-input" type="radio" id="contractSplitCatalog" value="1" {{(old('split_catalog') == '1') ? 'checked' : ''}}> Por frentes
                                                </label>
                                            </div>
                                        </div>
                                        @include('layouts.components.alert.field', ['field' => 'split_catalog'])
                                    </div>
                                    <div class="col-md-6 pb-3">
                                        <label for="exampleAccount">Tipo de contrato*</label>
                                        <div class="form-group">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input name="type" class="form-check-input" type="radio" id="contractType" value="1" {{(old('type') == '1') ? 'checked' : ''}}> Construcción
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input name="type" class="form-check-input" type="radio" id="contractType" value="2" {{(old('type') == '2') ? 'checked' : ''}}> Supervisión
                                                </label>
                                            </div>
                                        </div>
                                        @include('layouts.components.alert.field', ['field' => 'type'])
                                    </div>
                                    <div class="col-sm-9 pb-3">
                                        <label for="contractCompany">Empresa</label>
                                        <select name="company" class="form-control" id="contractCompany">
                                            <option value="" {{ old('company') != null ? '' : 'selected' }}>selecciona...</option>
                                            @foreach($companies as $key => $company)
                                                <!--<option value="{{ $key }}">{{ $company }}</option>  -->
                                                <option value="{{ $key }}" {{ old('company') == $key ? 'selected' : '' }}>{{ $company }}</option>
                                            @endforeach
                                        </select>
                                        @include('layouts.components.alert.field', ['field' => 'company'])
                                    </div>

                                    <div class="col-sm-12 col-lg-6 col-xl-4 pb-3">
                                        <label for="contractDescription">Firma 1</label>
                                        <textarea name="signature1" class="form-control mceEditor" id="signature1" rows="4">
                                            <p style="text-align:center"><strong>ELABORÓ</strong><br />EMPRESA O PERSONA FÍSICA.</p><p style="text-align:center"><br /><br />_____________________________________________<br /><strong>NOPMBRE DEL ADMINISTRADOR</strong><br />(ADMINISTRADOR &Uacute;NICO)</p>
                                        </textarea>
                                        @include('layouts.components.alert.field', ['field' => 'signature1'])
                                        <small class="text-info">
                                            Firma #1.
                                        </small>
                                    </div>

                                    <div class="col-sm-12 col-lg-6 col-xl-4 pb-3">
                                        <label for="contractDescription">Firma 2</label>
                                        <textarea name="signature2" class="form-control mceEditor" id="signature2" rows="4">
                                            <p style="text-align:center"><strong>APROBÓ</strong><br />RESIDENTE DE OBRA</p><p style="text-align:center"><br /><br />_____________________________________________<br /><strong>NOMBRE DEL FUNCIONARIO</strong><br />(PUESTO DEL FUNCIONARIO)</p>
                                        </textarea>
                                        @include('layouts.components.alert.field', ['field' => 'signature2'])
                                        <small class="text-info">
                                            Firma #2.
                                        </small>
                                    </div>

                                    <div class="col-sm-12 col-lg-6 col-xl-4 pb-3">
                                        <label for="contractDescription">Firma 3</label>
                                        <textarea name="signature3" class="form-control mceEditor" id="signature3" rows="4">
                                            <p style="text-align:center"><strong>AUTORIZÓ</strong><br />RESIDENTE DE OBRA</p><p style="text-align:center"><br /><br />_____________________________________________<br /><strong>NOMBRE DEL FUNCIONARIO</strong><br />(PUESTO DEL FUNCIONARIO)</p>
                                        </textarea>
                                        @include('layouts.components.alert.field', ['field' => 'signature3'])
                                        <small class="text-info">
                                            Firma #3.
                                        </small>
                                    </div>

                                    <div class="col-sm-12 col-lg-6 col-xl-4 pb-3">
                                        <label for="contractDescription">Firma 4</label>
                                        <textarea name="signature4" class="form-control mceEditor" id="signature4" rows="4">
                                            <p style="text-align:center"><strong>REVISÓ</strong><br />EMPRESA O PERSONA FÍSICA.</p><p style="text-align:center"><br /><br />_____________________________________________<br /><strong>NOPMBRE DEL ADMINISTRADOR</strong><br />(ADMINISTRADOR &Uacute;NICO)</p>
                                        </textarea>
                                        @include('layouts.components.alert.field', ['field' => 'signature4'])
                                        <small class="text-info">
                                            Firma #4.
                                        </small>
                                    </div>

                                    <div class="col-sm-12 col-lg-6 col-xl-4 pb-3">
                                        <label for="contractDescription">Firma 5</label>
                                        <textarea name="signature5" class="form-control mceEditor" id="signature5" rows="4">
                                            <p style="text-align:center"><strong>REVISÓ</strong><br />SUPERVISIÓN INTERNA</p><p style="text-align:center"><br /><br />_____________________________________________<br /><strong>NOMBRE DEL FUNCIONARIO</strong><br />(PUESTO DEL FUNCIONARIO)</p>
                                        </textarea>
                                        @include('layouts.components.alert.field', ['field' => 'signature5'])
                                        <small class="text-info">
                                            Firma #5.
                                        </small>
                                    </div>

                                    <div class="col-sm-12 col-lg-6 col-xl-4 pb-3">
                                        <label for="contractDescription">Firma 6</label>
                                        <textarea name="signature6" class="form-control mceEditor" id="signature6" rows="4">
                                            {{ old('signature6') }}
                                        </textarea>
                                        @include('layouts.components.alert.field', ['field' => 'signature2'])
                                        <small class="text-info">
                                            Firma #6.
                                        </small>
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
