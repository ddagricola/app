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
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3>Beneficiarios Ingresados</h3>
                    <div class="btn-group" role="group" aria-label="...">
                        <a href="javascript:history.back()" ="" class="btn btn-primary">
                            <span class='glyphicon glyphicon-menu-left' aria-hidden='true'></span>
                        </a>
                    </div>

                </div>
                <div class="box-body">
                    <table id="grid-beneficiarios" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Municipio</th>
                                <th>Comunidad</th>
                                <th>DPI</th>
                                <th>Beneficiario</th>
                                <th>Cantidad</th>
                                <th>Insumo</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{$item->municipio}}</td>
                                    <td>{{$item->comunidad}}</td>
                                    <td>{{$item->cui}}</td>
                                    <td>
                                        {{$item->primer_nombre}}
                                        {{$item->segundo_nombre}}
                                        {{$item->tercer_nombre}}
                                        {{$item->primer_apellido}}
                                        {{$item->segundo_apellido}}
                                        {{$item->apellido_casada}}

                                    </td>
                                    <td>{{$item->cantidad_beneficiario}}</td>
                                    <td>{{$item->insumo}}</td>
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
function ingreso(edit){
    location.href = "{{ url('distribuciones/municipios/intervenciones/ingreso') }}"+"/"+edit;
}
function listado(edit){
    location.href = "{{ url('movimiento/beneficiarios/evento/') }}"+"/"+edit;
}

$(function(){
        $('#grid-beneficiarios').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "iDisplayLength": 5,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },

        });
});
</script>

@endsection
