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
                                    Catálogos
                                </div>
                                <div class="col-sm-12 col-md-6 text-md-right text-info hidden">
                                    *campos requeridos
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('concept.store') }}" method="POST">
                            @csrf
                            <div class="col-md-10 offset-md-1">
                                <span class="anchor" id="formComplex"></span>
                                <hr class="my-2">
                                <h3 class="text-info">Agregar concepto </h3>
                                <div class="form-row mt-4">
                                    <div class="col-sm-4 pb-3">
                                        <label for="codeConcept">Código*</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-code text-muted"></i></span></div>
                                            <input name="code" value="{{ old('code') }}" type="text" class="form-control" id="codeConcept" placeholder="Código del concepto" required>
                                            @include('layouts.components.alert.field', ['field' => 'code'])
                                        </div>
                                    </div>
                                    <div class="col-sm-8 pb-3">
                                        <label for="concept">Concepto*</label>
                                        <textarea name="concept" class="form-control" id="concept" placeholder="concepto" rows="3" required>{{ old('concept') }}</textarea>
                                        @include('layouts.components.alert.field', ['field' => 'concept'])
                                    </div>
                                    <div class="col-sm-4 pb-3">
                                        <div class="pb-3">
                                            <label for="location">Frente*</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-location-arrow text-muted"></i></span></div>
                                                <input name="location" value="{{ old('location') }}" type="text" class="form-control" id="location" placeholder="ubicación" required>
                                                @include('layouts.components.alert.field', ['field' => 'location'])
                                            </div>
                                        </div>
                                        <div class="pb-3">
                                            <label for="address">Ubicacion del frente y/o dirección*</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-map-marker-alt text-muted"></i></span></div>
                                                <textarea name="address" class="form-control" id="address" placeholder="ubicación ó dirección" rows="5" required>{{ old('address') }}</textarea>
                                                @include('layouts.components.alert.field', ['field' => 'address'])
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-sm-4 pb-3">
                                        <label for="contractId">Contrato</label>
                                        <div class="input-group mb-2 mr-sm-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fas fa-snowplow text-muted"></i></div>
                                            </div>
                                            <select name="contract" class="form-control" id="contractId">
                                                <option value=" " {{ old('contract') != null ? ' ' : 'selected' }}>selecciona...</option>
                                                @foreach(auth()->user()->contracts()->get() as $key => $contract)
                                                    <option value="{{ $contract->id }}" {{ old('contract') == $contract->id ? 'selected' : ' ' }}>{{ $contract->codeOk }}</option>
                                                @endforeach
                                            </select>
                                            @include('layouts.components.alert.field', ['field' => 'contract'])
                                        </div>
                                    </div>
                                    <div class="col-sm-4 pb-3">
                                        <div>
                                            <label for="measurementUnit">Unidad de medida*</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-ruler text-muted"></i></span></div>
                                                <select name="measurementUnit" class="custom-select">
                                                    <option selected>Selecciona...</option>
                                                    <optgroup label="Longitud">
                                                        <option value="m">m</option>
                                                        <option value="m">km</option>
                                                        <option value="m">ton/km</option>
                                                        <option value="m">m3/km</option>
                                                        <option value="m">m3-est</option>
                                                        <option value="m">km-sub</option>
                                                    </optgroup>
                                                    <optgroup label="Área">
                                                        <option value="m">m2</option>
                                                        <option value="m">ha (hectária)</option>
                                                    </optgroup>
                                                    <optgroup label="Volumen">
                                                        <option value="m3">m3</option>
                                                    </optgroup>
                                                    <optgroup label="Unidad">
                                                        <option value="pz">pz</option>
                                                        <option value="muestra">muestra</option>
                                                        <option value="prueba">prueba</option>
                                                        <option value="jornada">jornada</option>
                                                    </optgroup>
                                                    <optgroup label="Capacidad">
                                                        <option value="pz">lt</option>
                                                    </optgroup>
                                                </select>
                                                @include('layouts.components.alert.field', ['field' => 'measurementUnit'])
                                            </div>
                                        </div>

                                        <div>
                                            <label for="type">Tipo*</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-angle-right text-muted"></i></span></div>
                                                <select name="type" class="custom-select">
                                                    <option selected>Selecciona...</option>
                                                    <option value="n">normal</option>
                                                    <option value="exc">excedente</option>
                                                    <option value="ext">extraordinario</option>
                                                </select>
                                                @include('layouts.components.alert.field', ['field' => 'measurementUnit'])
                                            </div>
                                        </div>
                                        <div>
                                            <label for="unitPrice">Precio unitario*</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-dollar-sign text-muted"></i></span></div>
                                                <input name="unitPrice" value="{{ old('unitPrice') }}" type="number" class="form-control" id="unitPrice" placeholder="0.00" step="0.01" required>
                                                @include('layouts.components.alert.field', ['field' => 'unitPrice'])
                                            </div>
                                        </div>
                                        <div>
                                            <label for="unitPrice">Cantidad máxima en contrato*</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-box-open text-muted"></i></span></div>
                                                <input name="unitPrice" value="{{ old('unitPrice') }}" type="number" class="form-control" id="unitPrice" placeholder="0.00 (máx 6 dec)" step="0.01" required>
                                                @include('layouts.components.alert.field', ['field' => 'unitPrice'])
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-lg btn-block mt-5">Agregar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
