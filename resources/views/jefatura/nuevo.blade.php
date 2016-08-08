@extends('layouts.app')

@section('content')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-folder-open"></i> Jefatura</a></li>
        <li class="active">Nuevo Jefatura</li>
    </ol>
</section><br>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Creación de nueva jefatura</h3>
                </div>
                <div class="box-body">
                    <form class="form" method="POST" action="{{ url('mantenimiento/jefaturas') }}" accept-charset="UTF-8">
                        {!! csrf_field() !!}
                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label for="pais">Ministerio</label>
                                <select class="form-control select2" style="width: 100%;" name="id_pais" id="id_pais">
                                    <option value="">Seleccione ministerio</option>
                                    @foreach($ministerios as $ministerio)
                                    <option value="{{$ministerio->id}}">{{ $ministerio->nombre }}</option>
                                    @endforeach;
                                </select>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="departamento">Dirección</label>
                                <select class="form-control select2" style="width: 100%;" name="id_direccion" id="id_direccion">
                                    <option value="">Seleccione dirección</option>
                                </select>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="pais">Nombre</label>
                                <input type="text" class="form-control" id="pais" name="nombre" required>
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
$pais = $("#id_pais");
$departamento = $("#id_direccion");
$pais.select2({
    placeholder: "Seleccione Ministerio",
    allowClear: true
});
$departamento.select2();

$pais.on("change", function(){
    $.ajax({
        url: "<?php echo url('direcciones/findPerMinisterio') ?>"+"/"+$(this).val(),
        type : 'GET',
        error: function(){
            alert('Ha ocurrido un error en el servidor')
        },
        success: function(data){
            option = "";
            option += "<option value=''>Seleccione dirección</option>"
            $.each(data, function(index, value){
                option += "<option value='"+value.id+"'>" + value.nombre + "</option>"
            })

            $departamento.html(option);
        }
    });
});
</script>
@endsection
