<div> <img src="{{ public_path() }}/img/logo.jpg" style="height: 100px;"> </div><br>
<style type="text/css">
	table tr td{
		font-size: 12px;
	}
	.firma{
		border-bottom: 1px solid black;
	}
</style>
<table style="width:100%">
	<tr">
		<td colspan="4">
			
		</td>	
	</tr>
	<tr>
		<td>
			<b>CUI:</b>
		</td>
		<td>{{ $data->cui }}</td>
	</tr>
	<tr>
		<td>
			<b>Primer Nombre:</b>
		</td>
		<td>{{ $data->primer_nombre }}</td>
		<td>
			<b>Segundo Nombre:</b>
		</td>
		<td>{{ $data->segundo_nombre }}</td>
		<td>
			<b>Tercer Nombre:</b>
		</td>
		<td>{{ $data->tercer_nombre }}</td>
	</tr>
	<tr>
		<td>
			<b>Primer Apellido:</b>
		</td>
		<td>{{ $data->primer_apellido }}</td>
		<td>
			<b>Segundo Apellido:</b>
		</td>
		<td>{{ $data->segundo_apellido }}</td>
		<td>
			<b>Apellido Casada:</b>
		</td>
		<td>{{ $data->apellido_casada }}</td>
	</tr>
	<tr>
		<td>
			<b>Municipio:</b>
		</td>
		<td>{{ \App\Municipio::find($data->id_municipio)->nombre }}</td>
		<td>
			<b>Departamento:</b>
		</td>
		<td>{{ \App\Departamento::find(\App\Municipio::find($data->id_municipio)->id_departamento)->nombre }}</td>
	</tr>
	<tr>
		<td><b>Insumo</b></td>
		<td>Frijol</td>
	</tr>
	<tr>
		<td><b>Cantidad</b></td>
		<td>15 Lbs</td>
	</tr>
</table>
<br><br>
<table style="width:50%">
	<tr>
		<td class="firma"></td>
		<td class="firma"></td>
	</tr>
	<tr>
		<td width="50%">Jefe Departamental</td>
		<td width="50%">Extensionista</td>
	</tr>
</table>


