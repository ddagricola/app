@extends('layouts.app')

@section('content')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-folder-open"></i> Fuentes de financiamiento</a></li>
        <li class="active">Edición</li>
    </ol>
</section><br>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Edición de fuente de financiamiento</h3>
                </div>
                <div class="box-body">
                    <form method="POST" action="{{ route('mantenimiento.fuentes-financiamiento.update', $fuente->id) }}" accept-charset="UTF-8">
                        {!! csrf_field() !!}
                        <input name="_method" type="hidden" value="PUT">
                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label for="pais">Nombre</label>
                                <input type="text" value="{{ $fuente->nombre }}" class="form-control" id="pais" name="nombre" required>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="codigo">Código</label>
                                <input type="text" value="{{ $fuente->codigo_partida }}" class="form-control" id="pais" name="codigo" required>
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
