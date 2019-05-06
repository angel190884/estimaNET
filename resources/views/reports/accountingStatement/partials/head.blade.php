<figure class="titleLogo">
	<img src="{{ asset('storage/imgs/header.png') }}" alt="logo cdmx" width="100%">
</figure>
<div class="titulo"><!-- TITULO -->
	<p>ESTADO CONTABLE A LA ESTIMACIÓN {{ $estimate->number }}</p>
</div>
<div class="datos"><!-- DATOS -->
	@if($estimate->contract->date_signature_covenant > 0)
		<p style="font-size: 7px">CONTRATO No.- {{ $estimate->contract->nameContractFormatted }} </p>
		<p style="font-size: 7px">FECHA FIRMA.- {{ $estimate->contract->signatureWithLetters }} </p>
		<p style="font-size: 7px">CONVENIO No.- {{ $estimate->contract->codeOk }} - C1</p>
	@else
		<p>CONTRATO No.- {{ $estimate->contract->nameContractFormatted }} </p>
		<p>FECHA FIRMA.- {{ $estimate->contract->signatureWithLetters }} </p>
	@endif
</div>