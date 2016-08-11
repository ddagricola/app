@extends('layouts.app')

@section('content')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-folder-open"></i> Colaboradores</a></li>
        <li class="active">Listado</li>
    </ol>
</section><br>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-md-3 pull-left">
                            <button class="btn btn-default btn-sm" type="button" id="add">Agregar empleado</button>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <table id="grid-paises" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Contrato</th>
                                <th>CUI</th>
                                <th>Primer Nombre</th>
                                <th>Primer Apellido</th>
                                <th>Puesto</th>
                                <th>Unidad</th>
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
        url: "<?php echo url('recepcion/colaboradores/remove') ?>"+"/"+data,
        type : 'GET',
        error: function(){
            alert('Ha ocurrido un error en el servidor')
        },
        success: function(data){
            $('#grid-paises').DataTable().ajax.reload();
        }
    });
}
function editar(edit){
    location.href = "{{ url('recepcion/colaboradores/editar') }}"+"/"+edit;
}
$(function(){
    $add = $("#add");
    $add.on('click', function(){
        location.href="<?php echo url('recepcion/colaboradores/nuevo') ?>"
    });
        $('#grid-paises').DataTable({
            "order": [[ 0, "desc" ]],
            "ajax": "{{ url('recepcion/colaboradores/todo') }}",
            "columnDefs": [ 
                { 
                    "data": "contrato", "targets": 0,
                    "width":"10%"
                },
                { "data": "cui", "targets": 1,"width":"5%" },
                { "data": "primer_nombre", "targets": 2},
                { "data": "primer_apellido", "targets": 3 },
                //{ "data": "segundo_nombre", "targets": 4 },
                { "data": "puesto", "targets": 4 , "width":"20%"},
                //{ "data": "segundo_apellido", "targets": 6 },
                { "data": "jefatura", "targets": 5 },
                {
                    "targets": 6,
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