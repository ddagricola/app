@extends('layouts.app')

@section('content')
<!-- Button trigger modal -->
<!--<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  Launch demo modal
</button>-->

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nuevo Grupo de Entrega</h4>
      </div>
      <form action="{{ url('distribuciones/agrupar-detalle') }}" method="post" id="form-grupo">
        {!! csrf_field() !!}
      <div class="modal-body">

            <div class="form-group">
              <label for="exampleInputEmail1">Ingresa un nombre para este grupo</label>
              <input type="text" class="form-control" id="nombreGrupo" name="nombreGrupo">
            </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
      </div>
      </form>
    </div>
  </div>
</div>
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
                        <a href="javascript:history.back()" ="" class="btn">
                            <span class='glyphicon glyphicon-arrow-left' aria-hidden='true'></span>
                            Atrás
                        </a>
                        <a href="javascript:grupoEntrega()" ="" class="btn">
                            <span class='glyphicon glyphicon-unchecked' aria-hidden='true'></span>
                            Crear Grupo de Entrega
                        </a>
                        <a href="#" class="btn" id="cancelarGeneracion" style="color:#E8434E">
                          <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                          Cancelar
                        </a>
                        <a href="#" class="btn" id="guardarGrupo" style="color:#40BD5F" data-toggle="modal" data-target="#myModal">
                          <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                          Guardar
                        </a>
                    </div>
                    <h3>Distribuciones {{ $municipio->nombre }}</h3>
                </div>
                <div class="box-body">
                    <table id="grid-paises" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <!--<th>Intervención</th>-->
                                <th></th>
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
var data = [];
$cancelar = $("#cancelarGeneracion");
$guardar = $("#guardarGrupo");
$formGrupo = $("#form-grupo");
$nombreGrupo = $("#nombreGrupo");
$formGrupo.submit(function(e){
  if($nombreGrupo.val()=='' || data.length<=0){
    alert('Completa campos o selecciona distribuciones.');
    return false;
  }else{
    $("<input/>").attr("name","detalle").attr("type","text").attr("value",JSON.stringify(data)).appendTo("#form-grupo");
    return true;
  }
});
function IntervencionItem(){
  this.id = null;
}
function ingreso(edit){
    location.href = "{{ url('movimiento/municipal', $municipio->id) }}"+"/"+edit;
}
function loadDataTable(flag){
  $('#grid-paises').DataTable({
      "order": [[ 1, "asc" ]],
      "ajax": "{{ url('distribuciones/municipios/intervenciones/todo') }}"+"/"+{{$municipio->id}},
      "columnDefs": [
          {
              "targets": 0,
              "visible": (flag)? false:true,
              "data": "id_detalle_intervencion",
              "render": function ( data, type, full, meta ) {
                  check = "<input type='checkbox' class='checkbox-addIntv' item='"+data+"'>"
                  return "<div class='pull-right'>" + check + "</div>";
              }
          },
          //{ "data": "departamento", "targets": 0},
          { "data": "municipio", "targets": 1},
          { "data": "insumo", "targets": 2},
          { "data": "beneficiarios", "targets": 3},
          { "data": "cantidad_por_beneficiario", "targets": 4},
          {
              "targets": 5,
              "data": "id_detalle_intervencion",
              "visible": (flag) ?false : false,
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
      "iDisplayLength": 15,
      "language": {
          "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
      },

  });
}
function grupoEntrega(){
  $('#grid-paises').DataTable().destroy();
  $cancelar.show();
  $guardar.show();
  loadDataTable(false);

  $cancelar.on('click', function(){
    location.reload();
  })
  $guardar.on('click', function(){
    $data = $(".checkbox-addIntv");
    $data.each(function(i, element){
      $this = $(this);
      if($this.is(":checked")){
        intervencion = new IntervencionItem();
        intervencion.id = $this.attr("item");
        data.push(intervencion);
      }
    });

    if(data.length > 0){
      //console.log(typeof(JSON.stringify(data));
    }/*else{
      alert('Debe seleccionar distribuciones')
    }*/
  });

}

$(function(){
  $cancelar.hide();
  $guardar.hide();
  loadDataTable(true);
});
</script>

@endsection
