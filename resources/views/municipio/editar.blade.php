@extends('layouts.app')

@section('content')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-folder-open"></i> Municipios</a></li>
        <li class="active">Nuevo municipio</li>
    </ol>
</section><br>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Creación de nuevo municipio</h3>
                </div>
                <div class="box-body">
                    <form method="POST" action="{{ route('mantenimiento.municipios.update', $municipio->id) }}" accept-charset="UTF-8">
                    {!! csrf_field() !!}
                    <input name="_method" type="hidden" value="PUT">
                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label for="pais">Pais</label>
                                <select class="form-control select2" style="width: 100%;" name="id_pais" id="id_pais">
                                    <option value="">Seleccione país</option>
                                    @foreach($paises as $pais)
                                        @if ($pais->id == $departamento->id_pais)
                                            <option value="{{$pais->id}}" selected>{{ $pais->nombre }}</option>
                                        @else
                                            <option value="{{$pais->id}}">{{ $pais->nombre }}</option>
                                        @endif
                                    @endforeach;
                                </select>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="departamento">Departamento</label>
                                <select class="form-control select2" style="width: 100%;" name="id_departamento" id="id_departamento">
                                    <option value="">Seleccione departamento</option>
                                    @foreach ($departamentos as $departamento)
                                        @if ($departamento->id == $municipio->id_departamento)
                                            <option value="{{$departamento->id}}" selected>{{ $departamento->nombre }}</option>
                                        @else
                                            <option value="{{$departamento->id}}">{{ $departamento->nombre }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="id_tipo_división">Tipo División</label>
                                <select class="form-control select2" style="width: 100%;" name="id_tipo_division" id="id_tipo_division">
                                    <option value="">Seleccione tipo de división</option>
                                    @foreach($divisiones as $division)
                                        @if ($division->id == $municipio->id_tipo_division)
                                            <option value="{{$division->id}}" selected>{{ $division->nombre }}</option>
                                        @else
                                            <option value="{{$division->id}}">{{ $division->nombre }}</option>
                                        @endif
                                    @endforeach;
                                </select>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="pais">Nombre</label>
                                <input value="{{ $municipio->nombre }}" type="text" class="form-control" id="pais" name="nombre" required>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="pais">Código</label>
                                <input value="{{ $municipio->codigo }}" type="text" class="form-control" id="codigo" name="codigo" required>
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
$departamento = $("#id_departamento");
$pais.select2({
    placeholder: "Seleccione país",
    allowClear: true
});
$departamento.select2();

$pais.on("change", function(){
    $.ajax({
        url: "<?php echo url('departamentos/findPerPais') ?>"+"/"+$(this).val(),
        type : 'GET',
        error: function(){
            alert('Ha ocurrido un error en el servidor')
        },
        success: function(data){
            option = "";
            $.each(data, function(index, value){
                option += "<option value='"+value.id+"'>" + value.nombre + "</option>"
            })

            $departamento.html(option);
        }
    });
});
</script>
@endsection
