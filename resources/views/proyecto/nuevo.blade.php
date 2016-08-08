@extends('layouts.app')

@section('content')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-folder-open"></i> Proyectos</a></li>
        <li class="active">Nuevo proyecto</li>
    </ol>
</section><br>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Creación de nuevo proyecto</h3>
                </div>
                <div class="box-body">
                    <form class="form" method="POST" action="{{ url('mantenimiento/proyectos') }}" accept-charset="UTF-8">
                        {!! csrf_field() !!}
                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label for="pais">Actividad</label>
                                <select class="form-control select2" style="width: 100%;" name="id_actividad" id="pais_origen">
                                    <option value="">Seleccione Actividad</option>
                                    @foreach($actividades as $actividad)
                                    <option value="{{$actividad->id_actividad}}">
                                            {{ $actividad->nombre_actividad }} 
                                        </option>
                                    @endforeach;
                                </select>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="pais">Nombre</label>
                                <input type="text" class="form-control" id="pais" name="nombre" required>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="codigo">Código</label>
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
