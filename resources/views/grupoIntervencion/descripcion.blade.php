@extends('layouts.app')

@section('content')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-folder-open"></i> Entregas</a></li>
        <li class="active">Listado de entregas</li>
    </ol>
</section><br>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                      <div class="col-md-12">
                        <h3>Grupo de entrega</h3>
                      </div>
                    </div>
                </div>
                <div class="box-body">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th> Departamento </th>
                        <th> Municipio </th>
                        <th> Insumo </th>
                        <th> Cantidad por Beneficiario </th>
                      </tr>
                    </thead>
                    @foreach($data as $item)
                      <tr>
                        <td> {{$item->departamento}} </td>
                        <td> {{$item->municipio}} </td>
                        <td> {{$item->insumo}} </td>
                        <td> {{$item->cantidad}} </td>
                      </tr>
                    @endforeach
                  </table>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="{{ asset ('/bower_components/AdminLTE/plugins/jQuery/jQuery-2.2.0.min.js') }}"></script>
@endsection
