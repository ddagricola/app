$(function(){
	function validar(){
		error = 0;
		if($.trim($primer_nombre.val()) == ''){
			error = 1;
			$primer_nombre.parent().addClass('has-error');
		}else{
			$primer_nombre.parent().removeClass('has-error');
		}
		if($.trim($primer_apellido.val()) == ''){
			error = 1;
			$primer_apellido.parent().addClass('has-error');
		}else{
			$primer_apellido.parent().removeClass('has-error');
		}
		if($.trim($fecha_nacimiento.val()) == ''){
			error = 1;
			$fecha_nacimiento.parent().addClass('has-error');
		}else{
			$fecha_nacimiento.parent().removeClass('has-error');
		}
		/*if($.trim($edad.val()) == ''){
			error = 1;
			$edad.parent().addClass('has-error');
		}else{
			$edad.parent().removeClass('has-error');
		}*/
		if($.trim($estado_civil.val()) == ''){
			error = 1;
			$estado_civil.parent().addClass('has-error');
		}else{
			$estado_civil.parent().removeClass('has-error');
		}
		if($.trim($departamento_nacimiento.val()) == ''){
			error = 1;
			$departamento_nacimiento.parent().addClass('has-error');
		}else{
			$departamento_nacimiento.parent().removeClass('has-error');
		}
		if($.trim($municipio_nacimiento.val()) == ''){
			error = 1;
			$municipio_nacimiento.parent().addClass('has-error');
		}else{
			$municipio_nacimiento.parent().removeClass('has-error');
		}
		if($.trim($nacionalidad.val()) == ''){
			error = 1;
			$nacionalidad.parent().addClass('has-error');
		}else{
			$nacionalidad.parent().removeClass('has-error');
		}
		if($.trim($pueblo.val()) == ''){
			error = 1;
			$pueblo.parent().addClass('has-error');
		}else{
			$pueblo.parent().removeClass('has-error');
		}
		if($.trim($etnia.val()) == ''){
			error = 1;
			$etnia.parent().addClass('has-error');
		}else{
			$etnia.parent().removeClass('has-error');
		}
		return error;
	}
	$('.datepicker').datepicker({
		format: 'dd/mm/yyyy',
		 language: 'es'
	})
	.on('changeDate', function(e) {
        /*$this = $(this);
        $.ajax({
	        url: "../../../../beneficiario/edad",
	        type : 'GET',
	        data: {
	        	'nacimiento':$this.val()
	        },
	        error: function(){
	            alert('Ha ocurrido un error en el servidor')
	        },
	        success: function(data){
	            $("#edad").val(data.fecha);
	        }
    	});*/
    });


	$("#departamento_nacimiento").on("change", function(){
    	$.ajax({
	        url: "../../../../municipios/buscar/departamento"+"/"+$(this).val(),
	        type : 'GET',
	        error: function(){
	            alert('Ha ocurrido un error en el servidor')
	        },
	        success: function(data){
	            option = "<option value=''>Seleccione Municipio</option>";
	            $.each(data, function(index, value){
	                option += "<option value='"+value.id+"'>" + value.nombre + "</option>"
	            })

	            $("#municipio_nacimiento").html(option);
	        }
    	});
	});
	$("#registrar").on('click', function(){
		if(validar()==0){
			$.ajaxSetup({
        		headers: {
            		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        		}
      		});
			$.ajax({
		        url: "../../../../../distribuciones/beneficiario/ingreso",
		        type : 'POST',
		        data:{
		        	'cui': $.trim($("#cui").val()),
		        	'primer_nombre': $.trim($primer_nombre.val()),
		        	'segundo_nombre': $.trim($segundo_nombre.val()),
		        	'tercer_nombre': $.trim($tercer_nombre.val()),
		        	'primer_apellido': $.trim($primer_apellido.val()),
		        	'segundo_apellido': $.trim($segundo_apellido.val()),
		        	'apellido_casada': $.trim($apellido_casada.val()),
		        	'fecha_nacimiento': $.trim($fecha_nacimiento.val()),
		        	'estado_civil': $.trim($estado_civil.val()),
		        	'departamento_nacimiento': $.trim($departamento_nacimiento.val()),
		        	'municipio_nacimiento': $.trim($municipio_nacimiento.val()),
		        	'nacionalidad': $.trim($nacionalidad.val()),
		        	'pueblo': $.trim($pueblo.val()),
		        	'etnia': $.trim($etnia.val()),
		        	'genero': $genero.val(),
		        	'id':$id.val(),
		        	'event':$event.val(),
		        	'id_evento':$id_evento.val(),
		        	'leer': ($leer.is(":checked"))? 1 : 0,
		        	'escribir': ($escribir.is(":checked")) ? 1 : 0
		        },
		        error: function(error){
		            alert(error)
		        },
		        success: function(data){
		        	if(data.status == 200){
		        		alert(data.text);
		        		location.reload();
		        	}else{
		        		alert(data.text);
		        		location.reload();
		        	}
		            //location.reload();
		            //setData(data);
		        }
    		});
		}
	});
	$("#search").on('click', function(e){
		$cui = $("#cui");
		if($.isNumeric( $.trim($cui.val()) )  &&  $.trim($cui.val().length) == 13){
			$cui.parent().removeClass('has-error');
			 /*$.ajaxSetup({
        		headers: {
            		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        		}
      			});*/
      		$.ajax({
        		url: "../../../../beneficiario/cui/",
        		type : 'GET',
        		data: {	
          			'cui': $.trim($cui.val()),
        		},
        		error: function(){
          			alert('Ha ocurrido un error en el servidor')
        		},
        		beforeSend: function(){
        			$primer_nombre.val('');
					$segundo_nombre.val('');
					$tercer_nombre.val('');	
					$primer_apellido.val('');	
					$segundo_apellido.val('');	
					$apellido_casada.val('');	
        			$("#content-over").html('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
        		},
        		success: function(data){
        			setData(data);
        			//$("#content-over").empty();
        		}
      		});
      		//location.reload();
		}else{
			$cui.parent().addClass('has-error')
		}
	});

	function setData(data){
		if(data.length==0){
        				$("#lbl-cui").text("CUI NO ENCONTRADO");
        				$cui.parent().addClass('has-error');
        				$event.val("new");
        				$id.val(0);
        				$("#content-over").empty();

        			}else{
        				$.each(data, function(q, element){
        				$("#lbl-cui").text("CUI");
        				$cui.parent().removeClass('has-error');

        				if(element.event == "insert"){
        					$("#content-over").empty();
        				}
        				$id.val(element.id);
        				$primer_nombre.val(element.primer_nombre);
						$segundo_nombre.val(element.segundo_nombre);
						$tercer_nombre.val(element.tercer_nombre);	
						$primer_apellido.val(element.primer_apellido);	
						$segundo_apellido.val(element.segundo_apellido);	
						$apellido_casada.val(element.apellido_casada);
						$fecha_nacimiento.val(element.fecha_nacimiento_st);
						$event.val(element.event);
						if(element.leer == 1){
							$leer.prop('checked', true);
						}
						if(element.escribir == 1){
							$escribir.prop('checked', true);
						}
						$pueblo.children().each(function(a, index){
							if ($(this).val()==element.id_pueblo){
								$(this).prop('selected', true);
							}
						});

						$etnia.children().each(function(a, index){
							if ($(this).val()==element.id_etnia){
								$(this).prop('selected', true);
							}
						});

						$genero.children().each(function(a, index){
							if ($(this).val()==element.genero){
								$(this).prop('selected', true);
							}
						});
						$estado_civil.children().each(function(a, index){
							if ($(this).val()==element.estado_civil){
								$(this).prop('selected', true);
							}
						});
						$departamento_nacimiento.children().each(function(a, index){
							if ($(this).val()==element.id_departamento){
								$(this).prop('selected', true);
								$.ajax({
							        url: "../../../../municipios/buscar/departamento"+"/"+element.id_departamento,
							        type : 'GET',
							        error: function(){
							            alert('Ha ocurrido un error en el servidor')
							        },
							        success: function(data){
							            option = "<option value=''>Seleccione Municipio</option>";
							            $.each(data, function(index, value){
							                option += "<option value='"+value.id+"'>" + value.nombre + "</option>"
							            })

							            $("#municipio_nacimiento").html(option);
							            $("#municipio_nacimiento").children().each(function(a, index){
							            	if ($(this).val()==element.id_municipio){
							            		$(this).prop('selected', true);
							            		$("#content-over").empty();
							            	}
							            });
							        }
						    	});
							}
						});
        			});
        			}
	}
})