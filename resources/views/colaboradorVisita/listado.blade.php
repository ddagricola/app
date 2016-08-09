@extends('layouts.app')

@section('content')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-folder-open"></i> Repeción</a></li>
        <li class="active">Listado de visitas</li>
    </ol>
</section><br>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3>LISTADO VISITAS {{ $jefatura->nombre }}</h3>
                </div>
                <div class="box-body">
                    <table id="grid-paises" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Colaborador</th>
                                <th>Jefatura</th>
                                <th>Día Visita</th>
                                <th>Nombre Visitante</th>
                                <th>Lugar Visitante</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($visitas as $item)
                                <tr>
                                    <td>{{ $item->colaborador }}</td>
                                    <td>{{ $item->jefatura }}</td>
                                    <td>{{ $item->dia_visita }}</td>
                                    <td>{{ $item->nombre_visitante }}</td>
                                    <td>{{ $item->lugar_visitante }}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{ asset ('/bower_components/AdminLTE/plugins/jQuery/jQuery-2.2.0.min.js') }}"></script>
<script type="text/javascript">
$(function(){
        $('#grid-paises').DataTable();
    });
</script>
@endsection