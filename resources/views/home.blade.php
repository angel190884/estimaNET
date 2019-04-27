@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="container">
                        <div class="row">
                            <div class="col-6 col-lg-3">
                                <div class="card">
                                    <div class="card-body p-3 d-flex align-items-center">
                                        <i class="fas fa-snowplow bg-primary fa-2x px-1 mr-3"></i>
                                        <div>
                                            <div class="text-value-sm text-primary">CONTRATOS ACTIVOS</div>
                                        <div class="text-muted text-uppercase font-weight-bold small">total: {{ $numContracts }}</div>
                                        </div>
                                    </div>
                                    <div class="card-footer px-3 py-2">
                                        <a class="btn-block text-muted d-flex justify-content-between align-items-center" href="">
                                            <span class="small font-weight-bold">Ver más</span>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                    
                            <div class="col-6 col-lg-3">
                                <div class="card">
                                    <div class="card-body p-3 d-flex align-items-center">
                                        <i class="fa fa-file-signature bg-info fa-2x px-1 mr-3"></i>
                                        <div>
                                            <div class="text-value-sm text-info">ESTIMACIONES</div>
                                            <div class="text-muted text-uppercase font-weight-bold small">cantidad:  </div>
                                        </div>
                                    </div>
                                    <div class="card-footer px-3 py-2">
                                    <a class="btn-block text-muted d-flex justify-content-between align-items-center" href="">
                                            <span class="small font-weight-bold">Ver más</span>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                    
                            <div class="col-6 col-lg-3">
                                <div class="card">
                                    <div class="card-body p-3 d-flex align-items-center">
                                        <i class="fas fa-map-marker-alt bg-primary fa-2x px-1 mr-3"></i>
                                        <div>
                                            <div class="text-value-sm text-primary">FRENTES</div>
                                            <div class="text-muted text-uppercase font-weight-bold small">cantidad:  </div>
                                        </div>
                                    </div>
                                    <div class="card-footer px-3 py-2">
                                    <a class="btn-block text-muted d-flex justify-content-between align-items-center" href="">
                                            <span class="small font-weight-bold">Ver más</span>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                    
                            <div class="col-6 col-lg-3">
                                <div class="card">
                                    <div class="card-body p-3 d-flex align-items-center">
                                        <i class="fa fa-bell bg-primary fa-2x px-1 mr-3"></i>
                                        <div>
                                            <div class="text-value-sm text-primary">LOG</div>
                                            <div class="text-muted text-uppercase font-weight-bold small">Log del sistema</div>
                                        </div>
                                    </div>
                                    <div class="card-footer px-3 py-2">
                                        <a class="btn-block text-muted d-flex justify-content-between align-items-center" href="">
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
