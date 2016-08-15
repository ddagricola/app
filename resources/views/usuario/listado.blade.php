@extends('layouts.app')

@section('content')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-folder-open"></i> Usuarios</a></li>
        <li class="active">Listado General</li>
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
                    <a href="javascript:nuevoUsuario()" class="btn btn-default btn-md">Nuevo Usuario
                        </a>
                </div>
                <div class="box-body">
                    <table id="grid-paises" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Correo Electrónico</th>
                                <th>Fecha Creación</th>
                                <th>IP Creación</th>
                                <th>Rol</th>
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
function nuevoUsuario(){
    location.href = "{{ url('configuration/usuario/create') }}";
}
function ingreso(edit){
    location.href = "{{ url('distribuciones/municipios/intervenciones/ingreso') }}"+"/"+edit;
}
$(function(){
//$( "input" ).appendTo( ".dataTables_filter" );

        $('#grid-paises').DataTable({
            "order": [[ 1, "asc" ]],
            "ajax": "{{ url('usuario/todo') }}",
            "columnDefs": [ 

                { "data": "email", "targets": 0},
                { "data": "fecha_creacion", "targets": 1},
                { "data": "ip_creacion", "targets": 2},
                { 
                    "data": "usuario_rol.nombre", 
                    "targets": 3,
                    "render": function ( data, type, full, meta ) {
                        edit = data;
                        return "<div class='pull-right'>" + edit +"</div>";
                    }
                },
                {
                    "targets": 4,
                    "data": "id",
                    "render": function ( data, type, full, meta ) {
                        edit = "<a href='javascript:ingreso("+data+")' id='edit' class='btn btn-success btn-sm' data-toggle='tooltip' data-placement='top' title='Asignar Colaborador'><span class='glyphicon glyphicon-user' aria-hidden='true'></span></a>";
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