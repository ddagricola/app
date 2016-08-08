function borrar(item){
  $("#state_"+item).val('delete');
  $("#row_"+item).css('display','none');
}
/*$(".delete").on('click', function(e){
                $this = $(this);
                item = $this.attr('item');
                $("#state_"+item).val('delete');
                //$("#row_"+item).remove();
              })
*/
$(function(){
  var error = 0;
  var data = new Array();
  $("#save").on('click', function(e){
    error = 0;
    data = [];
    
    if($("#content-detalle tr").length > 0){
      $("#content-detalle tr").each(function(i, element){
        $this = $(this);
        detalle = new DetalleIntervencion;
        i = i + 1;
        id_municipio = $this.children().find('select.jsmunicipio').val();
        id_medida = $this.children().find('select.jsmedida').val();
        //id_fuente = $this.children().find('select.jsfuente').val();
        //id_renglon = $this.children().find('select.jsrenglon').val();
        //id_partida = $this.children().find('select.jspartida').val();     
        cantidad = $this.children().find('input.jscantidad').val();
        precio = $this.children().find('input.jsprecio').val();
        beneficiario = $this.children().find('input.jsbeneficiario').val();
        id_detalle = $this.children().find('input.jsid').val();
        state  = $this.children().find('input.jsstate').val();
        cantidad_beneficiario  = $this.children().find('input.jscantidadBeneficiario').val();
        medida_entrega  = $this.children().find('select.jsmedidaEntrega').val();
        
        if(id_municipio==''){
          $this.children().find('#municipio_'+i).parent().addClass('has-error')
          error = 1;
        }else{
          $this.children().find('#municipio_'+i).parent().removeClass('has-error')
          detalle.id_municipio = id_municipio;
        }
        if(id_medida==''){
          $this.children().find('#medida_'+i).parent().addClass('has-error')
          error = 1;
        }else{
          $this.children().find('#medida_'+i).parent().removeClass('has-error')
          detalle.id_medida = id_medida;
        }

        if(medida_entrega==''){
          $this.children().find('#medida_entrega_'+i).parent().addClass('has-error')
          error = 1;
        }else{
          $this.children().find('#medida_entrega_'+i).parent().removeClass('has-error')
          detalle.medida_entrega = medida_entrega;
        }

        if(cantidad_beneficiario==''){
          $this.children().find('#cantidad_beneficiario_'+i).parent().addClass('has-error')
          error = 1;
        }else{
          $this.children().find('#cantidad_beneficiario_'+i).parent().removeClass('has-error')
          detalle.cantidad_beneficiario = cantidad_beneficiario;
        }

        /*if(id_fuente==''){
          $this.children().find('#fuente_'+i).parent().addClass('has-error')
          error = 1;
        }else{
          $this.children().find('#fuente_'+i).parent().removeClass('has-error')
          detalle.id_fuente = id_fuente;
        }

        if(id_renglon==''){
          $this.children().find('#renglon_'+i).parent().addClass('has-error')
          error = 1;
        }else{
          $this.children().find('#renglon_'+i).parent().removeClass('has-error')
          detalle.id_renglon = id_renglon;
        }

        if(id_partida=='' || id_partida=='Seleccione partida' || id_partida == 0 || id_partida==null ){
          $this.children().find('#partida_'+i).parent().addClass('has-error')
          error = 1;
        }else{
          $this.children().find('#partida_'+i).parent().removeClass('has-error')
          detalle.id_partida = id_partida;
        }*/

        if( cantidad =='' || cantidad == 0 ){
          $this.children().find('#cantidad_'+i).parent().addClass('has-error')
          error = 1;
        }else{
          $this.children().find('#cantidad_'+i).parent().removeClass('has-error')
          detalle.cantidad = cantidad;
        }

        if( precio =='' || precio == 0 ){
          $this.children().find('#precio_'+i).parent().addClass('has-error')
          error = 1;
        }else{
          $this.children().find('#precio_'+i).parent().removeClass('has-error')
          detalle.precio = precio;
        }

        if( beneficiario =='' || beneficiario == 0 ){
          $this.children().find('#beneficiario_'+i).parent().addClass('has-error')
          error = 1;
        }else{
          $this.children().find('#beneficiario_'+i).parent().removeClass('has-error')
          detalle.beneficiario = beneficiario;
        }

        detalle.id = id_detalle;
        detalle.state = state;

        data.push(detalle);
      });
      //-- fin foreach
    }else{
      error = 1;
      alert('Ingresa datos para poder guardar.')
    }

    /***** SAVE ******/
    if(error == 0){
      console.log(data)
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url: "../../intervenciones/detalle-intervencion/guardar",
        type : 'POST',
        data: {
          'data':data,
          'id_intervencion':$("#id_intervencion").val()
        },
        error: function(){
          alert('Ha ocurrido un error en el servidor')
        },
        success: function(data){
          //location.href = "../../intervenciones/listado";
          location.reload()
        }
      });
    }
  });

	$("#add").on('click', function(){
		 $.ajax({
            url: "../../detalle-intervencion/detalle"+"/"+item,
            type : 'GET',
            data: {
              'id_departamento': $("#departamento").val()
            },
            error: function(){
              alert('Ha ocurrido un error en el servidor')
            },
            success: function(data){
              $("#content-detalle").append(data);

              // BOTON DE ELIMINAR
              /*$(".deletes").on('click', function(e){
                alert(item)
                $this = $(this);
                item = $this.attr('item');
                $("#state_"+item).val('delete');
              })*/


              $(".jsrenglon").change(function(){
              	$this = $(this);
              	$fuente = $("#fuente_"+$this.attr("item"));
                $municipio = $("#municipio_"+$this.attr("item"));
              	if ($fuente.val() != ''){
              		$.ajax({
  			            url: "../../detalle-intervencion/partida",
  			            type : 'GET',
  			            data: {
  			            	'fuente': $fuente.val(),
  			            	'renglon': $this.val(),
                      'municipio': $municipio.val(),
  			            },
  			            error: function(){
  			              alert('Ha ocurrido un error en el servidor')
  			            },
  			            success: function(data){
  			              option = "<option val='0'>Seleccione partida</option>";
                      $.each(data, function(index, value){
                          option += "<option value='"+value.id+"'>" + value.codigo + "</option>"
                      })

                      $("#partida_"+$this.attr("item")).html(option);
  			            }
		        	    });
              	}else{
              		alert('Seleccione fuente de financiamiento.')
                  $("select#renglon_"+$this.attr("item"))[0].selectedIndex = 0;
              	}
              });
              item++;
            }
        });
	})
});