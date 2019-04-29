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
		<td class="text-right">{{ $estimate->TotalDeductionsAmountOk }}</td>
</tr>