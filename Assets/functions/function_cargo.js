// JavaScript Document
$(document).ready(function(){

	//verlistadoModulos();
	listCargoPedido();
	
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


/*================================================  FUNCTIONS CARGO  ================================================*/
/* TABLE CARGOS */
var tableCargos = $('#tableCargos').DataTable({
	"processing": true,
	"serverSide": true,
	"order": [],
	"language": {
		"url": base_url+'/Assets/js/es-pe.json'
	},
	"ajax": {
		"url": base_url+"/Cargo/getCargos",
		"type": "POST",
		"dataType": "json"
	},
	"columns": [
	{"data":"orden"}, 
	{"data":"cargo"},
	{"data":"remuneracion"}, 
	{"data":"estado"},
	{"data":"opciones"}, 
	],
	"resonsieve":"true",
	"dDestroy": true,
	"iDisplayLength": 10,
	/*"order": [[0,"asc"]],*/
	"columnDefs": [{
		"targets": [0 , 4],
		"orderable": false,
	}, ],
});


/* REGISTER CARGOS */
$("#form_registerCargo").submit(function() {
    var cargo 			= $('#txtcargo').val();
    var remuneracion	= $('#txtremuneracion').val();
    var total 			= cargo.length * remuneracion.length;

    var requestCArgo 				= new Object();
    requestCArgo["Idcargo"]			= $("#txtIDCargo").val();
    requestCArgo["controlCargo"]	= $("#txtcontrolCargo").val();
    requestCArgo["cargo"]			= $("#txtcargo").val();
	requestCArgo["remuneracion"]	= $("#txtremuneracion").val();
	requestCArgo["estado"]			= ($('#chkestadoCargo').prop('checked') ? '1' : '2');

    if (total>0){
        $.ajax({
            url: base_url+'/Cargo/setCargo',
	        type: "POST",     
	        dataType: 'json',
	        data:requestCArgo,    
	        cache: false,
	        	
	        success: function(data, textStatus, jqXHR){
	        	console.log(data.msg);

	        	if(jqXHR.status == 200){
	        		if(data.status){
						/*console.log(textStatus);
		        		console.log(jqXHR.status);*/
		        		swal(data.title, data.msg, "success");
		        		$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
		        		$('#tableCargos').DataTable().ajax.reload();
		        		cancelCargo();
		        		return false;

	        		}else{
		        		swal({  title: 	data.title,
							    text: 	data.msg,
							    type: 	"error"},
							    function(){ 
							    	setTimeout(function() {
							          $('#txtcargo').focus();
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
});


/* SHOW CARGO */
function editarCargo(id){
	// alert('ID a mostrar: '+id);
	$('#txtIDCargo').val(id);
    $('#txtcontrolCargo').val('1');
    $("#updateCargo").removeAttr('style');
    $("#agregarCargo").css("display","none");
    $("#titleCargo").html("<strong>EDITAR CARGO</strong>");
    $('#estado_cargo').show();

	$.ajax({
      	type:'GET',
      	url: base_url+"/Cargo/getCargo/"+id,
      	dataType:'json',
      	success: function(data, textStatus, jqXHR){
	       	
	       	if(jqXHR.status == 200){
	       		console.log(data);
		        if(data.status){
			        
			        var estado = (data.data.estado == 1) ? true : false;
			        $('#txtcargo').val(data.data.cargo).attr('disabled',true);
			        $('#txtremuneracion').val(data.data.remuneracion);
			        $('#chkestadoCargo').prop("checked",estado);
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


/* DELETE CARGO */
function eliminarCargo(id){
	//alert('ID a eliminar es: '+id)
	$('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').removeClass('btn btn-warning');
  	swal({  title: "Eliminar Cargo",
      	text: "¿Desea eliminar este Cargo?",
      	type: "warning",
      	showCancelButton: true,
      	cancelButtonText: "Cancelar",
      	confirmButtonColor: "#ff9600",
      	confirmButtonText: "Aceptar",
      	closeOnConfirm: false },
      	function(){ 
          	$.ajax({
	            type:'DELETE',
	            url: base_url+"/Cargo/delCargo/"+id,
	            dataType:'json',
	            success: function(data, textStatus, jqXHR){
	              	if(jqXHR.status == 200){
	              		console.log(data);
	              		if(data.status){

	              			swal(data.title, data.msg, "success");
		        			$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
		        			$('#tableCargos').DataTable().ajax.reload();
		        			cancelCargo();
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


/* CANCEL CARGO */
function cancelCargo(){
      $("#agregarCargo").removeAttr('style');
      $("#updateCargo").css("display","none");
      $("#titleCargo").html("<strong>REGISTRAR CARGO</strong>");
      $('#estado_cargo').hide();
      $('#form_registerCargo')[0].reset();
      $('#form_registerCargo').validate().resetForm();
      $('#txtcontrolCargo').val('0');
      $('#txtcargo').attr('disabled',false);
      $('#form_registerCargo .form-group').removeClass('has-success');
}



function descargarCargo(){
	$.ajax({
    	url: base_url+'/Cargo/getexportCargo',
    	type: "POST",     
    	dataType: 'json',
    	cache: false,

    	success: function(data, textStatus, jqXHR){ console.log(data);
    		console.log(data.msg);

    		if(jqXHR.status == 200){
    			if(data.status){
    				// console.log(textStatus);
    				// console.log(jqXHR.status);
    				window.open(base_url+'/'+data.data);
			        setTimeout(function() {
			        	eliminarfile(data.data);
			        },5000);
    				
    				return false;

    			}else{
    				swal({  title: 	data.title,
    					text: 	data.msg,
    					type: 	"warning"},
    					function(){ 
    						setTimeout(function() {
    							// $('#txtperfil').focus();
    						}, 10)
    					});
    				$('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').addClass('btn btn-warning');
    				return false;
    			}
    		}

    	},
    	error: 	function(jqXHR,textStatus,errorThrown){
    		console.log(errorThrown);
    		// console.log(textStatus);
    		// console.log(jqXHR.status);
    	}
    });
    return false;
}


function eliminarfile(id){
      
	$.ajax({
		type:'DELETE',
		url: base_url+'/Cargo/eliminarfile/'+id,
		success: function(data){

		}
	});
   	return false;
}



/*================================================  FUNCTIONS PEDIDO  ================================================*/

/* TABLE PEDIDOS */
var tablePedidos = $('#tablePedidos').DataTable({
	"processing": true,
	"serverSide": true,
	"order": [],
	"language": {
		"url": base_url+'/Assets/js/es-pe.json'
	},
	"ajax": {
		"url": base_url+"/Pedido/getPedidos",
		"type": "POST",
		"dataType": "json"
	},
	"columns": [
	{"data":"orden"}, 
	{"data":"pedido"},
	{"data":"memorandum"}, 
	{"data":"informe"},
	{"data":"fecha_pedido"},
	{"data":"opciones"}, 
	],
	"resonsieve":"true",
	"dDestroy": true,
	"iDisplayLength": 10,
	/*"order": [[0,"asc"]],*/
	"columnDefs": [{
		"targets": [0 , 5],
		"orderable": false,
	}, ],
});


function agruparCargo(){
	var detalle;
	var detalles =  new Array();
	$("#tablePedidoCargos input:checkbox:checked").each(function() {
		var idCargo 	= $(this).val();
		var cantCargo 	= $('#nroCantidad'+idCargo).val();
		detalle = new Object();
		detalle['IdCargo'] = idCargo;
		detalle['cantCargo'] = cantCargo;
		detalles.push(detalle);
		//alert(idCargo+' - '+cantCargo);
	});
    
    return detalles;         
}


/* REGISTER CARGOS */
$("#sign_registerPedido").submit(function() {
    var pedido 			= $('#txtpedido').val();
    var memorandum		= $('#txtmemorandum').val();
    var informe			= $('#txtinforme').val();
    var fechaPedido 	= $("#txtFechaPedido").val();
    var total 			= pedido.length * memorandum.length * informe.length * fechaPedido.length; 

    var requestPedido 				= new Object();
    requestPedido["IDPedido"]		= $("#txtIDPedido").val();
    requestPedido["controlPedido"]	= $("#txtcontrolPedido").val();
    requestPedido["pedido"]			= $("#txtpedido").val();
	requestPedido["memorandum"]		= $("#txtmemorandum").val();
	requestPedido["informe"]		= $("#txtinforme").val();
	requestPedido["fechaPedido"]	= $("#txtFechaPedido").val();
	requestPedido["observacion"]	= $("#txtobservacionPedido").val();
	requestPedido["cargos"]  		= JSON.stringify(agruparCargo());
	//requestPedido["estado"]		= ($('#chkestadoCargo').prop('checked') ? '1' : '2');
	var TABLA   = $("#tablePedidoCargos input:checkbox:checked");
    
    if (total>0){ 
    	if (TABLA.length === 0) {
	      swal("Alerta!", "Debe seleccionar minimo un Cargo", "warning");
	      $('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').addClass('btn btn-warning');
	      return false;
  
  		}else{
	        $.ajax({
	            url: base_url+'/Pedido/setPedido',
		        type: "POST",     
		        dataType: 'json',
		        data:requestPedido,    
		        cache: false,
		        	
		        success: function(data, textStatus, jqXHR){
		        	console.log(data.msg);

		        	if(jqXHR.status == 200){
		        		if(data.status){
							/*console.log(textStatus);
			        		console.log(jqXHR.status);*/
			        		swal(data.title, data.msg, "success");
			        		$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
			        		$('#tablePedidos').DataTable().ajax.reload();
			        		cancelPedido();
			        		return false;

		        		}else{
			        		swal({  title: 	data.title,
								    text: 	data.msg,
								    type: 	"error"},
								    function(){ 
								    	setTimeout(function() {
								          $('#txtpedido').focus();
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


/* LISTA DE CARGOS PARA PEDIDO */
function listCargoPedido(){
	$.ajax({
	    type: "GET",
	    async : false,
	    url: base_url+'/Pedido/getListCargos', 
	    success: function(data, textStatus, jqXHR){
	    	if(jqXHR.status == 200){
	            //console.log(data);
	            //$("#cbocargo").selectpicker('destroy');
	            //$("#cbocargo").html(data).selectpicker('refresh');
	            $('#tablePedidoCargos tbody').html(data);
	        }
	    }
	});
}

function checkEnable(id){
  if( $('#chkCargo'+id).is(':checked') ) {
    $('#nroCantidad'+id).attr('disabled',false).focus();
  }else{
    $('#nroCantidad'+id).attr('disabled',true).val('');
  }
}

/* SHOW PEDIDO */
function editarPedido(id){ 
	// alert('ID a mostrar: '+id);
	//cancelPedido();
	$('.nroCant').attr('disabled',true);
	listCargoPedido();
	$('#txtIDPedido').val(id);
    $('#txtcontrolPedido').val('1');
    $("#updatePedido").removeAttr('style');
    $("#agregarPedido").css("display","none");
    $("#addComentario").removeAttr('style');
    $("#titlePedido").html("<strong>EDITAR PEDIDO</strong>");
    //$('#estado_cargo').show();

	$.ajax({
      	type:'GET',
      	url: base_url+"/Pedido/getPedido/"+id,
      	dataType:'json',
      	success: function(data, textStatus, jqXHR){
	       	
	       	if(jqXHR.status == 200){
	       		console.log(data);
		        if(data.status){
			        
			        //var estado = (data.data.estado == 1) ? true : false;
			        $('#txtpedido').val(data.data.pedido).attr('disabled',true);
			        $('#txtmemorandum').val(data.data.memorandum);
			        $('#txtinforme').val(data.data.informe);
			        $('#txtFechaPedido').val(data.data.fechaPedido);
			        //$('#chkestadoCargo').prop("checked",estado);
			        $.each(data.data.parametros, function(i,row){
			        	// alert(row.idCargo)
		                $('#chkCargo'+row.idCargo).prop('checked', true);;
		                $('#nroCantidad'+row.idCargo).val(row.cantidad).attr('disabled', false);

		            });

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

/* SHOW PASSWORD */
function mostrarObservacion(){
	$('#txtobservacionPedido').val('');
    var passwordOn = $('#view_checkbox_obsv').is(':checked');
    if(passwordOn){
    	$("#obsv").removeAttr('style');
    }else{
      	$("#obsv").css("display","none");
    }
}

/* DELETE PEDIDo */
function eliminarPedido(id){
	//alert('ID a eliminar es: '+id)
	$('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').removeClass('btn btn-warning');
  	swal({  title: "Eliminar Cargo",
      	text: "¿Desea eliminar este Pedido?",
      	type: "warning",
      	showCancelButton: true,
      	cancelButtonText: "Cancelar",
      	confirmButtonColor: "#ff9600",
      	confirmButtonText: "Aceptar",
      	closeOnConfirm: false },
      	function(){ 
          	$.ajax({
	            type:'DELETE',
	            url: base_url+"/Pedido/delPedido/"+id,
	            dataType:'json',
	            success: function(data, textStatus, jqXHR){
	              	if(jqXHR.status == 200){
	              		console.log(data);
	              		if(data.status){

	              			swal(data.title, data.msg, "success");
		        			$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
		        			$('#tablePedidos').DataTable().ajax.reload();
		        			cancelPedido();
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

/* CANCEL PEDIDO */
function cancelPedido(){
	
	$("#agregarPedido").removeAttr('style');
	$("#updatePedido").css("display","none");
	$("#addComentario").css("display","none");
	$("#obsv").css("display","none");
	$("#titlePedido").html("<strong>REGISTRAR PEDIDO</strong>");
	$('#sign_registerPedido')[0].reset();
	$('#sign_registerPedido').validate().resetForm();
	$('#txtcontrolPedido').val('0');
	$('#txtpedido').attr('disabled',false);
	$('#sign_registerPedido .form-group').removeClass('has-success');
	$('.nroCant').attr('disabled',true);
	listCargoPedido();
	mostrarObservacion();
	
}


function verPedido(id){
	$.ajax({
	    type: "GET",
	    async : false,
	    url: base_url+'/Pedido/getPedido/'+id,
	    dataType:'json',
	    success: function(data, textStatus, jqXHR){
	    	if(jqXHR.status == 200){
	            //console.log(data);
	            //$("#cbocargo").selectpicker('destroy');
	            //$("#cbocargo").html(data).selectpicker('refresh');
	            //$('#tableCargosPedido tbody').html(data);
	            $("#historial").attr("onclick","verhistorial("+data.data.id_pedido+")");
	            var addrow = '';
	           	$.each(data.data.parametros, function(i,row){
			        	// alert(row.idCargo)
			    	addrow += 	'<tr>'+
			    				'	<td class="text-center">'+data.data.pedido+'</td>'+
	            				'	<td>'+row.cargo+'</td>'+
	            				'	<td class="text-center">'+row.cantidad+'</td>'+
	            				'</tr>';
		        });

	            $('#tableCargosPedido tbody').html(addrow);

	        }
	    }
	});
}



function verhistorial(id){
	//alert(id);
	$.ajax({
	    type: "GET",
	    async : false,
	    url: base_url+'/Pedido/getPedidoH/'+id,
	    dataType:'json',
	    success: function(data, textStatus, jqXHR){
	    	if(jqXHR.status == 200){
	    		if(data.status){
		    		console.log(data)
		    		var addrow = '';
		           	$.each(data.data.fechas, function(i,row){
				        	// alert(row.idCargo)

				    	addrow += 	'<tr>'+
		            				'	<td>'+row.fecha+'</td>'+
		            				'	<td>'+row.observacion+'</td>'+
		            				'	<td>';

		            	$.each(row.cargos, function(i,rowCargo){

							addrow +=		rowCargo.cargo+' / '+rowCargo.cantidad+'<br>';
		            	});

		            	addrow +=	'	</td>'+
		            				'</tr>';
			        });

		            $('#tableHistorial tbody').html(addrow);
		        
		        }else{

		        	$('#tableHistorial tbody').html(data.msg);

		        }

	        }
	    }
	});
}


function closeModal(){
	$('#collapseOne').removeClass('in');
}