@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Panel Pricipal</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
                        <h1 class="display-5">EstimaNET</h1>
                        <p class="lead">
                            Sistema Integral para el control de tus estimaciones en un solo lugar.
                        </p>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12 col-6-md col-lg-3 p-3">
                                <div class="card">
                                    <div class="card-body p-3 d-flex align-items-center">
                                        <i class="fas fa-snowplow text-black-50 fa-2x px-1 mr-3 col-xs-12"></i>
                                        <div class="col-xs-12">
                                            <div class="text-value-sm text-primary col-xs-12">CONTRATOS</div>
                                            <div class="text-muted text-uppercase font-weight-bold small col-xs-12">total: {{ $numContracts }}</div>
                                        </div>
                                    </div>
                                    <div class="card-footer px-3 py-2">
                                    <a class="btn-block text-muted d-flex justify-content-between align-items-center" href="{{ route('contract.index') }}">
                                            <span class="small font-weight-bold">Ver más</span>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                    
                            <div class="col-xs-12 col-6-md col-lg-3 p-3">
                                <div class="card">
                                    <div class="card-body p-3 d-flex align-items-center">
                                        <i class="fa fa-file-signature text-black-50 fa-2x px-1 mr-3"></i>
                                        <div>
                                            <div class="text-value-sm text-info">ESTIMACIONES</div>
                                            <div class="text-muted text-uppercase font-weight-bold small">total: {{ $numEstimates }}  </div>
                                        </div>
                                    </div>
                                    <div class="card-footer px-3 py-2">
                                    <a class="btn-block text-muted d-flex justify-content-between align-items-center" href="{{ route('estimate.index') }}">
                                            <span class="small font-weight-bold">Ver más</span>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                    
                            <div class="col-xs-12 col-6-md col-lg-3 p-3">
                                <div class="card">
                                    <div class="card-body p-3 d-flex align-items-center">
                                        <i class="fas fa-map-marker-alt text-black-50 fa-2x px-1 mr-3"></i>
                                        <div>
                                            <div class="text-value-sm text-primary">FRENTES</div>
                                            <div class="text-muted text-uppercase font-weight-bold small">total: {{ $numLocations }} </div>
                                        </div>
                                    </div>
                                    <div class="card-footer px-3 py-2">
                                    <a class="btn-block text-muted d-flex justify-content-between align-items-center" href="{{ route('location.index') }}">
                                            <span class="small font-weight-bold">Ver más</span>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                    
                            <div class="col-xs-12 col-6-md col-lg-3 p-3">
                                <div class="card">
                                    <div class=" card-body p-3 d-flex align-items-center">
                                        <i class="fa fa-bell text-black-50 fa-2x px-1 mr-3"></i>
                                        <div>
                                            <div class="text-value-sm text-primary">LOGS</div>
                                            <div class="text-muted text-uppercase font-weight-bold small">Log del sistema</div>
                                        </div>
                                    </div>
                                    <div class="card-footer px-3 py-2">
                                    <a class="btn-block text-muted d-flex justify-content-between align-items-center" href="{{ route('logs') }}">
                                            <span class="small font-weight-bold">Ver más</span>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
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
