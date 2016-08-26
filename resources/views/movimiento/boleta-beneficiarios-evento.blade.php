<style type="text/css">
	html{
		margin: 0px;
		/*margin-top: 1%;*/
	}
	.border-top{
		border-top: 1px solid black;
	}
	.border-bottom{
		border-bottom: 1px solid black;
	}
	.page{
		width: 100%;
	}
	.item-page{
		margin-top: 1%;
		/*border: 1px solid black;*/
		width: 100%;
		height: 343px;
		font-size: 11px;
	}
	.dashed-box{
		border-bottom: 1px solid black;
		height: 10px;
		border-bottom-style: dashed;
	}
	.body-table{
		width: 100%;
	}
	.header-text{
		text-decoration: underline;
	}
	.item-text{
		font-weight: bold;
	}
	.footer-table{
		text-align: center;
		margin-top: 60px;
		font-size: 11px;
		width: 100%;
	}
	.header-table{
		width: 100%;
	}
	.img-barcode{
		width: 50%;
		/*border:1px solid blue;*/
		text-align: center;
		padding:0px;
	}
	.img-barcode label{
		width: 100%;
	}
	.img-barcode img{
		width: auto;
		border:1px solid red;
	}
</style>
@foreach ($pages as $page)
	<div class="page">
		@foreach ($page as $item)
			<div class="item-page">
			<table class="header-table">
				<tr>
					<td width="70%">
						<img src="{{public_path().'/img/logo-boletas.png'}}" style="width:500px;">
					</td>
					<td rowspan="2" class="img-barcode">
						<!--<label>4542340000344</label>
							<img src="data:image/png;base64,{{$item->barcode}}" alt="barcode"   />
						<label>4542340000344</label>-->
					</td>
				</tr>
			</table>
				<table class="body-table">
					<tr>
						<td colspan="2" class="header-text">
							Datos del beneficiario
						</td>
					</tr>
					<tr>
						<td width="18%" class="item-text">
							Nombre:
						</td>
						<td>
							{{ $item->primer_nombre }}
							{{ $item->segundo_nombre }}
							{{ $item->tercer_nombre }}
							{{ $item->primer_apellido }}
							{{ $item->segundo_apellido }}
							@if ($item->apellido_casada != "" || $item->apellido_casada != null)
								DE {{ $item->apellido_casada }}
							@endif
						</td>
					</tr>
					<tr>
						<td class="item-text">No. de DPI:</td>
						<td>
							{{$item->cui}}
						</td>
					</tr>
					<tr>
						<td class="item-text"> Fecha de Nacimiento:</td>
						<td>{{ $item->fecha_nacimiento_beneficiario }}, {{ $item->edad }}</td>
					</tr>
				</table><br>
				<table class="body-table">
					<tr>
						<td colspan="2" class="header-text">Datos de Entrega</td>
					</tr>
					<tr>
						<td width="18%" class="item-text">Lugar del evento:</td>
						<td>
							{{ $item->departamento_entrega }}, {{ $item->municipio }}, 
							{{ $item->comunidad }}
						</td>
					</tr>
					<tr>
						<td class="item-text">Fecha de Entrega:</td>
						<td>
							24-02-1994
						</td>
					</tr>
					<tr>
						<td class="item-text">Insumo Entregado:</td>
						<td>
							{{ $item->tipo_insumo }} {{ $item->insumo }}
						</td>
					</tr>
					<tr>
						<td class="item-text">Cantidad Entregada:</td>
						<td>
							{{ $item->cantidad_beneficiario }} LIBRAS
						</td>
					</tr>
				</table>
				<table class="footer-table">
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td class="border-top">Firma Beneficiario</td>
						<td></td>
						<td></td>
						<td class="border-top">Firma Extensionista</td>
						<td></td>
						<td class="border-top">
							Firma Jefe Departamental
						</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td>
							{{$movimiento->nombre_extensionista}}</td>
						<td></td>
						<td>
							{{$movimiento->nombre_jefe}}
						</td>
					</tr>
				</table>
			</div>
			<div class="dashed-box"></div>
		@endforeach
	</div>
@endforeach