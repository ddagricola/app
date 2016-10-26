@extends('layouts.app')

@section('content')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-folder-open"></i> Departamentos</a></li>
        <li class="active">Listado de departamentos</li>
    </ol>
</section><br>
<section class="content">
     <div class="row">

        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">INGRESO DE BENEFICIARIOS {{$comunidad->nombre}}</h3>

              <!--<div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <div class="btn-group">
                  <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-wrench"></i></button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>-->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <input type="hidden" name="event" id="event">
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="id_evento" id="id_evento" value="{{$movimiento->id}}">
            <input type="hidden" name="id_distribucion_movimiento" id="id_distribucion_movimiento" value="{{$distribucion->id}}">
              <div class="row">
                <div class="col-md-8">
                  <p class="text-center">
                    <!--<strong style="font-size:20px">{{$comunidad->nombre}}</strong><br>-->
                    <strong>{{ $detalle->departamento }} - {{ $detalle->municipio }}</strong><br>
                    <strong>{{ $movimiento->nbeneficiario }} BENEFICIARIOS SOLICITADOS</strong><br>
                  </p>
                  <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cui" id="lbl-cui">CUI</label>
                            <input maxlength="13" type="text" class="form-control" id="cui" placeholder="Ingrese número de CUI">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group pull-left" style="margin-top:11.5%;margin-left:-30px">
                            <button class="btn btn-default" id="search">
                              <span class='glyphicon glyphicon-search' aria-hidden='true'></span>
                            </button>
                        </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="primer_nombre">Primer Nombre</label>
                            <input type="text" class="form-control" id="primer_nombre">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="segundo_nombre">Segundo Nombre</label>
                            <input type="text" class="form-control" id="segundo_nombre">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tercer_nombre">Tercer Nombre</label>
                            <input type="text" class="form-control" id="tercer_nombre">
                        </div>
                    </div>
                  </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="primer_apellido">Primer Apellido</label>
                            <input type="text" class="form-control" id="primer_apellido">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="segundo_apellido">Segundo Apellido</label>
                            <input type="text" class="form-control" id="segundo_apellido">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="apellido_casada">Apellido de Casada</label>
                            <input type="text" class="form-control" id="apellido_casada">
                        </div>
                    </div>
                  </div>
                <div class="row">
                    <div class="col-md-4">
                    <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                    <div class="input-group date">
                        <input class="form-control datepicker" data-date-format="mm/dd/yyyy" id="fecha_nacimiento">
                        <!--<input type="text" class="form-control" id="fecha_nacimiento">-->
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                        <!--<div class="form-group">
                            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                            <input type="text" class="form-control" id="fecha_nacimiento">
                        </div>-->
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <!--<label for="edad">Edad</label>
                            <input type="text" class="form-control" id="edad" disabled>-->
                            <label for="estado_civil">Genero</label>
                            <select class="form-control" id="genero">
                                <option value="">Seleccione genero</option>
                                <option value="1">MASCULINO</option>
                                <option value="2">FEMENINO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="estado_civil">Estado Civil</label>
                            <select class="form-control" id="estado_civil">
                                <option value="">Seleccione estado civil</option>
                                <option value="1">SOLTERO</option>
                                <option value="2">CASADO</option>
                            </select>
                        </div>
                    </div>
                  </div>
                  <div class="row">
                  <div class="col-md-4">
                        <div class="form-group">
                            <label for="departamento_nacimiento">Departamento de Nacimiento</label>
                            <select id="departamento_nacimiento" class="form-control">
                            <option value="">Seleccione departamento</option>
                              @foreach ($departamentos as $departamento)
                                <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                              @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="municipio_nacimiento">Municipio de Nacimiento</label>
                            <select id="municipio_nacimiento" class="form-control"></select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nacionalidad">Nacionalidad</label>
                            <input type="text" class="form-control" id="nacionalidad" value="GUATEMALTECO" disabled="disabled">
                        </div>
                    </div>
                  </div>
                  <div class="row">
                  <div class="col-md-4">
                        <div class="form-group">
                            <label for="pueblo">Pueblo</label>
                            <select class="form-control" id="pueblo">
                                <option value="">Seleccione pueblo</option>
                                @foreach($pueblo as $item)
                                  <option value="{{$item->id}}">{{$item->nombre}}</option>
                                @endforeach
                                <!--<option value="1">MAYA</option>
                                <option value="2">LADINO</option>-->
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="etnia">Etnia</label>
                            <select class="form-control" id="etnia">
                                <option value="">Seleccione etnia</option>
                                @foreach($etnia as $item)
                                  <option value="{{$item->id}}">{{$item->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" style="margin-top:15%">
                            <label>
                                <input type="checkbox" class="minimal" id="leer">
                                Sabe Leer
                            </label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="checkbox" class="minimal" id="escribir">
                                Sabe Escribir
                            </label>
                        </div>
                    </div>
                  </div>
                  <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                        <button id="registrar" class="btn btn-primary">Guardar e Ingresar</button>
                    </div>
                    </div>
                  </div>
                  <!--<div>
                      <form>
                        <div class="form-group">
                            <label for="cui">CUI</label>
                            <input type="text" class="form-control" id="cui" placeholder="Ingrese número de CUI">
                        </div>
                      </form>
                  </div>-->
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                  <!--<p class="text-center">
                    <strong>Goal Completion</strong>
                  </p>-->

                  <!--<div class="progress-group">
                    <span class="progress-text">Beneficiarios Ingresados</span>
                    <span class="progress-number"><b>0</b>/{{$movimiento->nbeneficiario}}</span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-aqua" style="width: 20%"></div>
                    </div>
                  </div>-->
                </div>
                <!-- /.col -->
              </div>
              <div id="content-over">

              </div>
              <!-- /.row -->
              <!--<div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
              </div>-->
            </div>
            <!-- ./box-body -->
            <div class="box-footer">
              <!--<div class="row">
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <h5 class="description-header">
                      {{$detalle->cantidad_por_beneficiario}} DE {{$detalle->insumo}}
                      </h5>
                    <span class="description-text">POR BENEFICIARIO</span>
                  </div>
                </div>
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <h5 class="description-header">{{$detalle->cantidad}} QUINTALES</h5>
                    <span class="description-text">ADQUIRIDOS PARA {{$detalle->municipio}} </span>
                  </div>
                </div>
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <h5 class="description-header">{{$detalle->beneficiarios}} BENEFICIARIOS</h5>
                    <span class="description-text">AUTORIZADOS EN {{$detalle->municipio}}</span>
                  </div>
                </div>-->
                <!-- /.col -->
                <!--<div class="col-sm-3 col-xs-6">
                  <div class="description-block">
                    <h5 class="description-header">0/40 BENEFICIARIOS</h5>
                    <span class="description-text">INGRESADOS EN {{$detalle->municipio}} </span>
                  </div>
                </div>-->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
</section>
<script src="{{ asset ('/bower_components/AdminLTE/plugins/jQuery/jQuery-2.2.0.min.js') }}"></script>
<script src="{{ asset ('/js/globals.js') }}"></script>
<script src="{{ asset ('/js/ingreso.js') }}"></script>
@endsection
