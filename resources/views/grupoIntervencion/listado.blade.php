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
                        <!--<div class="col-md-3 pull-left">
                            <button class="btn btn-primary btn-sm" type="button" id="add">Agregar fuente de financiamiento</button>
                        </div>--->
                    </div>
                </div>
                <div class="box-body">
                    <table id="grid-paises" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Departamento</th>
                                <th>Municipio</th>
                                <th>Beneficiarios</th>
                                <th>Insumos</th>
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
function editar(value){
    location.href = "{{ url('movimiento/listado-eventos/') }}"+"/"+value;
}
function desc(value){
    location.href = "{{ url('intervencion-entregas/descripcion-grupo') }}"+"/"+value;
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
            "ajax": "{{ url('intervencion-entregas/listados/todo') }}",
            "columnDefs": [
                { "data": "departamento", "targets": 0 },
                { "data": "municipio", "targets": 1 },
                { "data": "nbeneficiario", "targets": 2},
                { "data": "insumos", "targets": 3 },
                {
                    "targets": 4,
                    "data": "id_grupo_intervencion",
                    "visible": true,
                    "render": function ( data, type, full, meta ) {
                        view = "<a href='javascript:desc("+data+")' id='edit' class='btn btn-warning btn-sm' data-toggle='tooltip' data-placement='top' title='Ver Descripción'><span class='glyphicon glyphicon-menu-hamburger' aria-hidden='true'></span></a>";
                        edit = "<a href='javascript:editar("+data+")' id='edit' class='btn btn-primary btn-sm' data-toggle='tooltip' data-placement='top' title='Eventos'><span class='glyphicon glyphicon-home' aria-hidden='true'></span></a>";
                        del = "<a href='javascript:remove("+data+")' class='btn btn-danger btn-sm' data-toggle='tooltip' data-placement='top' title='Borrar'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>";
                        return "<div class='pull-right'>" + view  + edit + del + "</div>";
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
