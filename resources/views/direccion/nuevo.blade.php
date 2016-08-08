@extends('layouts.app')

@section('content')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-folder-open"></i> Direcciones</a></li>
        <li class="active">Nueva Dirección</li>
    </ol>
</section><br>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Creación de nueva dirección</h3>
                </div>
                <div class="box-body">
                    <form class="form" method="POST" action="{{ url('mantenimiento/direcciones') }}" accept-charset="UTF-8">
                        {!! csrf_field() !!}
                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label for="pais">Ministerio</label>
                                <select class="form-control select2" style="width: 100%;" name="id_ministerio" id="pais_origen">
                                    <option value="">Seleccione ministerio</option>
                                    @foreach($ministerios as $ministerio)
                                    <option value="{{$ministerio->id}}">{{ $ministerio->siglas  }} - {{ $ministerio->nombre }}</option>
                                    @endforeach;
                                </select>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="pais">Nombre</label>
                                <input type="text" class="form-control" id="pais" name="nombre" required>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="siglas">Siglas</label>
                                <input type="text" class="form-control" id="siglas" name="siglas" required>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="siglas">Código</label>
                                <input type="text" class="form-control" id="siglas" name="codigo" required>
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
