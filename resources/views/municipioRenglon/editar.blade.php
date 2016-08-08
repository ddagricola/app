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
                    <h3 class="box-title">Creación de nuevo departamento</h3>
                </div>
                <div class="box-body">
                    <form method="POST" action="{{ route('mantenimiento.departamentos.update', $departamento->id) }}" accept-charset="UTF-8">
                    {!! csrf_field() !!}
                    <input name="_method" type="hidden" value="PUT">
                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label for="pais">Pais</label>
                                <select class="form-control select2" style="width: 100%;" name="id_pais" id="pais_origen">
                                    <option value="">Seleccione país</option>
                                    @foreach($paises as $pais)
                                        @if ($pais->id == $departamento->id_pais)
                                            <option value="{{$pais->id}}" selected>{{ $pais->nombre }}</option>
                                        @else
                                            <option value="{{$pais->id}}">{{ $pais->nombre }}</option>
                                        @endif
                                    @endforeach;
                                </select>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="pais">Nombre</label>
                                <input type="text" value="{{ $departamento->nombre }}" class="form-control" id="pais" name="nombre" required>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="pais">Código</label>
                                <input type="text" value="{{ $departamento->codigo_partida }}" class="form-control" id="pais" name="codigo" required>
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
