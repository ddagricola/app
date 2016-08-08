@extends('layouts.app')

@section('content')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-folder-open"></i> Direcciones</a></li>
        <li class="active">Edición Dirección</li>
    </ol>
</section><br>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Edición de dirección</h3>
                </div>
                <div class="box-body">
                    <form method="POST" action="{{ route('mantenimiento.direcciones.update', $direccion->id) }}" accept-charset="UTF-8">
                        {!! csrf_field() !!}
                        <input name="_method" type="hidden" value="PUT">
                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label for="pais">Ministerio</label>
                                <select class="form-control select2" style="width: 100%;" name="id_ministerio" id="pais_origen">
                                    <option value="">Seleccione ministerio</option>
                                    @foreach($ministerios as $ministerio)
                                        @if ($ministerio->id == $direccion->id_ministerio)
                                            <option value="{{$ministerio->id}}" selected>{{ $ministerio->siglas  }} - {{ $ministerio->nombre }}</option>
                                        @else
                                            <option value="{{$ministerio->id}}">{{ $ministerio->siglas  }} - {{ $ministerio->nombre }}</option>
                                        @endif
                                    @endforeach;
                                </select>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="pais">Nombre</label>
                                <input type="text" value="{{ $direccion->nombre }}" class="form-control" id="pais" name="nombre" required>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="siglas">Siglas</label>
                                <input type="text" value="{{ $direccion->siglas }}" class="form-control" id="siglas" name="siglas" required>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="siglas">Código</label>
                                <input type="text" value="{{ $direccion->codigo_partida }}" class="form-control" id="siglas" name="codigo" required>
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
