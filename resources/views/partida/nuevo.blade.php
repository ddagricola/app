@extends('layouts.app')

@section('content')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-folder-open"></i> Partidas</a></li>
        <li class="active">Nuevo</li>
    </ol>
</section><br>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Creación de nueva partida</h3>
                </div>
                <div class="box-body">
                    <form class="form" method="POST" action="{{ url('mantenimiento/partidas') }}" accept-charset="UTF-8">
                        {!! csrf_field() !!}
                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label for="pais">Código</label>
                                <input type="text" class="form-control" id="codigo" name="codigo" required>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="id_tipo_división">Fuente de financiamiento</label>
                                <select class="form-control select2" style="width: 100%;" name="fuente" id="fuente">
                                    <option value="">Seleccione fuente</option>
                                    @foreach($fuentes as $fuente)
                                    <option value="{{$fuente->id}}">{{ $fuente->codigo_partida }} - {{ $fuente->nombre }}</option>
                                    @endforeach;
                                </select>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="id_tipo_división">Renglón</label>
                                <select class="form-control select2" style="width: 100%;" name="renglon" id="renglon">
                                    <option value="">Seleccione renglon</option>
                                    @foreach($renglones as $renglon)
                                    <option value="{{$renglon->id}}">{{ $renglon->codigo_partida }} - {{ $renglon->nombre }}</option>
                                    @endforeach;
                                </select>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="departamento">Departamento</label>
                                <select class="form-control select2" style="width: 100%;" name="departamento" id="departamento">
                                    <option value="">Seleccione departamento</option>
                                    @foreach($departamentos as $departamento)
                                    <option value="{{$departamento->id}}">{{ $departamento->codigo }} - {{ $departamento->nombre }}</option>
                                    @endforeach;
                                </select>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="id_tipo_división">Municipio</label>
                                <select class="form-control select2" style="width: 100%;" name="municipio" id="municipio">
                                </select>
                            </fieldset>
                            <fieldset class="form-group">
                                <button class="btn btn-primary">Guardar</button>
                            </fieldset>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{ asset ('/bower_components/AdminLTE/plugins/jQuery/jQuery-2.2.0.min.js') }}"></script>
<script type="text/javascript">
$("#departamento").on("change", function(){
    $.ajax({
        url: "<?php echo url('municipios/buscar/departamento') ?>"+"/"+$(this).val(),
        type : 'GET',
        error: function(){
            alert('Ha ocurrido un error en el servidor')
        },
        success: function(data){
            option = "<option>Seleccione municipio</option>";
            $.each(data, function(index, value){
                option += "<option value='"+value.id+"'>"+ value.codigo + " - "+ value.nombre + "</option>"
            })

            $("#municipio").html(option);
        }
    });
});
</script>

@endsection
