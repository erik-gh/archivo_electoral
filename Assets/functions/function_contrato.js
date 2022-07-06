// JavaScript Document
$(document).ready(function(){

	//verlistadoModulos();
	$('#tableFormAcad').DataTable();
	$('#tableCursoEspec').DataTable();
	$('#tableExperiencia').DataTable();
	listcboPedido();
	listcboProceso();
	listcboLocal();
	listcboDepartamento();
	listcboGradoEstudio();
	$('#cboProvincia').html( '<option value="">[ SELECCIONE PROVINCIA ]</option>' ).selectpicker('refresh');
	$('#cboDistrito').html( '<option value="">[ SELECCIONE DISTRITO ]</option>' ).selectpicker('refresh');
	$('#cboNivelEstudios').html( '<option value="">[ SELECCIONE NIVEL ]</option>' ).selectpicker('refresh');

	$('#openBtn').click(function() {
    	$('#myModal').modal({
      		show: true
    	})
  	});

  	$(document).on({
  		'show.bs.modal': function() {
  			var zIndex = 1040 + (10 * $('.modal:visible').length);
	      	$(this).css('z-index', zIndex);
	      	setTimeout(function() {
	        	$('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
	      	}, 0);
	    },
	    'hidden.bs.modal': function() {
	    	if ($('.modal:visible').length > 0) {
	        // restore the modal-open class to the body element, so that scrolling works
	        // properly after de-stacking a modal.
	    		setTimeout(function() {
	        		$(document.body).addClass('modal-open');
	        	}, 0);
	      	}
	    }
	}, '.modal');

	//timepoLaboral();
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





/* LISTA DE PEDIDOS PARA CONTRATOS */
function listcboPedido(){
	$.ajax({
	    type: "GET",
	    async : false,
	    dataType:'json',
	    url: base_url+'/Pedido/getSelectPedido', 
	    success: function(data, textStatus, jqXHR){
	    	if(jqXHR.status == 200){
	            //console.log(data);
	            //$("#cboPedido").selectpicker('destroy');
	            //$("#cboPedido").html(data).selectpicker('refresh');
	        	$('#cboPedido').empty().append('<option value="">[ SELECCIONE PEDIDO]</option>');
			    $.each(data,function(i, row) {
					$("#cboPedido").append('<option value='+ row.id_pedido +'>'+ row.pedido +'</option>');
			    });
			    $('#cboPedido').selectpicker();
	        }
	    }
	});
}


$("#cboProceso").on("change", function() {

  if($("#cboProceso").val() != ''){
    $('#registerContrato').attr({'disabled':false, 'href':'#modal_registro'});
  }else{
    $('#registerContrato').attr('disabled',true).removeAttr("href");
  }
})


$("#registerContrato").on("click", function(){
	var proceso = $('#cboProceso option:selected').text();
	$('#txtNroContrato').val('N°LS-'+proceso+'-');
	$('#titleContrato').html('<b>REGISTRAR CONTRATO - '+proceso+'</b>');
})


$("#cboPedido").on("change", function() { 
	var id = $(this).val();
	$('#cboPedido-error').hide();
	$('#txtMemorandum').val('');
	$('#txtInforme').val('');
	$('#txtNombre').val('');
	$('#txtCargo').val('');
	$('#txtremuneracion').val('');
	$('#txtRUC').val('');

	if(id != ''){
		$('#txtDNI').val('').attr('disabled', false).focus();
	}else{
		$('#txtDNI').val('').attr('disabled', true);
	}

	$.ajax({
      	type:'GET',
      	url: base_url+"/Pedido/getPedido/"+id,
      	dataType:'json',
      	success: function(data, textStatus, jqXHR){
	       	
	       	if(jqXHR.status == 200){
	       		//console.log(data);
		        if(data.status){
			        //var estado = (data.data.estado == 1) ? true : false;
			        $('#txtMemorandum').val(data.data.memorandum).attr('disabled',true);
			        $('#txtInforme').val(data.data.informe).attr('disabled',true);
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
})


$("#cboLocal").on("change", function() { 
	$('#cboLocal-error').hide();
});

$("#cboDepartamento").on("change", function() { 
	$('#cboDepartamento-error').hide();
});

$("#cboProvincia").on("change", function() { 
	$('#cboProvincia-error').hide();
});

$("#cboDistrito").on("change", function() { 
	$('#cboDistrito-error').hide();
});

$("#cboVerificacion").on("change", function() { 
	$('#cboVerificacion-error').hide();
});


$("#cboSexo").on("change", function() { 
	$('#cboSexo-error').hide();
});

function keyDNI(){
	var dni = $('#txtDNI').val();
	var pedido = $('#cboPedido').val();
	$('#txtNombre').val('');
	$('#txtIDPersonal').val('');
	$('#txtCargo').val('');
	$('#txtIDCargo').val('');
	$('#txtHonorarios').val('');
	$('#txtRUC').val('');
	
	var requestPersona 				= new Object();
    requestPersona["dniPersonal"]	= $("#txtDNI").val();
    requestPersona["idpedido"]		= $("#cboPedido").val();

	if(dni.length == 8){ 
		$.ajax({
	      	url: base_url+"/Personal/getselectedPersonal",
	      	type: "POST",     
	        dataType: 'json',
	        data:requestPersona,    
	        cache: false,
	      	success: function(data, textStatus, jqXHR){
		       	
		       	if(jqXHR.status == 200){
		       		//console.log(data);
			        if(data.status){
				        //var estado = (data.data.estado == 1) ? true : false;
				        $('#txtNombre').val(data.data.nombre).attr('disabled',true);
				        $('#txtIDPersonal').val(data.data.id_personal).attr('disabled',true);
				        $('#txtCargo').val(data.data.cargo).attr('disabled',true);
				        $('#txtIDCargo').val(data.data.id_cargo).attr('disabled',true);
				        $('#txtHonorarios').val(data.data.remuneracion).attr('disabled',true);
				        $('#txtRUC').val('10'+dni);
				      	return false;

			      	}else{
						swal(data.title, data.msg, "error");
			        	$('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
			        	$('#txtRUC').val('');
			        	return false;
			      	}
		      	}
	    	}
	  	});
	  	return false;
	}
}


function listcboProceso(){
	$.ajax({
	    type: "GET",
	    async : false,
	    dataType:'json',
	    url: base_url+'/Contrato/getSelectProceso', 
	    success: function(data, textStatus, jqXHR){
	    	if(jqXHR.status == 200){
	            //console.log(data);
	            //$("#cboProceso").selectpicker('destroy');
	            //$("#cboProceso").html(data).selectpicker('refresh');
	        	$('#cboProceso').empty().append('<option value="">[ SELECCIONE PROCESO]</option>');
			    $.each(data,function(i, row) {
					$("#cboProceso").append('<option value='+ row.id_proceso +'>'+ row.codigo_proceso +'</option>');
			    });
			    $('#cboProceso').selectpicker();
	        }
	    }
	});
}


function listcboLocal(){
	$.ajax({
	    type: "GET",
	    async : false,
	    dataType:'json',
	    url: base_url+'/Contrato/getSelectLocal', 
	    success: function(data, textStatus, jqXHR){
	    	if(jqXHR.status == 200){
	            //console.log(data);
	            //$("#cboProceso").selectpicker('destroy');
	            //$("#cboProceso").html(data).selectpicker('refresh');
	        	$('#cboLocal').empty().append('<option value="">[ SELECCIONE LOCAL]</option>');
			    $.each(data,function(i, row) {
					$("#cboLocal").append('<option value='+ row.id_local +'>'+ row.nombre_local +'</option>');
			    });
			    $('#cboLocal').selectpicker();
	        }
	    }
	});
}


function listcboDepartamento(){

	$.ajax({
	    type: "GET",
	    async : false,
	    dataType:'json',
	    url: base_url+'/Contrato/getSelectDepartamento', 
	    success: function(data, textStatus, jqXHR){
	    	if(jqXHR.status == 200){
	            //console.log(data);
	            //$("#cboProceso").selectpicker('destroy');
	            //$("#cboProceso").html(data).selectpicker('refresh');
	        	$('#cboDepartamento').empty().append('<option value="">[ SELECCIONE DEPARTAMENTO ]</option>');
			    $.each(data,function(i, row) {
					$("#cboDepartamento").append('<option value='+ row.codigo +'>'+ row.depart_ubi +'</option>');
			    });
			    $('#cboDepartamento').selectpicker();
	        }
	    }
	});
}


$("#cboDepartamento").on("change", function() { 
	$('#cboDistrito').html( '<option value="">[ SELECCIONE DISTRITO ]</option>' );
	$("#cboDistrito").selectpicker('destroy');
	$('#cboDistrito').selectpicker('refresh');
});


function listarCboProvincia(){

	var requestProvincia 			= new Object();
    requestProvincia["codDepart"]	= $("#cboDepartamento").val();

	$.ajax({
	    url: base_url+'/Contrato/getSelectProvincia',
	    type: "POST",     
	    dataType: 'json',
	    data:requestProvincia,    
	    cache: false,
	    success: function(data, textStatus, jqXHR){
	    	if(jqXHR.status == 200){
	            console.log(data);
	            //$("#cboProceso").selectpicker('destroy');
	            //$("#cboProceso").html(data).selectpicker('refresh');
	        	$('#cboProvincia').empty().append('<option value="">[ SELECCIONE PROVINCIA ]</option>');
			    $.each(data.data,function(i, row) {
					$("#cboProvincia").append('<option value='+ row.codigo +'>'+ row.prov_ubi +'</option>');
			    });
			    $("#cboProvincia").selectpicker('destroy');
			    $('#cboProvincia').selectpicker('refresh');
	        }
	    }
	});
}


function listarCboDistrito(){

	var requestDistrito 			= new Object();
    requestDistrito["codDepart"]	= $("#cboDepartamento").val();
    requestDistrito["codProv"]		= $("#cboProvincia").val();

	$.ajax({
	    url: base_url+'/Contrato/getSelectDistrito',
	    type: "POST",     
	    dataType: 'json',
	    data:requestDistrito,    
	    cache: false,
	    success: function(data, textStatus, jqXHR){
	    	if(jqXHR.status == 200){
	            console.log(data);
	            //$("#cboProceso").selectpicker('destroy');
	            //$("#cboProceso").html(data).selectpicker('refresh');
	        	$('#cboDistrito').empty().append('<option value="">[ SELECCIONE DISTRITO ]</option>');
			    $.each(data.data,function(i, row) {
					$("#cboDistrito").append('<option value='+ row.id_ubigeo +'>'+ row.dist_ubi +'</option>');
			    });
			    $("#cboDistrito").selectpicker('destroy');
			    $('#cboDistrito').selectpicker('refresh');
	        }
	    }
	});
}


function keynroContrato(){
  var nroContrato = $('#txtContrato').val(); 
  if(nroContrato.length == 17){ 
      $('#txtContrato').val(nroContrato+'-2019-ONPE');
      $('#txtRemuneracion').focus();
    }else{
      //$('#txtContrato').val('LS-ECE2020-');
    }
}


function validarCamposContrato(){
  var $inputs = $('#sign_registerContrato .vld'); 
  var formvalido = true; 
 
  $inputs.each(function() { 
    if($(this).val().length == 0){ 
      formvalido = false;
    }
  });
  // console.log($inputs);
  return formvalido; 
}



/* =================   CONTRATO CABECERA  =================*/
/* TABLE CONTRATOS */
var tableCargos = $('#tableContratos').DataTable({
	"processing": true,
	"serverSide": true,
	"order": [],
	"language": {
		"url": base_url+'/Assets/js/es-pe.json'
	},
	"ajax": {
		"url": base_url+"/Contrato/getContratos",
		"type": "POST",
		"dataType": "json"
	},
	"columns": [
	{"data":"orden"}, 
	{"data":"pedido"},
	{"data":"nombre"}, 
	{"data":"cargo"},
	{"data":"nro_contrato"},
	{"data":"fecha_inicio"}, 
	{"data":"fecha_fin"},
	{"data":"opciones"}, 
	],
	"resonsieve":"true",
	"dDestroy": true,
	"iDisplayLength": 10,
	/*"order": [[0,"asc"]],*/
	"columnDefs": [{
		"targets": [0 , 7],
		"orderable": false,
	}, ],
});


$("#sign_registerContrato").submit(function() {

    var pedido 			= 	$('#cboPedido').val();
	var dni 			=	$('#txtDNI').val();
	var ruc 			=	$('#txtRUC').val();
	var celular			=	$('#txtCelular').val();
	var telefono		=	$('#txtTelefono').val();
	var local 			= 	$('#cboLocal').val();
	var verificado		= 	$('#cboVerificacion').val();
	var sexo 			= 	$('#cboSexo').val();
	var departamento 	= 	$('#cboDepartamento').val();
	var provincia 		= 	$('#cboProvincia').val();
	var distrito 		= 	$('#cboDistrito').val();


	var requestContrato 				= new Object();
    requestContrato["IdContrato"]		= $("#txtIDContrato").val();
    requestContrato["controlContrato"]	= $("#txtcontrolContrato").val();
    requestContrato["pedido"]			= $("#cboPedido").val();
    requestContrato["IdPersonal"]		= $("#txtIDPersonal").val();
	requestContrato["nroContrato"]		= $("#txtNroContrato").val();
	requestContrato["ruc"]				= $("#txtRUC").val();
	requestContrato["fechaInicio"]		= $("#txtFechaInicio").val();
	requestContrato["fechaFin"]			= $("#txtFechaFin").val();
	requestContrato["proceso"]			= $("#cboProceso").val();
	requestContrato["local"]			= $("#cboLocal").val();
	requestContrato["jefe"]				= $("#txtJefe").val();
	requestContrato["verificacion"]		= $("#cboVerificacion").val();
	requestContrato["nacimiento"]		= $("#txtFechaNac").val();
	requestContrato["sexo"]				= $("#cboSexo").val();
	requestContrato["direccion"]		= $("#txtDireccion").val();
	requestContrato["ubigeo"]			= $("#cboDistrito").val();
	requestContrato["celular"]			= $("#txtCelular").val();
	requestContrato["telefono"]			= $("#txtTelefono").val();
	requestContrato["procesoUpd"]		= $('#txtProcesoUpd').val()


	if (validarCamposContrato()) {
		if (pedido.length != 0){
	    	if(dni.length == 8){
	    		if (ruc.length == 11){
	    			if(local.length != 0){
	    				if(verificado.length != 0){
	    					if(sexo.length != 0){
	    						if(departamento.length != 0){
	    							if(provincia.length != 0){
	    								if(distrito.length != 0){
	    									if(celular.length == 9){
	    										
	    											
			    									$.ajax({
			    										url: base_url+'/Contrato/setContrato',
			    										type: "POST",     
			    										dataType: 'json',
			    										data:requestContrato,    
			    										cache: false,

			    										success: function(data, textStatus, jqXHR){
			    											console.log(data);

			    											if(jqXHR.status == 200){
			    												if(data.status){
															// console.log(textStatus);
											        		// console.log(jqXHR.status);
													        		swal(data.title, data.msg, "success");
													        		$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
													        		$('#tableContratos').DataTable().ajax.reload();
													        		//cancelUsuario();
													        		$('#idContratoFormAcad').val(data.idContrato);
													        		$('#idContratoCursoEspec').val(data.idContrato);
													        		$('#idContratoExperiencia').val(data.idContrato);
													        		//listFormAcad(data.idContrato);
													        		//listCursoEspec(data.idContrato);
													        		//listExperiencia(data.idContrato);
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
	    								}
	    							}
	    						}
	    					}
	    				}
	    			}
	    		}
	    	}
	    }
	}
});


function editarContrato(id){
	// alert('ID a mostrar: '+id);
	$('#txtIDContrato').val(id);
	$('#idContratoFormAcad').val(id);
	$('#idContratoCursoEspec').val(id);
	$('#idContratoExperiencia').val(id);
    $('#txtcontrolContrato').val('1');
    //$("#updateCargo").removeAttr('style');
    //$("#agregarCargo").css("display","none");
    // $('#estado_cargo').show();
	$.ajax({
      	type:'GET',
      	url: base_url+"/Contrato/getContrato/"+id,
      	dataType:'json',
      	success: function(data, textStatus, jqXHR){
	       	
	       	if(jqXHR.status == 200){
	       		console.log(data);
		        if(data.status){
			        
			        // var estado = (data.data.estado == 1) ? true : false;
			        listFormAcad();
   					listCursoEspec();
    				listExperiencia();
    				$("#titleContrato").html("<b>EDITAR CONTRATO - "+data.data.codigo_proceso+"</b>");
			        $('#cboPedido').selectpicker('val',data.data.id_pedido);
			        $('#txtMemorandum').val(data.data.memorandum);
			        $('#txtInforme').val(data.data.informe);
			        $('#txtIDPersonal').val(data.data.id_personal);
			        $('#txtDNI').val(data.data.dni).attr('disabled',false);
			        $('#txtNombre').val(data.data.nombre);
			        $('#txtCargo').val(data.data.cargo);
			        $('#txtNroContrato').val(data.data.nro_contrato);
			        $('#txtHonorarios').val(data.data.remuneracion);
			        $('#txtRUC').val(data.data.ruc);
			        $('#txtFechaInicio').val(data.data.fecha_inicio);
			        $('#txtFechaFin').val(data.data.fecha_fin);
			        $('#cboLocal').selectpicker('val',data.data.id_local);
			        $('#txtJefe').val(data.data.nombre_jefe);
			        $('#cboVerificacion').selectpicker('val',data.data.verificacion);
			        $('#txtFechaNac').val(data.data.fecha_nacimiento);
			        $('#cboSexo').selectpicker('val',data.data.sexo);
			        $('#txtDireccion').val(data.data.direccion);
			        $('#cboDepartamento').selectpicker('val',data.data.departamento);
			        listarCboProvincia();
			        setTimeout(function() {
			        	$('#cboProvincia').selectpicker('val',data.data.provincia);
			        	listarCboDistrito(); 
			            setTimeout(function() {
			                $('#cboDistrito').selectpicker('val',data.data.id_ubigeo);
			            },50);
			        },100); 
			        $('#txtCelular').val(data.data.celular);
			        var telefono = (data.data.telefono == 0) ? '' : data.data.telefono;
			        $('#txtTelefono').val(telefono);
			        $('#txtProcesoUpd').val(data.data.id_proceso);
			        

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


function eliminarContrato(id){
	//alert('ID a eliminar es: '+id)
	$('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').removeClass('btn btn-warning');
  	swal({  title: "Eliminar Contrato",
      	text: "¿Desea eliminar este Contrato?",
      	type: "warning",
      	showCancelButton: true,
      	cancelButtonText: "Cancelar",
      	confirmButtonColor: "#ff9600",
      	confirmButtonText: "Aceptar",
      	closeOnConfirm: false },
      	function(){ 
          	$.ajax({
	            type:'DELETE',
	            url: base_url+"/Contrato/delContrato/"+id,
	            dataType:'json',
	            success: function(data, textStatus, jqXHR){
	              	if(jqXHR.status == 200){
	              		console.log(data);
	              		if(data.status){

	              			swal(data.title, data.msg, "success");
		        			$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
		        			$('#tableContratos').DataTable().ajax.reload();
		        			cancelContrato();
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


function verContrato(id){
	$.ajax({
      	type:'GET',
      	url: base_url+"/Contrato/getContratoPDF/"+id,
      	dataType:'json',
      	success: function(data, textStatus, jqXHR){
	       	
	       	if(jqXHR.status == 200){
	       		console.log(data);
		        if(data.status){
			        			        
		        	window.open(base_url+'/'+data.data+'.pdf');
			        setTimeout(function() {
			        	eliminarfile(data.data+'.pdf');
			        },5000);;
			      	return false;

		      	}else{
					swal(data.title, data.msg, "error");
		        	$('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
		        	return false;
		      	}
	      	}
    	}
  	});
}

function cancelContrato(){
	
	$("#titleContrato").html("<strong>REGISTRAR CONTRATO</strong>");
	$('#sign_registerContrato')[0].reset();
	$('#sign_registerContrato').validate().resetForm();
	$('#sign_registerContrato .form-group').removeClass('has-success');
	$('#txtcontrolContrato').val('0');
	$('#cboPedido').selectpicker("refresh");
	$('#cboLocal').selectpicker("refresh");
	$('#cboVerificacion').selectpicker("refresh");
	$('#cboSexo').selectpicker("refresh");
	$('#cboDepartamento').selectpicker("refresh");
	$('#cboProvincia').selectpicker("destroy");
	$('#cboDistrito').selectpicker("destroy");
	$('#cboProvincia').html( '<option value="">[ SELECCIONE PROVINCIA ]</option>' ).selectpicker('refresh');
	$('#cboDistrito').html( '<option value="">[ SELECCIONE DISTRITO ]</option>' ).selectpicker('refresh');
	$('#txtDNI').attr('disabled',true);
	$('#idContratoFormAcad').val('');
	$('#idContratoCursoEspec').val('');
	$('#idContratoExperiencia').val('');
	$('#txtTiempoGeneral').val('');
	$('#txttiempoExpecifica').val('');
	listFormAcad();
	listCursoEspec();
	listExperiencia();
	tabs();
}


function tabs(){
	$('#step3').removeClass('active');
	$('#step4').removeClass('active');
	$('#step5').removeClass('active');
	$('#step1').addClass('active');

	$('#tab3').removeClass('active');
	$('#tab4').removeClass('active');
	$('#tab5').removeClass('active');
	$('#tab1').addClass('active');
	$('#barra').css('width', '25%');
}


function eliminarfile(id){
      
	$.ajax({
		type:'DELETE',
		url: base_url+'/Contrato/eliminarfile/'+id,
		success: function(data){

		}
	});
   	return false;
}

/* =================   CONTRATO FROMACION ACADEMICA  =================*/

function listFormAcad(){ 
	var idContrato = $('#idContratoFormAcad').val();
	var tableFormAcad = $('#tableFormAcad').DataTable({
		//"processing": true,
		//"serverSide": true,
		"destroy": true,
		"order": [],
		"language": {
			"url": base_url+'/Assets/js/es-pe.json'
		},
		"ajax": {
			"url": base_url+"/Contrato/getFormAcad",
			"type": "POST",
			'data' : { 'idContrato' : idContrato },
			"dataType": "json"
		},
		"columns": [
		{"data":"orden"}, 
		{"data":"grado_estudio"},
		{"data":"nivel_estudio"}, 
		{"data":"especialidad"},
		{"data":"centro_estudio"},
		{"data":"fecha_obtencion"},
		{"data":"opciones"}, 
		],
		"resonsieve":"true",
		"dDestroy": true,
		"iDisplayLength": 10,
		/*"order": [[0,"asc"]],*/
		"columnDefs": [{
			"targets": [0 , 6],
			"orderable": false,
		}, ],
	});
}


function listcboGradoEstudio(){
	$.ajax({
	    type: "GET",
	    async : false,
	    dataType:'json',
	    url: base_url+'/Contrato/getSelectGrado', 
	    success: function(data, textStatus, jqXHR){
	    	if(jqXHR.status == 200){
	            //console.log(data);
	            //$("#cboTipoEstudios").selectpicker('destroy');
	            //$("#cboTipoEstudios").html(data).selectpicker('refresh');
	        	$('#cboTipoEstudios').empty().append('<option value="">[ SELECCIONE GRADO ]</option>');
			    $.each(data,function(i, row) {
					$("#cboTipoEstudios").append('<option value='+ row.id_grado +'>'+ row.grado_estudio +'</option>');
			    });
			    $('#cboTipoEstudios').selectpicker();
	        }
	    }
	});
}


function listarCboNivelEstudio(){
	var requestNivel 			= new Object();
    requestNivel["idGrado"]	= $("#cboTipoEstudios").val();

	$.ajax({
	    url: base_url+'/Contrato/getSelectNivel',
	    type: "POST",     
	    dataType: 'json',
	    data:requestNivel,    
	    cache: false,
	    success: function(data, textStatus, jqXHR){
	    	if(jqXHR.status == 200){
	            console.log(data);
	            //$("#cboNivelEstudios").selectpicker('destroy');
	            //$("#cboNivelEstudios").html(data).selectpicker('refresh');
	        	$('#cboNivelEstudios').empty().append('<option value="">[ SELECCIONE NIVEL ]</option>');
			    $.each(data.data,function(i, row) {
					$("#cboNivelEstudios").append('<option value='+ row.id_nivel +'>'+ row.nivel_estudio +'</option>');
			    });
			    $("#cboNivelEstudios").selectpicker('destroy');
			    $('#cboNivelEstudios').selectpicker('refresh');
	        }
	    }
	});
}


$("#cboTipoEstudios").on("change", function() {
	$('#sign_registerFormAcad').validate().resetForm();
	var grado = $(this).val();
	if(grado == 5){
		$('#txtEspecialidad').attr('disabled', true).removeClass('vld').val('');
		$('#txtCentroEstudio').attr('disabled', true).removeClass('vld').val('');
		$('#cboNivelEstudios').attr('disabled', true);
	}else{
		$('#txtEspecialidad').attr('disabled', false).addClass('vld');
		$('#txtCentroEstudio').attr('disabled', false).addClass('vld');
		$('#cboNivelEstudios').attr('disabled', false);
	}
});


$("#cboNivelEstudios").on("change", function() { 
	$('#cboNivelEstudios-error').hide();
});


function validarCamposFormAcad(){
  var $inputs = $('#sign_registerFormAcad .vld'); 
  var formvalido = true; 
 
  $inputs.each(function() { 
    if($(this).val().length == 0){ 
      formvalido = false;
    }
  });
  // console.log($inputs);
  return formvalido; 
}


$("#sign_registerFormAcad").submit(function() {
	
	var tipoEstudio 	= 	$('#cboTipoEstudios').val();
	var nivelEstudio	=	$('#cboNivelEstudios').val();
	var vldNivel = (tipoEstudio == 5 ) ? '9' : nivelEstudio ;

	var requestFormAcad 				= new Object();
    requestFormAcad["idFormAcad"]		= $("#txtIDFormAcad").val();
    requestFormAcad["controlFormAcad"]	= $("#txtcontrolFormAcad").val();
    requestFormAcad["IdContrato"]		= $("#idContratoFormAcad").val();
    requestFormAcad["tipoEstudio"]		= $("#cboTipoEstudios").val();
    requestFormAcad["nivelEstudio"]		= $("#cboNivelEstudios").val();
	requestFormAcad["especialidad"]		= $("#txtEspecialidad").val();
	requestFormAcad["centroEstudio"]	= $("#txtCentroEstudio").val();
	requestFormAcad["fechaEstudio"]		= $("#txtFechaEstudio").val();

	
	if (validarCamposFormAcad()) {
		if (tipoEstudio.length != 0){
		    if(vldNivel.length != 0){
		    	if($("#idContratoFormAcad").val() !== ''){
		    		$.ajax({
		    			url: base_url+'/Contrato/setFormAcad',
		    			type: "POST",     
		    			dataType: 'json',
		    			data:requestFormAcad,    
		    			cache: false,

		    			success: function(data, textStatus, jqXHR){
		    				console.log(data);

		    				if(jqXHR.status == 200){
		    					if(data.status){
		    						// console.log(textStatus);
		    						// console.log(jqXHR.status);
		    						swal(data.title, data.msg, "success");
		    						$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
		    						listFormAcad();
		    						//$('#tableFormAcad').DataTable().ajax.reload();
		    						cancelFormAcad();
		    						$('#modal_FormAcad').modal(data.mdl);
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

		    	}else{
					swal("Alerta!", "No se ha registrado ningun contrato en el Paso 1", "warning");
        			$('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').addClass('btn btn-warning');
        			return false;
				}
		    }
		}
	}
});


function editarFormAcad(id){
	// alert('ID a mostrar: '+id);
	$('#txtIDFormAcad').val(id);
    $('#txtcontrolFormAcad').val('1');
    $("#updateFormAcad").removeAttr('style');
    $("#agregarFormAcad").css("display","none");
    $("#titleFormAcad").html("<strong>EDITAR FORMACION ACADEMICA</strong>");
    // $('#estado_cargo').show();
	$.ajax({
      	type:'GET',
      	url: base_url+"/Contrato/getFormAcadId/"+id,
      	dataType:'json',
      	success: function(data, textStatus, jqXHR){
	       	
	       	if(jqXHR.status == 200){
	       		console.log(data);
		        if(data.status){
			        
			        // var estado = (data.data.estado == 1) ? true : false;
			        $('#cboTipoEstudios').selectpicker('val',data.data.id_estudio);
			        listarCboNivelEstudio();
			        setTimeout(function() {
			        	$('#cboNivelEstudios').selectpicker('val',data.data.id_nivel);
			        },100); 
			        $('#txtEspecialidad').val(data.data.especialidad);
			        $('#txtCentroEstudio').val(data.data.centro_estudio);
			        $('#txtFechaEstudio').val(data.data.fecha_obtencion);
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


function eliminarFormAcad(id){
	//alert('ID a eliminar es: '+id)
	$('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').removeClass('btn btn-warning');
  	swal({  title: "Eliminar Formacion Academica",
      	text: "¿Desea eliminar esta Formacion Academica?",
      	type: "warning",
      	showCancelButton: true,
      	cancelButtonText: "Cancelar",
      	confirmButtonColor: "#ff9600",
      	confirmButtonText: "Aceptar",
      	closeOnConfirm: false },
      	function(){ 
          	$.ajax({
	            type:'DELETE',
	            url: base_url+"/Contrato/delFormAcad/"+id,
	            dataType:'json',
	            success: function(data, textStatus, jqXHR){
	              	if(jqXHR.status == 200){
	              		console.log(data);
	              		if(data.status){

	              			swal(data.title, data.msg, "success");
		        			$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
		        			listFormAcad();
		        			cancelFormAcad();
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


function cancelFormAcad(){
	$('#txtIDFormAcad').val('');
	$('#cboNivelEstudios').attr("disabled",false)
	$('#txtEspecialidad').attr('disabled', false).addClass('vld').val('');
	$('#txtCentroEstudio').attr('disabled', false).addClass('vld').val('');
	$("#txtFechaEstudio").val('');
	$("#agregarFormAcad").removeAttr('style');
	$("#updateFormAcad").css("display","none");
	$("#titleFormAcad").html("<strong>REGISTRAR FORMACION ACADEMICA</strong>");
	//$('#sign_registerFormAcad')[0].reset();
	$('#sign_registerFormAcad').validate().resetForm();
	$('#sign_registerFormAcad .form-group').removeClass('has-success');
	$('#cboTipoEstudios').selectpicker("destroy");
	listcboGradoEstudio();
	$('#cboNivelEstudios').selectpicker("destroy");
	$('#cboNivelEstudios').html( '<option value="">[ SELECCIONE NIVEL ]</option>' ).selectpicker('refresh');
	$('#txtcontrolFormAcad').val('0');
}




/* =================   CONTRATO CURSOS  =================*/

function listCursoEspec(){ 
	var idContrato = $('#idContratoCursoEspec').val();
	var tableCursoEspec = $('#tableCursoEspec').DataTable({
		//"processing": true,
		//"serverSide": true,
		"destroy": true,
		"order": [],
		"language": {
			"url": base_url+'/Assets/js/es-pe.json'
		},
		"ajax": {
			"url": base_url+"/Contrato/getCursoEspec",
			"type": "POST",
			'data' : { 'idContrato' : idContrato },
			"dataType": "json"
		},
		"columns": [
		{"data":"orden"}, 
		{"data":"tipo_estudio"},
		{"data":"descripcion"}, 
		{"data":"centro_estudioCurso"},
		{"data":"fecha_inicioCurso"},
		{"data":"fecha_finCurso"},
		{"data":"horas_lectivas"},
		{"data":"opciones"}, 
		],
		"resonsieve":"true",
		"dDestroy": true,
		"iDisplayLength": 10,
		/*"order": [[0,"asc"]],*/
		"columnDefs": [{
			"targets": [0 , 7],
			"orderable": false,
		}, ],
	});
}


function validarCamposCurso(){
  var $inputs = $('#sign_registerCursoEspec .vld'); 
  var formvalido = true; 
 
  $inputs.each(function() { 
    if($(this).val().length == 0){ 
      formvalido = false;
    }
  });
  // console.log($inputs);
  return formvalido; 
}


$("#cboTipoCurso").on("change", function() { 
	$('#cboTipoCurso-error').hide();
});


$("#sign_registerCursoEspec").submit(function() {
	
	var tipoCurso 	= 	$('#cboTipoCurso').val();
	
	var requestCurso 					= new Object();
    requestCurso["idCursoEspec"]		= $("#txtIDCursoEspec").val();
    requestCurso["controlCursoEspec"]	= $("#txtcontrolCursoEspec").val();
    requestCurso["IdContrato"]			= $("#idContratoCursoEspec").val();
    requestCurso["cursoTipo"]			= $("#cboTipoCurso").val();
    requestCurso["cursoDescrip"]		= $("#txtCursoDescrip").val();
	requestCurso["cursoCentroEstudio"]	= $("#txtCursoCentroEstudio").val();
	requestCurso["cursoFechaInicio"]	= $("#txtFechaCursoInicio").val();
	requestCurso["cursoFechaFin"]		= $("#txtFechaCursoFin").val();
	requestCurso["cursoHoras"]			= $("#txtCursoHoras").val();

	
	if (validarCamposCurso()) {
		if (tipoCurso.length != 0){
	    	if($("#idContratoCursoEspec").val() !== ''){

	    		$.ajax({
	    			url: base_url+'/Contrato/setCursoEspec',
	    			type: "POST",     
	    			dataType: 'json',
	    			data:requestCurso,    
	    			cache: false,

	    			success: function(data, textStatus, jqXHR){
	    				console.log(data);

	    				if(jqXHR.status == 200){
	    					if(data.status){
	    						// console.log(textStatus);
	    						// console.log(jqXHR.status);
	    						swal(data.title, data.msg, "success");
	    						$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
	    						listCursoEspec();
	    						//$('#tableCursoEspec').DataTable().ajax.reload();
	    						cancelCursoEspec();
	    						$('#modal_CursoEspec').modal(data.mdl);
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

	    	
	    	}else{
				swal("Alerta!", "No se ha registrado ningun contrato en el Paso 1", "warning");
		        $('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').addClass('btn btn-warning');
		        return false;
			}
		}
	}
});


function editarCursoEspec(id){
	// alert('ID a mostrar: '+id);
	$('#txtIDCursoEspec').val(id);
    $('#txtcontrolCursoEspec').val('1');
    $("#updaterCursoEspec").removeAttr('style');
    $("#agregarCursoEspec").css("display","none");
    $("#titleFormAcad").html("<strong>EDITAR CURSO Y/O ESPECIALIZACION</strong>");
    // $('#estado_cargo').show();
	$.ajax({
      	type:'GET',
      	url: base_url+"/Contrato/getCursoEspecId/"+id,
      	dataType:'json',
      	success: function(data, textStatus, jqXHR){
	       	
	       	if(jqXHR.status == 200){
	       		console.log(data);
		        if(data.status){
			        
			        // var estado = (data.data.estado == 1) ? true : false;
			        $('#cboTipoCurso').selectpicker('val',data.data.id_especializacion);
			        $('#txtCursoDescrip').val(data.data.descripcion);
			        $('#txtCursoCentroEstudio').val(data.data.centro_estudioCurso);
			        $('#txtFechaCursoInicio').val(data.data.fecha_inicioCurso);
			        $('#txtFechaCursoFin').val(data.data.fecha_finCurso);
			        $('#txtCursoHoras').val(data.data.horas_lectivas);
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


function eliminarCursoEspec(id){
	//alert('ID a eliminar es: '+id)
	$('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').removeClass('btn btn-warning');
  	swal({  title: "Eliminar Cursos y/o Especializacion",
      	text: "¿Desea eliminar este Cursos y/o Especializacion?",
      	type: "warning",
      	showCancelButton: true,
      	cancelButtonText: "Cancelar",
      	confirmButtonColor: "#ff9600",
      	confirmButtonText: "Aceptar",
      	closeOnConfirm: false },
      	function(){ 
          	$.ajax({
	            type:'DELETE',
	            url: base_url+"/Contrato/delCursoEspec/"+id,
	            dataType:'json',
	            success: function(data, textStatus, jqXHR){
	              	if(jqXHR.status == 200){
	              		console.log(data);
	              		if(data.status){

	              			swal(data.title, data.msg, "success");
		        			$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
		        			listCursoEspec();
		        			cancelCursoEspec();
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


function cancelCursoEspec(){
	$('#txtIDCursoEspec').val('');
	$('#cboTipoCurso').selectpicker('val','');
	$('#txtCursoDescrip').val('')
	$('#txtCursoCentroEstudio').val('');
	$('#txtFechaCursoInicio').val('');
	$("#txtFechaCursoFin").val('');
	$("#txtCursoHoras").val('');
	$("#agregarCurso").removeAttr('style');
	$("#updaterCurso").css("display","none");
	$("#titleCurso").html("<strong>REGISTRAR CURSO Y/O ESPECIALIZACION</strong>");
	//$('#sign_registerCursoEspec')[0].reset();
	$('#sign_registerCursoEspec').validate().resetForm();
	$('#sign_registerCursoEspec .form-group').removeClass('has-success');
	$('#txtcontrolCursoEspec').val('0');
}




/* =================   CONTRATO EXPERCIENCIA LABORAL  =================*/

function listExperiencia(){
	selectCountExperiencia();
	setTimeout(function() {
		$('#countGeneral').html(tiempoLaboralGenExp($('#txtTiempoGeneral').val()));
		$('#countExpecifica').html(tiempoLaboralGenExp($('#txttiempoExpecifica').val()));
	},50);
	

	var idContrato = $('#idContratoExperiencia').val();
	var tableExperiencia = $('#tableExperiencia').DataTable({
		//"processing": true,
		//"serverSide": true,
		"destroy": true,
		"order": [],
		"language": {
			"url": base_url+'/Assets/js/es-pe.json'
		},
		"ajax": {
			"url": base_url+"/Contrato/getExperiencia",
			"type": "POST",
			'data' : { 'idContrato' : idContrato },
			"dataType": "json"
		},
		"columns": [
		{"data":"orden"}, 
		{"data":"id_tipo"},
		{"data":"id_tipoEntidad"}, 
		{"data":"entidad"},
		{"data":"area_entidad"},
		{"data":"cargo_entidad"},
		{"data":"fecha_inicioExp"},
		{"data":"fecha_finExp"},
		{"data":"tiempo"},
		{"data":"opciones"}, 
		],
		"resonsieve":"true",
		"dDestroy": true,
		"iDisplayLength": 10,
		/*"order": [[0,"asc"]],*/
		"columnDefs": [{
			"targets": [0 , 8],
			"orderable": false,
		}, ],
	});
}


function resetFechaFinal() {
	$("#txtFechaExperienFin").val('');
	$('#txtTiempoLaboral').val('');
	$('#txtTiempoDias').val('');
} 


$("#cboTipoExperiencia").on("change", function() { 
	$('#cboTipoExperiencia-error').hide();
});


$("#cboTipoEntidad").on("change", function() { 
	$('#cboTipoEntidad-error').hide();
});


function tiempoLaboral(){
	var fechaInicioExp	= $("#txtFechaExperienInicio").val();
	var fechaFinExp		= $("#txtFechaExperienFin").val();
	
	var diff = new Date(fechaFinExp).getTime() - new Date(fechaInicioExp).getTime();
	var dias = diff/(1000*60*60*24);

	var anios = Math.trunc(dias/365);
	var meses = Math.trunc((dias%365)/30);
	var dia = (dias%365)%30;

	$('#txtTiempoLaboral').val(anios+' AÑO(S) '+meses+' MES(ES) '+dia+' DIA(S)');
	$('#txtTiempoDias').val(dias);
}


function tiempoLaboralGenExp(dias){
	
	var anios = Math.trunc(dias/365);
	var meses = Math.trunc((dias%365)/30);
	var dia = (dias%365)%30;

	return anios+' AÑO(S) '+meses+' MES(ES) '+dia+' DIA(S)';
}


function validarCamposExperiencia(){
  var $inputs = $('#sign_registerExperiencia .vld'); 
  var formvalido = true; 
 
  $inputs.each(function() { 
    if($(this).val().length == 0){ 
      formvalido = false;
    }
  });
  // console.log($inputs);
  return formvalido; 
}


$("#sign_registerExperiencia").submit(function() {
	
	var tipoExperiencia 	= 	$('#cboTipoExperiencia').val();
	var tipoEntidad		 	= 	$('#cboTipoEntidad').val();
	
	var requestExperiencia 							= new Object();
    requestExperiencia["idExperiencia"]				= $("#txtIDExperiencia").val();
    requestExperiencia["controlExperiencia"]		= $("#txtcontrolExperiencia").val();
    requestExperiencia["IdContrato"]				= $("#idContratoExperiencia").val();
    requestExperiencia["experienciaTipo"]			= $("#cboTipoExperiencia").val();
    requestExperiencia["experienciaTipoEntidad"]	= $("#cboTipoEntidad").val();
	requestExperiencia["experienciaEntidad"]		= $("#txtNombreEntidad").val();
	requestExperiencia["experienciaArea"]			= $("#txtAreaEntidad").val();
	requestExperiencia["experienciaCargo"]			= $("#txtCargoEntidad").val();
	requestExperiencia["experienciaFechaInicio"]	= $("#txtFechaExperienInicio").val();
	requestExperiencia["experienciaFechaFin"]		= $("#txtFechaExperienFin").val();
	requestExperiencia["experienciaTiempoLaboral"]	= $("#txtTiempoLaboral").val();
	requestExperiencia["experienciaTiempoDias"]		= $("#txtTiempoDias").val();
	

	if (validarCamposExperiencia()) {
		if (tipoExperiencia.length != 0){
	    	if (tipoEntidad.length != 0){
	    		if($("#idContratoExperiencia").val() !== ''){
		    		$.ajax({
		    			url: base_url+'/Contrato/setExperiencia',
		    			type: "POST",     
		    			dataType: 'json',
		    			data:requestExperiencia,    
		    			cache: false,

		    			success: function(data, textStatus, jqXHR){
		    				console.log(data);

		    				if(jqXHR.status == 200){
		    					if(data.status){
		    						// console.log(textStatus);
		    						// console.log(jqXHR.status);
		    						swal(data.title, data.msg, "success");
		    						$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
		    						listExperiencia();
		    						//$('#tableExperiencia').DataTable().ajax.reload();
		    						cancelExperiencia();
		    						$('#modal_Experiencia').modal(data.mdl);
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
		    	}else{
		    		swal("Alerta!", "No se ha registrado ningun contrato en el Paso 1", "warning");
        			$('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').addClass('btn btn-warning');
        			return false;
		    	}
	    	}
	    }
	}
});


function editarExperiencia(id){
	// alert('ID a mostrar: '+id);
	$('#txtIDExperiencia').val(id);
    $('#txtcontrolExperiencia').val('1');
    $("#updateExperiencia").removeAttr('style');
    $("#agregarExperiencia").css("display","none");
    $("#titleExperiencia").html("<strong>EXPERIENCIA LABORAL</strong>");
    // $('#estado_cargo').show();
	$.ajax({
      	type:'GET',
      	url: base_url+"/Contrato/getExperienciaId/"+id,
      	dataType:'json',
      	success: function(data, textStatus, jqXHR){
	       	
	       	if(jqXHR.status == 200){
	       		console.log(data);
		        if(data.status){
			        
			        // var estado = (data.data.estado == 1) ? true : false;
			        $('#cboTipoExperiencia').selectpicker('val',data.data.id_tipo);
			        $('#cboTipoEntidad').selectpicker('val',data.data.id_tipoEntidad);
			        $('#txtNombreEntidad').val(data.data.entidad);
			        $('#txtAreaEntidad').val(data.data.area_entidad);
			        $('#txtCargoEntidad').val(data.data.cargo_entidad);
			        $('#txtFechaExperienInicio').val(data.data.fecha_inicioExp);
			        $('#txtFechaExperienFin').val(data.data.fecha_finExp);
			        $('#txtTiempoLaboral').val(data.data.tiempo);
			        $('#txtTiempoDias').val(data.data.tiempo_dias);
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


function eliminarExperiencia(id){
	//alert('ID a eliminar es: '+id)
	$('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').removeClass('btn btn-warning');
  	swal({  title: "Eliminar Experiencia Laboral",
      	text: "¿Desea eliminar esta Experiencia Laboral?",
      	type: "warning",
      	showCancelButton: true,
      	cancelButtonText: "Cancelar",
      	confirmButtonColor: "#ff9600",
      	confirmButtonText: "Aceptar",
      	closeOnConfirm: false },
      	function(){ 
          	$.ajax({
	            type:'DELETE',
	            url: base_url+"/Contrato/delExperiencia/"+id,
	            dataType:'json',
	            success: function(data, textStatus, jqXHR){
	              	if(jqXHR.status == 200){
	              		console.log(data);
	              		if(data.status){

	              			swal(data.title, data.msg, "success");
		        			$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
		        			listExperiencia();
		        			cancelExperiencia();
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


function cancelExperiencia(){
	$("#txtIDExperiencia").val('');
	$('#cboTipoExperiencia').selectpicker('val','');
	$('#cboTipoEntidad').selectpicker('val','');
	$('#txtNombreEntidad').val('')
	$('#txtAreaEntidad').val('');
	$('#txtCargoEntidad').val('');
	$("#txtFechaExperienInicio").val('');
	$("#txtFechaExperienFin").val('');
	$("#txtTiempoLaboral").val('');
	$("#txtTiempoDias").val('');
	$("#agregarExperiencia").removeAttr('style');
	$("#updateExperiencia").css("display","none");
	$("#titleExperiencia").html("<strong>REGISTRAR EXPERIENCIA LABORAL</strong>");
	//$('#sign_registerExperiencia')[0].reset();
	$('#sign_registerExperiencia').validate().resetForm();
	$('#sign_registerExperiencia .form-group').removeClass('has-success');
	$('#txtcontrolExperiencia').val('0');
}


function selectCountExperiencia(){
	// alert('ID a mostrar: '+id);
	var idContrato = $('#idContratoExperiencia').val();

	$.ajax({
      	type:'GET',
      	url: base_url+"/Contrato/getCountExperiencia/"+idContrato,
      	dataType:'json',
      	success: function(data, textStatus, jqXHR){
	       	
	       	if(jqXHR.status == 200){
	       		console.log(data);
		        if(data.status){
			        // var estado = (data.data.estado == 1) ? true : false;
			        $('#txtTiempoGeneral').val(data.data[0].total_experiencia);
			        $('#txttiempoExpecifica').val(data.data[1].total_experiencia);
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
	