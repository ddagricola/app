@extends('layouts.app')
@section('content')
    <tr id="row_{{$item}}">
        <td style="padding:5px">
            <label for="municipio_{{$item}}">Municipio</label><br>
            <select name="municipio" id="municipio_{{$item}}" class="form-control select2 jsmunicipio" item="{{$item}}">
                <option value="">Seleccione municipio ...</option>
                  @foreach ($municipio as $fuente)
                    <option value="{{ $fuente->id }}"> {{ $fuente->codigo }} - {{ $fuente->nombre }} </option>
                  @endforeach
            </select>
        </td>
        <!--<td style="padding:5px">
            <label for="fuente">Fuente</label><br>
            <select name="fuente" id="fuente_{{$item}}" class="form-control select2 jsfuente" item="{{$item}}">
                <option value="">Seleccione fuente ...</option>
                  @foreach ($fuentes as $fuente)
                    <option value="{{ $fuente->id }}"> {{ $fuente->codigo_partida }} - {{ $fuente->nombre }} </option>
                  @endforeach
            </select>
        </td>-->
        <!--<td style="padding:5px">
            <label for="renglon">Renglon</label><br>
            <select name="renglon" id="renglon_{{$item}}" class="form-control select2 jsrenglon" rows="2" item="{{$item}}">
                <option value="" class="init-option">Seleccione renglon ...</option>
                  @foreach ($renglones as $fuente)
                    <option value="{{ $fuente->id }}"> {{ $fuente->codigo_partida }} - {{ $fuente->nombre }} </option>
                  @endforeach
            </select>
        </td>-->
        <!--<td style="padding:5px">
            <label for="partida">Partida Presupuestaria</label><br>
            <select name="partida" id="partida_{{$item}}" class="form-control select2 jspartida ">
            </select>
        </td>-->
        <td style="padding:5px">
            <label for="cantidad">Cantidad de insumo</label>
            <input type="text" name="cantidad" class="form-control jscantidad" id="cantidad_{{$item}}">
        </td>
        <td style="padding:5px">
            <label for="renglon">Medida</label><br>
            <select name="renglon" id="medida_{{$item}}" class="form-control select2 jsmedida" rows="2" item="{{$item}}">
                <option value="" class="init-option">Seleccione medida ...</option>
                  @foreach ($unidades as $fuente)
                    <option value="{{ $fuente->id }}">{{ $fuente->nombre }} </option>
                  @endforeach
            </select>
        </td>
        <td style="padding:5px">
            <label for="precio">Monto Unitario(Q)</label>
            <input type="text" name="precio" class="form-control jsprecio" id="precio_{{$item}}">
        </td>
        <td style="padding:5px">
            <label for="beneficiarios">Beneficiarios</label>
            <input type="text" name="beneficiarios" class="form-control jsbeneficiario" id="beneficiario_{{$item}}">
        </td>
        <td style="padding:5px">
            <label for="beneficiarios">Cantidad/Beneficiario</label>
            <input type="text" name="beneficiarios" class="form-control jscantidadBeneficiario" id="cantidad_beneficiario_{{$item}}">
        </td>
        <td style="padding:5px;  display:none">
            <label for="beneficiarios">ID</label>
            <input type="text" name="beneficiarios" class="form-control jsid" id="id_{{$item}}" value="0">
        </td>
        <td style="padding:5px;display:none">">
            <label for="beneficiarios">STATE</label>
            <input type="text" name="beneficiarios" class="form-control jsstate" id="states_{{$item}}" value="new">
        </td>
        <td style="padding:5px">
            <label for="renglon">Medida Entrega</label><br>
            <select name="renglon" id="medida_entrega_{{$item}}" class="form-control select2 jsmedidaEntrega" rows="2" item="{{$item}}">
                <option value="" class="init-option">Seleccione medida ...</option>
                  @foreach ($unidades as $fuente)
                    <option value="{{ $fuente->id }}">{{ $fuente->nombre }} </option>
                  @endforeach
            </select>
        </td>
        <td style="padding:5px">
            <button type="button" onclick="borrar({{$item}})" class="btn btn-danger btn-sm deletes" item="{{$item}}" style=" margin-top:20px">
                <span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
            </button>
        </td>
    </tr>
@endsection
