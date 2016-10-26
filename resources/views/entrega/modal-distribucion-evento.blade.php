
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">
        <h4>
            NUEVA DISTRIBUCIÓN EN {{ $municipioModal }}
        </h4>
        </h4>
      </div>
      <div class="modal-body">
        <form class="form" method="POST" action="{{ url('entregas/distribucion-municipal/nuevo-distribucion-evento') }}" accept-charset="UTF-8">
        {!! csrf_field() !!}
        <input type="hidden" name="id_municipio" value="{{$idMunicipioModal}}">
        <input type="hidden" name="id_grupo_intervencion" value="{{$idGrupoIntervencion}}">
        <input type="hidden" name="id_movimiento" value="{{$movimiento->id}}">
        <div class="row">
          <div class="col-md-6">
              <fieldset class="form-group">
                <label for="departamento">Cantidad por Beneficiario</label>
                <input type="text" class="form-control" id="fecha_evento" name="cantidad_beneficiario" required>
              </fieldset>
          </div>
          <div class="col-md-6">
              <fieldset class="form-group">
                <label for="departamento">Cantidad de Beneficiarios</label>
                <input onkeypress="return isNumberKey(event)" type="text" class="form-control" id="nbeneficiario" name="nbeneficiario" required>
              </fieldset>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
              <fieldset class="form-group">

              </fieldset>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" type="submit">Guardar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
      </div>
      </form>
    </div>

  </div>
</div>


<script type="text/javascript">
  function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
</script>
