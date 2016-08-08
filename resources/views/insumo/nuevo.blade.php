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
                    <h3 class="box-title">Creación de nuevo insumo</h3>
                </div>
                <div class="box-body">
                    <form class="form" method="POST" action="{{ url('mantenimiento/insumos') }}" accept-charset="UTF-8">
                        {!! csrf_field() !!}
                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label for="pais">Tipo de insumo</label>
                                <select class="form-control select2" style="width: 100%;" name="id_tipo_insumo" id="pais_origen">
                                    <option value="">Seleccione tipo</option>
                                    @foreach($tipoInsumo as $insumo)
                                    <option value="{{$insumo->id}}">{{ $insumo->nombre }}</option>
                                    @endforeach;
                                </select>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="pais">Jefatura</label>
                                <select class="form-control select2" style="width: 100%;" name="id_jefatura" id="id_jefatura">
                                    <option value="">Seleccione jefatura</option>
                                    @foreach($jefaturas as $insumo)
                                    <option value="{{$insumo->id}}">{{ $insumo->nombre }}</option>
                                    @endforeach;
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
@endsection
