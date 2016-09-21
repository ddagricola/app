@extends('layouts.app')

@section('content')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-folder-open"></i> Intervenciones</a></li>
        <li class="active">Detalle</li>
    </ol>
</section><br>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Detalle de intervención</h3>
                </div>
                <div class="box-body">
                <div id="loader"></div>
                <table class="table table-striped">
                        <tr>
                            <td><b>Base Legal:</b> </td><td>{{ $intervencion->nombre }}</td>
                        </tr>
                        <tr>
                            <td><b>Justificación:</b> </td><td>{{ $intervencion->justificacion }}</td>
                        </tr>
                        <tr>
                            <td><b>Total de Beneficiarios:</b> </td><td> {{ $totalBeneficiarios[0]->total_beneficiarios }} </td>
                        </tr>
                        <tr>
                            <td><b>Inversión Total:</b> </td><td> Q {{ number_format($total[0]->total_intervencion, 2) }}</td>
                        </tr>
                </table>
                <br>
                <input type="hidden" value="{{$intervencion->id}}" id="id_intervencion">
                <input type="hidden" value="{{$intervencion->id_departamento}}" id="departamento">
                    <table>
                        <tbody id="content-detalle">
                            <?php $item = 1  ?>
                            @foreach ($detalles as $detalle)
                                <tr id="row_{{$item}}">
                                    <td style="padding:5px">
                                        <label for="municipio_{{$item}}">Municipio</label><br>
                                        <select name="municipio" id="municipio_{{$item}}" class="form-control select2 jsmunicipio" item="{{$item}}">
                                            <option value="">Seleccione municipio ...</option>
                                              @foreach ($municipio as $mun)
                                                @if ($mun->id == $detalle->id_municipio)
                                                    <option value="{{ $mun->id }}" selected=""> {{ $mun->codigo }} - {{ $mun->nombre }} </option>
                                                @else
                                                    <option value="{{ $mun->id }}"> {{ $mun->codigo }} - {{ $mun->nombre }} </option>
                                                @endif
                                              @endforeach
                                        </select>
                                    </td>
                                    <td style="padding:5px">
                                        <label for="cantidad">Cantidad</label>
                                        <input type="text" name="cantidad" class="form-control jscantidad" id="cantidad_{{$item}}" value="{{$detalle->cantidad}}">
                                    </td>
                                    <td style="padding:5px">
                                        <label for="renglon">Medida</label><br>
                                        <select name="renglon" id="medida_{{$item}}" class="form-control select2 jsmedida" rows="2" item="{{$item}}">
                                            <option value="" class="init-option">Seleccione medida ...</option>
                                              @foreach ($unidades as $mun)
                                                @if ($mun->id == $detalle->id_unidad_medida)
                                                    <option value="{{ $mun->id }}" selected="">{{ $mun->nombre }} </option>
                                                @else
                                                    <option value="{{ $mun->id }}">{{ $mun->nombre }} </option>
                                                @endif
                                              @endforeach
                                        </select>
                                    </td>
                                    <td style="padding:5px">
                                        <label for="precio">Monto Unitario(Q)</label>
                                        <input type="text" name="precio" class="form-control jsprecio" id="precio_{{$item}}" value="{{$detalle->precio}}">
                                    </td>
                                    <td style="padding:5px">
                                        <label for="beneficiarios">Beneficiarios</label>
                                        <input type="text" name="beneficiarios" class="form-control jsbeneficiario" id="beneficiario_{{$item}}" value="{{$detalle->nbeneficiario}}">
                                    </td>
                                    <td style="padding:5px">
                                        <label for="beneficiarios">Cantidad/Beneficiario</label>
                                        <input type="text" name="beneficiarios" class="form-control jscantidadBeneficiario" id="cantidad_beneficiario_{{$item}}" value="{{$detalle->cantidad_beneficiario}}">
                                    </td>
                                    <td style="padding:5px">
                                        <label for="renglon">Medida Entrega</label><br>
                                        <select name="renglon" id="medida_entrega_{{$item}}" class="form-control select2 jsmedidaEntrega" rows="2" item="{{$item}}">
                                            <option value="" class="init-option">Seleccione medida ...</option>
                                                @foreach ($unidades as $mun)
                                                @if ($mun->id == $detalle->id_unidad_entrega)
                                                    <option value="{{ $mun->id }}" selected="">{{ $mun->nombre }} </option>
                                                @else
                                                    <option value="{{ $mun->id }}">{{ $mun->nombre }} </option>
                                                @endif
                                              @endforeach
                                        </select>
                                    </td>
                                    <td style="padding:5px; display:none">
                                        <label for="beneficiarios">ID</label>
                                        <input type="text" name="beneficiarios" class="form-control jsid" id="id_{{$item}}" value="{{$detalle->id_detalle}}">
                                    </td>
                                    <td style="padding:5px;display:none">
                                        <label for="beneficiarios">STATE</label>
                                        @if ($detalle->estado == 1)
                                            <input type="text" name="beneficiarios" class="form-control jsstate" id="state_{{$item}}" value="edit">
                                        @endif
                                    </td>
                                    <td style="padding:5px">
                                        <button type="button" onclick="borrar({{ $item }})" class="btn btn-danger btn-sm delete" item="{{$item}}" style=" margin-top:20px">
                                            <span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
                                        </button>
                                    </td>
                                </tr>
                                <?php $item++ ?>
                            @endforeach
                        </tbody>
                    </table>
                    <fieldset class="form-group">
                        <button class="btn btn-primary" id="add">
                            <span class='glyphicon glyphicon-plus' aria-hidden='true'></span>
                        </button>
                        <button class="btn btn-primary" id="save">
                            <span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span>
                        </button>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="{{ asset ('/bower_components/AdminLTE/plugins/jQuery/jQuery-2.2.0.min.js') }}"></script>
<script type="text/javascript">
    var item = <?php echo  (count($detalles) > 0)  ?  (count($detalles)+1) :  1  ; ?>;
</script>
<script src="{{ asset ('/js/globals.js') }}"></script>
<script src="{{ asset ('/js/intervenciones.js') }}"></script>
@endsection
