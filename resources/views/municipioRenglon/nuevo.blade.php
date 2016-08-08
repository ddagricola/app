@extends('layouts.app')

@section('content')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-folder-open"></i> Departamentos</a></li>
        <li class="active">Nuevo departamento</li>
    </ol>
</section><br>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Creación de nuevo departamento</h3>
                </div>
                <div class="box-body">
                    <form class="form" method="POST" action="{{ url('mantenimiento/municipio-renglon') }}" accept-charset="UTF-8">
                        {!! csrf_field() !!}
                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label for="pais">Departamento</label>
                                <select class="form-control select2" style="width: 100%;" name="id_departamento" id="id_departamento_partida">
                                    <option value="">Seleccione departamento</option>
                                    @foreach($departamentos as $departamento)
                                    <option value="{{$departamento->id}}">{{ $departamento->codigo }} - {{ $departamento->nombre }}</option>
                                    @endforeach;
                                </select>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="pais">Municipio</label>
                                <select class="form-control select2" style="width: 100%;" name="id_municipio" id="id_municipio">
                                    <option value="">Seleccione municipio</option>
                                </select>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="pais">Fuente Financiamiento</label>
                                <select class="form-control select2" style="width: 100%;" name="id_fuente" id="id_fuente">
                                    <option value="">Seleccione fuente</option>
                                    @foreach($fuentes as $fuente)
                                    <option value="{{$fuente->id}}">{{ $fuente->codigo_partida }} - {{ $fuente->nombre }}</option>
                                    @endforeach;
                                </select>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="pais">Renglon</label>
                                <select class="form-control select2" style="width: 100%;" name="id_renglon" id="id_renglon">
                                    <option value="">Seleccione Renglon</option>
                                    @foreach($renglones as $renglon)
                                    <option value="{{$renglon->id}}">{{ $renglon->codigo_partida }} - {{ $renglon->nombre }}</option>
                                    @endforeach;
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
<script src="{{ asset ('/bower_components/AdminLTE/plugins/select2/select2.full.min.js') }}"></script>
<script type="text/javascript">
$("#id_renglon").select2();
$("#id_departamento_partida").on('change',function(){
    $this = $(this);
        $.ajax({
        url: "<?php echo url('municipios/buscar/departamento/') ?>"+"/"+$this.val(),
        type : 'GET',
        error: function(){
            alert('Ha ocurrido un error en el servidor')
        },
        success: function(data){
            option = "";
            $.each(data, function(index, value){
                option += "<option value='"+value.id+"'>" +value.codigo +" - "+value.nombre + "</option>"
            })

            $("#id_municipio").html(option);
        }
    });
});
</script>
@endsection
