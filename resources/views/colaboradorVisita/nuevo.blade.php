@extends('layouts.app')

@section('content')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-folder-open"></i> Recepción</a></li>
        <li class="active">Nueva Visita</li>
    </ol>
</section><br>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">
                        VISITA {{$jefatura->nombre}}
                    </h3>
                </div>
                <div class="box-body">
                    <form class="form" method="POST" action="{{ url('recepcion/jefatura/guardar') }}" accept-charset="UTF-8">
                        {!! csrf_field() !!}
                        <input type="hidden" name="id_jefatura" value="{{$jefatura->id}}">
                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label class="radio-inline">
                                  <input type="radio" name="tipo_visita" value="2">Visíta
                                </label>
                                <label class="radio-inline">
                                  <input type="radio" name="tipo_visita" value="1">Llamada Telefónica
                                </label>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="pais">Fecha y Hora </label>
                                <input type="text" class="form-control" id="fecha" name="fecha" readOnly>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="pais">Persona a Quien Visita </label>
                                <select id="id_colaborador" name="id_colaborador" class="form-control">
                                    @foreach($colaboradores as $colaborador) 
                                        <option value="{{ $colaborador->id }}">
                                            {{ $colaborador->primer_nombre }}
                                            {{ $colaborador->segundo_nombre }}
                                            {{ $colaborador->tercer_nombre }}
                                            {{ $colaborador->primer_apellido }}
                                            {{ $colaborador->segundo_apellido }}
                                            @if($colaborador->apellido_casada != "")
                                                DE {{$colaborador->apellido_casada}}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="pais">Nombre Visitante </label>
                                <input type="text" class="form-control" id="pais" name="nombre_visitante" required>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="pais">Lugar Visitante </label>
                                <input type="text" class="form-control" id="pais" name="lugar_visitante" required>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="pais">Motivo Visita </label>
                                <textarea class="form-control" id="pais" name="motivo_visita" required></textarea> 
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
var myVar = setInterval(timer, 1000);
function timer(){
     var d = new Date();
     var minutes = "";

        if(d.getMinutes() < 9 ){
            minutes = "0"+d.getMinutes();
        }else{
            minutes = d.getMinutes();
        }
        var fecha = d.getDate() + '/'+(d.getMonth()+1)+'/'+d.getFullYear()+' '+d.getHours()+':'+minutes+':'+d.getSeconds();


        $fecha = $("#fecha");
        $fecha.val(fecha);
}

    /*$(function(){
       
    });*/
</script>
@endsection
