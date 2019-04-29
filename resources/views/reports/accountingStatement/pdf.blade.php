<html>
	<head>
		<title>Estado Contable</title>
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8"/>
		<style>
			.titulo{
		
				display: inline-block;
				width: 60%;
				height: 35px;
				font-size: 15px;
			}
			.titulo p{
				margin: 0px;
				padding: 0px;
			
			}
			.datos{
				width: 39%;
				display: inline-block;
				border: 1px solid black;
				font-size: 10px;
				height: 30px;
				text-align: right;
				margin-bottom: 5px;
			
			}
			.datos p{
				margin: 0px;
				padding: 0px;
				vertical-align: middle;
			}
			.montos{
				width: 100%;
				font-size: 8px;
				border-collapse: collapse;
				text-align: right;
			}
			.montos td{
				border: 1px solid black;
			}
			.num_est{
				font-size: 20px;
				text-align: center;
			}
			.texto_monto{
				text-align: right;
			}
			.datos2{
				border: 1px solid black;
				margin: 2px;
				padding: 5px;
				text-align: center;
				font-size: 10px;
			}
			.datos2_izq{
				display: inline-block;
				font-size: 10px;
				width: 30%;
				text-align: left;
			}
			.datos2_der{
				
				display: inline-block;
				font-size: 10px;
				width: 68%;
			}
			.fechas{
				width: 100%;
				border: 1px solid black;
				text-align: center;
				font-size: 10px;
			}
			.fechas td{
				border: 1px solid black;
			}
			.cuentas{
				width: 100%;
				font-size: 8px;
				
				border-collapse: collapse;
			}
			.num{
				text-align: right;
			}
			.texto{
				text-align: left;
			}
			.cuentas_td{
				border-bottom: 1px solid black;
			}
			.firmas{
				width: 100%;
				margin-top: 10px;
			}
			.firmas td{
				border: 1px solid black;
				border-collapse: collapse;
				font-size: 8px;
				height: 50px;
				width: 33.3%;
				padding: 5px;
				margin: 0;
			}
			.firmas td p{
				#border: 1px solid red;
				margin: 0px;
				padding: 0px;
			}
			.firmas label{
				display: block;
			
			
				
				
			}
			.top{
				padding-top: 1px;
			}
			.down{
				padding-bottom: 1px;
			}
			.locations{
				font-size: 6px;
				margin: 0px;
				font: bold 35%;
			}
		</style>	
	</head>
	<body>
		@include('reports.accountingStatement.partials.head')
		@include('reports.accountingStatement.partials.amounts')
		@include('reports.accountingStatement.partials.builder')
		</div>www.estimanet.com
	</body>
</html>