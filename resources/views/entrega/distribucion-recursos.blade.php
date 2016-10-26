@extends('layouts.app')

@section('content')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-folder-open"></i>Recursos</a></li>
        <li class="active">Listado</li>
    </ol>
</section><br>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                  <h4>Recursos</h4>
                  <a href="javascript:history.back()" class="btn btn-sm btn-primary">
                    <span class='glyphicon glyphicon-chevron-left' aria-hidden='true'></span>
                  </a>
                </div>
                <div class="box-body">
                  <?php $jefatura =  \App\User::usuarioToJefatura(); ?>
                  <div class="row">
                    <div class="col-md-1">
                      <img src="{{'/img/1476909982_1-02.png'}}" width="50">
                    </div>
                    <div class="col-md-4">
                      <a href="{{ url('entregas/distribucion-municipal/'.$jefatura.'/planilla-unica/'.$movimiento->id) }}"><h4>Descargar Planilla Única de Beneficiarios</h4></a>
                    </div>
                  </div><br>
                  <div class="row">
                    <div class="col-md-1">
                      <img src="{{'/img/1476909822_excel.png'}}" width="30" style="margin-left:10px">
                    </div>
                    <div class="col-md-4">
                      <a href="{{ url('entregas/distribucion-municipal/'.$jefatura.'/planilla-general/'.$movimiento->id) }}"><h4>Descargar Listado de Beneficiarios</h4></a>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="{{ asset ('/bower_components/AdminLTE/plugins/jQuery/jQuery-2.2.0.min.js') }}"></script>
@endsection
