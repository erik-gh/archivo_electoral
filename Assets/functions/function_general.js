// JavaScript Document
$(document).ready(function(){

	cboTipoProceso();
	
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
function cboTipoProceso(){
	$.ajax({
	    type: "GET",
	    async : false,
	    url: base_url+'/General/getSelectTipoProceso', 
	    success: function(data, textStatus, jqXHR){
	    	if(jqXHR.status == 200){
	            //console.log(data);
	            $("#cbotipoproceso").selectpicker('destroy');
	            $("#cbotipoproceso").html(data).selectpicker('refresh');
	        }
	    }
	});
}

$("#cbotipoproceso").on("change", function() {
   $('#cbotipoproceso-error').hide();
})


/* TABLE PROCESOS */
var tablePerfiles = $('#tableProcesos').DataTable({
	//"processing": true,
	//"serverSide": true,
	"order": [],
	"language": {
		"url": base_url+'/Assets/js/es-pe.json'
	},
	"ajax": {
		"url": base_url+"/General/getProcesos",
		"type": "POST",
		"dataType": "json"
	},
	"columns": [
	{"data":"orden"}, 
	{"data":"PROCESO"},
	{"data":"DESCRIPCION"}, 
	{"data":"FECHA_INICIO"},
	{"data":"FECHA_CIERRE"},
	{"data":"ESTADO"},
	{"data":"opciones"}, 
	],
	"resonsieve":"true",
	"dDestroy": true,
	"iDisplayLength": 10,
	/*"order": [[0,"asc"]],*/
	/*"columnDefs": [{
		"targets": [0 , 4],
		"orderable": false,
	}, ],*/
});



function validarCamposProceso(){
  var $inputs = $('#form_registerProceso .vld'); 
  var formvalido = true; 
 
  $inputs.each(function() { 
    if($(this).val().length == 0){ 
      formvalido = false;
    }
  });
  // console.log($inputs);
  return formvalido; 
}


/* REGISTER PROCESOS */
$("#form_registerProceso").submit(function() {
    
    var requestProceso 					= new Object();
    requestProceso["IdProceso"]			= $("#txtIDProceso").val();
    requestProceso["controlProceso"]	= $("#txtcontrolProceso").val();
    requestProceso["tipoProceso"]		= $("#cbotipoproceso").val();
	requestProceso["codProceso"]		= $("#txtcodproceso").val();
	requestProceso["nomProceso"]		= $("#txtnomproceso").val();
	requestProceso["fechaInicio"]		= $("#txtfechainicio").val();
	requestProceso["fechaFin"]			= $("#txtfechacierre").val();
	requestProceso["estado"]			= ($('#chkestadoProceso').prop('checked') ? '1' : '2');

    if (validarCamposProceso()) {
	    if($('#cbotipoproceso').val().length != 0){
	        $.ajax({
	            url: base_url+'/General/setProceso',
		        type: "POST",     
		        dataType: 'json',
		        data:requestProceso,    
		        cache: false,
		        	
		        success: function(data, textStatus, jqXHR){
		        	console.log(data.msg);

		        	if(jqXHR.status == 200){
		        		if(data.status){
							/*console.log(textStatus);
			        		console.log(jqXHR.status);*/
			        		swal(data.title, data.msg, "success");
			        		$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
			        		$('#tableProcesos').DataTable().ajax.reload();
			        		cancelProceso();
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
	            	/*console.log(textStatus);
	        		console.log(jqXHR.status);*/
	        	}
	        });
	        return false;
	    }
    }
});


/* SHOW PROCESO */
function editarProceso(id){
	// alert('ID a mostrar: '+id);
	$('#txtIDProceso').val(id);
    $('#txtcontrolProceso').val('1');
    $("#updateProceso").removeAttr('style');
    $("#agregarProceso").css("display","none");
    $("#titleProceso").html("<strong>EDITAR PROCESO</strong>");
    $('#estado_proceso').show();

	$.ajax({
      	type:'GET',
      	url: base_url+"/General/getProceso/"+id,
      	dataType:'json',
      	success: function(data, textStatus, jqXHR){
	       	
	       	if(jqXHR.status == 200){
	       		console.log(data);
		        if(data.status){
			        
			        var estado = (data.data.ESTADO == 1) ? true : false;
			        $('#cbotipoproceso').selectpicker('val',data.data.ID_TIPO);
			        $('#txtcodproceso').val(data.data.PROCESO);
			        $('#txtnomproceso').val(data.data.DESCRIPCION);
			        $('#txtfechainicio').val(data.data.FECHA_INICIO);
			        $('#txtfechacierre').val(data.data.FECHA_CIERRE);
			        $('#chkestadoProceso').prop("checked",estado);
			      	return false;

		      	}else{
					swal(data.title, data.msg, "error");
		        	$('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
		        	return false;
		      	}
	      	}
    	}
  	});
  return false;
}


/* DELETE PROCESO */
function eliminarProceso(id){
	//alert('ID a eliminar es: '+id)
	$('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').removeClass('btn btn-warning');
  	swal({  title: "Eliminar Proceso",
      	text: "¿Desea eliminar este Proceso?",
      	type: "warning",
      	showCancelButton: true,
      	cancelButtonText: "Cancelar",
      	confirmButtonColor: "#ff9600",
      	confirmButtonText: "Aceptar",
      	closeOnConfirm: false },
      	function(){ 
          	$.ajax({
	            type:'DELETE',
	            url: base_url+"/General/delProceso/"+id,
	            dataType:'json',
	            success: function(data, textStatus, jqXHR){
	              	if(jqXHR.status == 200){
	              		console.log(data);
	              		if(data.status){

	              			swal(data.title, data.msg, "success");
		        			$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
		        			$('#tableProcesos').DataTable().ajax.reload();
			        		cancelProceso();
		        			return false;

	              		}else{
	              			swal(data.title, data.msg, "error");
		        			$('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
		        			return false;
	              		}
	              	}
            	}
          	});
			return false;
      	});
}


/* CANCEL PROCESO */
function cancelProceso(){
      $("#agregarProceso").removeAttr('style');
      $("#updateProceso").css("display","none");
      $("#titleProceso").html("<strong>REGISTRAR PROCESO</strong>");
      $('#estado_proceso').hide();
      $('#form_registerProceso')[0].reset();
      $('#form_registerProceso').validate().resetForm();
      $('#txtcontrolProceso').val('0');
      $('#form_registerProceso .form-group').removeClass('has-success');
      $('#cbotipoproceso').selectpicker('refresh');
}





/*================================================  FUNCTIONS CONSULTA  ================================================*/

var tableConsultas = $('#tableConsultas').DataTable({
		/*"processing": true,
		"serverSide": true,*/
		"order": [],
		"language": {
			"url": base_url+'/Assets/js/es-pe.json'
		},
		"ajax": {
			"url": base_url+"/General/getConsultas",
			"type": "POST",
			"dataType": "json"
		},
		"columns": [
		{"data":"orden"}, 
		{"data":"CONSULTA"},
		{"data":"DESCRIPCION"}, 
		{"data":"ESTADO"},
		{"data":"opciones"}, 
		],
		"resonsieve":"true",
		"dDestroy": true,
		"iDisplayLength": 10,
		// "order": [[0,"asc"]],
		/*"columnDefs": [{
			"targets": [0 , 7],
			"orderable": false,
		}, ],*/
});


/* REGISTER USUARIOS */
$("#form_registerConsulta").submit(function() {
	var consulta 		=	$('#txtconsulta').val()
    var descripcion 	= 	$('#txtdescripcion').val();
    var total 			= 	consulta.length * descripcion.length;

    var requestConsulta 				= new Object();
    requestConsulta["IdConsulta"]		= $("#txtIDConsulta").val();
    requestConsulta["controlConsulta"]	= $("#txtcontrolConsulta").val();
    requestConsulta["consulta"]			= $("#txtconsulta").val();
    requestConsulta["descripcion"]		= $("#txtdescripcion").val();
	requestConsulta["estado"]			= ($('#chkestadoConsulta').prop('checked') ? '1' : '2');

	if (total > 0) {
	    		
	    		$.ajax({
	    			url: base_url+'/General/setConsulta',
	    			type: "POST",     
	    			dataType: 'json',
	    			data:requestConsulta,    
	    			cache: false,

	    			success: function(data, textStatus, jqXHR){
	    				console.log(data.msg);

	    				if(jqXHR.status == 200){
	    					if(data.status){
								// console.log(textStatus);
								// console.log(jqXHR.status);
								swal(data.title, data.msg, "success");
								$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
								$('#tableConsultas').DataTable().ajax.reload();
								cancelConsulta();
								return false;

							}else{
								swal({  title: 	data.title,
										text: 	data.msg,
										type: 	"error"},
										function(){ 
											setTimeout(function() {
												// $('#txtperfil').focus();
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
});


/* SHOW CONSULTA */
function editarConsulta(id){
	// alert('ID a mostrar: '+id);
	$('#txtIDConsulta').val(id);
    $('#txtcontrolConsulta').val('1');
    $("#updateConsulta").removeAttr('style');
    $("#agregarConsulta").css("display","none");
    $("#titleConsulta").html("<strong>EDITAR CONSULTA</strong>");
    $('#estado_consulta').show();

	$.ajax({
      	type:'GET',
      	url: base_url+"/General/getConsulta/"+id,
      	dataType:'json',
      	success: function(data, textStatus, jqXHR){
	       	
	       	if(jqXHR.status == 200){
	       		console.log(data);
		        if(data.status){
			        
			        var estado = (data.data.ESTADO == 1) ? true : false;
			        $('#txtconsulta').val(data.data.CONSULTA);
			        $('#txtdescripcion').val(data.data.DESCRIPCION);
			        $('#chkestadoConsulta').prop("checked",estado);
			      	return false;

		      	}else{
					swal(data.title, data.msg, "error");
		        	$('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
		        	return false;
		      	}
	      	}
    	}
  	});
  return false;
}


/* DELETE CONSULTA */
function eliminarConsulta(id){
	//alert('ID a eliminar es: '+id)
	$('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').removeClass('btn btn-warning');
  	swal({  title: "Eliminar Consulta",
      	text: "¿Desea eliminar este Consulta?",
      	type: "warning",
      	showCancelButton: true,
      	cancelButtonText: "Cancelar",
      	confirmButtonColor: "#ff9600",
      	confirmButtonText: "Aceptar",
      	closeOnConfirm: false },
      	function(){ 
          	$.ajax({
	            type:'DELETE',
	            url: base_url+"/General/delConsulta/"+id,
	            dataType:'json',
	            success: function(data, textStatus, jqXHR){
	              	if(jqXHR.status == 200){
	              		console.log(data);
	              		if(data.status){

	              			swal(data.title, data.msg, "success");
		        			$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
		        			$('#tableConsultas').DataTable().ajax.reload();
		        			cancelConsulta();
		        			return false;

	              		}else{
	              			swal(data.title, data.msg, "error");
		        			$('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
		        			return false;
	              		}
	              	}
            	}
          	});
			return false;
      	});
}


/* CANCEL CONSULTA */
function cancelConsulta(){
	$("#agregarConsulta").removeAttr('style');
	$("#updateConsulta").css("display","none");
	$("#titleConsulta").html("<strong>REGISTRAR CONSULTA</strong>");
	$('#estado_consulta').hide();
	$('#form_registerConsulta')[0].reset();
	$('#form_registerConsulta').validate().resetForm();
	$('#txtcontrolConsulta').val('0');
	$('#form_registerConsulta .form-group').removeClass('has-success');
}




/*================================================  FUNCTIONS ETAPA  ================================================*/

var tableEtapas = $('#tableEtapas').DataTable({
		/*"processing": true,
		"serverSide": true,*/
		"order": [],
		"language": {
			"url": base_url+'/Assets/js/es-pe.json'
		},
		"ajax": {
			"url": base_url+"/General/getEtapas",
			"type": "POST",
			"dataType": "json"
		},
		"columns": [
		{"data":"orden"}, 
		{"data":"ETAPA"},
		{"data":"DESCRIPCION"}, 
		{"data":"ESTADO"},
		{"data":"opciones"}, 
		],
		"resonsieve":"true",
		"dDestroy": true,
		"iDisplayLength": 10,
		// "order": [[0,"asc"]],
		/*"columnDefs": [{
			"targets": [0 , 7],
			"orderable": false,
		}, ],*/
});


/* REGISTER ETAPA */
$("#form_registerEtapa").submit(function() {
	var etapa 			=	$('#txtetapa').val()
    var descripcion 	= 	$('#txtdescripcionEtapa').val();
    var total 			= 	etapa.length * descripcion.length;

    var requestEtapa 				= new Object();
    requestEtapa["IdEtapa"]			= $("#txtIDEtapa").val();
    requestEtapa["controlEtapa"]	= $("#txtcontrolEtapa").val();
    requestEtapa["descripcion"]		= $("#txtdescripcionEtapa").val();
	requestEtapa["estado"]			= ($('#chkestadoEtapa').prop('checked') ? '1' : '2');

	if (total > 0) {
	    		
	    		$.ajax({
	    			url: base_url+'/General/setEtapa',
	    			type: "POST",     
	    			dataType: 'json',
	    			data:requestEtapa,    
	    			cache: false,

	    			success: function(data, textStatus, jqXHR){
	    				console.log(data.msg);

	    				if(jqXHR.status == 200){
	    					if(data.status){
								// console.log(textStatus);
								// console.log(jqXHR.status);
								swal(data.title, data.msg, "success");
								$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
								$('#tableEtapas').DataTable().ajax.reload();
								$('#modal_etapa').modal('hide');
								cancelEtapa();
								return false;

							}else{
								swal({  title: 	data.title,
										text: 	data.msg,
										type: 	"error"},
										function(){ 
											setTimeout(function() {
												// $('#txtperfil').focus();
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
});


/* SHOW ETAPA */
function editarEtapa(id){
	// alert('ID a mostrar: '+id);
	$('#txtIDEtapa').val(id);
    $('#txtcontrolEtapa').val('1');
    $("#updateEtapa").removeAttr('style');
    //$("#agregarEtapa").css("display","none");
    $("#titleEtapa").html("<strong>EDITAR ETAPA</strong>");
    //$('#estado_etapa').show();

	$.ajax({
      	type:'GET',
      	url: base_url+"/General/getEtapa/"+id,
      	dataType:'json',
      	success: function(data, textStatus, jqXHR){
	       	
	       	if(jqXHR.status == 200){
	       		console.log(data);
		        if(data.status){
			        
			        var estado = (data.data.ESTADO == 1) ? true : false;
			        $('#txtetapa').val(data.data.ETAPA).attr('disabled',true);
			        $('#txtdescripcionEtapa').val(data.data.DESCRIPCION);
			        $('#chkestadoEtapa').prop("checked",estado);
			      	return false;

		      	}else{
					swal(data.title, data.msg, "error");
		        	$('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
		        	return false;
		      	}
	      	}
    	}
  	});
  return false;
}


/* CANCEL ETAPA */
function cancelEtapa(){
	$("#agregarEtapa").removeAttr('style');
	$("#updateEtapa").css("display","none");
	$('#form_registerEtapa')[0].reset();
	$('#form_registerEtapa').validate().resetForm();
	$('#txtcontrolEtapa').val('0');
	$('#form_registerEtapa .form-group').removeClass('has-success');
}






/*================================================  FUNCTIONS SOLUCION TECNOLOGICA  ================================================*/

var tableSoluciones = $('#tableSoluciones').DataTable({
		/*"processing": true,
		"serverSide": true,*/
		"order": [],
		"language": {
			"url": base_url+'/Assets/js/es-pe.json'
		},
		"ajax": {
			"url": base_url+"/General/getSoluciones",
			"type": "POST",
			"dataType": "json"
		},
		"columns": [
		{"data":"orden"}, 
		{"data":"SOLUCIONTECNOLOGICA"},
		{"data":"DESCRIPCION"}, 
		{"data":"ESTADO"},
		{"data":"opciones"}, 
		],
		"resonsieve":"true",
		"dDestroy": true,
		"iDisplayLength": 10,
		// "order": [[0,"asc"]],
		/*"columnDefs": [{
			"targets": [0 , 7],
			"orderable": false,
		}, ],*/
});


/* REGISTER ETAPA */
$("#form_registerSolucion").submit(function() {
	var solucion 		=	$('#txtsolucion').val()
    var descripcion 	= 	$('#txtdescripcionSolucion').val();
    var total 			= 	solucion.length * descripcion.length;

    var requestSolucion 				= new Object();
    requestSolucion["IdSolucion"]		= $("#txtIDSolucion").val();
    requestSolucion["controlSolucion"]	= $("#txtcontrolSolucion").val();
	requestSolucion["solucion"]			= $("#txtsolucion").val();
    requestSolucion["descripcion"]		= $("#txtdescripcionSolucion").val();
	requestSolucion["estado"]			= ($('#chkestadoSolucion').prop('checked') ? '1' : '2');

	if (total > 0) {
	    		
	    		$.ajax({
	    			url: base_url+'/General/setSolucion',
	    			type: "POST",     
	    			dataType: 'json',
	    			data:requestSolucion,    
	    			cache: false,

	    			success: function(data, textStatus, jqXHR){
	    				console.log(data.msg);

	    				if(jqXHR.status == 200){
	    					if(data.status){
								// console.log(textStatus);
								// console.log(jqXHR.status);
								swal(data.title, data.msg, "success");
								$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
								$('#tableSoluciones').DataTable().ajax.reload();
								cancelSolucion();
								return false;

							}else{
								swal({  title: 	data.title,
										text: 	data.msg,
										type: 	"error"},
										function(){ 
											setTimeout(function() {
												// $('#txtperfil').focus();
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
});


/* SHOW SOLUCION */
function editarSolucion(id){
	// alert('ID a mostrar: '+id);
	$('#txtIDSolucion').val(id);
    $('#txtcontrolSolucion').val('1');
    $("#updateSolucion").removeAttr('style');
    $("#agregarSolucion").css("display","none");
    $("#titleSolucion").html("<strong>EDITAR SOLUCI&Oacute;N TECNOL&Oacute;GICA</strong>");
    $('#estado_solucion').show();

	$.ajax({
      	type:'GET',
      	url: base_url+"/General/getSolucion/"+id,
      	dataType:'json',
      	success: function(data, textStatus, jqXHR){
	       	
	       	if(jqXHR.status == 200){
	       		console.log(data);
		        if(data.status){
			        
			        var estado = (data.data.ESTADO == 1) ? true : false;
			        $('#txtsolucion').val(data.data.SOLUCIONTECNOLOGICA);
			        $('#txtdescripcionSolucion').val(data.data.DESCRIPCION);
			        $('#chkestadoSolucion').prop("checked",estado);
			      	return false;

		      	}else{
					swal(data.title, data.msg, "error");
		        	$('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
		        	return false;
		      	}
	      	}
    	}
  	});
  return false;
}


/* DELETE SOLUCION */
function eliminarSolucion(id){
	//alert('ID a eliminar es: '+id)
	$('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').removeClass('btn btn-warning');
  	swal({  title: "Eliminar Solución Tecnológica",
      	text: "¿Desea eliminar este Solución Tecnológica?",
      	type: "warning",
      	showCancelButton: true,
      	cancelButtonText: "Cancelar",
      	confirmButtonColor: "#ff9600",
      	confirmButtonText: "Aceptar",
      	closeOnConfirm: false },
      	function(){ 
          	$.ajax({
	            type:'DELETE',
	            url: base_url+"/General/delSolucion/"+id,
	            dataType:'json',
	            success: function(data, textStatus, jqXHR){
	              	if(jqXHR.status == 200){
	              		console.log(data);
	              		if(data.status){

	              			swal(data.title, data.msg, "success");
		        			$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
		        			$('#tableSoluciones').DataTable().ajax.reload();
		        			cancelSolucion();
		        			return false;

	              		}else{
	              			swal(data.title, data.msg, "error");
		        			$('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
		        			return false;
	              		}
	              	}
            	}
          	});
			return false;
      	});
}


/* CANCEL SOLUCION */
function cancelSolucion(){
	$("#agregarSolucion").removeAttr('style');
	$("#updateSolucion").css("display","none");
	$("#titleSolucion").html("<strong>REGISTRAR SOLUCI&Oacute;N TECNOL&Oacute;GICA</strong>");
	$('#estado_solucion').hide();
	$('#form_registerSolucion')[0].reset();
	$('#form_registerSolucion').validate().resetForm();
	$('#txtcontrolSolucion').val('0');
	$('#form_registerSolucion .form-group').removeClass('has-success');
}



/*================================================  FUNCTIONS MATERIAL  ================================================*/

var tableMateriales = $('#tableMateriales').DataTable({
		/*"processing": true,
		"serverSide": true,*/
		"order": [],
		"language": {
			"url": base_url+'/Assets/js/es-pe.json'
		},
		"ajax": {
			"url": base_url+"/General/getMateriales",
			"type": "POST",
			"dataType": "json"
		},
		"columns": [
		{"data":"orden"}, 
		{"data":"MATERIAL"},
		{"data":"DESCRIPCION"}, 
		{"data":"ESTADO"},
		{"data":"opciones"}, 
		],
		"resonsieve":"true",
		"dDestroy": true,
		"iDisplayLength": 10,
		// "order": [[0,"asc"]],
		/*"columnDefs": [{
			"targets": [0 , 7],
			"orderable": false,
		}, ],*/
});


/* REGISTER ETAPA */
$("#form_registerMaterial").submit(function() {
	var material 		=	$('#txtmaterial').val()
    var descripcion 	= 	$('#txtdescripcionMaterial').val();
    var total 			= 	material.length * descripcion.length;

    var requestMaterial 				= new Object();
    requestMaterial["IdMaterial"]		= $("#txtIDMaterial").val();
    requestMaterial["controlMaterial"]	= $("#txtcontrolMaterial").val();
    requestMaterial["descripcion"]		= $("#txtdescripcionMaterial").val();
	requestMaterial["estado"]			= ($('#chkestadoMaterial').prop('checked') ? '1' : '2');

	if (total > 0) {
	    		
	    		$.ajax({
	    			url: base_url+'/General/setMaterial',
	    			type: "POST",     
	    			dataType: 'json',
	    			data:requestMaterial,    
	    			cache: false,

	    			success: function(data, textStatus, jqXHR){
	    				console.log(data.msg);

	    				if(jqXHR.status == 200){
	    					if(data.status){
								// console.log(textStatus);
								// console.log(jqXHR.status);
								swal(data.title, data.msg, "success");
								$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
								$('#tableMateriales').DataTable().ajax.reload();
								$('#modal_material').modal('hide');
								cancelMaterial();
								return false;

							}else{
								swal({  title: 	data.title,
										text: 	data.msg,
										type: 	"error"},
										function(){ 
											setTimeout(function() {
												// $('#txtperfil').focus();
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
});


/* SHOW SOLUCION */
function editarMaterial(id){
	// alert('ID a mostrar: '+id);
	$('#txtIDMaterial').val(id);
    $('#txtcontrolMaterial').val('1');
    $("#updateMaterial").removeAttr('style');
    //$("#agregarEtapa").css("display","none");
    $("#titleMaterial").html("<strong>EDITAR MATERIAL</strong>");
    //$('#estado_etapa').show();

	$.ajax({
      	type:'GET',
      	url: base_url+"/General/getMaterial/"+id,
      	dataType:'json',
      	success: function(data, textStatus, jqXHR){
	       	
	       	if(jqXHR.status == 200){
	       		console.log(data);
		        if(data.status){
			        
			        var estado = (data.data.ESTADO == 1) ? true : false;
			        $('#txtmaterial').val(data.data.MATERIAL).attr('disabled',true);
			        $('#txtdescripcionMaterial').val(data.data.DESCRIPCION);
			        $('#chkestadoMaterial').prop("checked",estado);
			      	return false;

		      	}else{
					swal(data.title, data.msg, "error");
		        	$('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
		        	return false;
		      	}
	      	}
    	}
  	});
  return false;
}


/* CANCEL CONSULTA */
function cancelMaterial(){
	$("#agregarMaterial").removeAttr('style');
	$("#updateMaterial").css("display","none");
	$('#form_registerMaterial')[0].reset();
	$('#form_registerMaterial').validate().resetForm();
	$('#txtcontrolMaterial').val('0');
	$('#form_registerMaterial .form-group').removeClass('has-success');
}




/*================================================  FUNCTIONS INCIDENCIA  ================================================*/

var tableIncidencias = $('#tableIncidencias').DataTable({
		/*"processing": true,
		"serverSide": true,*/
		"order": [],
		"language": {
			"url": base_url+'/Assets/js/es-pe.json'
		},
		"ajax": {
			"url": base_url+"/General/getIncidencias",
			"type": "POST",
			"dataType": "json"
		},
		"columns": [
		{"data":"orden"}, 
		{"data":"INCIDENCIA"},
		{"data":"DESCRIPCION"}, 
		{"data":"ESTADO"},
		{"data":"opciones"}, 
		],
		"resonsieve":"true",
		"dDestroy": true,
		"iDisplayLength": 10,
		// "order": [[0,"asc"]],
		/*"columnDefs": [{
			"targets": [0 , 7],
			"orderable": false,
		}, ],*/
});


/* REGISTER INCIDENCIA */
$("#form_registerIncidencia").submit(function() {
	var incidencia 		=	$('#txtincidencia').val()
    var descripcion 	= 	$('#txtdescripcionIncidencia').val();
    var total 			= 	incidencia.length * descripcion.length;

    var requestIncidencia 					= new Object();
    requestIncidencia["IdIncidencia"]		= $("#txtIDIncidencia").val();
    requestIncidencia["controlIncidencia"]	= $("#txtcontrolIncidencia").val();
    requestIncidencia["incidencia"]			= $("#txtincidencia").val();
    requestIncidencia["descripcion"]		= $("#txtdescripcionIncidencia").val();
	requestIncidencia["estado"]				= ($('#chkestadoIncidencia').prop('checked') ? '1' : '2');

	if (total > 0) {
	    		
	    		$.ajax({
	    			url: base_url+'/General/setincidencia',
	    			type: "POST",     
	    			dataType: 'json',
	    			data:requestIncidencia,    
	    			cache: false,

	    			success: function(data, textStatus, jqXHR){
	    				console.log(data.msg);

	    				if(jqXHR.status == 200){
	    					if(data.status){
								// console.log(textStatus);
								// console.log(jqXHR.status);
								swal(data.title, data.msg, "success");
								$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
								$('#tableIncidencias').DataTable().ajax.reload();
								cancelIncidencia();
								return false;

							}else{
								swal({  title: 	data.title,
										text: 	data.msg,
										type: 	"error"},
										function(){ 
											setTimeout(function() {
												// $('#txtperfil').focus();
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

});


/* SHOW INCIDENCIA */
function editarIncidencia(id){
	// alert('ID a mostrar: '+id);
	$('#txtIDIncidencia').val(id);
    $('#txtcontrolIncidencia').val('1');
    $("#updateIncidencia").removeAttr('style');
    $("#agregarIncidencia").css("display","none");
    $("#titleIncidencia").html("<strong>EDITAR INCIDENCIA</strong>");
    $('#estado_incidencia').show();

	$.ajax({
      	type:'GET',
      	url: base_url+"/General/getIncidencia/"+id,
      	dataType:'json',
      	success: function(data, textStatus, jqXHR){
	       	
	       	if(jqXHR.status == 200){
	       		console.log(data);
		        if(data.status){
			        
			        var estado = (data.data.ESTADO == 1) ? true : false;
			        $('#txtincidencia').val(data.data.INCIDENCIA);
			        $('#txtdescripcionIncidencia').val(data.data.DESCRIPCION);
			        $('#chkestadoIncidencia').prop("checked",estado);
			      	return false;

		      	}else{
					swal(data.title, data.msg, "error");
		        	$('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
		        	return false;
		      	}
	      	}
    	}
  	});
  return false;
}


/* DELETE INCIDENCIA */
function eliminarIncidencia(id){
	//alert('ID a eliminar es: '+id)
	$('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').removeClass('btn btn-warning');
  	swal({  title: "Eliminar Incidencia",
      	text: "¿Desea eliminar este Incidencia?",
      	type: "warning",
      	showCancelButton: true,
      	cancelButtonText: "Cancelar",
      	confirmButtonColor: "#ff9600",
      	confirmButtonText: "Aceptar",
      	closeOnConfirm: false },
      	function(){ 
          	$.ajax({
	            type:'DELETE',
	            url: base_url+"/General/delIncidencia/"+id,
	            dataType:'json',
	            success: function(data, textStatus, jqXHR){
	              	if(jqXHR.status == 200){
	              		console.log(data);
	              		if(data.status){

	              			swal(data.title, data.msg, "success");
		        			$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
		        			$('#tableIncidencias').DataTable().ajax.reload();
		        			cancelIncidencia();
		        			return false;

	              		}else{
	              			swal(data.title, data.msg, "error");
		        			$('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
		        			return false;
	              		}
	              	}
            	}
          	});
			return false;
      	});
}


/* CANCEL INCIDENCIA */
function cancelIncidencia(){
	$("#agregarIncidencia").removeAttr('style');
	$("#updateIncidencia").css("display","none");
	$("#titleIncidencia").html("<strong>REGISTRAR CONSULTA</strong>");
	$('#estado_incidencia').hide();
	$('#form_registerIncidencia')[0].reset();
	$('#form_registerIncidencia').validate().resetForm();
	$('#txtcontrolIncidencia').val('0');
	$('#form_registerIncidencia .form-group').removeClass('has-success');
}




/*================================================  FUNCTIONS ASIGNAR  ================================================*/
function cboEtapaAsignar(){
	$.ajax({
	    type: "GET",
	    async : false,
	    url: base_url+'/General/getSelectEtapa', 
	    success: function(data, textStatus, jqXHR){
	    	if(jqXHR.status == 200){
	            //console.log(data);
	            $("#cboincidenciaAsignar").selectpicker('destroy');
	            $("#cboincidenciaAsignar").html(data).selectpicker('refresh');
	        }
	    }
	});
}

$("#cboincidenciaAsignar").on("change", function() {
   $('#cboincidenciaAsignar-error').hide();
})


$("#multiIncidencia").on("change", function() {
   $('#multiIncidencia-error').hide();
})

/* MULTISELECT */
function multicIncidencias(){
	$.ajax({
	    type: "GET",
	    async : false,
	    url: base_url+'/General/getSelectIncidencias', 
	    success: function(data, textStatus, jqXHR){
	    	if(jqXHR.status == 200){
	            console.log(data);
	            $("#multiIncidencia").selectpicker('destroy');
	            $("#multiIncidencia").html(data).selectpicker('refresh');
	        }
	    }
	});
}


/* TABLE ASIGNAR MODULOS */
var tableAsignar = $('#tableAsignar').DataTable({
		/*"processing": true,
		"serverSide": true,*/
		"order": [],
		"language": {
			"url": base_url+'/Assets/js/es-pe.json'
		},
		"ajax": {
			"url": base_url+"/General/getIncidenciasAsignados",
			"type": "POST",
			"dataType": "json"
		},
		"columns": [
		{"data":"orden"}, 
		{"data":"ETAPA"},
		{"data":"LISTA_INCIDENCIAS"}, 
		{"data":"opciones"}, 
		],
		"resonsieve":"true",
		"dDestroy": true,
		"iDisplayLength": 10,
		'columnDefs': [
		{
		      "targets": 0, // your case first column
		      "className": "text-center",
		},
		{
		      "targets": 1,
		      "className": "text-center",
		},
		{
		      "targets": 3, // your case first column
		      "className": "text-center",
		}],
		// "order": [[0,"asc"]],
});


/* SHOW ASIGNAR MODULO */
function editarAsignar(id){
    $('#txtIDAsignar').val(id);
    $('#txtcontrolAsignar').val('1');
    $("#updateAsignar").removeAttr('style');
    $("#agregarAsignar").css("display","none");
    $("#titleAsignar").html("<strong>EDITAR LA ASIGNACI&Oacute;N DE INCIDENCIAS</strong>");
    $('#form_registerAsignar').validate().resetForm();
    $('#form_registerAsignar .form-group').removeClass('has-success');
    $('#multiIncidencia').selectpicker('deselectAll');
    // $('#multimodulo').multiselect("deselectAll", false);
    
    $.ajax({
      	type:'GET',
      	url: base_url+"/General/getAsignar/"+id,
      	dataType:'json',
      	success: function(data, textStatus, jqXHR){
	       	
	       	if(jqXHR.status == 200){
	       		console.log(data);
		        if(data.status){
			        
			        $('#cboincidenciaAsignar').attr("disabled",true).html('<option value="'+id+'">'+data.data.ETAPA+'</option>').selectpicker('refresh');
          			$('#cboincidenciaAsignar').selectpicker('val',id);  
			       
			       	var modulo = data.data.INCIDENCIA.split(','); 
          			$('#multiIncidencia').selectpicker('val', modulo);
			      	return false;

		      	}else{
					swal(data.title, data.msg, "error");
		        	$('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
		        	return false;
		      	}
	      	}
    	}
  	});
  return false;
}


/* REGISTER MODULO */
$("#form_registerAsignar").submit(function(){

    var cboIncidenciaAsignar 	= $('#cboincidenciaAsignar').val();
    var multiIncidencia 		= $('#multiIncidencia').val();

    var total = cboIncidenciaAsignar.length * multiIncidencia.length;

    var requesAsignar 				= new Object();
    requesAsignar["controlAsignar"]	= $("#txtcontrolAsignar").val();
    requesAsignar["etapa"]			= $("#cboincidenciaAsignar").val();
    requesAsignar["incidencias"]	= $("#multiIncidencia").val();
        
    if (total > 0) {
    	$.ajax({
            url: base_url+'/General/setAsignar',
	        type: "POST",     
	        dataType: 'json',
	        data:requesAsignar,    
	        cache: false,
	        	
	        success: function(data, textStatus, jqXHR){
	        	console.log(data.msg);

	        	if(jqXHR.status == 200){
	        		if(data.status){
						// console.log(textStatus);
		        		// console.log(jqXHR.status);
		        		swal(data.title, data.msg, "success");
		        		$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
		        		$('#tableAsignar').DataTable().ajax.reload();
		        		cancelAsignar();
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



/* DELETE ASIGNAR */
function eliminarAsignar(id){
	//alert('ID a eliminar es: '+id)
	$('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').removeClass('btn btn-warning');
  	swal({  title: "Eliminar Etapa",
      	text: "¿Desea eliminar esta Etapa?",
      	type: "warning",
      	showCancelButton: true,
      	cancelButtonText: "Cancelar",
      	confirmButtonColor: "#ff9600",
      	confirmButtonText: "Aceptar",
      	closeOnConfirm: false },
      	function(){ 
          	$.ajax({
	            type:'DELETE',
	            url: base_url+"/General/delAsignar/"+id,
	            dataType:'json',
	            success: function(data, textStatus, jqXHR){
	              	if(jqXHR.status == 200){
	              		console.log(data);
	              		if(data.status){

	              			swal(data.title, data.msg, "success");
		        			$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
		        			$('#tableAsignar').DataTable().ajax.reload();
		        			cancelAsignar();
		        			return false;

	              		}else{
	              			swal(data.title, data.msg, "error");
		        			$('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
		        			return false;
	              		}
	              	}
            	}
          	});
			return false;
      	});
}


/* CANCEL ASIGNAR */
function cancelAsignar(){
	  	$('#cboincidenciaAsignar').attr("disabled",false)
      	$("#agregarAsignar").removeAttr('style');
      	$("#updateAsignar").css("display","none");
      	$("#titleAsignar").html("<strong>ASIGNAR INCIDENCIAS</strong>");
      	$('#form_registerAsignar')[0].reset();
      	$('#form_registerAsignar').validate().resetForm();
      	$('#form_registerAsignar .form-group').removeClass('has-success');
      	cboEtapaAsignar();
      	$('#multiIncidencia').selectpicker("refresh");
      	$('#txtcontrolAsignar').val('0');
      	$('#errormultiIncidencia').html('');
}


/*================================================  FUNCTIONS DISPOSITIVOS USB  ================================================*/

var tableDispositivos = $('#tableDispositivos').DataTable({
	/*"processing": true,
	"serverSide": true,*/
	"order": [],
	"language": {
		"url": base_url+'/Assets/js/es-pe.json'
	},
	"ajax": {
		"url": base_url+"/General/getDispositivos",
		"type": "POST",
		"dataType": "json"
	},
	"columns": [
	{"data":"orden"}, 
	{"data":"DESCRIPCION"}, 
	{"data":"ESTADO"},
	{"data":"opciones"}, 
	],
	"resonsieve":"true",
	"dDestroy": true,
	"iDisplayLength": 10,
	// "order": [[0,"asc"]],
	/*"columnDefs": [{
		"targets": [0 , 7],
		"orderable": false,
	}, ],*/
});


/* REGISTER DISPOSITIVO */
$("#form_registerDispositivo").submit(function() {
	// var solucion 		=	$('#txtsolucion').val()
    var descripcion 	= 	$('#txtdescripcionDispositivo').val();
    var total 			= 	descripcion.length;

    var requestDispositivo 						= new Object();
    requestDispositivo["IdDispositivo"]			= $("#txtIDDispositivo").val();
    requestDispositivo["controlDispositivo"]	= $("#txtcontrolDispositivo").val();
    requestDispositivo["descripcion"]			= $("#txtdescripcionDispositivo").val();
	requestDispositivo["estado"]				= ($('#chkestadoDispositivo').prop('checked') ? '1' : '2');

	if (total > 0) {
	    		
	    		$.ajax({
	    			url: base_url+'/General/setDispositivo',
	    			type: "POST",     
	    			dataType: 'json',
	    			data:requestDispositivo,    
	    			cache: false,

	    			success: function(data, textStatus, jqXHR){
	    				console.log(data.msg);

	    				if(jqXHR.status == 200){
	    					if(data.status){
								// console.log(textStatus);
								// console.log(jqXHR.status);
								swal(data.title, data.msg, "success");
								$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
								$('#tableDispositivos').DataTable().ajax.reload();
								cancelDispositivo();
								return false;

							}else{
								swal({  title: 	data.title,
										text: 	data.msg,
										type: 	"error"},
										function(){ 
											setTimeout(function() {
												// $('#txtperfil').focus();
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
});


/* SHOW DISPOSITIVO */
function editarDispositivo(id){
	// alert('ID a mostrar: '+id);
	$('#txtIDDispositivo').val(id);
    $('#txtcontrolDispositivo').val('1');
    $("#updateDispositivo").removeAttr('style');
    $("#agregarDispositivo").css("display","none");
    $("#titleDispositivo").html("<strong>EDITAR DISPOSITIVO USB</strong>");
    $('#estado_dispositivo').show();

	$.ajax({
      	type:'GET',
      	url: base_url+"/General/getDispositivo/"+id,
      	dataType:'json',
      	success: function(data, textStatus, jqXHR){
	       	
	       	if(jqXHR.status == 200){
	       		console.log(data);
		        if(data.status){
			        
			        var estado = (data.data.ESTADO == 1) ? true : false;
			        $('#txtdescripcionDispositivo').val(data.data.DESCRIPCION);
			        $('#chkestadoDispositivo').prop("checked",estado);
			      	return false;

		      	}else{
					swal(data.title, data.msg, "error");
		        	$('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
		        	return false;
		      	}
	      	}
    	}
  	});
  return false;
}


/* DELETE DISPOSITIVO */
function eliminarDispositivo(id){
	//alert('ID a eliminar es: '+id)
	$('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').removeClass('btn btn-warning');
  	swal({  title: "Eliminar Dispositivo USB",
      	text: "¿Desea eliminar este Dispositivo USB?",
      	type: "warning",
      	showCancelButton: true,
      	cancelButtonText: "Cancelar",
      	confirmButtonColor: "#ff9600",
      	confirmButtonText: "Aceptar",
      	closeOnConfirm: false },
      	function(){ 
          	$.ajax({
	            type:'DELETE',
	            url: base_url+"/General/delDispositivo/"+id,
	            dataType:'json',
	            success: function(data, textStatus, jqXHR){
	              	if(jqXHR.status == 200){
	              		console.log(data);
	              		if(data.status){

	              			swal(data.title, data.msg, "success");
		        			$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
		        			$('#tableDispositivos').DataTable().ajax.reload();
		        			cancelDispositivo();
		        			return false;

	              		}else{
	              			swal(data.title, data.msg, "error");
		        			$('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
		        			return false;
	              		}
	              	}
            	}
          	});
			return false;
      	});
}


/* CANCEL DISPOSITIVO */
function cancelDispositivo(){
	$("#agregarDispositivo").removeAttr('style');
	$("#updateDispositivo").css("display","none");
	$("#titleDispositivo").html("<strong>REGISTRAR DISPOSITIVO USB</strong>");
	$('#estado_dispositivo').hide();
	$('#form_registerDispositivo')[0].reset();
	$('#form_registerDispositivo').validate().resetForm();
	$('#txtcontrolDispositivo').val('0');
	$('#form_registerDispositivo .form-group').removeClass('has-success');
}