<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table>
    <thead>
        <tr>
            <th>CUI</th>
            <th>PRIMER NOMBRE</th>
            <th>SEGUNDO NOMBRE</th>
            <th>TERCER NOMBRE</th>
            <!--<th>PARTIDA</th>-->
            <th>PRIMER APELLIDO</th>
            <th>SEGUNDO APELLIDO</th>
            <th>TERCER APELLIDO</th>
            <th>NO. CONTRATO</th>
            <th>JEFATURA</th>
            <th>PUESTO</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $item)
            <tr>
                <td>{{ $item->cui }}</td>
                <td>{{ $item->primer_nombre }}</td>
                <td>{{ $item->segundo_nombre }}</td>
                <td>{{ $item->tercer_nombre }}</td>
                <td>{{ $item->primer_apellido }}</td>
                <td>{{ $item->segundo_apellido }}</td>
                <td>
                    @if($item->apellido_casada == '' || $item->apellido_casada == null)
                    @else
                        DE {{ $item->apellido_casada }}
                    @endif
                </td>
                <td>{{ $item->contrato }}</td>
                <td>{{ $item->jefatura }}</td>
                <td>{{ $item->puesto }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
