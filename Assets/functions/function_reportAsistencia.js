// JavaScript Document
$(document).ready(function(){


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


/*================================================  FUNCTIONS REPORT ASISTENCIA  ================================================*/

function viewAsistencia(){

  	var dni 		=	$('#txtDNI').val()

    var requestReportAsistencia 			= new Object();
    requestReportAsistencia["dni"]			= $("#txtDNI").val();
    requestReportAsistencia["fechaInicio"]	= $("#txtFechaInicio").val();
    requestReportAsistencia["fechaFin"]		= $("#txtFechaFin").val();


    $.ajax({
    	url: base_url+'/ReportAsistencia/getreporteAsistencia',
    	type: "POST",     
    	dataType: 'json',
    	data:requestReportAsistencia,    
    	cache: false,

    	success: function(data, textStatus, jqXHR){ console.log(data);
    		console.log(data.msg);

    		if(jqXHR.status == 200){
    			if(data.status){
    				// console.log(textStatus);
    				// console.log(jqXHR.status);
    				// swal(data.title, data.msg, "success");
    				// $('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');    				
    				$('#tbl_reportAsistencia').html(data.data);
    				$('#tbl_lista_reportAsistencia').DataTable();
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
    				if($('#tbl_lista_reportAsistencia').children().length != 0){
				    	$('#tbl_lista_reportAsistencia').DataTable().clear().destroy();
				    	$('#tbl_lista_reportAsistencia').empty();
				    }
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



function cancelreportAsistencia(){
      
    $('#form_reportAsistencia')[0].reset();
    $('#form_reportAsistencia').validate().resetForm();
    $('#form_reportAsistencia .form-group').removeClass('has-success');
    if($('#tbl_lista_reportAsistencia').children().length != 0){
    	$('#tbl_lista_reportAsistencia').DataTable().clear().destroy();
    	$('#tbl_lista_reportAsistencia').empty();
    }
    
}


$('#txtDNI').keypress(function(e){
	var long = $('#txtDNI').val().length;
	if(long == 8){
		if (e.keyCode == 13 || e.which == 13 ){
	    	viewAsistencia();
	  	}
	}

});
  

function exportarAsistencia(){ 
  	var dni 		=	$('#txtDNI').val()

    var requestReportAsistencia 			= new Object();
    requestReportAsistencia["dni"]			= $("#txtDNI").val();
    requestReportAsistencia["fechaInicio"]	= $("#txtFechaInicio").val();
    requestReportAsistencia["fechaFin"]		= $("#txtFechaFin").val();


    $.ajax({
    	url: base_url+'/ReportAsistencia/getexportAsistencia',
    	type: "POST",     
    	dataType: 'json',
    	data:requestReportAsistencia,    
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
		url: base_url+'/ReportAsistencia/eliminarfile/'+id,
		success: function(data){

		}
	});
   	return false;
}