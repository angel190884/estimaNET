<div>
			<table class="montos">
				<tr>
					<td colspan="3" class="num_est">ESTIMACIÓN No.</td>
					<td>MONTOS</td>
					<td>IMPORTE</td>
					<td>I.V.A.</td>
					<td>TOTAL</td>
				</tr>
				<tr>
					<td colspan="3" rowspan="4" class="num_est">
						{{ $estimate->number }} {{ $estimate->estimateLetter  }}
					</td>
					<td class="texto_monto">ORIGINAL CONTRATO</td>
					<td>${{ number_format($estimate->contract->originalAmount,2) }}</td>
					<td>${{ number_format($estimate->contract->originalIva,2) }}</td>
					<td>${{ number_format($estimate->contract->originalAmountTotal,2) }}</td>
				</tr>
				<tr>
					<td class="texto_monto">AMPLIACIÓN O REDUCCIÓN</td>
					@if($estimate->period_start >= $estimate->contract->date_covenant )
						<td>${{ number_format($estimate->contract->extensionAmount, 2) }}</td>
						<td>${{ number_format($estimate->contract->extensionIva, 2) }}</td>
						<td>${{ number_format($estimate->contract->extensionAmountTotal, 2) }}</td>
					@else
						<td>$0.00</td>
						<td>$0.00</td>
						<td>$0.00</td>
					@endif
				</tr>
				<tr>
					<td class="texto_monto">TOTAL CONTRATADO</td>
					@if($estimate->period_start >= $estimate->contract->date_covenant )
						<td>${{ number_format($estimate->contract->totalAmount, 2) }}</td>
						<td>${{ number_format($estimate->contract->totalAmountIva, 2) }}</td>
						<td>${{ number_format($estimate->contract->total, 2) }}</td>
					@else
						<td>${{ number_format($estimate->contract->originalAmount,2) }}</td>
						<td>${{ number_format($estimate->contract->originalIva,2) }}</td>
						<td>${{ number_format($estimate->contract->originalAmountTotal,2) }}</td>
					@endif
				</tr>
				<tr>
					<td class="texto_monto">ANTICIPO</td>
					<td>${{ number_format($estimate->contract->anticipatedAmount, 2) }}</td>
					<td>${{ number_format($estimate->contract->anticipatedAmountIva, 2) }}</td>
					<td>${{ number_format($estimate->contract->totalAnticipatedAmount, 2) }}</td>
				</tr>
				
			</table>
</div>
