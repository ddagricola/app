@extends('layouts.app')

@section('content')
<table class="table table-striped">
    <!--<thead>
        <tr>
            <th>Nombre</th>
            
            <th></th>
        </tr>
    </thead>-->
    <tbody>
        @foreach($paises as $pais)
        <tr>
            <td><input value="{{$pais->nombre}}" id="pais_{{$pais->id}}" class="input-edit"></td>
            <!--<td>
                @if($pais->estado == 1)
                    Habilitado
                @else
                    Deshabilitado
                @endif
            </td>-->
            <td width="30%">
                <a href="javascript:edit({{$pais->id}})" class="btn btn-primary btn-sm">
                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                </a>
                <a href="#" class="btn btn-danger btn-sm">
                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
    <!--<tfoot>
        <tr>
            <th>Nombre</th>
            <th>Estado</th>
            <th></th>
        </tr>
    </tfoot>-->
</table>
@endsection