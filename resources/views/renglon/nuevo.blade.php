@extends('layouts.app')

@section('content')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-folder-open"></i> Renglones</a></li>
        <li class="active">Nuevo renglon</li>
    </ol>
</section><br>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Creación de nuevo renglon</h3>
                </div>
                <div class="box-body">
                    <form class="form" method="POST" action="{{ url('mantenimiento/renglones') }}" accept-charset="UTF-8">
                        {!! csrf_field() !!}
                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label for="pais">Actividad-Proyecto</label>
                                <select class="form-control select2" style="width: 100%;" name="id_proyecto" id="id_proyecto">
                                    <option value="">Seleccione actividad-proyecto</option>
                                    @foreach($proyectos as $proyecto)
                                        <option value="{{$proyecto->id_proyecto}}">{{ $proyecto->actividad }} - {{$proyecto->proyecto}}</option>
                                    @endforeach;
                                </select>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="pais">Nombre</label>
                                <input type="text" class="form-control" id="pais" name="nombre" required>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="pais">Código</label>
                                <input type="text" class="form-control" id="pais" name="codigo" required>
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
