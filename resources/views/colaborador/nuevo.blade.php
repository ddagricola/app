@extends('layouts.app')

@section('content')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-folder-open"></i> Recepción</a></li>
        <li class="active">Nueva Colaboradr</li>
    </ol>
</section><br>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">
                        Creación de nuevo empleado
                    </h3>
                </div>
                <div class="box-body">
                    <form class="form" method="POST" action="{{ url('recepcion/colaboradores/guardar') }}" accept-charset="UTF-8">
                        {!! csrf_field() !!}
                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label for="pais">CUI</label>
                                <input type="text" class="form-control" name="cui" maxlength="13">
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="pais">Primer Nombre</label>
                                <input type="text" class="form-control" name="primer_nombre">
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="pais">Segundo Nombre</label>
                                <input type="text" class="form-control" name="segundo_nombre">
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="pais">Tercer Nombre</label>
                                <input type="text" class="form-control" name="tercer_nombre">
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="pais">Primer Apellido</label>
                                <input type="text" class="form-control" name="primer_apellido">
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="pais">Segundo Apellido</label>
                                <input type="text" class="form-control" name="segundo_apellido">
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="pais">Apellido Casada (No incluir DE)</label>
                                <input type="text" class="form-control" name="apellido_casada">
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="pais">Jefatura </label>
                                <select id="id_colaborador" name="id_jefatura" class="form-control">
                                    @foreach($jefaturas as $jefatura) 
                                        <option value="{{ $jefatura->id }}">
                                            {{ $jefatura->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="pais">Contrato </label>
                                <input type="text" class="form-control" name="contrato" required>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="pais">Puesto</label>
                                <select id="id_colaborador" name="id_puesto" class="form-control">
                                    @foreach($puestos as $jefatura) 
                                        <option value="{{ $jefatura->id }}">
                                            {{ $jefatura->nombre }}
                                        </option>
                                    @endforeach
                                </select>
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
