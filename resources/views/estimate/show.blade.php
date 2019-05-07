@extends('layouts.app')
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
    {!! $chart->script() !!}
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
                                                    {{ $estimate->contract->nameContractFormatted }} <a href="{{ route('contract.edit',$estimate->contract) }}"><i class="fas fa-pen" title="editar contracto"></i></a> <br>
                                                    <strong>Fechas</strong><br>
                                                    <i class="fas fa-play-circle" title="Fecha de inicio"></i>{{ $estimate->contract->startOk }}<br>
                                                    <i class="fas fa-stop-circle" title="Fecha de Terminación"></i>{{ $estimate->contract->finishOk }}<br>
                                                    <i class="fas fa-stopwatch" title="Fecha de Término Modificada"></i>{{ $estimate->contract->finishModifiedOk }}<br>                                            
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
                                                    <i class="fas fa-calendar-check" title="Fecha de Emisión"></i>{{ $estimate->releaseOK }}<br>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-3 col-lg-3">
                                            <div class="card  height">
                                                <div class="card-header">Gráfica</div>
                                                <div class="card-block">
                                                    {!! $chart->container() !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-3 col-lg-3 float-xs-right">
                                            <div class="card  height">
                                                <div class="card-header">Acciones</div>
                                                <div class="card-block">
                                                    <strong>Sistema:</strong><br>
                                                    <a class="btn btn-sm btn-primary text-white" title="Actualizar" href="{{ url()->current() }}"><i class="fas fa-sync fa-2x"></i></a>
                                                    <a class="btn btn-sm btn-primary text-white" title="Editar Estimación" href="{{ route('estimate.edit', $estimate) }}"><i class="fas fa-edit fa-2x"></i></a>
                                                    <!--<a class="btn btn-sm btn-primary text-white" title="Control de Ruta" href="#"><i class="fas fa-route fa-2x"></i></a>-->
                                                    <a class="btn btn-sm btn-primary text-white" title="Editar Conceptos" href="{{ route('generator.list',$estimate) }}"><i class="fas fa-clipboard-list fa-2x"></i></a><br>
                                                    
                                                    <strong>PDF's</strong><br>
                                                    @if($estimate->contract->split_catalog)
                                                        <a class="btn btn-sm btn-primary text-white" title="Control Acumulativo" href="{{ route('report.cumulativeControlLocations',$estimate) }}" target="_blank"><i class="fas fa-file-alt fa-2x"></i></i></a>
                                                    @else
                                                        <a class="btn btn-sm btn-primary text-white" title="Control Acumulativo" href="{{ route('report.cumulativeControl',$estimate) }}" target="_blank"><i class="fas fa-file-alt fa-2x"></i></i></a>
                                                    @endif
                                                        <a class="btn btn-sm btn-primary text-white" title="Estado Contable" href="{{ route('report.accountingStatement',$estimate) }}" target="_blank"><i class="fas fa-file-invoice fa-2x"></i></a>                                            
                                                    <!--<a class="btn btn-sm btn-primary text-danger" title="Oficio de Entrega"><i class="fas fa-file-signature fa-2x"></i></a>
                                                    <a class="btn btn-sm btn-primary text-danger" title="Hoja de Ruta"><i class="fas fa-file-export fa-2x"></i></a>
                                                    <a class="btn btn-sm btn-primary text-danger" title="Borrador Factura"><i class="fas fa-file-invoice-dollar fa-2x"></i></a>-->
                                                    <br>
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
                                                <table class="table table-sm table-hover">
                                                    <thead>
                                                        <tr>
                                                            <td><strong>Concepto</strong></td>
                                                            <td class="text-xs-center"><strong></strong></td>
                                                            <td class="text-xs-center"><strong></strong></td>
                                                            <td class="text-right"><strong>Monto</strong></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Estimado Anterior</td>
                                                            <td class="text-xs-center"></td>
                                                            <td class="text-xs-center"></td>
                                                            <td class="text-right">{{ $estimate->totalPreviousAmountOk }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Importe de esta Estimación</td>
                                                            <td class="text-xs-center"></td>
                                                            <td class="text-xs-center"></td>
                                                            <td class="text-right">{{ $estimate->totalEstimateAmountOk }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>I.V.A.</td>
                                                            <td class="text-xs-center"></td>
                                                            <td class="text-xs-center"></td>
                                                            <td class="text-right">{{ $estimate->totalEstimateAmountIvaOk}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong> Monto total de esta Estimación</strong></td>
                                                            <td class="text-xs-center"></td>
                                                            <td class="text-xs-center"></td>
                                                            <td class="text-right"><strong>{{ $estimate->totalEstimateAmountWithIvaOk }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Total Estimado</td>
                                                            <td class="text-xs-center"></td>
                                                            <td class="text-xs-center"></td>
                                                            <td class="text-right">{{ $estimate->totalEstimatedOk }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Total x Estimar</td>
                                                            <td class="text-xs-center"></td>
                                                            <td class="text-xs-center"></td>
                                                            <td class="text-right">{{ $estimate->totalForExecuteAmountOk }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Deducciones</strong></td>
                                                            <td class="text-xs-center"></td>
                                                            <td class="text-xs-center"></td>
                                                            <td class="text-right"></td>
                                                        </tr>
                                                        
                                                        @foreach ($estimate->contract->deductions()->typeContract()->get() as $deduction)
                                                            @if($deduction->contracts()->first())
                                                                <tr>
                                                                    <td>{{ $deduction->code }}</td>
                                                                    <td class="text-center">{{ $deduction->percentage }} %</td>
                                                                    <td class="text-center">x {{ $deduction->contracts()->first()->pivot->factor }}</td>
                                                                    <td class="text-right">{{ '$ ' . number_format(round(
                                                                        ($estimate->totalEstimateAmount*($deduction->percentage * $deduction->contracts()->first()->pivot->factor))/100, 2),2) }}</td>
                                                                </tr>
                                                            @endif    
                                                        @endforeach
                                                        @foreach ($estimate->deductions()->typeEstimate()->get() as $deduction)
                                                            @if($deduction->estimates()->where('estimate_id',$estimate->id)->first())
                                                                <tr>
                                                                    <td>{{ $deduction->code }}</td>
                                                                    <td class="text-center">{{ $deduction->percentage }} %</td>
                                                                    <td class="text-center">x {{ $deduction->estimates()->where('estimate_id',$estimate->id)->first()->pivot->factor }}</td>
                                                                    <td class="text-right">{{ '$ ' . number_format(round(
                                                                        ($estimate->totalEstimateAmount*($deduction->percentage * $deduction->estimates()->where('estimate_id',$estimate->id)->first()->pivot->factor))/100, 2),2) }}</td>
                                                                </tr>
                                                            @endif    
                                                        @endforeach
                                                        <tr>
                                                            <td><strong>Total de Deducciones</strong></td>
                                                                <td class="text-xs-center"></td>
                                                                <td class="text-xs-center"></td>
                                                                <td class="text-right"><strong>{{ $estimate->TotalDeductionsAmountOk }}</strong></td>
                                                            </tr>
                                                        <tr>
                                                            <td class="highrow text-right" colspan="2"><strong>Importe Neto a Pagar</strong></td>
                                                            <td class="highrow text-right" colspan="2"><strong>{{ $estimate->amountNetOk }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="emptyrow text-right" colspan="2"><strong>Importe Neto a Pagar con Letra</strong></td>
                                                            <td class="emptyrow text-right" colspan="2">{{ $estimate->amountNetLetterOk }}</td>
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