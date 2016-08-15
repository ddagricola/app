
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">
        <h4>
            NUEVA COMUNIDAD EN {{ $municipio->nombre }}
        </h4>
        </h4>
      </div>
      <div class="modal-body">
        <form class="form" method="POST" action="{{ url('movimiento/comunidad/evento-nuevo') }}" accept-charset="UTF-8">
        {!! csrf_field() !!}
        <input type="hidden" name="id_municipio" value="{{$municipio->id}}">
        <input type="hidden" name="id_detalle_intervencion" value="{{$id_detalle_intervencion}}">
        <div class="row">
          <div class="col-md-4">
            <fieldset class="form-group">
              <label for="pais">Lugar de entrega</label>
                <select class="form-control select2" style="width: 100%;" name="id_comunidad">
                  <option value="">Seleccione lugar de entrega</option>
                  @foreach($comunidades as $comunidad)
                    <option value="{{ $comunidad->id }}">{{$comunidad->division}} - {{$comunidad->comunidad}}</option>
                  @endforeach
                </select>
            </fieldset>
          </div>
          <div class="col-md-4">
              <fieldset class="form-group">
                <label for="departamento">Fecha de Evento</label>
                <input type="date" class="form-control" id="fecha_evento" name="fecha_evento" required>                 
              </fieldset>
          </div>
          <div class="col-md-4">
              <fieldset class="form-group">
                <label for="departamento">Cantidad de Beneficiarios</label>
                <input onkeypress="return isNumberKey(event)" type="text" class="form-control" id="nbeneficiario" name="nbeneficiario" required>
              </fieldset>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
              <fieldset class="form-group">
                <label for="departamento">Nombre Extensionista</label>
                <input type="text" class="form-control" id="nombre_extensionista" name="nombre_extensionista" required>                 
              </fieldset>
          </div>
          <div class="col-md-4">
              <fieldset class="form-group">
                <label for="departamento">DPI Extensionista</label>
                <input  onkeypress="return isNumberKey(event)" maxlength="13" type="text" class="form-control" id="dpi_extensionista" name="dpi_extensionista" required>                 
              </fieldset>
          </div>
          <div class="col-md-4">
              <fieldset class="form-group">
                <label onkeypress="return isNumberKey(event)" for="departamento">Teléfono Extensionista</label>
                <input maxlength="8" type="text" class="form-control" id="telefono_extensionista" name="telefono_extensionista" required>
              </fieldset>
          </div>
        </div>

<div class="alert alert-info">
  <strong>Precaución!</strong> 
    Si la lugar de entrega no existe o está mal escrito comuniquese con nosotros
    a través del soporte en linea.
</div>
        <!--<div class="row">
          <div class="col-md-12">
              <fieldset class="form-group">
                <label for="departamento">Nombre Jefe Departamental</label>
                <input type="text" class="form-control" id="nombre_jefe" name="nombre_jefe" required>                 
              </fieldset>
          </div>
        </div>-->
        <!--<div class="row">
          <div class="col-md-6">
              <fieldset class="form-group">
                <label for="departamento">DPI Jefe Departamental</label>
                <input onkeypress="return isNumberKey(event)" maxlength="13" type="text" class="form-control" id="dpi_nombre_jefe" name="dpi_nombre_jefe" required>                 
              </fieldset>
          </div>
        
          <div class="col-md-6">
              <fieldset class="form-group">
                <label for="departamento">Teléfono Jefe Departamental</label>
                <input onkeypress="return isNumberKey(event)" maxlength="8" type="text" class="form-control" id="telefono_nombre_jefe" name="telefono_nombre_jefe" required>                 
              </fieldset>
          </div>
        </div>-->
        <div class="row">
          <div class="col-md-12">
              <fieldset class="form-group">

              </fieldset>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" type="submit">Guardar Evento</button>
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