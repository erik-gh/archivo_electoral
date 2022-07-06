// JavaScript Document
$(document).ready(function(){

	verlistadoModulos();
	
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


/*================================================  FUNCTIONS PERFIL  ================================================*/
/* TABLE PERFILES */
var tablePerfiles = $('#tablePerfiles').DataTable({
	"processing": true,
	"serverSide": true,
	"order": [],
	"language": {
		"url": base_url+'/Assets/js/es-pe.json'
	},
	"ajax": {
		"url": base_url+"/Perfil/getPerfiles",
		"type": "POST",
		"dataType": "json"
	},
	"columns": [
	{"data":"orden"}, 
	{"data":"PERFIL"},
	{"data":"DESCRIPCION"}, 
	{"data":"ESTADO"},
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


/* REGISTER PERFILES */
$("#form_registerPerfil").submit(function() {
    var perfil 		= $('#txtperfil').val();
    var descripcion	= $('#txtdescripcion').val();
    var total 		= perfil.length * descripcion.length;

    var requestPerfil 				= new Object();
    requestPerfil["Idperfil"]		= $("#txtIDPerfil").val();
    requestPerfil["controlPerfil"]	= $("#txtcontrolPerfil").val();
    requestPerfil["perfil"]			= $("#txtperfil").val();
	requestPerfil["descripcion"]	= $("#txtdescripcion").val();
	requestPerfil["estado"]			= ($('#chkestadoPerfil').prop('checked') ? '1' : '2');

    if (total>0){
        $.ajax({
            url: base_url+'/Perfil/setPerfil',
	        type: "POST",     
	        dataType: 'json',
	        data:requestPerfil,    
	        cache: false,
	        	
	        success: function(data, textStatus, jqXHR){
	        	console.log(data.msg);

	        	if(jqXHR.status == 200){
	        		if(data.status){
						/*console.log(textStatus);
		        		console.log(jqXHR.status);*/
		        		swal(data.title, data.msg, "success");
		        		$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
		        		$('#tablePerfiles').DataTable().ajax.reload();
		        		cancelPerfil();
		        		return false;

	        		}else{
		        		swal({  title: 	data.title,
							    text: 	data.msg,
							    type: 	"error"},
							    function(){ 
							    	setTimeout(function() {
							          $('#txtperfil').focus();
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


/* SHOW PERFIL */
function editarPerfil(id){
	// alert('ID a mostrar: '+id);
	$('#txtIDPerfil').val(id);
    $('#txtcontrolPerfil').val('1');
    $("#updatePerfil").removeAttr('style');
    $("#agregarPerfil").css("display","none");
    $("#titlePerfil").html("<strong>EDITAR PERFIL</strong>");
    $('#estado_perfil').show();

	$.ajax({
      	type:'GET',
      	url: base_url+"/Perfil/getPerfil/"+id,
      	dataType:'json',
      	success: function(data, textStatus, jqXHR){
	       	
	       	if(jqXHR.status == 200){
	       		console.log(data);
		        if(data.status){
			        
			        var estado = (data.data.ESTADO == 1) ? true : false;
			        $('#txtperfil').val(data.data.PERFIL).attr('disabled',true);
			        $('#txtdescripcion').val(data.data.DESCRIPCION);
			        $('#chkestadoPerfil').prop("checked",estado);
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


/* DELETE PERFIL */
function eliminarPerfil(id){
	//alert('ID a eliminar es: '+id)
	$('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').removeClass('btn btn-warning');
  	swal({  title: "Eliminar Perfil",
      	text: "¿Desea eliminar este Perfil?",
      	type: "warning",
      	showCancelButton: true,
      	cancelButtonText: "Cancelar",
      	confirmButtonColor: "#ff9600",
      	confirmButtonText: "Aceptar",
      	closeOnConfirm: false },
      	function(){ 
          	$.ajax({
	            type:'DELETE',
	            url: base_url+"/Perfil/delPerfil/"+id,
	            dataType:'json',
	            success: function(data, textStatus, jqXHR){
	              	if(jqXHR.status == 200){
	              		console.log(data);
	              		if(data.status){

	              			swal(data.title, data.msg, "success");
		        			$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
		        			$('#tablePerfiles').DataTable().ajax.reload();
		        			cancelPerfil();
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


/* CANCEL PERFIL */
function cancelPerfil(){
      $("#agregarPerfil").removeAttr('style');
      $("#updatePerfil").css("display","none");
      $("#titlePerfil").html("<strong>REGISTRAR PERFIL</strong>");
      $('#estado_perfil').hide();
      $('#form_registerPerfil')[0].reset();
      $('#form_registerPerfil').validate().resetForm();
      $('#txtcontrolPerfil').val('0');
      $('#txtperfil').attr('disabled',false);
      $('#form_registerPerfil .form-group').removeClass('has-success');
}


/*================================================  FUNCTIONS USUARIOS  ================================================*/
/* SELECT PERFILES */
function cboPerfilUsuarios(){
	$.ajax({
	    type: "GET",
	    async : false,
	    url: base_url+'/Perfil/getSelectPerfiles', 
	    success: function(data, textStatus, jqXHR){
	    	if(jqXHR.status == 200){
	            //console.log(data);
	            $("#cboperfil").selectpicker('destroy');
	            $("#cboperfil").html(data).selectpicker('refresh');
	        }
	    }
	});
}

$("#cboperfil").on("change", function() {
   $('#cboperfil-error').hide();
})

function  nickname(){
	var nickname = $('#txtDNI').val().length;

	if(nickname == 8){
		$('#txtusuario').val($('#txtDNI').val());
	}else{
		$('#txtusuario').val('');
	}
}


/* SHOW PASSWORD */
function mostrarContrasena(){
    var passwordOn = $('#view_checkbox_pass').is(':checked');
    if(passwordOn){
      document.getElementById('txtpassword').type = 'text';
      document.getElementById('txtpassword2').type = 'text';
    }else{
      document.getElementById('txtpassword').type = 'password';
      document.getElementById('txtpassword2').type = 'password';
    }
}

function mostrarContrasenanueva(){
    var passwordOn = $('#view_checkbox_newpass').is(':checked');
    if(passwordOn){
      document.getElementById('txtnewpassword').type = 'text';
      document.getElementById('txtnewpassword2').type = 'text';
    }else{
      document.getElementById('txtnewpassword').type = 'password';
      document.getElementById('txtnewpassword2').type = 'password';
     
    }
}

function validarCamposUsuario(){
  var $inputs = $('#form_registerUsuario .vld'); 
  var formvalido = true; 
 
  $inputs.each(function() { 
    if($(this).val().length == 0){ 
      formvalido = false;
    }
  });
  // console.log($inputs);
  return formvalido; 
}


/* TABLE USUARIOS */
function verlistadoUsuarios(){
	$('#tableUsuarios').dataTable().fnClearTable();
	$('#tableUsuarios').dataTable().fnDestroy();
	var tableUsuarios = $('#tableUsuarios').DataTable({
		/*"processing": true,
		"serverSide": true,*/
		"order": [],
		"language": {
			"url": base_url+'/Assets/js/es-pe.json'
		},
		"ajax": {
			"url": base_url+"/Usuario/getUsuarios",
			"type": "POST",
			"dataType": "json"
		},
		"columns": [
		{"data":"orden"}, 
		{"data":"DNI_USUARIO"},
		{"data":"APELLIDOS"}, 
		{"data":"NOMBRES"},
		{"data":"PERFIL"},
		{"data":"USERNAME"},
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
}


/* REGISTER USUARIOS */
$("#form_registerUsuario").submit(function() {
	var dni 		=	$('#txtDNI').val()
    var perfil 		= 	$('#cboperfil').val();

    var caract_invalido = " ";
    var caract_length = 8;
    var letter = /[A-z]/;
    var number = /[0-9]/;
    var pass1 = $('#txtpassword').val();
    var pass2 = $('#txtpassword2').val();

    var requestUsuario 					= new Object();
    requestUsuario["IdUsuario"]			= $("#txtIDUsuario").val();
    requestUsuario["controlUsuario"]	= $("#txtcontrolUsuario").val();
    requestUsuario["dni"]				= $("#txtDNI").val();
    requestUsuario["apellido"]			= $("#txtapellido").val();
	requestUsuario["nombre"]			= $("#txtnombre").val();
	requestUsuario["perfil"]			= $("#cboperfil").val();
	requestUsuario["usuario"]			= $("#txtusuario").val();
	//requestUsuario["password"]			= $("#txtpassword").val();
	requestUsuario["estado"]			= ($('#chkestadoUsuario').prop('checked') ? '1' : '2');

	if (validarCamposUsuario()) {
	    if (dni.length == 8){
	    	if($('#cboperfil').val().length != 0){
	    		
	    		$.ajax({
	    			url: base_url+'/Usuario/setUsuario',
	    			type: "POST",     
	    			dataType: 'json',
	    			data:requestUsuario,    
	    			cache: false,

	    			success: function(data, textStatus, jqXHR){
	    				console.log(data.msg);

	    				if(jqXHR.status == 200){
	    					if(data.status){
								// console.log(textStatus);
								// console.log(jqXHR.status);
								swal(data.title, data.msg, "success");
								$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
								$('#tableUsuarios').DataTable().ajax.reload();
								cancelUsuario();
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
});


/* SHOW USUARIO */
function editarUsuario(id){
	// alert('ID a mostrar: '+id);
	$('#txtIDUsuario').val(id);
    $('#txtIDpass').val(id);
    $('#txtcontrolUsuario').val('1');
    $("#updateUsuario").removeAttr('style');
    $("#agregarUsuario").css("display","none");
    $("#titleUsuario").html("<strong>EDITAR USUARIO</strong>");
    $('#pass_user').hide();
    $('#estado_user').show();

	$.ajax({
      	type:'GET',
      	url: base_url+"/Usuario/getUsuario/"+id,
      	dataType:'json',
      	success: function(data, textStatus, jqXHR){
	       	
	       	if(jqXHR.status == 200){
	       		console.log(data);
		        if(data.status){
			        
			        var estado = (data.data.ESTADO == 1) ? true : false;
			        $('#cboperfil').selectpicker('val',data.data.ID_PERFIL);
			        $('#txtDNI').val(data.data.DNI_USUARIO,8).attr('disabled',true);
			        $('#txtapellido').val(data.data.APELLIDOS);
			        $('#txtnombre').val(data.data.NOMBRES);
			        $('#txtusuario').val(data.data.DNI_USUARIO);
			        $('#txtpassword').val('password1');
			        $('#txtpassword2').val('password1');
			        $('#chkestadoUsuario').prop("checked",estado);
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


/* DELETE USUARIO */
function eliminarUsuario(id){
	//alert('ID a eliminar es: '+id)
	$('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').removeClass('btn btn-warning');
  	swal({  title: "Eliminar Usuario",
      	text: "¿Desea eliminar este Usuario?",
      	type: "warning",
      	showCancelButton: true,
      	cancelButtonText: "Cancelar",
      	confirmButtonColor: "#ff9600",
      	confirmButtonText: "Aceptar",
      	closeOnConfirm: false },
      	function(){ 
          	$.ajax({
	            type:'DELETE',
	            url: base_url+"/Usuario/delUsuario/"+id,
	            dataType:'json',
	            success: function(data, textStatus, jqXHR){
	              	if(jqXHR.status == 200){
	              		console.log(data);
	              		if(data.status){

	              			swal(data.title, data.msg, "success");
		        			$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
		        			$('#tableUsuarios').DataTable().ajax.reload();
		        			cancelUsuario();
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


/* CANCEL USUARIO */
function cancelUsuario(){
	$("#agregarUsuario").removeAttr('style');
	$("#updateUsuario").css("display","none");
	$("#titleUsuario").html("<strong>REGISTRAR USUARIO</strong>");
	$('#pass_user').show();
	$('#estado_user').hide();
	$('#form_registerUsuario')[0].reset();
	$('#form_registerUsuario').validate().resetForm();
	$('#txtcontrolUsuario').val('0');
	$('#txtDNI').attr('disabled',false);
	$('#form_registerUsuario .form-group').removeClass('has-success');
	$('#cboperfil').selectpicker('refresh');
	mostrarContrasena();
}


/* CANCEL PASSWORD NEW */
function cancelPass(){
    $('#txtnewpassword').val('');
    $('#txtnewpassword2').val('');
    $("#view_checkbox_newpass").prop('checked', false); 
    $('#form_updatePassword').validate().resetForm();
    $('#form_updatePassword .form-group').removeClass('has-success');
    mostrarContrasenanueva();
} 


/* UPDATE PASSWORD */
$("#form_updatePassword").submit(function(){

    var caract_invalido = " ";
    var caract_length = 8;
    var letter = /[A-z]/;
    var number = /[0-9]/;
    var pass1 = $('#txtnewpassword').val();
    var pass2 = $('#txtnewpassword2').val();
    var total = pass1.length * pass2.length;

    var requestNewPassword 					= new Object();
    requestNewPassword["IdUsuario"]			= $("#txtIDpass").val();
    requestNewPassword["controlUsuario"]	= $("#txtcontrolpass").val();
    requestNewPassword["password"]			= $("#txtnewpassword").val();
    requestNewPassword["dni"]				= $("#txtDNI").val();
    requestNewPassword["apellido"]			= $("#txtapellido").val();
	requestNewPassword["nombre"]			= $("#txtnombre").val();
	requestNewPassword["perfil"]			= $("#cboperfil").val();
	requestNewPassword["usuario"]			= $("#txtusuario").val();
	requestNewPassword["estado"]			= ($('#chkestadoUsuario').prop('checked') ? '1' : '2');

    if (total > 0) {
      	if ( pass1.length < caract_length) {
            swal("Alerta!", "La contraseña debe constar de " + caract_length + " carácteres como mínimo.", "warning");
            $('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').addClass('btn btn-warning');
            return false;

      	}else{
        	if(pass1.indexOf(caract_invalido) > -1){
              	swal("Alerta!", "La contraseña no debe contener espacios en blanco", "warning");
              	$('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').addClass('btn btn-warning');
              	return false;

        	}else{
          		if(pass1.match(number) <= 0){
                	swal("Alerta!", "La contraseña debe contener al menos un número", "warning");
                	$('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').addClass('btn btn-warning');
                	return false;

          		}else{
            		if(pass1.match(letter) > -1){
                		swal("Alerta!", "La contraseña debe contener al menos una letra", "warning");
                		$('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').addClass('btn btn-warning');
                		return false;

            		}else{
              			if (pass1 != pass2){
                    		swal("Alerta!", "Las contraseñas no coiinciden", "warning");
                    		$('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').addClass('btn btn-warning');
                    		return false;

              			}else{
			                //alert('Contraeña correcta');
			                $.ajax({
			                	url: base_url+'/Usuario/setUsuario',
								type: "POST",     
								dataType: 'json',
								data:requestNewPassword,    
								cache: false,
											        	
								success: function(data, textStatus, jqXHR){
									console.log(data.msg);

								     if(jqXHR.status == 200){
								     	if(data.status){
											// console.log(textStatus);
									        // console.log(jqXHR.status);						        
									        swal({  title: 	data.title,
									    			text: 	data.msg,
									    			type: 	"success"},
									    			function(){ 
									    				setTimeout(function() {
									    					$('#modal_newpass').modal('hide');
															cancelPass();
														}, 10)
									    			});
											$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
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
});


/*================================================  FUNCTIONS MODULO  ================================================*/
/* TABLE USUARIOS */
function verlistadoModulos(){
	$('#tableModulo').dataTable().fnClearTable();
	$('#tableModulo').dataTable().fnDestroy();
	var tableModulo = $('#tableModulo').DataTable({
		//"processing": true,
		//"serverSide": true,
		"order": [],
		"language": {
			"url": base_url+'/Assets/js/es-pe.json'
		},
		"ajax": {
			"url": base_url+"/Modulo/getModulos",
			"type": "POST",
			"dataType": "json"
		},
		"columns": [
		{"data":"orden"}, 
		{"data":"MODULO"},
		{"data":"DESCRIPCION"}, 
		{"data":"URL"},
		{"data":"ICONO"},
		{"data":"ESTADO"},
		{"data":"opciones"}, 
		],
		"resonsieve":"true",
		"dDestroy": true,
		"iDisplayLength": 10,
		// "order": [[0,"asc"]],
		/*"columnDefs": [{
			"targets": [0 , 6],
			"orderable": false,
		}, ],*/
	});
}


/* SHOW MODULO */
function editarModulo(id){
    $('#txtIDModulo').val(id);
    $('#txtcontrolModulo').val('1');
    $("#updateModulo").removeAttr('style');
    $("#agregarModulo").css("display","none");
    
    $.ajax({
      	type:'GET',
      	url: base_url+"/Modulo/getModulo/"+id,
      	dataType:'json',
      	success: function(data, textStatus, jqXHR){
	       	
	       	if(jqXHR.status == 200){
	       		console.log(data);
		        if(data.status){
			        
			        var estado = (data.data.ESTADO == 1) ? true : false;
			        $('#txtmodulo').val(data.data.MODULO);
		          	$('#txtdescripcionModulo').val(data.data.DESCRIPCION);
		          	$('#txticono').val(data.data.ICONO);
		          	$('#txtURL').val(data.data.URL);
		          	$('#chkestadoModulo').prop("checked",estado);
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


/* VIEW ICONOS */
function verIconos(){ 
    var ventana = false; 
    var ancho = 850; 
    var alto = 480; 
    var der = (screen.width - ancho) / 2; 
    var sup = (screen.height - alto) / 2;
    
    var propis = "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=850,height=480,top=" + sup + ",left=" + der; 
    ventana = window.open("icons", "Iconos", propis); 
}


/* CANCEL MODULO */
function cancelModulo(){
    setTimeout(function() {
        $("#agregarModulo").removeAttr('style');
        $("#updateModulo").css("display","none");
        // $("#title_modulo").html("<strong>REGISTRAR modulo DEL SISTEMA</strong>");
    },500);
    $('#form_registerModulo')[0].reset();
    $('#form_registerModulo').validate().resetForm();
    $('#form_registerModulo .form-group').removeClass('has-success');
    $('#txtcontrolModulo').val('0');
}


function validarCamposModulo(){
  var $inputs = $('#form_registerModulo .vld'); 
  var formvalido = true; 
 
  $inputs.each(function() { 
    if($(this).val().length == 0){ 
      formvalido = false;
    }
  });
  // console.log($inputs);
  return formvalido; 
}

/* UPDATE MODULO */
$("#form_registerModulo").submit(function(){

    var requestModulo 				= new Object();
    requestModulo["IdModulo"]		= $("#txtIDModulo").val();
    requestModulo["controlModulo"]	= $("#txtcontrolModulo").val();
    requestModulo["modulo"]			= $("#txtmodulo").val();
    requestModulo["descripcion"]	= $("#txtdescripcionModulo").val();
	requestModulo["icono"]			= $("#txticono").val();
	requestModulo["url"]			= $("#txtURL").val();
	requestModulo["estado"]			= ($('#chkestadoModulo').prop('checked') ? '1' : '2');
    
    if (validarCamposModulo()) {
    	$.ajax({
            url: base_url+'/Modulo/setModulo',
	        type: "POST",     
	        dataType: 'json',
	        data:requestModulo,    
	        cache: false,
	        	
	        success: function(data, textStatus, jqXHR){
	        	console.log(data.msg);

	        	if(jqXHR.status == 200){
	        		if(data.status){
						/*console.log(textStatus);
		        		console.log(jqXHR.status);*/
		        		swal({  title: 	data.title,
		        				text: 	data.msg,
		        				type: 	"success"},
			        			function(){ 
			        				setTimeout(function() {
			        					$('#tableModulo').DataTable().ajax.reload();
			        					$('#modal_modulo').modal('hide');
			        					cancelModulo();
			        				}, 10)
			        			});
		        		$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
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
  	return false;
});



/*================================================  FUNCTIONS MODULO ASIGNAR  ================================================*/

$("#cboperfilAsignar").on("change", function() {
   $('#cboperfilAsignar-error').hide();
})

$("#multimodulo").on("change", function() {
   $('#multimodulo-error').hide();
})

/* SELECT PERFIL MODULOS */
function cboPerfilModulo(){
	$.ajax({
	    type: "GET",
	    async : false,
	    url: base_url+'/Perfil/getSelectPerfilesModulo', 
	    success: function(data, textStatus, jqXHR){
	    	if(jqXHR.status == 200){
	            //console.log(data);
	            $("#cboperfilAsignar").selectpicker('destroy');
	            $("#cboperfilAsignar").html(data).selectpicker('refresh');
	        }
	    }
	});
}

/* MULTISELECT MODULOS */
function multicboModulos(){
	$.ajax({
	    type: "GET",
	    async : false,
	    url: base_url+'/Modulo/getSelectModulos', 
	    success: function(data, textStatus, jqXHR){
	    	if(jqXHR.status == 200){
	            console.log(data);
	            $("#multimodulo").selectpicker('destroy');
	            $("#multimodulo").html(data).selectpicker('refresh');
	        }
	    }
	});
}


/* REGISTER MODULO */
$("#form_registerAsignar").submit(function(){

    var cboperfilAsignar 	= $('#cboperfilAsignar').val();
    var multimodulo 		= $('#multimodulo').val();

    var total = cboperfilAsignar.length * multimodulo.length;

    var requesAsignar 				= new Object();
    requesAsignar["controlAsignar"]	= $("#txtcontrolAsignar").val();
    requesAsignar["perfil"]			= $("#cboperfilAsignar").val();
    requesAsignar["modulos"]		= $("#multimodulo").val();
        
    if (total > 0) {
    	$.ajax({
            url: base_url+'/Modulo/setAsignar',
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


/* SHOW ASIGNAR MODULO */
function editarAsignar(id){
    $('#txtIDAsignar').val(id);
    $('#txtcontrolAsignar').val('1');
    $("#updateAsignar").removeAttr('style');
    $("#agregarAsignar").css("display","none");
    $("#titleAsignar").html("<strong>EDITAR LA ASIGNACI&Oacute;N DE M&Oacute;DULOS</strong>");
    $('#form_registerAsignar').validate().resetForm();
    $('#form_registerAsignar .form-group').removeClass('has-success');
    $('#multimodulo').selectpicker('deselectAll');
    // $('#multimodulo').multiselect("deselectAll", false);
    
    $.ajax({
      	type:'GET',
      	url: base_url+"/Modulo/getAsignar/"+id,
      	dataType:'json',
      	success: function(data, textStatus, jqXHR){
	       	
	       	if(jqXHR.status == 200){
	       		console.log(data);
		        if(data.status){
			        
			        $('#cboperfilAsignar').attr("disabled",true).html('<option value="'+id+'">'+data.data.PERFIL+'</option>').selectpicker('refresh');
          			$('#cboperfilAsignar').selectpicker('val',id);  
			       
			       	var modulo = data.data.MODULOS.split(','); 
          			$('#multimodulo').selectpicker('val', modulo);
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


/* TABLE ASIGNAR MODULOS */
function verlistadoAsignar(){
	$('#tableAsignar').dataTable().fnClearTable();
	$('#tableAsignar').dataTable().fnDestroy();
	var tableAsignar = $('#tableAsignar').DataTable({
		/*"processing": true,
		"serverSide": true,*/
		"order": [],
		"language": {
			"url": base_url+'/Assets/js/es-pe.json'
		},
		"ajax": {
			"url": base_url+"/Modulo/getModulosAsignados",
			"type": "POST",
			"dataType": "json"
		},
		"columns": [
		{"data":"orden"}, 
		{"data":"PERFIL"},
		{"data":"DESCRIPCION"}, 
		{"data":"MODULOS"},
		{"data":"opciones"}, 
		],
		"resonsieve":"true",
		"dDestroy": true,
		"iDisplayLength": 10,
		// "order": [[0,"asc"]],
	});
}


/* DELETE ASIGANR */
function eliminarAsignar(id){
	//alert('ID a eliminar es: '+id)
	$('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').removeClass('btn btn-warning');
  	swal({  title: "Eliminar Perfil",
      	text: "¿Desea eliminar este Perfil?",
      	type: "warning",
      	showCancelButton: true,
      	cancelButtonText: "Cancelar",
      	confirmButtonColor: "#ff9600",
      	confirmButtonText: "Aceptar",
      	closeOnConfirm: false },
      	function(){ 
          	$.ajax({
	            type:'DELETE',
	            url: base_url+"/Modulo/delAsignar/"+id,
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
	  	$('#cboperfilAsignar').attr("disabled",false)
      	$("#agregarAsignar").removeAttr('style');
      	$("#updateAsignar").css("display","none");
      	$("#titleAsignar").html("<strong>ASIGNAR M&Oacute;DULOS</strong>");
      	$('#form_registerAsignar')[0].reset();
      	$('#form_registerAsignar').validate().resetForm();
      	$('#form_registerAsignar .form-group').removeClass('has-success');
      	cboPerfilModulo();
      	$('#multimodulo').selectpicker("refresh");
      	$('#txtcontrolAsignar').val('0');
      	$('#errormultimodulo').html('');
}