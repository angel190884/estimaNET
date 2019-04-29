<figure>
	<img src="{{ asset('storage/imgs/header.png') }}" alt="logo cdmx" width="100%">
</figure>
<div class="titulo"><!-- TITULO -->
	<p>ESTADO CONTABLE A LA ESTIMACIÓN {{ $estimate->number }}</p>
</div>
<div class="datos"><!-- DATOS -->
	@if($estimate->contract->date_covenant > 0)
		<p style="font-size: 7px">CONTRATO No.-{{ $estimate->contract->nameContractFormatted }} </p>
		<p style="font-size: 7px">FECHA FIRMA.-{{ strtoupper($estimate->contract->signatureDate) }} </p>
		<p style="font-size: 7px">CONVENIO No.-{{ $estimate->contract->nameContractFormatted }}-C1</p>
	@else
		<p>CONTRATO No.-{{ $estimate->contract->nameContractFormatted }} </p>
		<p>FECHA FIRMA.-{{ strtoupper($estimate->contract->signaturewithLetters) }} </p>
	@endif
</div>