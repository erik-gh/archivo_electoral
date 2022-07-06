// JavaScript Document
$(document).ready(function(){
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

	cboCargoPersonal();
	cboGerenciaPersonal();
	// $('#cbogerencia').selectpicker();

	/*FILE UPLOAD PLANTILLA*/
	const uploadButton = document.querySelector('.browse-btn');
  	const fileInfo = document.querySelector('.file-info');
  	const realInput = document.getElementById('archivo');

  	uploadButton.addEventListener('click', (e) => {
    	realInput.click();
  	});

  	realInput.addEventListener('change', () => {
    	const name = realInput.value.split(/\\|\//).pop();
    	const truncated = name.length > 20 
    	? name.substr(name.length - 20) 
    	: name;

    	fileInfo.innerHTML = truncated;
  	});


  	/*FILE UPLOAD IMAGEN*/
  	const uploadButton1 = document.querySelector('.browse-btn1');
  	const fileInfo1 = document.querySelector('.file-info1');
  	const realInput1 = document.getElementById('archivo1');

  	uploadButton1.addEventListener('click', (e) => {
    	realInput1.click();
  	});

  	realInput1.addEventListener('change', () => {
    	const name1 = realInput1.value.split(/\\|\//).pop();
    	const truncated1 = name1.length > 20 
    	? name1.substr(name1.length - 20) 
    	: name1;

    	fileInfo1.innerHTML = truncated1;
  	});

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
var tablePersonal = $('#tablePersonal').DataTable({
	"processing": true,
	"serverSide": true,
	"order": [],
	"language": {
		"url": base_url+'/Assets/js/es-pe.json'
	},
	"ajax": {
		"url": base_url+"/Personal/getPersonal",
		"type": "POST",
		"dataType": "json"
	},
	"columns": [
	{"data":"orden"}, 
	{"data":"dni"},
	{"data":"nombre"},
	{"data":"cargo"},
	{"data":"gerencia"}, 
	{"data":"estado"},
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



/* SELECT CARGOS */
function cboCargoPersonal(){
	$.ajax({
	    type: "GET",
	    async : false,
	    url: base_url+'/Cargo/getSelectCargos', 
	    success: function(data, textStatus, jqXHR){
	    	if(jqXHR.status == 200){
	            //console.log(data);
	            $("#cbocargo").selectpicker('destroy');
	            $("#cbocargo").html(data).selectpicker('refresh');
	        }
	    }
	});
}

$("#cbocargo").on("change", function() {
   $('#cbocargo-error').hide();
})


/* SELECT gerencias */
function cboGerenciaPersonal(){
	$.ajax({
	    type: "GET",
	    async : false,
	    url: base_url+'/Personal/getSelectGerencia', 
	    success: function(data, textStatus, jqXHR){
	    	if(jqXHR.status == 200){
	            //console.log(data);
	            $("#cbogerencia").selectpicker('destroy');
	            $("#cbogerencia").html(data).selectpicker('refresh');
	        }
	    }
	});
}

$("#cbogerencia").on("change", function() {
   $('#cbogerencia-error').hide();
})


function validarCamposPersonal(){
  var $inputs = $('#form_registerPersonal .vld'); 
  var formvalido = true; 
 
  $inputs.each(function() { 
    if($(this).val().length == 0){ 
      formvalido = false;
    }
  });
  // console.log($inputs);
  return formvalido; 
}

/* REGISTER PERSONAL */
$("#form_registerPersonal").submit(function() {
	var dni 		=	$('#txtdni').val()
    var cargo 		= 	$('#cbocargo').val();

    var requestPersonal 				= new Object();
    requestPersonal["IdPersonal"]		= $("#txtIDPersonal").val();
    requestPersonal["controlPersonal"]	= $("#txtcontrolPersonal").val();
    requestPersonal["dni"]				= $("#txtdni").val();
    requestPersonal["apellido"]			= $("#txtapellidos").val();
	requestPersonal["nombre"]			= $("#txtnombre").val();
	requestPersonal["nombreCompleto"]	= $("#txtnombreCompleto").val();
	requestPersonal["cargo"]			= $("#cbocargo").val();
	requestPersonal["gerencia"]			= $("#cbogerencia").val();
	requestPersonal["imagen"]			= $("#file_temp").val();
	requestPersonal["estado"]			= ($('#chkestadoPersonal').prop('checked') ? '1' : '2');
	requestPersonal["listblack"]		= ($('#view_checkbox_black').prop('checked') ? '3' : '2');

	if (validarCamposPersonal()) {
	    if (dni.length == 8){
	    	if($('#cbocargo').val().length != 0){
				if($('#cbogerencia').val().length != 0){					
					$.ajax({
						url: base_url+'/Personal/setPersonal',
						type: "POST",     
						dataType: 'json',
						data:requestPersonal,    
						cache: false,
									        	
						success: function(data, textStatus, jqXHR){
						console.log(data.msg);

							if(jqXHR.status == 200){
								if(data.status){
									// console.log(textStatus);
									// console.log(jqXHR.status);
									swal(data.title, data.msg, "success");
									$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
									$('#tablePersonal').DataTable().ajax.reload();
									if( ($("#file_temp").val() != $("#file_delete").val()) && $("#txtcontrolPersonal").val() == 1){
										elimianrImgUpdate($("#file_delete").val());
									}
									cancelPersonalset();
									limpiarImgset();
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
						error: 	function(jqXHR,textStatus,errorThrown){
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
});


/* SHOW PERSONAL */
function editarPersonal(id){
	// alert('ID a mostrar: '+id);
	$('#txtIDPersonal').val(id);
    $('#txtcontrolPersonal').val('1');
    $("#updatePersonal").removeAttr('style');
    $("#agregarPersonal").css("display","none");
    $('#txtdni').attr('disabled',true)
    $("#titlePersonal").html("<strong>EDITAR PERSONAL</strong>");
    $('#estado_personal').show();
    $('#personal_nombreCompleto').show();
    $('#personal_nombre').hide('');
    $('#txtnombre').val('-').removeClass('vld');
	$('#txtapellidos').val('-').removeClass('vld');
	if( ($("#file_temp").val() != $("#file_delete").val()) && $("#txtcontrolPersonal").val() == 1){
		elimianrImgUpdate($("#file_temp").val());
	}

	$.ajax({
      	type:'GET',
      	url: base_url+"/Personal/getPersona/"+id,
      	dataType:'json',
      	success: function(data, textStatus, jqXHR){
	       	
	       	if(jqXHR.status == 200){
	       		console.log(data);
		        if(data.status){
			       
			        var estado 		= (data.data.estado == 1) ? true : false;
			        $('#cbocargo').selectpicker('val',data.data.id_cargo);
			        $('#cbogerencia').selectpicker('val',data.data.id_gerencia);
			        $('#txtdni').val(data.data.dni,8).attr('disabled',true);
			        $('#txtnombreCompleto').val(data.data.nombre).addClass('vld');
			        $('#chkestadoPersonal').prop("checked",estado);
			        $("#file_temp").val(data.data.imagen);
			        $("#file_delete").val(data.data.imagen);
			        var img = (data.data.imagen != '' ) ? data.data.imagen : 'user.png' ;
			        $('#img_personal').html('<img src="'+base_url+'/Assets/images/uploads/personal/'+img+'" style="max-width:100% ; height:auto;">');               

			        if(data.data.estado == 3){
 						$('#view_checkbox_black').prop("checked",true);
 						$('#chkestadoPersonal').attr({disabled:true, checked:false});
			        }else{
			        	$('#view_checkbox_black').prop("checked",false);
			        	$('#chkestadoPersonal').attr({disabled:false});
			        }

			       
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


/* SHOW STATUS */
function mostrarEstado(){
    var listblackOn = $('#view_checkbox_black').is(':checked');
    if(listblackOn){
      $('#chkestadoPersonal').attr({checked:false, disabled:true});
    }else{
      $('#chkestadoPersonal').attr("disabled",false);
    }
}


/* DELETE PERSONAL */
function eliminarPersonal(id){
	//alert('ID a eliminar es: '+id)
	$('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').removeClass('btn btn-warning');
  	swal({  title: "Eliminar Personal",
      	text: "¿Desea eliminar este Personal?",
      	type: "warning",
      	showCancelButton: true,
      	cancelButtonText: "Cancelar",
      	confirmButtonColor: "#ff9600",
      	confirmButtonText: "Aceptar",
      	closeOnConfirm: false },
      	function(){ 
          	$.ajax({
	            type:'DELETE',
	            url: base_url+"/Personal/delPersonal/"+id,
	            dataType:'json',
	            success: function(data, textStatus, jqXHR){
	              	if(jqXHR.status == 200){
	              		console.log(data);
	              		if(data.status){

	              			swal(data.title, data.msg, "success");
		        			$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
		        			$('#tablePersonal').DataTable().ajax.reload();
		        			cancelPersonal();
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


/* CANCEL PERSONAL */
function cancelPersonal(){
	  elimianrImg($("#file_delete").val());
	  limpiarImg();
      $("#agregarPersonal").removeAttr('style');
      $("#updatePersonal").css("display","none");
      $("#titlePersonal").html("<strong>REGISTRAR PERSONAL</strong>");
      $('#estado_personal').hide();
      $('#form_registerPersonal')[0].reset();
      $('#form_registerPersonal').validate().resetForm();
      $('#txtcontrolPersonal').val('0');
      $('#txtdni').attr('disabled',false);
      $('#form_registerPersonal .form-group').removeClass('has-success');
      $('#personal_nombre').show('');
      $('#txtnombre').val('').addClass('vld');
      $('#txtapellidos').val('').addClass('vld');
      $('#txtnombreCompleto').removeClass('vld');
      $('#personal_nombreCompleto').val('').hide();
      $('#cbocargo').selectpicker('refresh');
      $('#cbogerencia').selectpicker('refresh');
}


/* DONWLOAD PLANTILLA PERSONAL */
function descargarPlantilla(){
	$('#downloadPlantilla').blur(); /*Quita el foco a un elemento*/
    $("#downloadPlantilla").attr("href", base_url+"/Personal/plantillaExcel");
}


function descargarPersonal(){
	$.ajax({
    	url:  base_url+'/Personal/personalExcel',
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


/*  PLANTILLA PERSONAL */
$("#file_upload").submit(function(){ 
    var archivo = $('#archivo').val();
    var total = archivo.length;

    if(total>0){
          importarFile();
          //return false;
    }else{

      if(archivo.length > 0 ){ 
          $('#errorfile').hide();
          $('#archivo').removeClass('error');
        }else{
          $('#errorfile').html('Este campo es obligatorio.').show();
          $('#archivo').removeClass('error');
        }
   }
    return false;
});


$('#archivo').on('change',function (e) {
    if($(this).val() == 0){
          $('#errorfile').html('Este campo es obligatorio.').show();
          $('#archivo').removeClass('error');
          setTimeout(function() {
              $('#txtnameupload').html('Archivo a subir');
          }, 0);
        }else{
          $('#errorfile').hide();
          // $('#archivo').removeClass('error');
        }
});


/* IMPORTAR PLANTLLA PERSONAL */
function importarFile(nrocaja) {
  $('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').removeClass('btn btn-primary').removeClass('btn btn-warning');
  var elemento = $(this);

    swal({  title: "¿Desea realizar la importanción?",
      text: "Se realizará una importación con el archivo seleccionado.",
      type: "warning",
      showCancelButton: true,
      cancelButtonText: "Cancelar",
      confirmButtonColor: "#ff9600",
      confirmButtonText: "Aceptar",
      closeOnConfirm: false },

      function (isConfirm) {
            if(isConfirm){
                $(elemento).closest('tr').remove();
                swal({
                  title: "Realizando la importación del Archivo",
                  text: "<img src='"+base_url+"/Assets/images/importando.gif' style='width:190px;'>",
                  html:true,
                  showCancelButton: false,
                  showConfirmButton: false
                });
                
                $("#archivo").upload( base_url+'/Personal/importarPersonal',
                  {
                      nombre_archivo: $("#archivo").val(),

                  },
                    function(data, textStatus, jqXHR) {
                    	// if(jqXHR.status == 200){ 
	                    	console.log(data);
	                      	//Subida finalizada.
	                      	$("#barraProgreso").css('width','0%');

	                      	if(data.status){

		              			//swal(data.title, data.msg, "success");
		              			swal({  title: 	data.title,
											text: 	data.msg,
											type: 	"success"},
											function(){ 
												setTimeout(function() {
													// $('#txtperfil').focus();
													$('#modal_informacion').modal('show');
													$('#tbl_cargaInfo').html(data.datos);

												}, 10)
									});
			        			$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
			        			$('#tablePersonal').DataTable().ajax.reload();
			        			cancelImportar();
			        			return false;

		              		}else{
		              			swal(data.title, data.msg, "error");
			        			$('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
			        			return false;
		              		}

                    }, 
                    function(progreso, valor) {
                        //Barra de progreso.
                        $("#barraProgreso").css('width',valor+'%');
                        $("#barraProgreso").html('Completado '+valor+'%')
                    });
            }
         }
    ); 
}


/* CANCEL IMPORTAR */
function cancelImportar(){
	$('#file_upload')[0].reset();
    $('#file_upload').validate().resetForm();
    $('#errorfile').hide();
    $('#txtnameupload').html('Archivo a subir');
    $('#modal_importar').modal('hide');
}


/* UPLOAD FOTO PERSONAL */
$('#archivo1').on('change',function () {
	var controlPersonal = $("#txtcontrolPersonal").val();
	if($('#archivo1').val() != 0){
		$("#archivo1").upload( base_url+'/Personal/cargaImagen',
		{
			nombre_archivo: $("#archivo1").val(),
		},
		function(data, textStatus, jqXHR) {
			console.log(data);
			
			if(data.status){

					$("#img_personal").html(data.data);
					$("#file_temp").val(data.name);
					if(controlPersonal == 0){
	                	$("#file_delete").val(data.name);
	            	}
					$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
					return false;

			}else{
				swal(data.title, data.msg, "error");
				limpiarImg();
				$('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
				return false;
			}
		});
	}else{
		swal('Error!', 'Ningun archivo seleccionado.', "error");
		limpiarImg();
		$('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
		return false;
	}
});

function limpiarImg() {
	var controlPersonal = $("#txtcontrolPersonal").val();
	var fileTemporal = $("#file_temp").val();
	var fileDelete = $("#file_delete").val();

	if(controlPersonal == 0){
		elimianrImg(fileDelete);
		$('#file_delete').val('');
	}else{
		if(fileTemporal === fileDelete){
			//alert('no elimino');
		}else{
			elimianrImg(fileTemporal);
		}
	}
		$("#deletimg").blur();
		$('#archivo1').val(null);
		$('#file_temp').val('');
		$('#img_personal').empty();
		$('#txtnameuploadImg').html('Imagen a subir');
}


function elimianrImg(id){
	var controlPersonal = $("#txtcontrolPersonal").val();
	var fileTemporal = $("#file_temp").val();
	var fileDelete = $("#file_delete").val();
	var image = (controlPersonal == 0) ? fileDelete : fileTemporal ;
	
	if( (fileTemporal === fileDelete) && controlPersonal == 1){
			//alert('no elimino');
	}else{	
		$.ajax({
			type:'DELETE',
			url: base_url+'/Personal/eliminarImagen/'+image,
			success: function(data){
		
			}
		});
	}
	return false;
}


function elimianrImgUpdate(id){
		$.ajax({
			type:'DELETE',
			url: base_url+'/Personal/eliminarImagen/'+id,
			success: function(data){
		
			}
		});
}


/* CANCEL SET PERSONAL */
function limpiarImgset() {
		$("#deletimg").blur();
		$('#archivo1').val(null);
		$('#file_temp').val('');
		$("#file_delete").val('')
		$('#img_personal').empty();
		$('#txtnameuploadImg').html('Imagen a subir');
}


function cancelPersonalset(){
	  limpiarImgset();
      $("#agregarPersonal").removeAttr('style');
      $("#updatePersonal").css("display","none");
      $("#titlePersonal").html("<strong>REGISTRAR PERSONAL</strong>");
      $('#estado_personal').hide();
      $('#form_registerPersonal')[0].reset();
      $('#form_registerPersonal').validate().resetForm();
      $('#txtcontrolPersonal').val('0');
      $('#txtdni').attr('disabled',false);
      $('#form_registerPersonal .form-group').removeClass('has-success');
      $('#personal_nombre').show('');
      $('#txtnombre').val('').addClass('vld');
      $('#txtapellidos').val('').addClass('vld');
      $('#txtnombreCompleto').removeClass('vld');
      $('#personal_nombreCompleto').val('').hide();
      $('#cbocargo').selectpicker('refresh');
      $('#cbogerencia').selectpicker('refresh');
}