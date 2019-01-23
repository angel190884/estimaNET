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
                                        <label for="name">Concepto*</label>
                                        <textarea name="name" class="form-control" id="name" placeholder="concepto" rows="3" required>{{ old('name') }}</textarea>
                                        @include('layouts.components.alert.field', ['field' => 'name'])
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
                                        <label for="contractId">Contrato*</label>
                                        <div class="input-group mb-2 mr-sm-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fas fa-snowplow text-muted"></i></div>
                                            </div>
                                            <select name="contract" class="form-control" id="contractId" required>
                                                <option value=" " {{ old('contract') != null ? ' ' : 'selected' }}>selecciona...</option>
                                                @foreach(auth()->user()->contracts()->orderBy('code','desc')->get() as $key => $contract)
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
                                                <select name="measurementUnit" class="custom-select" required>
                                                    <option value = "" {{ old('measurementUnit') != null ? '' : 'selected' }}>Selecciona...</option>
                                                    <optgroup label="Longitud">
                                                        <option value="m" {{ old('measurementUnit') != 'm' ? ' ' : 'selected' }}>m</option>
                                                        <option value="km" {{ old('measurementUnit') != 'km' ? ' ' : 'selected' }}>km</option>
                                                        <option value="ton/km" {{ old('measurementUnit') != 'ton/km' ? ' ' : 'selected' }}>ton/km</option>
                                                        <option value="m3/km" {{ old('measurementUnit') != 'm3/km' ? ' ' : 'selected' }}>m3/km</option>
                                                        <option value="m3-est" {{ old('measurementUnit') != 'm3-est' ? ' ' : 'selected' }}>m3-est</option>
                                                        <option value="km-sub" {{ old('measurementUnit') != 'km-sub' ? ' ' : 'selected' }}>km-sub</option>
                                                    </optgroup>
                                                    <optgroup label="Área">
                                                        <option value="m2" {{ old('measurementUnit') != 'm2' ? ' ' : 'selected' }}>m2</option>
                                                        <option value="ha" {{ old('measurementUnit') != 'ha' ? ' ' : 'selected' }}>ha (hectária)</option>
                                                    </optgroup>
                                                    <optgroup label="Volumen">
                                                        <option value="m3" {{ old('measurementUnit') != 'm3' ? ' ' : 'selected' }}>m3</option>
                                                    </optgroup>
                                                    <optgroup label="Unidad">
                                                        <option value="pz" {{ old('measurementUnit') != 'pz' ? ' ' : 'selected' }}>pz</option>
                                                        <option value="muestra" {{ old('measurementUnit') != 'muestra' ? ' ' : 'selected' }}>muestra</option>
                                                        <option value="prueba" {{ old('measurementUnit') != 'prueba' ? ' ' : 'selected' }}>prueba</option>
                                                        <option value="jornada" {{ old('measurementUnit') != 'jornada' ? ' ' : 'selected' }}>jornada</option>
                                                    </optgroup>
                                                    <optgroup label="Capacidad">
                                                        <option value="lt" {{ old('measurementUnit') != 'lt' ? ' ' : 'selected' }}>lt</option>
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
                                                    <option {{ old('type') != null ? ' ' : 'selected' }}>Selecciona...</option>
                                                    <option {{ old('type') != 'n' ? ' ' : 'selected' }} value="n">normal</option>
                                                    <option {{ old('type') != 'exc' ? ' ' : 'selected' }} value="exc">excedente</option>
                                                    <option {{ old('type') != 'ext' ? ' ' : 'selected' }} value="ext">extraordinario</option>
                                                </select>
                                                @include('layouts.components.alert.field', ['field' => 'type'])
                                            </div>
                                        </div>
                                        <div>
                                            <label for="unitPrice">Precio unitario*</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-dollar-sign text-muted"></i></span></div>
                                                <input name="unitPrice" value="{{ old('unitPrice') }}" type="number" class="form-control" id="unitPrice" placeholder="0.00" step="0.000001" required>
                                                @include('layouts.components.alert.field', ['field' => 'unitPrice'])
                                            </div>
                                        </div>
                                        <div>
                                            <label for="quantity">Cantidad máxima en contrato*</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-box-open text-muted"></i></span></div>
                                                <input name="quantity" value="{{ old('quantity') }}" type="number" class="form-control" id="quantity" placeholder="0.00 (máx 6 dec)" step="0.000001">
                                                @include('layouts.components.alert.field', ['field' => 'quantity'])
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
