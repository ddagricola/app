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
                    <h3>Distribuciones {{ $municipio->nombre }}</h3>
                </div>
                <div class="box-body">
                    <table id="grid-paises" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <!--<th>Intervención</th>-->
                                <th>Departamento</th>
                                <th>Municipio</th>
                                <th>Insumo</th>
                                <th>Beneficiarios</th>
                                <th>Cantidad por beneficiario</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <!--<th></th>-->
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
    location.href = "{{ url('movimiento/municipal', $municipio->id) }}"+"/"+edit;;
    //location.href = "{{ url('distribuciones/municipios/intervenciones/ingreso') }}"+"/"+edit;
}
$(function(){

        $('#grid-paises').DataTable({
            "order": [[ 1, "asc" ]],
            "ajax": "{{ url('distribuciones/municipios/intervenciones/todo') }}"+"/"+{{$municipio->id}},
            "columnDefs": [ 

                //{ "data": "orden", "targets": 0},
                { "data": "departamento", "targets": 0},
                { "data": "municipio", "targets": 1},
                { "data": "insumo", "targets": 2},
                { "data": "beneficiarios", "targets": 3},
                { "data": "cantidad_por_beneficiario", "targets": 4},
                {
                    "targets": 5,
                    "data": "id_detalle_intervencion",
                    "render": function ( data, type, full, meta ) {
                        edit = "<a href='javascript:ingreso("+data+")' id='edit' class='btn btn-primary btn-sm' data-toggle='tooltip' data-placement='top' title='Eventos'><span class='glyphicon glyphicon-home' aria-hidden='true'></span></a>";
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