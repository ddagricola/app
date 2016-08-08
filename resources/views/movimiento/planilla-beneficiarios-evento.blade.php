<style type="text/css">
	.center{
		text-align: center;
	}
	.border-top{
		border-top: 1px solid black;
	}
	html{
		margin-top: 0%;
		margin-bottom: 1%;
		border: 1px solid red;
	}	
	.first-row td{
		border-bottom:1px solid black;
	}
	.box-right{
		text-align: justify;
		font-size: 13px;
		font-weight: 400;
		border: 1.2px solid black
	}
	
	.header-label{
		font-size: 24px;
	}
	.header-table{
		width:100%;
		border-collapse: collapse;
		
	}
	.header-table tr td{
		padding: 3px;
		font-size: 11px;
	}
	.data-table{
		width:100%;
		border-collapse: collapse;
	}
	.data-table tr td {
		border:1px solid black;
		padding:5px;
		font-size: 12px;
	}
	.data-table tr th {
		border:1px solid black;
		padding:5px;
		font-size: 12px;
	}
	.data-table tr td{
		height: 35px;
	}
	.center{
		text-align: center;
	}
	.ajust-text{
		text-align: center;
		letter-spacing: 3px
	}
	.table-from-picture tr td {
		
		font-size: 12px;
	}
	.table-from-picture tr td label{
		font-size: 18px;
	}
	.table-from-picture tr td p{
		
	}
	.border-bottom{
		border-bottom: 1px solid black;
	}
	.box-legend{
		position: absolute;
		overflow: auto;
		border:2px solid black;
		background-color: yellow;
	}
	.box-image-header{
		width: 50%;
	}
	.footer-table {
		width: 100%;
		font: 10px;
	}
	.footer-table tr{
	}
	.footer-table tr td{
	}
</style>

@foreach ($pages as $page)
	<div class="page">
		<table width="100%" class="table-from-picture">
			<tr>
				<td colspan="3">
					<img src="{{public_path().'/img/logo-cuencas.png'}}" style="width:500px;">
				</td>
				<td rowspan="2" class="box-legend" width="35%" height="10px">
					<p style="text-align:justify">
						<label style="width:100%;font-weight:bold;font-size:12px">CONVENIO DE COOPERACION TECNICA No. 33-2014</label>
						<b>Proyecto:</b>Fortalecimiento de la Capacidad de Producción de semillas mejoradas del Instituto de Ciencia y Tecnología Agrícolas -ICTA- para atender a los danmificados de la canicula prolongada del año <?php date("Y")?>
					</p>
				</td>
			</tr>
			<tr>
				<td width="1%">INSUMO ENTREGADO:</td>
				<td class="border-bottom" colspan="2" height="10px">
					<label>SEMILLA CERTIFICADA DE MAÍZ ICTA HB-83</label>
				</td>
			</tr>
		</table>
		<!-- sub-header -->
		<table width="100%" class="header-table">
		  <tr class="first-row">
		    <td width="13%"><b>(1) DEPARTAMENTO:</b></td>
		    <td width="18%">SAN JUAN SACATEPEQUEZ</td>
		    <td width="10%"><b>(2) MUNICIPIO:</b></td>
		    <td width="20%">SANTA LUCIA LA REFORMA</td>
		    <td width="11%"><b>(3) COMUNIDAD:</b></td>
		    <td >SANTO TOMAS DE CASTILLA</td>
		    <td width="7%"><b>(4) FECHA:</b></td>
		    <td >20-05-2014</td>
		  </tr>
		</table>
		<br>
		<table class="data-table">
		<thead>
			<tr>
				<th>No.</th>
				<th>(5) NOMBRE COMPLETO DEL BENEFICIARIO (conforme al DPI)</th>
				<th>(6) CÓDIGO ÚNICO DE IDENTIFICACIÓN (CUI)</th>
				<th>(7) PUEBLO</th>
				<th>(8) ETNIA</th>
				<th>(9) EDAD</th>
				<th>(10) SEXO</th>
				<th>(11) CANTIDAD (libras)</th>
				<th>(12) FIRMA O HUELLA DIGITAL</th>
			</tr>	
		</thead>
			<tbody>
			<?php $i = 1; ?>
			@foreach ($page as $item)
				<tr>
				<td class="center" width="3%">{{ $i }}</td>
				<td width="25%">
					{{ $item->primer_nombre }}
					{{ $item->segundo_nombre }}
					{{ $item->tercer_nombre }}
					{{ $item->primer_apellido }}
					{{ $item->segundo_apellido }}
					@if ($item->apellido_casada != "" || $item->apellido_casada != null)
						DE {{ $item->apellido_casada }}
					@endif
				</td>
				<td class="ajust-text" width="18%">{{ $item->cui }}</td>
				<td class="center" width="5%">{{ $item->sigla_pueblo }}</td>
				<td class="center" width="5%">{{ $item->codigo_etnia }}</td>
				<td class="center" width="5%">{{ $item->edad }}</td>
				<td class="center" width="5%">
					@if($item->genero == 1)
						M
					@else
						F
					@endif
				</td>
				<td class="center" width="5%">{{ $item->cantidad_beneficiario }}</td>
				<td class="center" width="12%"></td>
			</tr>
			<?php $i++?>
			@endforeach
			</tbody>
		</table>
		<table width="100%" class="footer-table">
			<tr>
				<td>
					(13) OBSERVACIONES
				</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>
				</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td class="border-top"></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td class="border-bottom"></td>
				<td></td>
				<td class="border-top center">
					(14) Firma del extensionista
				</td>
				<td></td>
				<td class="border-top center">
					(15) Firma y sello
				</td>
			</tr>
			<tr>
				<td class="border-bottom"></td>
				<td></td>
				<td class="center">
					Nombre: {{$movimiento->nombre_extensionista}}
				</td>
				<td></td>
				<td class="center">
					Vo.Bo. Jefe de Sede Departamental
				</td>
			</tr>
			<tr>
				<td class="border-bottom"></td>
				<td></td>
				<td class="center">
					DPI: {{$movimiento->cui_extensionista}}, Celular: {{$movimiento->telefono_extensionista}}
				</td>
				<td></td>
				<td></td>
			</tr>
		</table>
	</div>
@endforeach