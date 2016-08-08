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
                    <h3 class="box-title">Configuración de la cuenta</h3>
                </div>
                <div class="box-body">
                    <form class="form" method="POST" action="{{ url('configuration/usuario/store') }}" accept-charset="UTF-8">
                        {!! csrf_field() !!}
                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label for="pais">No. Contrato</label>
                                <input type="text" class="form-control" id="pais" name="contrato" required>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="siglas">Primer Nombre</label>
                                <input type="text" class="form-control" id="siglas" name="primer_nombre" required>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="siglas">Segundo Nombre</label>
                                <input type="text" class="form-control" id="siglas" name="segundo_nombre">
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="siglas">Tercer Nombre</label>
                                <input type="text" class="form-control" id="siglas" name="tercer_nombre">
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="siglas">Primer Apellido</label>
                                <input type="text" class="form-control" id="siglas" name="primer_apellido" required>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="siglas">Segundo Apellido</label>
                                <input type="text" class="form-control" id="siglas" name="segundo_apellido">
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="siglas">Apellido Casada</label>
                                <input type="text" class="form-control" id="siglas" name="apellido_casada">
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
