<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <title>Sabana Finiquito</title>
    </head>
    <body class="m-3">
        <div class="table-responsive">
            <figure>
                <img src="{{ asset('/storage/imgs/header.png') }}"
                    alt="{{ asset('/storage/imgs/header.png')}}" width="100%">
            </figure>
            <table class="table table-sm table-bordered text-center">
                <thead class="thead-dark">
                    <tr>
                        <th COLSPAN="3">SABANA FINIQUITO</th>
                        <th class="bg-dark text-white">MONTOS</th>
                        <th class="bg-dark text-white">IMPORTES</th>
                        <th class="bg-dark text-white">I.V.A.</th>
                        <th class="bg-dark text-white">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td rowspan="2" COLSPAN="3" class="font-weight-bold">{{ $contract->name }}</td>
                        <td class="bg-dark text-white">ORIGINAL CONTRATADO</td>
                        <td>{{ $contract->originalAmountOk }}</td>
                        <td>{{ $contract->originalAmountIvaOk }}</td>
                        <td>{{ $contract->originalAmountWithIvaOk   }}</td>
                    </tr>
                    <tr>
                        <td class="bg-dark text-white">CONVENIO1</td>
                        <td>{{ $contract->extensionAmountOk }}</td>
                        <td>{{ $contract->extensionAmountIvaOk }}</td>
                        <td>{{ $contract->extensionAmountWithIvaOk }}</td>
                    </tr>
                    <tr>
                        <td rowspan="2" class="bg-dark text-white align-middle">CONTRATISTA:</td>
                        <td rowspan="2" class="align-middle">{{ $contract->companies()->first()->reason_social }}</td>
                        <td class="bg-dark text-white">CONTRATO:</td>
                        
                        <td class="bg-dark text-white">TOTAL CONTRATADO</td>
                        <td>{{ $contract->totalAmountOk }}</td>
                        <td>{{ $contract->totalAmountIvaOk }}</td>
                        <td>{{ $contract->totalAmountWithIvaOk }}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">{{ $contract->nameContractFormatted }}</td>
                        <td class="bg-dark text-white">ANTICIPO</td>
                        <td>{{ $contract->advancePaymentAmountOk }}</td>
                        <td>{{ $contract->advancePaymentAmountIvaOk }}</td>
                        <td>{{ $contract->advancePaymentAmountWithIvaOk }}</td>
                    </tr>
                    <tr>
                        <td rowspan="2" class="bg-dark text-white">
                            @if($contract->type==1)
                            SUPERVISIÓN:
                            @elseif($contract->type==2)
                            SUPERVISA:
                            @endif
                        </td>
                        <td rowspan="2">
                            _____________________________________
                        </td>
                        <td rowspan="2"></td>
                        <td rowspan="2" class="bg-dark text-white">FECHA DE INICIO</td>
                        <td rowspan="2">{{ $contract->startWithLetters }}</td>
                        <td rowspan="2" class="bg-dark text-white">FECHA DE TÉRMINO</td>
                        <td rowspan="2">{{ $contract->finishWithLetters }}</td>
                    </tr>
                </tbody>
                
            </table>
        </div>
        <div class="table-responsive">
            <table class="table table-sm table-bordered table-hover text-center">
                <thead class="thead-dark">
                    <tr>
                        <th rowspan="2">NUM</th>
                        <th rowspan="2">DESCRIPCIÓN</th>
                        <th rowspan="2">UNIDAD</th>
                        <th rowspan="2">CANTIDAD</th>
                        <th rowspan="2">PRECIO UNITARIO</th>
                        <th rowspan="2">125%</th>
                        @foreach($estimates as $estimate)
                            <th colspan="2">{{ $estimate->estimate }} ({{ $estimate->numberEstimateLetter }})</th>
                        @endforeach
                        <th colspan="2">REAL EJECUTADO</th>
                        <th rowspan="2">%</th>
                    </tr>
                    <tr>
                        @foreach($estimates as $estimate)
                        <th>cantidad</th>
                        <th>monto</th>
                        @endforeach
                        <th>cantidad</th>
                        <th>monto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($concepts as $concept)
                        <tr>
                            <td>{{ $concept->code }}</td>
                            <td class="text-left">{{ $concept->name }}</td>
                            <td>{{ $concept->measurement_unit }}</td>
                            <td>{{ $concept->quantity }}</td>
                            <td>{{ formatCash($concept->unit_price) }}</td>
                            <td>{{$concept->quantityMaxOk }}</td>
                            @foreach($estimates as $estimate)
                                <?php $var = 0; ?>
                                @foreach ($concept->data as $data) 
                                    @if ($data->number == $estimate->number) 
                                        <td>{{ format($data->quantity) }}</td>
                                        <td>{{ formatCash(round($data->quantity * $data->unit_price, 2)) }}</td>
                                        <?php $var = 1; ?>
                                    @endif
                                @endforeach
                                @if($var == 0)
                                    <td class="bg-light"></td>
                                    <td class="bg-light"></td>
                                @endif
                            @endforeach
                        
                            <td>
                                {{ format($concept->total) }}
                            </td>
                            <td>
                                @if($concept->total != 0)
                                {{ formatCash(round($concept->total * $concept->unit_price,2)) }}
                                @endif
                            </td>
                            <td>
                                @if($concept->total != 0)
                                {{ number_format(round($concept->total*100)/$concept->quantity,2,'.',',') }}%
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <!--*****************************************************************************************RETENCIONES-->
                    <tr>
                        <td colspan="6" class="bg-dark text-white"></td>
                        <td colspan="{{ $numEstimates * 2 + 3 }}" class="bg-dark text-white">RETENCIÓN/DEVOLUCIÓN</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="bg-dark text-white">MONTO S/IVA</td>
                        @foreach($estimates as $estimate)
                        <td colspan="2">{{ $estimate->retentionOk }}</td>
                        @endforeach
                        <td class="bg-light"></td>
                        <td class="bg-light"></td>
                        <td class="bg-light"></td>
                    </tr>
                    <!--/////////////////////////////////////////////////////////////////////////////////////////RETENCIONES-->
                    <!--*****************************************************************************************ESTIMADO LAST-->
                    <tr>
                        <td colspan="6" class="bg-dark text-white"></td>
                        <td colspan="{{ $numEstimates * 2+3 }}" class="bg-dark text-white">MONTO DE LA ESTIMACIÓN
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" class="bg-dark text-white">ESTIMADO ANTERIOR</td>
                        @foreach($estimates as $estimate)
                        <td colspan="2">{{ $estimate->totalPreviousAmountok }}</td>
                        @endforeach
                        <td class="bg-light"></td>
                        <td class="bg-light"></td>
                        <td class="bg-light"></td>
                    </tr>
                    <!--/////////////////////////////////////////////////////////////////////////////////////////TOTALAST-->
                    <!--*****************************************************************************************TOTALES-->
                    <tr>
                        <td colspan="6" class="bg-dark text-white">IMPORTE DE ESTA ESTIMACIÓN</td>
                        @foreach($estimates as $estimate)
                        <td colspan="2">{{ $estimate->totalEstimateAmountOk }}</td>
                        @endforeach
                        <td class="bg-light"></td>
                        <td class="bg-light"></td>
                        <td class="bg-light"></td>
                    </tr>
                    <!--/////////////////////////////////////////////////////////////////////////////////////////TOTALES-->
                    <!--*****************************************************************************************IVA-->
                    <tr>
                        <td colspan="6" class="bg-dark text-white">I.V.A.</td>
                        @foreach($estimates as $estimate)
                        <td colspan="2">{{ $estimate->totalEstimateAmountIvaOk }}</td>
                        @endforeach
                        <td class="bg-light"></td>
                        <td class="bg-light"></td>
                        <td class="bg-light"></td>
                    </tr>
                    <!--/////////////////////////////////////////////////////////////////////////////////////////IVA-->
                    <!--*****************************************************************************************MONTO CON IVA-->
                    <tr>
                        <td colspan="6" class="bg-dark text-white">MONTO DE LA ESTIMACIÓN CON I.V.A.</td>
                        @foreach($estimates as $estimate)
                        <td colspan="2">{{ $estimate->totalEstimateAmountWithIvaOk }}</td>
                        @endforeach
                        <td class="bg-light"></td>
                        <td class="bg-light"></td>
                        <td class="bg-light"></td>
                    </tr>
                    <!--/////////////////////////////////////////////////////////////////////////////////////////MONTO CON IVA-->
                    <!--*****************************************************************************************TOTAL ESTIMADO-->
                    <tr>
                        <td colspan="6" class="bg-dark text-white">TOTAL ESTIMADO</td>
                        @foreach($estimates as $estimate)
                        <td colspan="2">{{ $estimate->totalEstimatedOk }}</td>
                        @endforeach
                        <td class="bg-light"></td>
                        <td class="bg-light"></td>
                        <td class="bg-light"></td>
                    </tr>
                    <!--/////////////////////////////////////////////////////////////////////////////////////////TOTAL ESTIMADO-->
                    <!--*****************************************************************************************POR ESTIMAR-->
                    <tr>
                        <td colspan="6" class="bg-dark text-white">TOTAL POR ESTIMAR</td>
                        @foreach($estimates as $estimate)
                        <td colspan="2">{{ $estimate->totalForExecuteAmountOk }}</td>
                        @endforeach
                        <td class="bg-light"></td>
                        <td class="bg-light"></td>
                        <td class="bg-light"></td>
                    </tr>
                    <!--/////////////////////////////////////////////////////////////////////////////////////////POR ESTIMAR-->
                    <!--*****************************************************************************************DEDUCTIVAS OBLIGACTOTIAS-->
                    <tr>
                        <td colspan="6" class="bg-dark text-white"></td>
                        <td colspan="{{ $numEstimates * 2+3 }}" class="bg-dark text-white">DEDUCCIONES DE ESTA
                            ESTIMACIÓN</td>
                    </tr>
                    
                    <!--/////////////////////////////////////////////////////////////////////////////////////////DEDUCTIVAS OBLIGATORIAS-->
                    <!--*****************************************************************************************DEDUCTIVAS NOOO  OBLIGACTOTIAS-->
                    @forelse ($contract->deductions()->typeContract()->get() as $deduction)
                        @if($deduction->contracts()->first())
                            <tr>
                                <td colspan="6" class="bg-dark text-white">{{ $deduction->code }}</td>
                                @foreach($estimates as $estimate)
                                    <td colspan="2">
                                        {{ '$ ' . number_format(round(($estimate->totalEstimateAmount*($deduction->percentage * $deduction->contracts()->first()->pivot->factor))/100, 2),2) }}
                                    </td>
                                @endforeach
                                <td class="bg-light"></td>
                                <td class="bg-light"></td>
                                <td class="bg-light"></td>
                            </tr>
                        @endif
                    @empty
                        
                    @endforelse
                   
                    <tr>
                        <td colspan="6" class="bg-dark text-white">SANCIONES</td>
                        @forelse ($estimates as $estimate)
                            <td colspan="2" class="bg-light m-0 p-0">
                                @forelse ($estimate->deductions()->get() as $sanction)
                                    <table class="table table-sm table-responsive table-bordered text-center m-0" width=100%>
                                        <tr>
                                            <td class="bg-danger text-white">
                                                {{ $sanction->code }}
                                            </td>
                                            <td class="bg-dark text-white">
                                                {{ $sanction->pivot->factor }} periodo(s)
                                                {{ formatCash(round($estimate->totalEstimateAmount * (($sanction->percentage * $sanction->pivot->factor) / 100), 2, PHP_ROUND_HALF_DOWN)) }}
                                            </td>
                                        </tr>
                                    </table>
                                @empty
                                    
                                @endforelse
                            </td>
                        @empty
                    
                        @endforelse
                        <td class="bg-light"></td>
                        <td class="bg-light"></td>
                        <td class="bg-light"></td>
                    </tr>

                    <tr>
                        <td colspan="6" class="bg-dark text-white">TOTAL DE DEDUCCIONES</td>
                        @foreach($estimates as $estimate)
                            <td colspan="2" class="bg-danger text-white">{{ $estimate->totalDeductionsAmountOk }}</td>
                        @endforeach
                        <td class="bg-light"></td>
                        <td class="bg-light"></td>
                        <td class="bg-light"></td>
                    </tr>
                    <!--/////////////////////////////////////////////////////////////////////////////////////////DEDUCTIVAS NOOO  OBLIGATORIAS-->
                    <tr>
                        <td colspan="6" class="bg-dark text-white"></td>
                        <td colspan="{{ $estimates->count()*2+3 }}" class="bg-dark text-white">IMPORTE A PAGAR EN ESTA ESTIMACIÓN</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="bg-dark text-white">MONTO DE ESTA ESTIMACIÓN</td>
                        @foreach($estimates as $estimate)
                        <td colspan="2" class="bg-success text-white">{{ $estimate->totalEstimateAmountWithIvaOk }}</td>
                        @endforeach
                        <td class="bg-light"></td>
                        <td class="bg-light"></td>
                        <td class="bg-light"></td>
                    </tr>
                    <tr>
                        <td colspan="6" class="bg-dark text-white">DEDUCCIONES DE ESTA ESTIMACIÓN</td>
                        @foreach($estimates as $estimate)
                            <td colspan="2" class="bg-success text-white">{{ $estimate->totalDeductionsAmountOk }}</td>
                        @endforeach
                        <td class="bg-light"></td>
                        <td class="bg-light"></td>
                        <td class="bg-light"></td>
                    </tr>
                    <tr>
                        <td colspan="6" class="bg-dark text-white">IMPORTE NETO A PAGAR</td>
                        @foreach($estimates as $estimate)
                            <td colspan="2" class="bg-success text-white">{{ $estimate->amountNetOk }}</td>
                        @endforeach
                        <td class="bg-light"></td>
                        <td class="bg-light"></td>
                        <td class="bg-light"></td>
                    </tr>
                </tbody>    
            </table>
        </div>
        <div>
            <table class="table table-bordered">
                <tr>
                    <td>
                        {!! $contract->signature_1 !!}
                    </td>
                    <td>
                        {!! $contract->signature_2 !!}
                    </td>
                    <td>
                        {!! $contract->signature_3 !!}
                    </td>
                </tr>
                <tr>
                    <td>
                        {!! $contract->signature_4 !!}
                    </td>

                    <td>
                        {!! $contract->signature_5 !!}
                    </td>
                    <td>

                    </td>
                </tr>
            </table>
            <p>https://estimanet.com/</p>
        </div>
    </body>
</html>