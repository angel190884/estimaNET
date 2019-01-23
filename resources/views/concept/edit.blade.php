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
                        <form action="{{ route('concept.update', $concept) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="col-md-10 offset-md-1">
                                <span class="anchor" id="formComplex"></span>
                                <hr class="my-2">
                                <h3 class="text-info">Editar concepto </h3>
                                <div class="form-row mt-4">
                                    <div class="col-sm-4 pb-3">
                                        <label for="codeConcept">Código*</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-code text-muted"></i></span></div>
                                            <input name="code" value="{{ $concept->codeOk }}" type="text" class="form-control text-uppercase " id="codeConcept" placeholder="Código del concepto" required>
                                            @include('layouts.components.alert.field', ['field' => 'code'])
                                        </div>
                                    </div>
                                    <div class="col-sm-8 pb-3">
                                        <label for="name">Concepto*</label>
                                        <textarea name="name" class="form-control text-uppercase" id="name" placeholder="concepto" rows="3" required>{{ $concept->name }}</textarea>
                                        @include('layouts.components.alert.field', ['field' => 'name'])
                                    </div>
                                    <div class="col-sm-4 pb-3">
                                        <div class="pb-3">
                                            <label for="location">Frente*</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-location-arrow text-muted"></i></span></div>
                                                <input name="location" value="{{ $concept->location }}" type="text" class="form-control text-uppercase" id="location" placeholder="ubicación" required>
                                                @include('layouts.components.alert.field', ['field' => 'location'])
                                            </div>
                                        </div>
                                        <div class="pb-3">
                                            <label for="address">Ubicacion del frente y/o dirección*</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-map-marker-alt text-muted"></i></span></div>
                                                <textarea name="address" class="form-control text-uppercase" id="address" placeholder="ubicación ó dirección" rows="5" required>{{ $concept->address }}</textarea>
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
                                            <select name="contract" class="form-control text-uppercase" id="contractId" required>
                                                <option value=" " {{ $concept->contract_id != null ? ' ' : 'selected' }}>selecciona...</option>
                                                @foreach(auth()->user()->contracts()->orderBy('code','asc')->get() as $key => $contract)
                                                    <option value="{{ $contract->id }}" {{ $concept->contract_id == $contract->id ? 'selected' : ' ' }}>{{ $contract->codeOk }}</option>
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
                                                <select name="measurementUnit" class="custom-select text-uppercase" required>
                                                    <option value = "" {{ $concept->measurement_unit == null ? 'selected' : '' }}>Selecciona...</option>
                                                    <optgroup label="Longitud">
                                                        <option value="m" {{ $concept->measurement_unit == 'M' ? 'selected' : '' }}>m</option>
                                                        <option value="km" {{ $concept->measurement_unit == 'KM' ? 'selected' : '' }}>km</option>
                                                        <option value="ton/km" {{ $concept->measurement_unit == 'TON/KM' ? 'selected' : '' }}>ton/km</option>
                                                        <option value="m3/km" {{ $concept->measurement_unit == 'M3/KM' ? 'selected' : '' }}>m3/km</option>
                                                        <option value="m3-est" {{ $concept->measurement_unit == 'M3-EST' ? 'selected' : '' }}>m3-est</option>
                                                        <option value="km-sub" {{ $concept->measurement_unit == 'KM-SUB' ? 'selected' : '' }}>km-sub</option>
                                                    </optgroup>
                                                    <optgroup label="Área">
                                                        <option value="m2" {{ $concept->measurement_unit == 'M2' ? 'selected' : '' }}>m2</option>
                                                        <option value="ha" {{ $concept->measurement_unit == 'HA' ? 'selected' : '' }}>ha (hectária)</option>
                                                    </optgroup>
                                                    <optgroup label="Volumen">
                                                        <option value="m3" {{ $concept->measurement_unit == 'M3' ? 'selected' : '' }}>m3</option>
                                                    </optgroup>
                                                    <optgroup label="Unidad">
                                                        <option value="pz" {{ $concept->measurement_unit == 'PZ' ? 'selected' : '' }}>pz</option>
                                                        <option value="muestra" {{ $concept->measurement_unit == 'MUESTRA' ? 'selected' : '' }}>muestra</option>
                                                        <option value="prueba" {{ $concept->measurement_unit == 'PRUEBA' ? 'selected' : '' }}>prueba</option>
                                                        <option value="jornada" {{ $concept->measurement_unit == 'JORNADA' ? 'selected' : '' }}>jornada</option>
                                                    </optgroup>
                                                    <optgroup label="Capacidad">
                                                        <option value="lt" {{ $concept->measurement_unit == 'LT' ? 'selected' : '' }}>lt</option>
                                                    </optgroup>
                                                </select>
                                                @include('layouts.components.alert.field', ['field' => 'measurementUnit'])
                                            </div>
                                        </div>

                                        <div>
                                            <label for="type">Tipo*</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-angle-right text-muted"></i></span></div>
                                                <select name="type" class="custom-select text-uppercase">
                                                    <option {{ $concept->type == 'N' ? 'selected' : '' }}>Selecciona...</option>
                                                    <option {{ $concept->type == 'N' ? 'selected' : '' }} value="N">normal</option>
                                                    <option {{ $concept->type == 'EXC' ? 'selected' : '' }} value="EXC">excedente</option>
                                                    <option {{ $concept->type == 'EXT' ? 'selected' : '' }} value="EXT">extraordinario</option>
                                                </select>
                                                @include('layouts.components.alert.field', ['field' => 'type'])
                                            </div>
                                        </div>
                                        <div>
                                            <label for="unitPrice">Precio unitario*</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-dollar-sign text-muted"></i></span></div>
                                                <input name="unitPrice" value="{{ $concept->unit_price }}" type="number" class="form-control" id="unitPrice" placeholder="0.00" step="0.000001" required>
                                                @include('layouts.components.alert.field', ['field' => 'unitPrice'])
                                            </div>
                                        </div>
                                        <div>
                                            <label for="quantity">Cantidad máxima en contrato*</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-box-open text-muted"></i></span></div>
                                                <input name="quantity" value="{{ $concept->quantity }}" type="number" class="form-control" id="quantity" placeholder="0.00 (máx 6 dec)" step="0.000001">
                                                @include('layouts.components.alert.field', ['field' => 'quantity'])
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-lg btn-block mt-5">Editar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
