<div class="datos2">
	<div class="datos2_izq">PERIODO DE ESTIMACIÓN:</div>
	<div class="datos2_der">{{ $estimate->formattedPeriodEstimate }}.</div>
</div>
<div class="datos2">
	<div class="datos2_izq">NOMBRE DE LA EMPRESA:</div>
	<div class="datos2_der">{{ $estimate->contract->companies()->first()->reasonSocialOk }}</div>
</div>
<div class="datos2">
	<div>{{ strtoupper ($estimate->contract->name) }}</div>
</div>
<div class="datos2">
	<div>UBICACIÓN:  {{ strtoupper ($estimate->contract->location) }}</div>
</div>
<div>
	<table class="fechas">
		<tr>
			<td colspan="3"><strong>DATOS DE CONTRATACIÓN</strong></td>
		</tr>
		<tr>
			<td>FECHA DE INICIO ORIGINAL</td>
			<td>FECHA DE TERMINACIÓN ORIGINAL</td>
			<td>FECHA DE TERMINACIÓN MODIFICADA</td>
		</tr>
		<tr>
			<td>{{ $estimate->contract->startWithLetters }}</td>
			<td>{{ $estimate->contract->finishwithLetters }}</td>
			<td>{{ $estimate->contract->finishModifiedWithLetters }}</td>
		</tr>
	</table>
</div>
<div>
	<table class="cuentas">
		<tr>
			<td></td>
			<td class="cuentas_td"><strong>MONTO DE LA ESTIMACIÓN</strong></td>
			<td class="cuentas_td"></td>
			<td class="cuentas_td"></td>
			<td></td>
		</tr>
		<tr>
			<td><strong>A</strong></td>
			<td class="cuentas_td">ESTIMADO ANTERIOR</td>
			<td class="cuentas_td"></td>
			<td class="cuentas_td num">{{ $estimate->totalPreviousAmountOk }}</td><!-- OK -->
			<td>CON I.V.A.</td>
		</tr>
		<tr>
			<td><strong>B</strong></td>
			<td class="cuentas_td">IMPORTE DE ESTA ESTIMACIÓN</td>
			<td class="cuentas_td"></td>
			<td class="cuentas_td num">{{ $estimate->totalEstimateAmountOk }}</td><!-- OK -->
			<td>SIN I.V.A.</td>
		</tr>
		<tr>
			<td><strong>C</strong></td>
			<td class="cuentas_td">I.V.A.</td>
			<td class="cuentas_td"></td>
			<td class="cuentas_td num">{{ $estimate->totalEstimateAmountIvaOk }}</td><!-- OK -->
			<td></td>
		</tr>
		<tr>
			<td><strong>D</strong></td>
			<td class="cuentas_td">MONTO TOTAL DE ESTA ESTIMACIÓN(B+C)</td>
			<td class="cuentas_td"></td>
			<td class="cuentas_td num">{{ $estimate->totalEstimateAmountWithIvaOk }}</td><!-- OK -->
			<td>CON I.V.A.</td>
		</tr>
		<tr>
			<td><strong>E</strong></td>
			<td class="cuentas_td">TOTAL ESTIMADO</td>
			<td class="cuentas_td"></td>
			<td class="cuentas_td num">{{ $estimate->totalEstimatedOk }}</td><!-- OK -->
			<td>CON I.V.A.</td>
		</tr>
		<tr>
			<td>F</td>
				@if($estimate->typeOk=='FINAL' || $estimate->typeOk=='FINAL COMBINADA')
					<td class="cuentas_td"><strong>TOTAL POR CANCELAR</strong></td>
				@else
					<td class="cuentas_td"><strong>TOTAL POR ESTIMAR</strong></td>
				@endif
			<td class="cuentas_td"></td>
			<td class="cuentas_td num">{{ $estimate->totalForExecuteAmountOk }}</td><!-- OK -->
			<td>CON I.V.A.</td>
		</tr>

		@include('reports.accountingStatement.partials.advancePayment')
		
		@foreach ($estimate->contract->deductions()->typeContract()->get() as $deduction)
			@if($deduction->contracts()->first())
				<tr>
					<td></td>
					<td class="cuentas_td">{{ $deduction->code }}</td>
					<td class="cuentas_td">{{ $deduction->percentage }} % @if($deduction->contracts()->first()->pivot->factor > 1) x {{ $deduction->contracts()->first()->pivot->factor }} @endif</td>
					<td class="cuentas_td num">{{ '$ ' . number_format(round(
							($estimate->totalEstimateAmount*($deduction->percentage * $deduction->contracts()->first()->pivot->factor))/100, 2),2) }}</td>
					<td>SIN I.V.A.</td>	
				</tr>
			@endif    
		@endforeach
		@foreach ($estimate->deductions()->typeEstimate()->get() as $deduction)
			@if($deduction->estimates()->where('estimate_id',$estimate->id)->first())
				<tr>
					<td></td>
					<td class="cuentas_td">{{ $deduction->code }}</td>
					<td class="cuentas_td">{{ $deduction->percentage }} % x {{ $deduction->estimates()->where('estimate_id',$estimate->id)->first()->pivot->factor }}</td>
					<td class="cuentas_td num">{{ '$ ' . number_format(round(
						($estimate->totalEstimateAmount*($deduction->percentage * $deduction->estimates()->where('estimate_id',$estimate->id)->first()->pivot->factor))/100, 2),2) }}</td>
					<td>SIN I.V.A.</td>
				</tr>
			@endif    
		@endforeach
		<tr>
				<td></td>
				<td class="cuentas_td"><strong>TOTAL DE DEDUCCIONES</strong></td>
				<td class="cuentas_td"></td>
				<td class="cuentas_td num">{{ $estimate->TotalDeductionsAmountOk }}</td>
				<td> SIN I.V.A.</td>
		</tr>


		<tr>
			<td><strong></strong></td>
			<td class="">IMPORTE A PAGAR EN ESTA ESTIMACIÓN</td>
			<td class=""></td>
			<td class=""></td>
			<td></td>
		</tr>
		<tr>
			<td><strong></strong></td>
			<td class="cuentas_td"><strong>MONTO DE ESTA ESTIMACIÓN(D)</strong></td>
			<td class="cuentas_td"></td>
			<td class="cuentas_td num">{{ $estimate->totalEstimateAmountWithIvaOk }}</td><!-- OK -->
			<td>CON I.V.A.</td>
		</tr>
		<tr>
			<td><strong></strong></td>
			<td class="cuentas_td"><strong>AMORTIZACIÓN DE ESTA ESTIMACIÓN(I)</strong></td>
			<td class="cuentas_td"></td>
			<td class="cuentas_td num">$0.00</td>
			<td>CON I.V.A.</td>
		</tr>
		<tr>
			<td><strong></strong></td>
			<td class="cuentas_td"><strong>DEDUCCIONES DE ESTA ESTIMACIÓN(M)</strong></td>
			<td class="cuentas_td"></td>
			<td class="cuentas_td num" >{{ $estimate->TotalDeductionsAmountOk }}</td><!-- OK -->
			<td>SIN I.V.A.</td>
		</tr>
		<tr>
			<td><strong>N</strong></td>
			<td class="cuentas_td"><strong>IMPORTE NETO A PAGAR( D - I - M )</strong></td>
			<td class="cuentas_td"></td>

			<td class="cuentas_td num">{{ $estimate->amountNetOk }}</td><!-- OK -->
			<td>CON I.V.A.</td>
		</tr>

		<tr>
			<td><strong></strong></td>
			<td class="cuentas_td"><strong>IMPORTE NETO A PAGAR(CON LETRA):</td>
			<td class="cuentas_td texto " colspan="2"><strong>( {{ $estimate->amountNetLetterOk }} )</strong></td><!-- OK -->
			<td></td>
		</tr>
	</table>
</div>
<div>
	<table class="firmas">
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
				{!! $estimate->contract->signature_6 !!}
			</td>
		</tr>
	</table>
</div>