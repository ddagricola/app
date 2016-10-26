@extends('layouts.app')

@section('content')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-folder-open"></i>Distribución Municipal</a></li>
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
                              <h3>Distribución Municipal <h5>Departamento de {{ \App\Jefatura::find(Auth::user()->id_jefatura)->nombre }}</h5></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                  <div id="btn-group-box">
                  </div>
                    <table id="grid-paises" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Departamento</th>
                                <th>Municipio</th>
                                <th>Insumos</th>
                                <th>Beneficiarios</th>
                                <!--<th>Base Legal</th>
                                <th>Insumo</th>-->
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <!--<tr>
                                <th>ID</th>
                                <th>Año</th>
                                <th>Orden</th>
                                <th>Departamento</th>
                                <th>Base Legal</th>
                                <th>Insumo</th>
                                <th></th>
                            </tr>-->
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="{{ asset ('/bower_components/AdminLTE/plugins/jQuery/jQuery-2.2.0.min.js') }}"></script>
<script type="text/javascript">
function cancelarGrupo(){
  location.reload();
}
function editar(edit){
    location.href = "{{ url('intervenciones/editar/') }}"+"/"+edit;
}
function descargar(edit){
    location.href = "{{ url('detalle-intervencion/export/') }}"+"/"+edit;
}
function crearMovimiento(edit){
    "<?php $jefatura =  \App\User::usuarioToJefatura(); ?>";
    url = "<?php echo  url('entregas/distribucion-municipal/'.$jefatura.'/eventos/');?>";

    location.href = url+'/'+edit;
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

function IntervencionGrupo(){
    this.id = null;
}

function agregarGrupo(){
  data = [];
  var accept =true;// confirm("¿Desea agrupar estas intervenciones?");
  $data = $(".checkbox-interv");
  $data.each(function(i, element){
    $this = $(this);
    if($this.is(":checked")){
        _id = $this.attr('item');
        grupo = new IntervencionGrupo();
        grupo.id = _id;
        data.push(grupo);
    }
  });
  if(data.length>0){
    console.log(data)
  }else{
    alert('Debes selecccionar intervenciones.')
  }
}
function getGrid(flag){
  $('#grid-paises').DataTable({
      "order": [[ 0, "desc" ]],
      "ajax": "{{ url('entregas/distribucion-municipal/todo-distribucion') }}",
      "columnDefs": [
          /*{
              "targets": 0,
              "visible": (flag)? false:true,
              "data": "id_intervencion",
              "render": function ( data, type, full, meta ) {
                  check = "<input type='checkbox' class='checkbox-interv' item='"+data+"'>"
                  return "<div class='pull-right'>" + check + "</div>";
              }
          },*/
          { "data": "departamento", "targets": 0 },
          { "data": "municipio", "targets": 1 },
          { "data": "kit_insumo", "targets": 2 },
          { "data": "otorgados", "targets": 3 },
          /*{ "data": "orden", "targets": 2 , "visible":false},
          { "data": "departamento", "targets": 3 },
          { "data": "nombre_intervencion", "targets": 4 },
          { "data": "insumo", "targets": 5 },*/
          {
              "targets": 4,
              "data": "id_grupo",
              "visible": (flag)? true:false,
              "render": function ( data, type, full, meta ) {
                  intv = "<a href='javascript:crearMovimiento("+data+")' id='edit' class='btn btn-primary btn-sm' data-toggle='tooltip' data-placement='top' title='Crear Eventos'><span class='glyphicon glyphicon-home' aria-hidden='true'></span></a>";
                  edit = "<a id='edit' href='javascript:editar("+data+")' class='btn btn-primary btn-sm' data-toggle='tooltip' data-placement='top' title='Editar Intervención'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a>";
                  download = "<a href='javascript:descargar("+data+")'  id='edit' class='btn btn-success btn-sm' data-toggle='tooltip' data-placement='top' title='Descargar detalle de Intervención'><span class='glyphicon glyphicon-cloud-download' aria-hidden='true'></span></a>";
                  del = "<a class='btn btn-danger btn-sm' data-toggle='tooltip' data-placement='top' title='Borrar Intervención'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>";
                  return "<div class='pull-right'>" + intv + "</div>";
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
}
$(function(){
    $add = $("#add");
    $agrupar = $("#agrupar");

    getGrid(true);

    $agrupar.on('click',function(e){
      var guardar = '<a href="javascript:agregarGrupo()" class="btn btn-primary btn-sm">Guardar</a>';
      var cancelar = '<a href="javascript:cancelarGrupo()" class="btn btn-danger btn-sm">Cancelar</a>';
      $('#grid-paises').DataTable().destroy();
      $add.remove();
      $agrupar.remove();

      $("#btn-group-box").html(guardar + cancelar);
      getGrid(false);
    });
    $add.on('click', function(){
        location.href="<?php echo url('intervenciones/nuevo') ?>"+"/"+<?php echo 1//$consolidado->id?>;
    });

});
</script>

@endsection
