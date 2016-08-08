@extends('layouts.app')

@section('content')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-folder-open"></i> Fuentes de financiamiento</a></li>
        <li class="active">Listado de fuentes de financiamiento</li>
    </ol>
</section><br>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-md-3 pull-left">
                            <button class="btn btn-primary btn-sm" type="button" id="add">Agregar fuente de financiamiento</button>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <table id="grid-paises" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Fecha Creación</th>
                                <th>Email Creación</th>
                                <th>IP Creación</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Fecha Creación</th>
                                <th>Email Creación</th>
                                <th>IP Creación</th>
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
    location.href = "{{ url('mantenimiento/fuentes-financiamiento/') }}"+"/"+edit+"/edit";
}
function remove(data){
    $.ajax({
        url: "<?php echo url('fuentes-financiamiento/remove') ?>"+"/"+data,
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
        location.href="<?php echo url('mantenimiento/fuentes-financiamiento/create') ?>"
    });
        $('#grid-paises').DataTable({
            "order": [[ 0, "desc" ]],
            "ajax": "{{ url('fuentes-financiamiento/todo') }}",
            "columnDefs": [ 
                { "data": "codigo_partida", "targets": 0 },
                { "data": "nombre", "targets": 1 },
                { "data": "fecha_creacion", "targets": 2},
                { "data": "email_creacion", "targets": 3 },
                { "data": "ip_creacion", "targets": 4 },
                {
                    "targets": 5,
                    "data": "id",
                    "render": function ( data, type, full, meta ) {
                        edit = "<a href='javascript:editar("+data+")' id='edit' class='btn btn-primary btn-sm' data-toggle='tooltip' data-placement='top' title='Editar'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></a>";
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