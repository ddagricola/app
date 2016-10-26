@extends('layouts.app')

@section('content')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-folder-open"></i>Distribución Eventos</a></li>
        <li class="active">{{-- $consolidado->nombre --}}</li>
    </ol>
</section><br>
<section class="content">
  <?php $municipioModal=""?>
  <?php $idMunicipioModal=""?>
  <?php $idGrupoIntervencion=""?>
  @foreach($detalle as $item)
  <?php $municipioModal = $item->municipio?>
  <?php $idMunicipioModal = $item->id_municipio?>
  <?php $idGrupoIntervencion = $item->id_grupo_intervencion?>
  @endforeach

  @include('entrega.modal-distribucion-evento')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="btn-group">
                              @foreach($detalle as $item)
                              <h3>Distribución: {{ $item->tipo_division }} {{ $item->comunidad }}</h3>
                              <h4>{{ $item->departamento }} - {{ $item->municipio }}</h4>

                              @endforeach
                              <a href="javascript:history.back()" class="btn btn-sm btn-primary">
                                <span class='glyphicon glyphicon-chevron-left' aria-hidden='true'></span>
                              </a>
                              <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal">Agregar</button>
                              <!--<a href="#" class="btn btn-sm btn-success">Distribuir Insumos</a>-->
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
                                <th>Beneficiarios</th>
                                <th>Cantidad</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
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
    url = "<?php echo  url('entregas/distribucion-municipal/'.$jefatura.'/ingreso-beneficiario/');?>";
    location.href = url+'/'+edit;
    //location.href = "{{ url('intervenciones/detalle-intervencion') }}"+"/"+edit;
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
      "order": [[ 2, "desc" ]],
      "ajax": "{{ url('entregas/distribucion-municipal/todo-distribucion-evento',$movimiento->id) }}",
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
          { "data": "nbeneficiario", "targets": 0 },
          { "data": "cantidad", "targets": 1 },
          /*{ "data": "nombre_intervencion", "targets": 2 },*/
          //{ "data": "otorgados", "targets": 3 },
          /*{ "data": "orden", "targets": 2 , "visible":false},
          { "data": "departamento", "targets": 3 },
          { "data": "nombre_intervencion", "targets": 4 },
          { "data": "insumo", "targets": 5 },*/
          {
              "targets": 2,
              "data": "id",
              "visible": (flag)? true:false,
              "render": function ( data, type, full, meta ) {
                  intv = "<a href='javascript:crearMovimiento("+data+")' id='edit' class='btn btn-primary btn-sm' data-toggle='tooltip' data-placement='top' title='Ingresar Beneficiarios'><span class='glyphicon glyphicon-user' aria-hidden='true'></span></a>";
                  //edit = "<a id='edit' href='javascript:editar("+data+")' class='btn btn-primary btn-sm' data-toggle='tooltip' data-placement='top' title='Editar Intervención'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a>";
                  //del = "<a class='btn btn-danger btn-sm' data-toggle='tooltip' data-placement='top' title='Borrar Intervención'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>";
                  //download = "<a href='javascript:descargar("+data+")'  id='edit' class='btn btn-success btn-sm' data-toggle='tooltip' data-placement='top' title='Recursos'><span class='glyphicon glyphicon-save' aria-hidden='true'></span></a>";
                  //listado = "<a href='javascript:descargar("+data+")'  id='edit' class='btn btn-info btn-sm' data-toggle='tooltip' data-placement='top' title='Beneficiarios Ingresados'><span class='glyphicon glyphicon-user' aria-hidden='true'></span></a>";
                  deletes = "<a href='javascript:descargar("+data+")'  id='edit' class='btn btn-danger btn-sm' data-toggle='tooltip' data-placement='top' title='Eliminar Distribución'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>";
                  return "<div class='pull-right'>" + intv +"</div>";
                  //+ deletes+
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
