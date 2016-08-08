@extends('layouts.app')

@section('content')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-folder-open"></i> Programa</a></li>
        <li class="active">Nuevo sub programa</li>
    </ol>
</section><br>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Creación de nuevo Sub Programa</h3>
                </div>
                <div class="box-body">
                    <form class="form" method="POST" action="{{ url('mantenimiento/programas/subprogramas/save') }}" accept-charset="UTF-8">
                        {!! csrf_field() !!}
                        <input class="form-control" type="hidden" value="{{ $programaPadre->id }}" name="id_programa">
                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label for="pais">Unidad</label>
                                <select class="form-control select2" style="width: 100%;" name="id_direccion" id="pais_origen" readOnly>
                                    <option value="">Seleccione unidad</option>
                                    @foreach($direcciones as $direccion)
                                        @if($direccion->id == $programaPadre->id_direccion)
                                            <option value="{{$direccion->id}}" selected>{{ $direccion->codigo_partida }} - {{ $direccion->nombre }}</option>
                                        @else
                                            <option value="{{$direccion->id}}">{{ $direccion->codigo_partida }} - {{ $direccion->nombre }}</option>
                                        @endif
                                    @endforeach;
                                </select>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="padre">Programa</label>
                                <input class="form-control" type="text" value="{{ $programaPadre->nombre }}" id="padre" disabled>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="pais">Nombre</label>
                                <input type="text" class="form-control" id="pais" name="nombre" required>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="codigo">Código Presupuestario</label>
                                <input type="text" class="form-control" id="pais" name="codigo" required>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="codigo">Descripción</label>
                                <textarea class="form-control" rows="3" name="descripcion"></textarea>
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
