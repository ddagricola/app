@extends('layouts.app')

@section('content')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-folder-open"></i> Ministerio</a></li>
        <li class="active">Nuevo Ministerio</li>
    </ol>
</section><br>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Edición de nuevo ministerio</h3>
                </div>
                <div class="box-body">
                    <!--<form class="form" method="POST" action="{{ url('mantenimiento/ministerios/update', $ministerio->id) }}" accept-charset="UTF-8">-->
                    <form method="POST" action="{{ route('mantenimiento.ministerios.update', $ministerio->id) }}" accept-charset="UTF-8">
                        {!! csrf_field() !!}
                        <input name="_method" type="hidden" value="PUT">
                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label for="pais">Nombre</label>
                                <input type="text" class="form-control" value="{{ $ministerio->nombre }}" id="pais" name="nombre" required>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="pais">Siglas</label>
                                <input type="text" class="form-control" value="{{ $ministerio->siglas }}" id="pais" name="siglas" required>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="pais">Código</label>
                                <input type="text" class="form-control" value="{{ $ministerio->codigo_partida }}" id="codigo" name="codigo" required>
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
