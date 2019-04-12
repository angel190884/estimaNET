<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <style>
        @page {
            margin: 0cm 1cm 6cm 1cm;
        }

        body {
            font-family: sans-serif;
            margin: 38mm 0cm 0cm 0cm;
            text-align: justify;
            border: 0.1pt solid dimgrey;
        }

        #header,#footer {
            position: fixed;
            left: 0;
            right: 0;
            color: black;
            font-size: 0.5em;
        }

        #header {
            top: 0;
            border-bottom: 0.1pt solid #aaa;
        }
        #footer {
            bottom: 0;
            border-top: 0.1pt solid #aaa;
        }

        #header figure{
            margin: 0;
            #border: 0.1pt solid black;
            padding: 0;

        }

        #header table, #footer table {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }

        #header thead, th{
            border: .1pt solid dimgrey;
            font-weight: normal;
            font-size: .800em;
        }
        .fechas{
            font-size: .800em;
        }
        .col1,.col2,.col3,.col4,.col5,.col6,.col7,.col8,.col9, .col10,.col11{
            text-align: center;
            font-size: .800em;
        }
        .col1{
            width: 5%;

        }.col2{
             width: 34%;
             font-size: .9em;

         }.col3{
              width: 5%;
          }.col4{
               width: 7%;

           }.col5{
                width: 7%;

            }.col6{
                 width: 7%;

             }.col7{
                  width: 7%;

              }
        .col8{
            width: 7%;

        }.col9{
             width: 7%;

         }.col10{
              width: 7%;

          }.col11{
               width:  7%;
           }

        #header td,    #footer td {
            padding: 0;
            width: 50%;
            border: .1pt solid dimgrey;
        }
        .page-number {
            text-align: left;
        }

        .page-number:before {
            content: "Pagina " counter(page);
        }
        .page-estimanet {
            text-align: right;
            padding: -2.5mm;
        }

        .page-estimanet:before {
            content: "www.estimanet.com";
        }
        hr {
            page-break-after: always;
            border: 0;
        }
        #content table{
            width: 100%;
            border-collapse: collapse;
            border: none;
        }
        #content td{
            border: 0.1pt solid dimgrey;
            margin: 0;
            padding: 1px;
        }
        #content th{
            border: 0.1pt solid dimgrey;
            margin: 0;
            padding: 1px;
        }
        .contentCol1{
            width: 5%;
            text-align: center;
            font-size: 9px;
        }
        #address{
            margin: 0;
            padding: 0;
            font-size: 7px;
        }
        .contentCol2{
            width: 34%;
            font-size: 7px;
            text-align: justify;
        }
        .contentCol3{
            width: 5%;
            font-size: 7px;
            text-align: center;

        }
        .contentCol4{
            width: 7%;
            font-size: 7px;
            text-align: center;
        }
        .contentCol5{
            width: 7%;
            font-size: 7px;
            text-align: right;
        }
        .contentHeader{
            font-size: 10px;
            text-align: center;
            color: #FFFFFF;
            background: dimgrey;
        }
        .contentSubtotalAditivas{
            font-size: 10px;
            text-align: right;
            color: black;
            background: #BDBDBD;
        }
        .contentSubtotalDeductivas{
            font-size: 10px;
            text-align: center;
            color: black;
            background: #BDBDBD;
        }
        .contentDeductivasHeader{
            font-size: 9px;
            text-align: center;
            color: black;
        }
        .contentTotalEstimate{
            font-size: 18px;
            text-align: right;
            color: white;
            background: #232323;
            font-weight: bold;
        }
    </style>
    <title>Control Acumulativo x locaciones</title>
</head>
<body>
<div id="header">
    <figure>
        <img src="{{ public_path() . '/storage/imgs/header.png' }}" alt="{{ public_path() . '/storage/imgs/header.png' }}" width="100%">
    </figure>

    <table>
        <tr>
            <td colspan="6">CONTROL ACUMULATIVO A LA ESTIMACIÓN: <b>{{ $estimate->number }} {{ $estimate->estimateLetter }}</b></td>
            <td colspan="3" align="center">FECHA: <b>{{ $estimate->dateOfDelivery }}</b></td>
            <td colspan="3" align="center">VERSIÓN:</td>
        </tr>
        <tr>
            <td colspan="3">ESTIMACIÓN No.-
                <b>{{ $estimate->number }} {{ $estimate->estimateLetter }}</b>
            </td>
            <td colspan="5" align="center" class="fechas">
                {{ strtoupper($estimate->formattedPeriodEstimate) }}
            </td>
            <td colspan="4" align="center">
                IMPORTE DEL CONTRATO S/IVA:
                @if($estimate->start >= $estimate->contract->date_finish_modified )
                    <b>$ {!! number_format( $estimate->contract->totalAmount,2,'.',',' ) !!}</b>
                @else
                    <b>$ {!! number_format( $estimate->contract->originalAmount,2,'.',',' ) !!}</b>
                @endif

            </td>
        </tr>
        <tr>
            <td colspan="12" align="center" HEIGHT="6mm"><b>"{{ $estimate->contract->name }}"</b></td>
        </tr>
        <tr>
            <td colspan="8" height="6mm">
                UBICACIÓN(ES):<b>{{ $estimate->contract->location }}</b>
            </td>
            <td colspan="4" align="center">
                NÚMERO DE CONTRATO: <b>{{ $estimate->contract->nameContractFormatted }}</b>
            </td>
        </tr>
    </table>

    <table>
        <thead>
        <tr>
            <th rowspan="2" class="col1">NUM</th>
            <th rowspan="2" class="col2">DESCRIPCIÓN</th>
            <th rowspan="2" class="col3">UNIDAD</th>
            <th colspan="4" align="center">CANTIDADES</th>
            <th colspan="4" align="center">IMPORTES</th>
        </tr>
        <tr>
            <th class="col4">SEGÚN CONTRATO</th>
            <th class="col5">ACUMULADO ANTERIOR</th>
            <th class="col6">ESTA ESTIMACIÓN</th>
            <th class="col7">ACUMULADO ACTUAL</th>
            <th class="col8">PRECIO UNITARIO</th>
            <th class="col9">IMPORTE ANTERIOR</th>
            <th class="col10">IMPORTE ESTA ESTIMACIÓN</th>
            <th class="col11">IMPORTE ACUMULADO</th>
        </tr>
        </thead>
    </table>
</div>
<div id="content">
    <table>
        @foreach($data as $key => $location)
            <tr>
                <th colspan="11" class="contentHeader">
                    {{ $location['location'] }}
                    <p id="address">{{ $location['address'] }}</p>
                </th>
            </tr>
            @foreach($location['additions'] as $addition)
                <tr>
                    <td class="contentCol1">{{ $addition->generator->concept->code }}</td>
                    <td class="contentCol2">{{ $addition->generator->concept->name }}</td>

                    @if($estimate->contract->typeOk == 'supervision')
                        <td class="contentCol3">%</td>
                    @else
                        <td class="contentCol3">{{ $addition->generator->concept->measurement_unit }}</td>
                    @endif

                    <td class="contentCol4">{{$addition->generator->concept->quantityOk }}</td>
                    <td class="contentCol4">{{ $addition->acumuladoAnterior }}</td>
                    <td class="contentCol4">{{ $addition->quantityOk }}</td>

                    <td class="contentCol4">{{ $addition->acumuladoActual }}</td>

                    <td class="contentCol5">{{ $addition->generator->concept->unitPriceOk }}</td>



                    <td class="contentCol5">{{ $addition->importeAnterior }}</td>
                    <td class="contentCol5">{{ $addition->importeActual }}</td>
                    <td class="contentCol5">{{ $addition->importeAcumulado }}</td>
                </tr>
            @endforeach
            <tr>
                <th colspan="11" class="contentSubtotalAditivas">
                    SubTotal:&nbsp;&nbsp;${{ $location['subTotalAdditions'] }}
                </th>
            </tr>
            @if(count($location['deductions']) > 0)
                <tr>
                    <th colspan="11" class="contentDeductivasHeader">
                        *******DEDUCTIVAS*******
                    </th>
                </tr>
                @foreach($location['deductions'] as $deduction)
                    <tr>
                        <td class="contentCol1">{{ $deduction->generator->concept->code }}</td>
                        <td class="contentCol2">{{ $deduction->generator->concept->name }}</td>
                        @if($estimate->contract->typeOk == 'supervision')
                            <td class="contentCol3">%</td>
                        @else
                            <td class="contentCol3">{{ $deduction->generator->concept->measurement_unit }}</td>
                        @endif
                        <td class="contentCol4">{{ $deduction->generator->concept->quantityOk }}</td>
                        <td class="contentCol4">{{ $deduction->lastQuantityOk }}</td>
                        <td class="contentCol4">{{ $deduction->quantityOk }}</td>

                        <td class="contentCol4">{{ $deduction->accumulatedQuantityOk }}</td>

                        <td class="contentCol5">{{ $deduction->generator->concept->unitPriceOk }}</td>



                        <td class="contentCol5">{{ $deduction->lastAmountOk }}</td>
                        <td class="contentCol5">{{ $deduction->amountOk }}</td>
                        <td class="contentCol5">{{ $deduction->accumulatedAmount }}</td>
                    </tr>
                @endforeach
                <tr>
                    <th colspan="11" class="contentSubtotalAditivas">
                        SubTotal Deductivas:&nbsp;&nbsp;${{ $location['subTotalDeductions'] }}
                    </th>
                </tr>
            @endif
            <tr>
                <th colspan="11" class="contentSubtotalAditivas">
                    TOTAL {{ $location['location'] }}:&nbsp;&nbsp;${{ $location['subTotal'] }}
                </th>
            </tr>
        @endforeach
        @if($estimate->retention != 0)
            <tr>
                <td colspan="11" class="contentSubtotalAditivas">
                    RETENCIÓN Y/O DEVOLUCIÓN: ${{ number_format($estimate->retention ,2,'.',',') }}
                </td>
            </tr>
        @endif
        <tr>
            <td colspan="11" class="contentTotalEstimate">
                TOTAL: ${{ number_format($total ,2,'.',',') }}
            </td>
        </tr>
    </table>
</div>
<div id="footer">
    <table>
        <tr>
            <td>
                {!! $estimate->contract->signature_1 !!}
            </td>
            <td>
                {!! $estimate->contract->signature_2 !!}
            </td>
            <td>
                {!! $estimate->contract->signature_3 !!}
            </td>
        </tr>
        <tr>
            <td>
                {!! $estimate->contract->signature_4 !!}
            </td>

            <td>
                {!! $estimate->contract->signature_5 !!}
            </td>
            <td>

            </td>
        </tr>
    </table>

    <div class="page-number"></div><div class="page-estimanet"></div>
</div>
</body>
</html>
