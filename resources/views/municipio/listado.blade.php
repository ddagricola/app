@extends('layouts.app')

@section('content')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-folder-open"></i> Municipios</a></li>
        <li class="active">Listado de municipios</li>
    </ol>
</section><br>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-md-3 pull-left">
                            <button class="btn btn-default btn-sm" type="button" id="add">Agregar un nuevo municipio</button>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <table id="grid-paises" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>País</th>
                                <th>Código</th>
                                <th>Departamento</th>
                                <th>Nombre</th>
                                <th>División</th>
                                <th>IP Creación</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>País</th>
                                <th>Código</th>
                                <th>Departamento</th>
                                <th>Nombre</th>
                                <th>División</th>
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

function divisiones(edit){
    location.href = "{{ url('mantenimiento/divisiones/') }}"+"/create/"+edit;
}
function editar(edit){
    location.href = "{{ url('mantenimiento/municipios/') }}"+"/"+edit+"/edit";
}
function remove(data){
    $.ajax({
        url: "<?php echo url('municipios/remove') ?>"+"/"+data,
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
        location.href="<?php echo url('mantenimiento/municipios/create') ?>"
    });
        $('#grid-paises').DataTable({
            "order": [[ 0, "desc" ]],
            "ajax": "{{ url('municipios/todo') }}",
            "columnDefs": [ 
                { "data": "pais", "targets": 0 },
                { "data": "codigo", "targets": 1 },
                { "data": "departamento", "targets": 2 },
                { "data": "nombre", "targets": 3 },
                { "data": "division", "targets": 4},
                { "data": "ip_creacion", "targets": 5 },
                {
                    "targets": 6,
                    "data": "id",
                    "render": function ( data, type, full, meta ) {
                        division = "<a href='javascript:divisiones("+data+")' id='edit' class='btn btn-success btn-sm' data-toggle='tooltip' data-placement='top' title='Editar'><span class='glyphicon glyphicon-list-alt' aria-hidden='true'></span></a>";
                        edit = "<a href='javascript:editar("+data+")' id='edit' class='btn btn-primary btn-sm' data-toggle='tooltip' data-placement='top' title='Editar'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a>";
                        del = "<a href='javascript:remove("+data+")' class='btn btn-danger btn-sm' data-toggle='tooltip' data-placement='top' title='Borrar'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>";
                        return "<div class='pull-right'>" + division + edit + del + "</div>";
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