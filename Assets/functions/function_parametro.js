// JavaScript Document
$(document).ready(function(){

	multiEtapas();
	multiSoluciones();
	listarConsultaProceso();
	
	
});

function SoloNum() {
	if ((event.keyCode < 48) || (event.keyCode > 57)) 
  	event.returnValue = false;
}

function SoloLetras() {
 	if ((event.keyCode != 32) && (event.keyCode < 65) || (event.keyCode > 90) && (event.keyCode < 97) || (event.keyCode > 122) && (event.keyCode < 164))
  	event.returnValue = false;
}

function Validador(correo){
	var tester = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-]+)\.)+([a-zA-Z0-9]{2,4})+$/;
	return tester.test(correo);
}



/*================================================  FUNCTIONS PROCESO  ================================================*/
/*STEP 1*/
function crearProceso_radio(){
  	var accion = $('input:radio[name=radioProceso]:checked').val();
  	$(".itemConsulta input[type=checkbox]").prop('checked', false);
  	$(".itemConsulta input[type=text]").prop('disabled', true).val('');
  	$('#idProcesoConsulta').val('');
  	CboProceso(accion);
  	multiSoluciones();
  	multiEtapas();
  	$('#multiSolucion').prop('disabled', true);;
    $('#multiSolucion').selectpicker("refresh");
    $('#multiEtapa').prop('disabled', true);
    $('#multiEtapa').selectpicker("refresh");
  	$('#agregarCrearProceso').attr("disabled", true);
  	$('#tableCedulaProceso tbody').hide();
  	$('#tableActaProceso tbody').hide();
  	$('#tableDispositivoProceso tbody').hide();
  	$('#tableReservaProceso tbody').hide();
  	//$('#cbocrearProceso').selectpicker('refresh');
 	//alert(accion);
}


function CboProceso(accion){
	$.ajax({
	    type: "GET",
	    async : false,
	    url: base_url+'/Parametro/getSelectProceso/'+accion, 
	    success: function(data, textStatus, jqXHR){
	    	if(jqXHR.status == 200){
	            //console.log(data);
	            $("#cbocrearProceso").selectpicker('destroy');
	            $("#cbocrearProceso").html(data).selectpicker('refresh');
	            $('#multiSolucion').blur();
        		$('#multiEtapa').blur();
	        }
	    }
	});
}


function multiSoluciones(){
	$.ajax({
	    type: "GET",
	    async : false,
	    url: base_url+'/Parametro/getSelectSolucion', 
	    success: function(data, textStatus, jqXHR){
	    	if(jqXHR.status == 200){
	    		$("#multiSolucion").selectpicker('destroy');
	            $("#multiSolucion").html(data).selectpicker('refresh');
	            //console.log(data);
	            
	        }
	    }
	});
}


function multiEtapas(){
	$.ajax({
	    type: "GET",
	    async : false,
	    url: base_url+'/Parametro/getSelectEtapa', 
	    success: function(data, textStatus, jqXHR){
	    	if(jqXHR.status == 200){
	            //console.log(data);
	            $("#multiEtapa").selectpicker('destroy');
	            $("#multiEtapa").html(data).selectpicker('refresh');
	        }
	    }
	});
}


$("#cbocrearProceso").on("change", function() {
    $('#cbocrearProceso-error').hide();
    var proceso = $(this).val();
    var accion = $('input:radio[name=radioProceso]:checked').val();
    //$('#idProcesoConsulta').val(proceso);
    //setTimeout(function(){ 
    	if (proceso==0) { 
         	$('#sign_registerCrearProceso1')[0].reset();
          	$('#sign_registerCrearProceso1').validate().resetForm();
          	$('#multiSolucion').prop('disabled', true);;
          	$('#multiSolucion').selectpicker("refresh");
          	$('#multiEtapa').prop('disabled', true);
          	$('#multiEtapa').selectpicker("refresh");
          	$('#agregarCrearProceso').attr("disabled", true);

      	}else{
      		
      		$("#multiSolucion").prop('disabled', false);
      		$('#multiSolucion').selectpicker("refresh");
          	$("#multiEtapa").prop('disabled', false);
          	$('#multiEtapa').selectpicker("refresh");
          	$('#agregarCrearProceso').attr("disabled", false);
			
      	}
    //}, 100); 

    if(accion == 2){

    	//$('#idProcesoConsulta').val(proceso);
    	$('#idProcesoConsulta').val(proceso);
    	$('#idProcesoCedula').val(proceso);
    	$('#idProcesoActa').val(proceso);
		$('#idProcesoDispositivo').val(proceso);
		$('#idProcesoReserva').val(proceso);

    	cargaSolucion(proceso);
    	cargaEtapa(proceso);
    	cargaConsulta(proceso);

    	listarCedulaProceso(proceso);
    	listarActaProceso();
    	listarDispositivoProceso();
    	listarReservaProceso(proceso);
    	
    	cargaCedula(proceso);
    	cargaActa(proceso);
    	cargaDispositivo(proceso);
    	cargaReserva(proceso);
    }

});


function cargaSolucion(proceso){
	$.ajax({
	    type: "GET",
	    async : false,
	    url: base_url+'/Parametro/getCargaSolucion/'+proceso,
	    dataType:'json',
	    success: function(data, textStatus, jqXHR){
	    	if(jqXHR.status == 200){
	    		//console.log(data.data.SOLUCIONES);
	    		var solucion = data.data.SOLUCIONES.split(','); 
          		$('#multiSolucion').selectpicker('val', solucion);
			    return false;
	        }
	    }
	});
}


function cargaEtapa(proceso){
	$.ajax({
	    type: "GET",
	    async : false,
	    url: base_url+'/Parametro/getCargaEtapa/'+proceso,
	    dataType:'json',
	    success: function(data, textStatus, jqXHR){
	    	if(jqXHR.status == 200){
	    		//console.log(data.data.ETAPAS);
	    		var etapa = data.data.ETAPAS.split(','); 
          		$('#multiEtapa').selectpicker('val', etapa);
			    return false;
	        }
	    }
	});
}


$("#multiSolucion").on("change", function() {
    $('#multiSolucion-error').hide();
});

$("#multiEtapa").on("change", function() {
    $('#multiEtapa-error').hide();
});


$("#sign_registerCrearProceso1").submit(function(){

	var proceso 	= $("#cbocrearProceso").val();
	var solucion 	= $("#multiSolucion").val();
	var etapa 		= $("#multiEtapa").val();
	var total 		= proceso.length * solucion.length * etapa.length;

	var requesCrearProceso 					= new Object();
	requesCrearProceso["IdProceso"]			= $("#txtIDProceso").val();
    requesCrearProceso["controlProceso"]	= $("#txtcontrolProceso").val();
    requesCrearProceso["proceso"]			= $("#cbocrearProceso").val();
    requesCrearProceso["soluciones"]		= $("#multiSolucion").val();
    requesCrearProceso["etapas"]			= $("#multiEtapa").val();

	if(total > 0){
		//alert(1);
		$.ajax({
            url: base_url+'/Parametro/setCrearProceso',
	        type: "POST",     
	        dataType: 'json',
	        data:requesCrearProceso,    
	        cache: false,
	        	
	        success: function(data, textStatus, jqXHR){
	        	console.log(data.msg);

	        	if(jqXHR.status == 200){
	        		if(data.status){
						// console.log(textStatus);
		        		// console.log(jqXHR.status);
		        		swal(data.title, data.msg, "success");
		        		$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
		        		$('#idProcesoConsulta').val(proceso);
		        		return false;

	        		}else{
		        		swal({  title: 	data.title,
							    text: 	data.msg,
							    type: 	"error"},
							    function(){ 
							    	setTimeout(function() {

							    	}, 10)
								});
		        		$('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
		        		return false;
		        	}
		        }

            },
            error: function(jqXHR,textStatus,errorThrown){
            	console.log(errorThrown);
            	// console.log(textStatus);
        		// console.log(jqXHR.status);
        	}
        });

        return false;
	}

	return false;
});



/*STEP 2*/
function listarConsultaProceso(){
	$.ajax({
	    type: "GET",
	    async : false,
	    url: base_url+'/Parametro/getConsultas', 
	    success: function(data, textStatus, jqXHR){
	    	if(jqXHR.status == 200){
	            //console.log(data);
	            $("#tableConsultaProceso tbody").html(data);
	        }
	    }
	});
}


function checkEnable(id){
  if( $('#chkConsulta'+id).is(':checked') ) {
    $('#nropaquete'+id).attr('disabled',false).focus();
    $('#nrocartel'+id).attr('disabled',false);
  }else{
    $('#nropaquete'+id).attr('disabled',true).val('');
    $('#nrocartel'+id).attr('disabled',true).val('');
  }
}


function cargaConsulta(proceso){
    $(".itemConsulta input[type=checkbox]").prop('checked', false);
    $(".itemConsulta input[type=text]").prop('disabled', true).val('');

    $.ajax({
	    type: "GET",
	    async : false,
	    url: base_url+'/Parametro/getCargaConsulta/'+proceso,
	    dataType:'json',
	    success: function(data, textStatus, jqXHR){
	    	if(jqXHR.status == 200){
	    		
	    		$.each(data.data, function(i,row){
	                $('#chkConsulta'+row.ID_CONSULTA).prop('checked', true);;
	                $('#nropaquete'+row.ID_CONSULTA).val(row.CANTIDAD_PAQUETES).attr('disabled', false);
	                $('#nrocartel'+row.ID_CONSULTA).val(row.CANTIDAD_CARTELES).attr('disabled', false);
            	});
          		
			    return false;
	        }
	    }
	});
}


function agruparConsulta(){
	var detalle;
	var detalles =  new Array();
	$("#tableConsultaProceso input:checkbox:checked").each(function() {
		var idConsulta 	= $(this).val();
		var cantPaquete = ($('#nropaquete'+idConsulta).val() != '' ) ? $('#nropaquete'+idConsulta).val() : 0 ;
		var cantCartel 	= ($('#nrocartel'+idConsulta).val() != '') ? $('#nrocartel'+idConsulta).val() : 0;
		detalle = new Object();
		detalle['idConsulta'] 	= idConsulta;
		detalle['cantPaquete'] 	= cantPaquete;
		detalle['cantCartel']	= cantCartel;
		detalles.push(detalle);
		//alert(idConsulta+' - '+cantPaquete+' - '+cantCartel);
	});
    return detalles;         
}


function guardarConsulta(){
	
	var idProcesoConsulta = $('#idProcesoConsulta').val();
	var total 	= idProcesoConsulta.length;

	var requestConsultaPorceso 			= new Object();
	requestConsultaPorceso["proceso"]	= $("#idProcesoConsulta").val();
	requestConsultaPorceso["consultas"]	= JSON.stringify(agruparConsulta());

	var TABLA   = $("#tableConsultaProceso input:checkbox:checked");

	if (total>0){ 

		if (TABLA.length === 0) {
	      swal("Alerta!", "Debe seleccionar minimo una Consulta Electoral", "warning");
	      $('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').addClass('btn btn-warning');
	      return false;
  
  		}else{
  			$('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').removeClass('btn btn-info').removeClass('btn btn-warning');
	        swal({  title: "¿Esta seguro de Guardar las Consultas?",
	            text: "Los campos vacios se consideran como cantidad 0. \n No podrás deshacer este paso...",
	            type: "warning",
	            showCancelButton: true,
	            cancelButtonText: "Cancelar",
	            confirmButtonColor: "#ff9600",
	            confirmButtonText: "Aceptar",
	            closeOnConfirm: false },
	            function(){
		  			$.ajax({
			            url: base_url+'/Parametro/setConsultaProceso',
				        type: "POST",     
				        dataType: 'json',
				        data:requestConsultaPorceso,    
				        cache: false,
				        	
				        success: function(data, textStatus, jqXHR){
				        	//console.log(data.msg);
				        	if(jqXHR.status == 200){
				        		if(data.status){
									/*console.log(textStatus);
					        		console.log(jqXHR.status);*/
					        		swal(data.title, data.msg, "success");
					        		$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
					        		$('#idProcesoCedula').val($("#cbocrearProceso").val());
				                    $('#idProcesoActa').val($("#cbocrearProceso").val());
				                    $('#idProcesoDispositivo').val($("#cbocrearProceso").val());
				                    $('#idProcesoReserva').val($("#cbocrearProceso").val());
				                    listarCedulaProceso(idProcesoConsulta);
				                    listarActaProceso(idProcesoConsulta);
				                    listarDispositivoProceso(idProcesoConsulta);
				                    listarReservaProceso(idProcesoConsulta);
					        		return false;

				        		}else{
					        		swal({  title: 	data.title,
										    text: 	data.msg,
										    type: 	"error"},
										    function(){ 
										    	setTimeout(function() {
										          //$('#txtpedido').focus();
										    	}, 10)
											});
					        		$('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
					        		return false;
					        	}
					        }

			            },
			            error: function(jqXHR,textStatus,errorThrown){
			            	console.log(errorThrown);
			            	/*console.log(textStatus);
			        		console.log(jqXHR.status);*/
			        	}
			        });
			        return false;
 			});
		}


	}else{
		swal("Alerta!", "No ha guardado el Proceso Electoral en el Paso 1", "warning");
		$('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').addClass('btn btn-warning');
		return false;
	}
}




/*STEP 3*/
function listarCedulaProceso(proceso){ 
    $.ajax({
	    type: "GET",
	    async : false,
	    url: base_url+'/Parametro/getCedulaProceso/'+proceso, 
	    success: function(data, textStatus, jqXHR){
	    	if(jqXHR.status == 200){
	            //console.log(data);
	            $("#tableCedulaProceso tbody").html(data).show();
	        }
	    }
	});
}


function cargaCedula(proceso){
    
    $.ajax({
	    type: "GET",
	    async : false,
	    url: base_url+'/Parametro/getCargaCedula/'+proceso,
	    dataType:'json',
	    success: function(data, textStatus, jqXHR){
	    	if(jqXHR.status == 200){
	    		
	    		$.each(data.data, function(i,row){
	                
	                $('#tipo'+row.ID_CONSULTA+row.ORDEN).val(row.TIPO_CEDULA);
	                $('#totalDigUbigeo'+row.ID_CONSULTA+row.ORDEN).val(row.DIG_UBIGEO);
	                $('#prefUbigeo'+row.ID_CONSULTA+row.ORDEN).val(row.PREF_UBIGEO);
	                $('#sufUbigeo'+row.ID_CONSULTA+row.ORDEN).val(row.SUF_UBIGEO);
	                $('#totalDigRotulo'+row.ID_CONSULTA+row.ORDEN).val(row.DIG_ROTULO);
	                $('#prefRotulo'+row.ID_CONSULTA+row.ORDEN).val(row.PREF_ROTULO);
	                $('#sufRotulo'+row.ID_CONSULTA+row.ORDEN).val(row.SUF_ROTULO);
            	});
			    return false;
	        }
	    }
	});
}


function agruparCedula(){
	var detalle;
	var detalles =  new Array();
	$("#tableCedulaProceso tbody > tr.itemCedula").each(function() {
		var id 			= $(this).find('input#idvalue').val();
		var idConsulta 	= $(this).find('input#idConsulta').val();
		var orden 		= $(this).find('input#orden').val();
		var tipo 		= $(this).find("input#tipo"+id).val();

		var digUbigeo 	= ($(this).find("input#totalDigUbigeo"+id).val() != '' ) ? $(this).find("input#totalDigUbigeo"+id).val() : 0 ;
	    var prefUbigeo 	= $(this).find("input#prefUbigeo"+id).val();
	    var sufUbigeo 	= $(this).find("input#sufUbigeo"+id).val();

	    var digRotulo 	= ($(this).find("input#totalDigRotulo"+id).val() != '' ) ? $(this).find("input#totalDigRotulo"+id).val() : 0 ;
	    var prefRotulo 	= $(this).find("input#prefRotulo"+id).val();
	    var sufRotulo 	= $(this).find("input#sufRotulo"+id).val();

		detalle = new Object();
		detalle['id'] 			= id;
		detalle['idConsulta'] 	= idConsulta;
		detalle['orden'] 		= orden;
		detalle['tipo'] 		= tipo;

		detalle["digUbigeo"]	= digUbigeo;
      	detalle['prefUbigeo']	= prefUbigeo;
      	detalle["sufUbigeo"]	= sufUbigeo;

      	detalle["digRotulo"]	= digRotulo;
      	detalle['prefRotulo']	= prefRotulo;
      	detalle["sufRotulo"]	= sufRotulo;

		detalles.push(detalle);
		//alert(id +' - '+idConsulta+' - '+orden+' - '+tipo+' - '+digUbigeo+' - '+prefUbigeo+' - '+sufUbigeo+' - '+digRotulo+' - '+prefRotulo+' - '+sufRotulo);
	});
    return detalles;         
}


function guardarCedulas(){
	
	var idProcesoCedula = $('#idProcesoCedula').val();
	var total 	= idProcesoCedula.length;

	var requestCedulaPorceso 			= new Object();
	requestCedulaPorceso["proceso"]		= $("#idProcesoCedula").val();
	requestCedulaPorceso["codCedula"]	= JSON.stringify(agruparCedula());

	if (total>0){ 

  			$('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').removeClass('btn btn-info').removeClass('btn btn-warning');
	        swal({  title: "¿Esta seguro de Guardar los Códigos de Cedulas?",
	            text: "Los campos vacios se consideran como cantidad 0. \n No podrás deshacer este paso...",
	            type: "warning",
	            showCancelButton: true,
	            cancelButtonText: "Cancelar",
	            confirmButtonColor: "#ff9600",
	            confirmButtonText: "Aceptar",
	            closeOnConfirm: false },
	            function(){
		  			$.ajax({
			            url: base_url+'/Parametro/setCedulaProceso',
				        type: "POST",     
				        dataType: 'json',
				        data:requestCedulaPorceso,    
				        cache: false,
				        	
				        success: function(data, textStatus, jqXHR){
				        	//console.log(data.msg);
				        	if(jqXHR.status == 200){
				        		if(data.status){
									/*console.log(textStatus);
					        		console.log(jqXHR.status);*/
					        		swal(data.title, data.msg, "success");
					        		$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
					        		return false;

				        		}else{
					        		swal({  title: 	data.title,
										    text: 	data.msg,
										    type: 	"error"},
										    function(){ 
										    	setTimeout(function() {
										          //$('#txtpedido').focus();
										    	}, 10)
											});
					        		$('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
					        		return false;
					        	}
					        }

			            },
			            error: function(jqXHR,textStatus,errorThrown){
			            	console.log(errorThrown);
			            	/*console.log(textStatus);
			        		console.log(jqXHR.status);*/
			        	}
			        });
			        return false;
 			});
		


	}else{
		swal("Alerta!", "No ha guardado el Proceso Electoral en el Paso 1", "warning");
		$('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').addClass('btn btn-warning');
		return false;
	}
}




/*STEP 4*/
function listarActaProceso(){ 
    $.ajax({
	    type: "GET",
	    async : false,
	    url: base_url+'/Parametro/getActaProceso/', 
	    success: function(data, textStatus, jqXHR){
	    	if(jqXHR.status == 200){
	            //console.log(data);
	            $("#tableActaProceso tbody").html(data).show();
	        }
	    }
	});
}


function longitudActa(id){
	var total = $('#cantidadDig'+id).val();
	var codigo = $('#cantidadCod'+id).val().trim().length;
	var resto = total - codigo;
	$('#cantidadResto'+id).val(resto);
}


function cargaActa(proceso){
    
    $.ajax({
	    type: "GET",
	    async : false,
	    url: base_url+'/Parametro/getCargaActa/'+proceso,
	    dataType:'json',
	    success: function(data, textStatus, jqXHR){
	    	if(jqXHR.status == 200){
	    		
	    		$.each(data.data, function(i,row){
	                
	                var code = (row.CODIGO == null ) ? '' : row.CODIGO;
                	$('#cantidadDig'+row.ID_MATERIAL).val(row.DIGITO);
                	$('#cantidadCod'+row.ID_MATERIAL).val(row.CODIGO);
                	$('#cantidadResto'+row.ID_MATERIAL).val(row.DIGITO-code.length);

            	});
			    return false;
	        }
	    }
	});
}


function agruparActa(){
	var detalle;
	var detalles =  new Array();
	$("#tableActaProceso tbody > tr.itemActa").each(function() {
		var idMaterial 	= $(this).find("input#idMaterial").val();
		var digitos 	= ($(this).find("input#cantidadDig"+idMaterial).val() != '' ) ? $(this).find("input#cantidadDig"+idMaterial).val() : 0 ;
	    var codigo 		= $(this).find("input#cantidadCod"+idMaterial).val();

		detalle = new Object();
		detalle['idMaterial'] 	= idMaterial;
		detalle["digitos"]		= digitos;
      	detalle['codigo']		= codigo;

		detalles.push(detalle);
		//alert(idMaterial +' - '+digitos+' - '+codigo);
	});
    return detalles;         
}


function guardarActa(){
	
	var idProcesoActa 	= $('#idProcesoActa').val();
	var total 			= idProcesoActa.length;

	var requestActaPorceso 			= new Object();
	requestActaPorceso["proceso"]	= $("#idProcesoActa").val();
	requestActaPorceso["codActa"]	= JSON.stringify(agruparActa());

	if (total>0){ 

  			$('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').removeClass('btn btn-info').removeClass('btn btn-warning');
	        swal({  title: "¿Esta seguro de Guardar los Códigos de Acta Padrón?",
	            text: "Los campos vacios se consideran como cantidad 0. \n No podrás deshacer este paso...",
	            type: "warning",
	            showCancelButton: true,
	            cancelButtonText: "Cancelar",
	            confirmButtonColor: "#ff9600",
	            confirmButtonText: "Aceptar",
	            closeOnConfirm: false },
	            function(){
		  			$.ajax({
			            url: base_url+'/Parametro/setActaProceso',
				        type: "POST",     
				        dataType: 'json',
				        data:requestActaPorceso,    
				        cache: false,
				        	
				        success: function(data, textStatus, jqXHR){
				        	//console.log(data.msg);
				        	if(jqXHR.status == 200){
				        		if(data.status){
									/*console.log(textStatus);
					        		console.log(jqXHR.status);*/
					        		swal(data.title, data.msg, "success");
					        		$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
					        		return false;

				        		}else{
					        		swal({  title: 	data.title,
										    text: 	data.msg,
										    type: 	"error"},
										    function(){ 
										    	setTimeout(function() {
										          //$('#txtpedido').focus();
										    	}, 10)
											});
					        		$('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
					        		return false;
					        	}
					        }

			            },
			            error: function(jqXHR,textStatus,errorThrown){
			            	console.log(errorThrown);
			            	/*console.log(textStatus);
			        		console.log(jqXHR.status);*/
			        	}
			        });
			        return false;
 			});
		


	}else{
		swal("Alerta!", "No ha guardado el Proceso Electoral en el Paso 1", "warning");
		$('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').addClass('btn btn-warning');
		return false;
	}
}




/*STEP 5*/
function listarDispositivoProceso(){ 
    $.ajax({
	    type: "GET",
	    async : false,
	    url: base_url+'/Parametro/getDispositivoProceso/', 
	    success: function(data, textStatus, jqXHR){
	    	if(jqXHR.status == 200){
	            //console.log(data);
	            $("#tableDispositivoProceso tbody").html(data).show();
	        }
	    }
	});
}


function longitudDispositivo(id){
  var total = $('#cantidadDig'+id).val();
  var prefijo = $('#cantidadPre'+id).val().trim().length;
  var codigo = $('#cantidadCod'+id).val().trim().length;
  var resto = total - prefijo - codigo;
  /*var cod = 'C'.repeat(resto);
  var estructura = $('#cantidadPre'+id).val()+'{'+cod+'}'+$('#cantidadCod'+id).val()+'{NNNNNN}';*/
  $('#cantidadResto'+id).val(resto); 
}


function cargaDispositivo(proceso){
    
    $.ajax({
	    type: "GET",
	    async : false,
	    url: base_url+'/Parametro/getCargaDispositivo/'+proceso,
	    dataType:'json',
	    success: function(data, textStatus, jqXHR){
	    	if(jqXHR.status == 200){
	    		//console.log('OK: '+data);
	    		$.each(data.data, function(i,row){
	                
	                var codePre = (row.PREFIJO == null ) ? '' : row.PREFIJO;
                	var codeSuf = (row.CODIGO == null ) ? '' : row.CODIGO;

                	$('#cantidadDig'+row.ID_MATERIAL+row.TIPO).val(row.DIGITO);
                	$('#cantidadPre'+row.ID_MATERIAL+row.TIPO).val(row.PREFIJO);
                	$('#cantidadCod'+row.ID_MATERIAL+row.TIPO).val(row.CODIGO);
                	$('#cantidadResto'+row.ID_MATERIAL+row.TIPO).val(row.DIGITO-(codePre.length+codeSuf.length));

            	});
			    return false;
	        }
	    }
	});
}


function agruparDispositivo(){
	var detalle;
	var detalles =  new Array();
	$("#tableDispositivoProceso tbody > tr.itemDispositivo").each(function() {
		var idMaterial 	= $(this).find("input#idMaterial").val();
		var idTipo 		= $(this).find("input#idvalue").val();
		var digitos 	= ($(this).find("input#cantidadDig"+idMaterial+idTipo).val() != '' ) ? $(this).find("input#cantidadDig"+idMaterial+idTipo).val() : 0 ;
	    var prefijo 	= $(this).find("input#cantidadPre"+idMaterial+idTipo).val();
	    var codigo 		= $(this).find("input#cantidadCod"+idMaterial+idTipo).val();

		detalle = new Object();
		detalle['idMaterial'] 	= idMaterial;
		detalle["digitos"]		= digitos;
      	detalle['prefijo']		= prefijo;
      	detalle['codigo']		= codigo;
      	detalle['tipo']			= idTipo;

		detalles.push(detalle);
		//alert(idMaterial +' - '+digitos+' - '+prefijo+' - '+codigo);
	});
    return detalles;         
}


function guardarDispositivo(){
	
	var idProcesoDispositivo 	= $('#idProcesoDispositivo').val();
	var total 					= idProcesoDispositivo.length;

	var requestDispositivoPorceso 				= new Object();
	requestDispositivoPorceso["proceso"]		= $("#idProcesoDispositivo").val();
	requestDispositivoPorceso["codDispositivo"]	= JSON.stringify(agruparDispositivo());

	if (total>0){ 

  			$('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').removeClass('btn btn-info').removeClass('btn btn-warning');
	        swal({  title: "¿Esta seguro de Guardar los Códigos de Dispositivos?",
	            text: "Los campos vacios se consideran como cantidad 0. \n No podrás deshacer este paso...",
	            type: "warning",
	            showCancelButton: true,
	            cancelButtonText: "Cancelar",
	            confirmButtonColor: "#ff9600",
	            confirmButtonText: "Aceptar",
	            closeOnConfirm: false },
	            function(){
		  			$.ajax({
			            url: base_url+'/Parametro/setDispositivoProceso',
				        type: "POST",     
				        dataType: 'json',
				        data:requestDispositivoPorceso,    
				        cache: false,
				        	
				        success: function(data, textStatus, jqXHR){
				        	//console.log(data.msg);
				        	if(jqXHR.status == 200){
				        		if(data.status){
									/*console.log(textStatus);
					        		console.log(jqXHR.status);*/
					        		swal(data.title, data.msg, "success");
					        		$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
					        		return false;

				        		}else{
					        		swal({  title: 	data.title,
										    text: 	data.msg,
										    type: 	"error"},
										    function(){ 
										    	setTimeout(function() {
										          //$('#txtpedido').focus();
										    	}, 10)
											});
					        		$('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
					        		return false;
					        	}
					        }

			            },
			            error: function(jqXHR,textStatus,errorThrown){
			            	console.log(errorThrown);
			            	/*console.log(textStatus);
			        		console.log(jqXHR.status);*/
			        	}
			        });
			        return false;
 			});
		


	}else{
		swal("Alerta!", "No ha guardado el Proceso Electoral en el Paso 1", "warning");
		$('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').addClass('btn btn-warning');
		return false;
	}
}




/*STEP 6*/
function listarReservaProceso(proceso){ 
    $.ajax({
	    type: "GET",
	    async : false,
	    url: base_url+'/Parametro/getReservaProceso/'+proceso, 
	    success: function(data, textStatus, jqXHR){
	    	if(jqXHR.status == 200){
	            //console.log(data);
	            $("#tableReservaProceso tbody").html(data).show();
	        }
	    }
	});
}


function cargaReserva(proceso){
    
    $.ajax({
	    type: "GET",
	    async : false,
	    url: base_url+'/Parametro/getCargareserva/'+proceso,
	    dataType:'json',
	    success: function(data, textStatus, jqXHR){
	    	if(jqXHR.status == 200){
	    		
	    		$.each(data.data, function(i,row){
	                
	                $('#tipoRes'+row.ID_CONSULTA+row.ORDEN).val(row.TIPO_CEDULA);
	                $('#totalDigResUbigeo'+row.ID_CONSULTA+row.ORDEN).val(row.DIG_UBIGEO);
	                $('#prefResUbigeo'+row.ID_CONSULTA+row.ORDEN).val(row.PREF_UBIGEO);
	                $('#sufResUbigeo'+row.ID_CONSULTA+row.ORDEN).val(row.SUF_UBIGEO);
	                $('#totalDigResRotulo'+row.ID_CONSULTA+row.ORDEN).val(row.DIG_ROTULO);
	                $('#prefResRotulo'+row.ID_CONSULTA+row.ORDEN).val(row.PREF_ROTULO);
	                $('#sufResRotulo'+row.ID_CONSULTA+row.ORDEN).val(row.SUF_ROTULO);
	                $('#codResConsulta'+row.ID_CONSULTA+row.ORDEN).val(row.COD_CONSULTA);
            	});
			    return false;
	        }
	    }
	});
}


function agruparReserva(){
	var detalle;
	var detalles =  new Array();
	$("#tableReservaProceso tbody > tr.itemReserva").each(function() {
		var id 				= $(this).find('input#idvalueRes').val();
		var idConsulta 		= $(this).find('input#idConsultaRes').val();
		var orden 			= $(this).find('input#orden').val();
		var tipo 			= $(this).find("input#tipoRes"+id).val();

		var digResUbigeo 	= ($(this).find("input#totalDigResUbigeo"+id).val() != '' ) ? $(this).find("input#totalDigResUbigeo"+id).val() : 0 ;
	    var prefResUbigeo 	= $(this).find("input#prefResUbigeo"+id).val();
	    var sufResUbigeo 	= $(this).find("input#sufResUbigeo"+id).val();

	    var digResRotulo 	= ($(this).find("input#totalDigResRotulo"+id).val() != '' ) ? $(this).find("input#totalDigResRotulo"+id).val() : 0 ;
	    var prefResRotulo 	= $(this).find("input#prefResRotulo"+id).val();
	    var sufResRotulo 	= $(this).find("input#sufResRotulo"+id).val();

	    var codResConsulta	= $(this).find("input#codResConsulta"+id).val();

		detalle = new Object();
		detalle['id'] 				= id;
		detalle['idConsulta'] 		= idConsulta;
		detalle['orden'] 			= orden;
		detalle['tipo'] 			= tipo;

		detalle["digResUbigeo"]		= digResUbigeo;
      	detalle['prefResUbigeo']	= prefResUbigeo;
      	detalle["sufResUbigeo"]		= sufResUbigeo;

      	detalle["digResRotulo"]		= digResRotulo;
      	detalle['prefResRotulo']	= prefResRotulo;
      	detalle["sufResRotulo"]		= sufResRotulo;

      	detalle["codResConsulta"]	= codResConsulta;

		detalles.push(detalle);
		//alert(id +' - '+idConsulta+' - '+orden+' - '+tipo+' - '+digResUbigeo+' - '+prefResUbigeo+' - '+sufResUbigeo+' - '+digResRotulo+' - '+prefResRotulo+' - '+sufResRotulo+' - '+codResConsulta);
	});
    return detalles;         
}


function guardarReserva(){
	
	var idProcesoReserva = $('#idProcesoReserva').val();
	var total 	= idProcesoReserva.length;

	var requestReservaPorceso 			= new Object();
	requestReservaPorceso["proceso"]	= $("#idProcesoReserva").val();
	requestReservaPorceso["codReserva"]	= JSON.stringify(agruparReserva());

	if (total>0){ 

  			$('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').removeClass('btn btn-info').removeClass('btn btn-warning');
	        swal({  title: "¿Esta seguro de Guardar los Códigos de Cedulas De Reserva?",
	            text: "Los campos vacios se consideran como cantidad 0. \n No podrás deshacer este paso...",
	            type: "warning",
	            showCancelButton: true,
	            cancelButtonText: "Cancelar",
	            confirmButtonColor: "#ff9600",
	            confirmButtonText: "Aceptar",
	            closeOnConfirm: false },
	            function(){
		  			$.ajax({
			            url: base_url+'/Parametro/setreservaProceso',
				        type: "POST",     
				        dataType: 'json',
				        data:requestReservaPorceso,    
				        cache: false,
				        	
				        success: function(data, textStatus, jqXHR){
				        	//console.log(data.msg);
				        	if(jqXHR.status == 200){
				        		if(data.status){
									/*console.log(textStatus);
					        		console.log(jqXHR.status);*/
					        		swal(data.title, data.msg, "success");
					        		$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
					        		return false;

				        		}else{
					        		swal({  title: 	data.title,
										    text: 	data.msg,
										    type: 	"error"},
										    function(){ 
										    	setTimeout(function() {
										          //$('#txtpedido').focus();
										    	}, 10)
											});
					        		$('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
					        		return false;
					        	}
					        }

			            },
			            error: function(jqXHR,textStatus,errorThrown){
			            	console.log(errorThrown);
			            	/*console.log(textStatus);
			        		console.log(jqXHR.status);*/
			        	}
			        });
			        return false;
 			});
		


	}else{
		swal("Alerta!", "No ha guardado el Proceso Electoral en el Paso 1", "warning");
		$('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').addClass('btn btn-warning');
		return false;
	}
}
