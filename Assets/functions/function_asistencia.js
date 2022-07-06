// JavaScript Document
$(document).ready(function(){

	setInterval(function(){ 
   		cantidadPersonal();
	}, 1000);
	
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


/*================================================  FUNCTIONS ASISTENCIA  ================================================*/
function inpDNI(){
	if (event.keyCode == 13 || event.which == 13) {
    	var dni = $('#txtDNI').val();
    	var registro = $('input:radio[name=radioIngreso]:checked').val();

    	var requestAsistencia 			= new Object();
    	requestAsistencia["dni"]		= $("#txtDNI").val();
    	requestAsistencia["conrol"]		= $('input:radio[name=radioIngreso]:checked').val();


    	if (dni.length==8){
	        $.ajax({
	            url: base_url+'/Asistencia/setAsistencia',
		        type: "POST",     
		        dataType: 'json',
		        data:requestAsistencia,    
		        cache: false,
		        	
		        success: function(data, textStatus, jqXHR){
		        	console.log(data.msg);

		        	if(jqXHR.status == 200){
		        		if(data.status){
							// console.log(textStatus);
			        		// console.log(jqXHR.status);
			        		$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
			        		$('#txtDNI').val('');
			        		
			        		var date = (data.ctrl == 'ingreso') ? 'fecha': 'fecha_salida';
			        		$('#controlAsistencia').html('<b>'+data.datos[data.ctrl].toUpperCase()+'</b>').addClass('font-20');
				            $('#dniAsistencia').html('<b>'+data.datos['dni']+'</b>').addClass('font-20');
				            $('#nombreAsistencia').html('<b>'+data.datos['nombre']+'</b>').addClass('font-20');
				            $('#cargoAsistencia').html('<b>'+data.datos['cargo']+'</b>').addClass('font-20');
				            $('#fechaAsistencia').html('<b>'+data.datos[date]+' '+data.datos['hora_'+data.ctrl]+'</b>').addClass('font-20');
				            $('#gerenciaAsistencia').html('<b>'+data.datos['abreviatura']+'</b>').addClass('font-60');

				            var img = (data.datos['imagen'] != '' ) ? data.datos['imagen'] : 'user.png' ;
			        		$('#img_personal').html('<img src="'+base_url+'/Assets/images/uploads/personal/'+img+'" style="max-width:100% ; height:auto;">');               



				            $('#txtDNI').val('').focus();
				            responsiveVoice.speak(data.datos[data.ctrl], "Spanish Latin American Female");
			        		return false;

		        		}else{
			        		swal({  title: 	data.title,
								    text: 	data.msg,
								    type: 	"warning"},
								    function(){ 
								    	setTimeout(function() {
								          //$('#txtcargo').focus();
								    	}, 10)
									});
			        		$('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').addClass('btn btn-warning');
			        		$('#txtDNI').val('').focus();
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

	    	swal('Alerta!', 'Formato de D.N.I. inválido', "warning");
	    	$('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').addClass('btn btn-warning');
	    	return false;

	    }


    }
}


function cantidadPersonal(){

   	$.ajax({
      	type:'POST',
      	url: base_url+'/Asistencia/getCantidad',
      	dataType: 'json',
      	//data:'id='+id,
      	success: function(data, textStatus, jqXHR){
			console.log(data.data);
			if(jqXHR.status == 200){
		        if(data.status){
		        	//var datos = JSON.parse(data);
		        	$('#tbl_cantidadPersonal tbody').html(data.data);
		        	$('#fechaActual').html(data.fecha);
		        	
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