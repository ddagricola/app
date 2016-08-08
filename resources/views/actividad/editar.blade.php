@extends('layouts.app')

@section('content')

<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-folder-open"></i> Actividades</a></li>
        <li class="active">Nueva Actividad</li>
    </ol>
</section><br>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Creación de nueva actividad</h3>
                </div>
                <div class="box-body">
                    <form method="POST" action="{{ route('mantenimiento.actividades.update', $actividad->id) }}" accept-charset="UTF-8">
                        {!! csrf_field() !!}
                        <input name="_method" type="hidden" value="PUT">
                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label for="pais">Programa</label>
                                <select class="form-control select2" style="width: 100%;" name="id_programa" id="programa_actividad">
                                    <option value="">Seleccione programa</option>
                                    @foreach($programas as $programa)
                                        @if ($programa->id_subprograma == $actividad->id_programa)
                                            <option value="{{$programa->id_subprograma}}" selected>{{ $programa->programa }}, {{ $programa->subprograma }}</option>
                                        @else
                                            <option value="{{$programa->id_subprograma}}">{{ $programa->programa }}, {{ $programa->subprograma }}</option>
                                        @endif
                                    @endforeach;
                                </select>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="pais">Nombre</label>
                                <input type="text" value="{{ $actividad->nombre }}" class="form-control" id="pais" name="nombre" required>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="pais">Código</label>
                                <input type="text" value="{{ $actividad->codigo_partida }}" class="form-control" id="pais" name="codigo" required>
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
