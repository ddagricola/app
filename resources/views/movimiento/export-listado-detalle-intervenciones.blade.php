<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table>
    <thead>
        <tr>
            <th>No. INTERVENCIÓN</th>
            <th>AÑO</th>
            <th>DEPARTAMENTO</th>
            <th>MUNICIPIO</th>
            <!--<th>PARTIDA</th>-->
            <th>BASE LEGAL</th>
            <th>TIPO DE INSUMO</th>
            <th>INSUMO</th>
            <th>CANTIDAD ADQUISICIÓN</th>
            <th>UNIDAD DE COMPRA</th>
            <th>MONTO UNITARIO</th>
            <th>MONTO TOTAL</th>
            <th>BENEFICIARIOS CONVOCADOS</th>
            <th>CANTIDAD POR BENEFICIARIO</th>
            <th>UNIDAD DE ENTREGA</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $item)
            <tr>
                <td>{{ $item->intervencion }}</td>
                <td>{{ $item->anio_intervencion }}</td>
                <td>{{ $item->departamento }}</td>
                <td>{{ $item->municipio }}</td>
                <!--<td>{{ $item->codigo }}</td>-->
                <td>{{ $item->base_legal }}</td>
                <td>{{ $item->tipo_insumo }}</td>
                <td>{{ $item->insumo }}</td>
                <td>{{ $item->cantidad }}</td>
                <td>{{ $item->unidad_compra }}</td>
                <td>{{ number_format($item->precio, 2) }}</td>
                <td>{{ number_format(($item->precio * $item->cantidad), 2) }}</td>
                <td>{{ $item->beneficiarios_convocados }}</td>
                <td>{{ $item->cantidad_beneficiario }}</td>
                <td>{{ $item->unidad_entrega }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
