@extends('layouts.app')

@section('content')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-folder-open"></i> Intervenciones</a></li>
        <li class="active">{{ $jefatura->nombre }}</li>
    </ol>
</section><br>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Consolidado - {{ $jefatura->nombre }}</h3>
                </div>
                <div class="box-body">
                    <form class="form" method="POST" action="{{ url('intervenciones/consolidado-general') }}" accept-charset="UTF-8">
                        {!! csrf_field() !!}
                        <div class="col-md-4">
                            <input type="hidden" value="{{ $jefatura->id }}" name="id_jefatura">
                            <fieldset class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="fuente">Fuente de financiamiento</label>
                                <select id="fuente" name="id_fuente" class="form-control">
                                    @foreach ($fuentes as $fuente)
                                    <option value="{{ $fuente->id }}">{{ $fuente->codigo_partida }} - {{ $fuente->nombre }}</option>
                                    @endforeach
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
@endsection
