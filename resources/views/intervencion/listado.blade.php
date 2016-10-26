@extends('layouts.app')

@section('content')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-folder-open"></i> Intervenciones</a></li>
        <li class="active">{{-- $jefatura->nombre --}}</li>
    </ol>
</section><br>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-md-3 pull-left">
                            <button class="btn btn-primary btn-sm" type="button" id="add">Agregar un nuevo consolidado</button>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <table id="grid-paises" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Año</th>
                                <th>Nombre</th>
                                <th>Fuente</th>
                                <th>Jefatura</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Año</th>
                                <th>Nombre</th>
                                <th>Fuente</th>
                                <th>Jefatura</th>
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
function grupoIntervencion(){
  $('#grid-paises').empty();
}
function intervencion(edit){
    //location.href = "{{ url('intervenciones/nuevo') }}"+"/"+edit;
    location.href = "{{ url('intervenciones/listado') }}"+"/"+edit;
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
        location.href="<?php echo url('intervenciones/granos-basicos/nuevo') ?>"+"/"+<?php //echo $jefatura->id?>;
    });
        $('#grid-paises').DataTable({
            "order": [[ 0, "desc" ]],
            "ajax": "{{ url('intervenciones/general/todo/') }}"+"/"+ <?php //echo $jefatura->id?>,
            "columnDefs": [
                { "data": "anio", "targets": 0 },
                { "data": "nombre", "targets": 1 },
                { "data": "fuente", "targets": 2},
                { "data": "jefatura", "targets": 3 },
                {
                    "targets": 4,
                    "data": "id",
                    "render": function ( data, type, full, meta ) {
                        intv = "<a href='javascript:intervencion("+data+")' id='edit' class='btn btn-warning btn-sm' data-toggle='tooltip' data-placement='top' title='Ver Intervenciones'><span class='glyphicon glyphicon-folder-open' aria-hidden='true'></span></a>";
                        edit = "<a id='edit' class='btn btn-primary btn-sm' data-toggle='tooltip' data-placement='top' title='Editar'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></a>";
                        del = "<a href='javascript:remove("+data+")' class='btn btn-danger btn-sm' data-toggle='tooltip' data-placement='top' title='Borrar'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>";
                        return "<div class='pull-right'>" + intv + edit + del + "</div>";
                    }
                },
            ],
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "iDisplayLength": 10,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },

        });
});
</script>

@endsection
