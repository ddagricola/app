@extends('layouts.app')

@section('content')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-folder-open"></i> Consolidado</a></li>
        <li class="active">{{-- $consolidado->nombre --}}</li>
    </ol>
</section><br>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Nueva Intervención</h3>
                </div>
                <div class="box-body">
                    <form class="form" method="POST" action="{{ url('intervenciones/guardar') }}" accept-charset="UTF-8">
                        {!! csrf_field() !!}
                        <div class="col-md-4">
                            <!--<fieldset class="form-group">
                                <label for="id_tipo_intervencion">Tipo Intervencion</label>
                                <select class="form-control" name="id_tipo_intervencion" id="id_tipo_intervencion">
                                    @foreach ($tipoIntervencion as $tipo)
                                        <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                    @endforeach
                                </select>
                            </fieldset>-->
                            <fieldset class="form-group">
                                <label for="departamento">Departamento</label>
                                <select class="form-control" name="departamento" id="departamento">
                                    @foreach ($departamentos as $tipo)
                                        <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                    @endforeach
                                </select>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="departamento">Fuente de financiamiento</label>
                                <select class="form-control" name="id_fuente" id="id_fuente">
                                    @foreach ($fuentes as $tipo)
                                        <option value="{{ $tipo->id }}">{{ $tipo->codigo_partida }} - {{ $tipo->nombre }}</option>
                                    @endforeach
                                </select>
                            </fieldset>
                            <!--<fieldset class="form-group">
                                <label for="departamento">Tipo de insumo</label>
                                <select class="form-control" name="id_tipo_insumo" id="id_tipo_insumo">
                                <option value="">Seleccione tipo de insumo</option>
                                    @foreach ($tipoInsumos as $tipo)
                                        <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                    @endforeach
                                </select>
                            </fieldset>-->
                            <fieldset class="form-group">
                                <label for="departamento">Insumo</label>
                                <select class="form-control" name="id_insumo" id="id_insumo">
                                    @foreach ($insumos as $tipo)
                                        <option value="{{ $tipo->id }}">{{ $tipo->insumo }}</option>
                                    @endforeach
                                </select>
                            </fieldset>
                            <!--<fieldset class="form-group">
                                <label for="departamento">Municipio</label>
                                <select class="form-control" name="municipio" id="municipio">
                                    
                                </select>
                            </fieldset>-->
                            <fieldset class="form-group">
                                <label for="nombre">Base Legal</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="departamento">Orden de Adquisición</label>
                                
                                <select class="form-control" name="orden" id="orden">
                                   <?php
                                    $array = array("1"=>"Primera Adquisición", "2"=>"Segunda Adquisición","3"=>"Tercera Adquisición","4"=>"Cuarta Adquisición",);
                                    foreach ($array as $i => $value) {
                                        echo "<option value='".$i."'>".$array[$i]."</option>";
                                    }
                                ?>
                                </select>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="departamento">Año de adquisión</label>
                                
                                <select class="form-control" name="anio" id="anio">
                                <?php for($i=2016; $i<2018; $i++ ):?>
                                    <option value="{{ $i }}">{{ $i }}</option>
                                <?php endfor;?>
                                </select>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="justificacion">Justificación</label>
                                <textarea class="form-group" cols="50" rows="8" id="justificacion" name="justificacion"></textarea>
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
$("#id_tipo_insumo").on("change", function(){
    $.ajax({
        url: "<?php echo url('insumos/buscar/tipo/') ?>"+"/"+$(this).val(),
        type : 'GET',
        error: function(){
            alert('Ha ocurrido un error en el servidor')
        },
        success: function(data){
            option = "<option>Seleccione municipio</option>";
            $.each(data, function(index, value){
                option += "<option value='"+value.id+"'>" + value.nombre + "</option>"
            })

            $("#id_insumo").html(option);
        }
    });
});
</script>
@endsection
