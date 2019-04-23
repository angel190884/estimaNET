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
                                    Estimación {{ $estimate->number }} del contrato {{ $estimate->contract->short_name }}
                                </div>
                                <div class="col-sm-12 col-md-6 text-md-right text-info hidden">
                                    <a href="{{ route('monitoring.index') }}" class="btn btn-primary text-white"><i class="fas fa-arrow-left"></i> Regresar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <div class="row text-center">
                                <div class="col-md-12">
                                    <div class="text-xs-center">
                                        <h2>Estimación #{{ $estimate->number}}</h2>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-xs-12 col-md-3 col-lg-3 float-xs-left">
                                            <div class="card  height">
                                                <div class="card-header">Detalles del Contrato</div>
                                                <div class="card-block">
                                                    <strong>Contrato:</strong><br>
                                                    {{ $estimate->contract->nameContractFormatted }}<br>
                                                    <strong>Fechas</strong><br>
                                                    <i class="fas fa-play-circle" title="Fecha de inicio"></i>{{ $estimate->contract->startOk }}<br>
                                                    <i class="fas fa-stop-circle" title="Fecha de Terminación"></i>{{ $estimate->contract->finishOk }}<br>
                                                    <i class="fas fa-stopwatch" title="Fecha de Término Modificada"></i>{{ $estimate->contract->dateModifiedOk }}<br>                                            
                                                    <br>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-3 col-lg-3">
                                            <div class="card  height">
                                                <div class="card-header">Detalles de la Estimación</div>
                                                <div class="card-block">
                                                    <strong>Número:</strong> {{ $estimate->number }}<br>
                                                    <strong>Tipo:</strong> {{ $estimate->typeOk}}<br>
                                                    <strong>Fechas:</strong><br>
                                                    <i class="fas fa-play-circle" title="Fecha de inicio"></i>{{ $estimate->startOk }}<br>
                                                    <i class="fas fa-stop-circle" title="Fecha de Término"></i>{{ $estimate->finishOk }}<br>
                                                    <i class="fas fa-calendar-check" title="Fecha de Emisión"></i>{{ $estimate->release }}<br>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-3 col-lg-3">
                                            <div class="card  height">
                                                <div class="card-header">Gráfica</div>
                                                <div class="card-block">
                                                    <strong>Gift:</strong> No<br>
                                                    <strong>Express Delivery:</strong> Yes<br>
                                                    <strong>Insurance:</strong> No<br>
                                                    <strong>Coupon:</strong> No<br>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-3 col-lg-3 float-xs-right">
                                            <div class="card  height">
                                                <div class="card-header">Detalles de la Factura</div>
                                                <div class="card-block">
                                                    <strong>David Peere:</strong><br>
                                                    1111 Army Navy Drive<br>
                                                    Arlington<br>
                                                    VA<br>
                                                    <strong>22 203</strong><br>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card ">
                                        <div class="card-header">
                                            <h3 class="text-xs-center"><strong>Estado Contable</strong></h3>
                                        </div>
                                        <div class="card-block">
                                            <div class="table-responsive">
                                                <table class="table table-sm">
                                                    <thead>
                                                        <tr>
                                                            <td><strong>Item Name</strong></td>
                                                            <td class="text-xs-center"><strong>Item Price</strong></td>
                                                            <td class="text-xs-center"><strong>Item Quantity</strong></td>
                                                            <td class="text-xs-right"><strong>Total</strong></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Samsung Galaxy S5</td>
                                                            <td class="text-xs-center">$900</td>
                                                            <td class="text-xs-center">1</td>
                                                            <td class="text-xs-right">$900</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Samsung Galaxy S5 Extra Battery</td>
                                                            <td class="text-xs-center">$30.00</td>
                                                            <td class="text-xs-center">1</td>
                                                            <td class="text-xs-right">$30.00</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Screen protector</td>
                                                            <td class="text-xs-center">$7</td>
                                                            <td class="text-xs-center">4</td>
                                                            <td class="text-xs-right">$28</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="highrow"></td>
                                                            <td class="highrow"></td>
                                                            <td class="highrow text-xs-center"><strong>Subtotal</strong></td>
                                                            <td class="highrow text-xs-right">$958.00</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="emptyrow"></td>
                                                            <td class="emptyrow"></td>
                                                            <td class="emptyrow text-xs-center"><strong>Shipping</strong></td>
                                                            <td class="emptyrow text-xs-right">$20</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="emptyrow"><i class="fa fa-barcode iconbig"></i></td>
                                                            <td class="emptyrow"></td>
                                                            <td class="emptyrow text-xs-center"><strong>Total</strong></td>
                                                            <td class="emptyrow text-xs-right">$978.00</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('stylesheets')
    <style>
        .height {
            min-height: 200px;
        }
        
        .icon {
            font-size: 47px;
            color: #5CB85C;
        }
        
        .iconbig {
            font-size: 77px;
            color: #5CB85C;
        }
        
        .table > tbody > tr > .emptyrow {
            border-top: none;
        }
        
        .table > thead > tr > .emptyrow {
            border-bottom: none;
        }
        
        .table > tbody > tr > .highrow {
            border-top: 3px solid;
        }
    </style>
@endsection