@extends('layouts.app')

@section('content')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-folder-open"></i> Departamentos</a></li>
        <li class="active">Listado de beneficiarios ingresados</li>
    </ol>
</section><br>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header">
                    Nuevo Usuario
                </div>
                <div class="box-body">
                <form method="POST" action="{{ url('configuration/usuario') }}">
                {!! csrf_field() !!}
                    <fieldset class="form-group">
                        <label>Rol:</label>
                        <select name="id_rol" class="form-control">
                            @foreach ($roles as $item)
                                <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                            @endforeach
                        </select>
                    </fieldset>
                    <fieldset class="form-group">
                        <label>Jefatura:</label>
                        <select name="id_jefatura" class="form-control">
                            @foreach ($jefaturas as $item)
                                <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                            @endforeach
                        </select>
                    </fieldset>
                    <fieldset class="form-group">
                        <label>Correo Electrónico:</label>
                        <input type="email" name="email" class="form-control" required="">
                    </fieldset>
                    <fieldset class="form-group">
                        <label>Contraseña:</label>
                        <input type="password" name="password" class="form-control" required="">
                    </fieldset>
                    <fieldset class="form-group">
                        <button class="btn btn-success" type="submit">Guardar</button>
                    </fieldset>
                </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection