@extends('layouts.app')

@section('content')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-folder-open"></i> Programas</a></li>
        <li class="active">Listado de Sub Programas</li>
    </ol>
</section><br>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-md-3 pull-left">
                            <button class="btn btn-default btn-sm" type="button" id="add">Agregar un nuevo sub programa</button>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <table id="grid-paises" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Programa</th>
                                <th>Subprograma</th>
                                <th>IP Creción</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Programa</th>
                                <th>Subprograma</th>
                                <th>IP Creción</th>
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
function remove(data){
    $.ajax({
        url: "<?php echo url('programas/remove') ?>"+"/"+data,
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
        location.href="<?php echo url('mantenimiento/programas/subprogramas/create/') ?>/"+<?php echo $idPrograma?>
    });
        $('#grid-paises').DataTable({
            "order": [[ 0, "desc" ]],
            "ajax": "{{ url('programas/todo-sub') }}"+"/"+<?php echo $idPrograma?>,
            "columnDefs": [ 
                { "data": "programa", "targets": 0 },
                { "data": "subprograma", "targets": 1 },
                { "data": "ip_creacion", "targets": 2 },
                {
                    "targets": 3,
                    "data": "id_subprograma",
                    "render": function ( data, type, full, meta ) {
                        //sub = "<a id='edit' class='btn btn-success btn-sm' data-toggle='tooltip' data-placement='top' title='Subprograma'><span class='glyphicon glyphicon-plus' aria-hidden='true'></span></a>";
                        edit = "<a id='edit' class='btn btn-primary btn-sm' data-toggle='tooltip' data-placement='top' title='Editar'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></a>";
                        del = "<a href='javascript:remove("+data+")' class='btn btn-danger btn-sm' data-toggle='tooltip' data-placement='top' title='Borrar'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>";
                        return "<div class='pull-right'>" + edit + del + "</div>";
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