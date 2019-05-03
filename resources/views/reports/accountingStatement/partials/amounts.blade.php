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
					<td>{{ $estimate->contract->originalAmountOk }}</td>
					<td>{{ $estimate->contract->originalAmountIvaOk }}</td>
					<td>{{ $estimate->contract->originalAmountWithIvaOk  }}</td>
				</tr>
				<tr>
					<td class="texto_monto">AMPLIACIÓN O REDUCCIÓN</td>
					@if($estimate->start >= $estimate->contract->date_signature_covenant)
						<td>{{ $estimate->contract->extensionAmountOk }}</td>
						<td>{{ $estimate->contract->extensionAmountIvaOk }}</td>
						<td>{{ $estimate->contract->extensionAmountWithIvaOk }}</td>
					@else
						<td>$0.00</td>
						<td>$0.00</td>
						<td>$0.00</td>
					@endif
				</tr>
				<tr>
					<td class="texto_monto">TOTAL CONTRATADO</td>
					@if($estimate->start >= $estimate->contract->date_signature_covenant )
						<td>{{ $estimate->contract->totalAmountOk }}</td>
						<td>{{ $estimate->contract->totalAmountIvaOk }}</td>
						<td>{{ $estimate->contract->totalAmountWithIvaOk }}</td>
					@else
						<td>{{ $estimate->contract->originalAmountOk }}</td>
						<td>{{ $estimate->contract->originalAmountIvaOk }}</td>
						<td>{{ $estimate->contract->originalAmountWithIvaOk  }}</td>
					@endif
				</tr>
				<tr>
					<td class="texto_monto">ANTICIPO</td>
					<td>{{ $estimate->contract->advancePaymentAmountOk }}</td>
					<td>{{ $estimate->contract->advancePaymentAmountIvaOk }}</td>
					<td>{{ $estimate->contract->advancePaymentAmountWithIvaOk }}</td>
				</tr>
				
			</table>
</div>
