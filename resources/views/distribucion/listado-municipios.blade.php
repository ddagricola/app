@extends('layouts.app')

@section('content')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-folder-open"></i> Departamentos</a></li>
        <li class="active">Listado de departamentos</li>
    </ol>
</section><br>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <div class="btn-group" role="group" aria-label="...">
                        <a href="javascript:history.back()" ="" class="btn btn-primary">
                            <span class='glyphicon glyphicon-menu-left' aria-hidden='true'></span>
                        </a>
                    </div>
                    <h3>Distribución Municipal</h3>
                </div>
                <div class="box-body">
                    <table id="grid-paises" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>MUNICIPIOS DE {{$departamento->nombre}}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
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
function intervenciones(edit){
    location.href = "{{ url('distribuciones/municipios/intervenciones') }}"+"/"+edit;
}
function remove(data){
    $.ajax({
        url: "<?php echo url('departamentos/remove') ?>"+"/"+data,
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
        location.href="<?php echo url('mantenimiento/departamentos/create') ?>"
    });
        $('#grid-paises').DataTable({
            "order": [[ 1, "asc" ]],
            "ajax": "{{ url('distribuciones/municipios/todo') }}"+"/"+{{$departamento->id}},
            "columnDefs": [ 

                { "data": "municipio", "targets": 0},
                {
                    "targets": 1,
                    "data": "id_municipio",
                    "render": function ( data, type, full, meta ) {
                        edit = "<a href='javascript:intervenciones("+data+")' id='edit' class='btn btn-success btn-sm' data-toggle='tooltip' data-placement='top' title='Ver Intervenciones'><span class='glyphicon glyphicon-menu-right' aria-hidden='true'></span></a>";
                        del = "<a href='javascript:remove("+data+")' class='btn btn-danger btn-sm' data-toggle='tooltip' data-placement='top' title='Borrar'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>";
                        return "<div class='pull-right'>" + edit +"</div>";
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