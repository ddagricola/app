@extends('layouts.app')

@section('content')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-folder-open"></i> Departamentos</a></li>
        <li class="active">Eventos de {{$municipio->nombre}}</li>
    </ol>
</section><br>
<section class="content">
@include('movimiento.templates.modal')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                
                    <h3>COMUNIDADES EN {{ $municipio->nombre }}</h3>
                    <div class="btn-group" role="group" aria-label="...">
                        <a href="javascript:history.back()" ="" class="btn btn-primary">
                            <span class='glyphicon glyphicon-menu-left' aria-hidden='true'></span>
                        </a>
                    </div>
                    <!-- Trigger the modal with a button -->
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Agregar Comunidad</button>
                    <br>
                    @if(Session::has('message'))
                        <br>
                        <div class="alert alert-danger">
                          {{ Session::get('message') }}
                        </div>
                        <!--<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>-->
                    @endif

                </div>
                <div class="box-body">
                    <table id="grid-paises" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Año</th>
                                <th>Insumo</th>
                                <th>Municipio</th>
                                <th>Comunidad</th>
                                <th>Extensionista</th>
                                <!--<th>Jefe Departamental</th>-->
                                <th>Beneficiarios Solicitados</th>
                                <th></th>
                            </tr>
                        </thead>
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
function ingreso(edit){
    location.href = "{{ url('distribuciones/municipios/intervenciones/ingreso') }}"+"/"+edit;
}
function listado(edit){
    location.href = "{{ url('movimiento/beneficiarios/evento/') }}"+"/"+edit;
}
function planilla(edit){
    location.href = "{{ url('grupos/tecnicos/exportar/planilla') }}"+"/"+edit;
}

function boletas(key){
    location.href = "{{ url('grupos/tecnicos/exportar/boletas/') }}"+"/"+key;
}

$(function(){
        $('#grid-paises').DataTable({
            "order": [[ 1, "asc" ]],
            "ajax": "{{ url('movimiento/comunidad/todo-eventos/') }}"+"/"+{{$municipio->id}},
            "columnDefs": [ 
                { "data": "anio", "targets": 0},
                { "data": "insumo", "targets": 1},
                { "data": "municipio", "targets": 2},
                { "data": "comunidad", "targets": 3},
                //{ "data": "nbeneficiario", "targets": 4},
                //{ "data": "nbeneficiario", "targets": 4},
                { "data": "nombre_extensionista", "targets": 4},
                //{ "data": "nombre_jefe", "targets": 5},
                { "data": "nbeneficiario", "targets": 5},
                
                //{ "data": "cantidad_por_beneficiario", "targets": 5},
                {
                    "targets": 6,
                    "data": "id_movimiento",
                    "render": function ( data, type, full, meta ) {
                        edit = "<a href='javascript:ingreso("+data+")' id='edit' class='btn btn-success btn-sm' data-toggle='tooltip' data-placement='top' title='Ingresar Beneficiarios'><span class='glyphicon glyphicon-user' aria-hidden='true'></span></a>";
                        list = "<a href='javascript:listado("+data+")' id='edit' class='btn btn-primary btn-sm' data-toggle='tooltip' data-placement='top' title='Ver Beneficiarios'><span class='glyphicon glyphicon-folder-open' aria-hidden='true'></span></a>";

                        planillaPDF = "<a href='javascript:planilla("+data+")' id='edit' class='btn btn-warning btn-sm' data-toggle='tooltip' data-placement='top' title='Descargar Planilla'><span class='glyphicon glyphicon-th-list' aria-hidden='true'></span></a>";

                        boletasPDF = "<a href='javascript:boletas("+data+")' id='edit' class='btn btn-primary btn-sm' data-toggle='tooltip' data-placement='top' title='Descargar Boletas'><span class='glyphicon glyphicon-th-list' aria-hidden='true'></span></a>";

                        return "<div class='pull-right'>" + edit + list + planillaPDF + boletasPDF + "</div>";
                    }
                },
            ],
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