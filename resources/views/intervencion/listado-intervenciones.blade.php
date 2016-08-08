@extends('layouts.app')

@section('content')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-folder-open"></i> Intervenciones</a></li>
        <li class="active">{{-- $consolidado->nombre --}}</li>
    </ol>
</section><br>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="btn-group">
                                <a id='add' class='btn btn-primary btn-md' data-toggle='tooltip' data-placement='top' title='Ver Detalle'>
                                    Nueva Intervención
                                </a>
                                <!--<a id='add' class='btn btn-success btn-sm' data-toggle='tooltip' data-placement='top' title='Descargar'>
                                    <span class='glyphicon glyphicon-cloud-download' aria-hidden='true'></span> 
                                </a>-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <table id="grid-paises" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Año</th>
                                <th>Orden</th>
                                <th>Departamento</th>
                                <th>Base Legal</th>
                                <th>Insumo</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Año</th>
                                <th>Orden</th>
                                <th>Departamento</th>
                                <th>Base Legal</th>
                                <th>Insumo</th>
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
function editar(edit){
    location.href = "{{ url('intervenciones/editar/') }}"+"/"+edit;
}
function descargar(edit){
    location.href = "{{ url('detalle-intervencion/export/') }}"+"/"+edit;
}
function detalleIntervencion(edit){
    location.href = "{{ url('intervenciones/detalle-intervencion') }}"+"/"+edit;
}
function remove(data){
    $.ajax({
        url: "<?php echo url('insumos/remove') ?>"+"/"+data,
        type : 'GET',
        error: function(){
            alert('Ha ocurrido un error en el servidor')
        },
        success: function(data){
            $('#grid-paises').DataTable().ajax.reload();
        }
    });
}

$(function(){
    $add = $("#add");
    $add.on('click', function(){
        location.href="<?php echo url('intervenciones/nuevo') ?>"+"/"+<?php echo 1//$consolidado->id?>;
    });
        $('#grid-paises').DataTable({
            "order": [[ 0, "desc" ]],
            "ajax": "{{ url('intervenciones/listado/todo/') }}",
            "columnDefs": [ 
                { "data": "correlativo", "targets": 0 },
                { "data": "anio", "targets": 1 },
                { "data": "orden", "targets": 2 },
                { "data": "departamento", "targets": 3 },
                { "data": "nombre_intervencion", "targets": 4 },
                { "data": "insumo", "targets": 5 },
                {
                    "targets": 6,
                    "data": "id_intervencion",
                    "render": function ( data, type, full, meta ) {
                        intv = "<a href='javascript:detalleIntervencion("+data+")' id='edit' class='btn btn-warning btn-sm' data-toggle='tooltip' data-placement='top' title='Detalles de Intervención'><span class='glyphicon glyphicon-folder-open' aria-hidden='true'></span></a>";
                        edit = "<a id='edit' href='javascript:editar("+data+")' class='btn btn-primary btn-sm' data-toggle='tooltip' data-placement='top' title='Editar Intervención'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a>";
                        download = "<a href='javascript:descargar("+data+")'  id='edit' class='btn btn-success btn-sm' data-toggle='tooltip' data-placement='top' title='Descargar detalle de Intervención'><span class='glyphicon glyphicon-cloud-download' aria-hidden='true'></span></a>";
                        del = "<a class='btn btn-danger btn-sm' data-toggle='tooltip' data-placement='top' title='Borrar Intervención'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>";
                        return "<div class='pull-right'>" + intv + edit + download + del + "</div>";
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