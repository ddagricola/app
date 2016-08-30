@extends('layouts.app')

@section('content')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-folder-open"></i>Configuración</a></li>
        <li class="active">Restaurar Contraseña</li>
    </ol>
</section><br>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header">
                    <h3>Restauración de Contraseña</h3>
                </div>
                <div class="box-body">
                <form method="POST" action="{{ url('grupos/tecnicos/configuracion/restauracion-save') }}" id="form-restore">
                {!! csrf_field() !!}
                    <fieldset class="form-group">
                        <label>Usuario:</label>
                        <input type="email" name="email" class="form-control" value="{{$user->email}}" disabled="">
                    </fieldset>
                    <fieldset class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="control-label">Contraseña:</label>
                        <input type="password" name="password" class="form-control" id="password">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="repetPassword">Repetir Contraseña:</label>
                        <input type="password" name="repetPassword" class="form-control" id="repetPassword">
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
<script src="{{ asset ('/bower_components/AdminLTE/plugins/jQuery/jQuery-2.2.0.min.js') }}"></script>
<script type="text/javascript">
    $(function(){
        $("#form-restore").submit(function(){
            confirm =  confirm("Al restaurar tu contraseña deberás iniciar sesión nuevamente.");
            if(confirm){
                $password = $("#password");
                $repetPassword = $("#repetPassword");
                if($repetPassword.val()==""||$password.val()==""){
                    alert("Completar campos");
                    $password.focus();
                    return false;
                }else{
                    if( $password.val()!=$repetPassword.val() ){
                        alert("Las contraseñas no coinciden");
                        $password.focus();
                        return false;
                    }
                }
            }else{
                return false;
            }
        })
    });
</script>
@endsection