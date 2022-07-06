// JavaScript Document
$(document).ready(function(){

   	CboProceso();
    $('#tableResumenOdpe').DataTable({});

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


/* UPDATE PASSWORD */
$("#form_updatePassword").submit(function(){

    var caract_invalido = " ";
    var caract_length = 8;
    var letter = /[A-z]/;
    var number = /[0-9]/;
    var pass1 = $('#txtnewpassword').val();
    var pass2 = $('#txtnewpassword2').val();
    var total = pass1.length * pass2.length;

    var requestNewPassword 					    = new Object();
    requestNewPassword["newpassword"]		= $("#txtnewpassword").val();

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
			                	url: base_url+'/Dashboard/setUpdatePassword',
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
                                          document.location.href = base_url+'/logout'
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


/* CANCEL PASSWORD NEW */
function cancelPass(){
	$('#txtpassword').val('');
    $('#txtnewpassword').val('');
    $('#txtnewpassword2').val('');
    $("#view_checkbox_newpass").prop('checked', false); 
    $('#form_updatePassword').validate().resetForm();
    $('#form_updatePassword .form-group').removeClass('has-success');
    mostrarContrasenanueva();
}


function CboProceso(){
  $.ajax({
      type: "GET",
      async : false,
      url: base_url+'/Dashboard/getSelectProceso', 
      success: function(data, textStatus, jqXHR){
        if(jqXHR.status == 200){
              //console.log(data);
              $("#cboProceso").selectpicker('destroy');
              $("#cboProceso").html(data).selectpicker('refresh');

          }
      }
  });
}



function cboProcesoCarga(){
  
  //var proceso = $('#cboProceso').val();
  resumenGeneral();
  resumenODPE();
  resumenSOLTEC();

}


function resumenGeneral(){ 

  var requestDatelleResumen             = new Object();
  requestDatelleResumen["idProceso"]  = $("#cboProceso").val();

  $.ajax({
      url: base_url+'/Dashboard/getResumenProceso',
      type: "POST",     
      dataType: 'json',
      data:requestDatelleResumen,    
      cache: false,
      success: function(data, textStatus, jqXHR){
        if(jqXHR.status == 200){
              // console.log(data);
              $("#cantSoltec").html(data.data.SOLUCION);
              $("#cantOdpe").html(data.data.ODPE);
              $("#cantDistrito").html(data.data.DISTRITOS);
              $("#cantLocal").html(data.data.LOCAL);
              $("#cantMesas").html(data.data.MESAS);
              $("#cantElectores").html(data.data.ELECTORES);
              
          }
      }
  });
}



function resumenODPE(){ 

  var requestResumenOdpe             = new Object();
  requestResumenOdpe["idProceso"]  = $("#cboProceso").val();

  var tableResumenOdpe = $('#tableResumenOdpe').DataTable({
      //"processing": true,
      //"serverSide": true,
      "destroy": true,
      "order": [],
      "language": {
        "url": base_url+'/Assets/js/es-pe.json'
      },
      "ajax": {
        "url": base_url+'/Dashboard/getResumenOdpe',
        "type": "POST",
        "data" : requestResumenOdpe,
        "dataType": "json",
        "cache": false,
      },
      "columns": [
      {"data":"ORDEN"}, 
      {"data":"NOMBRE_ODPE"}, 
      {"data":"DISTRITOS"},
      {"data":"LOCAL"},
      {"data":"MESAS"},
      {"data":"ELECTORES"}, 
      ],
      "resonsieve":"true",
      "dDestroy": true,
      "iDisplayLength": 10,
      /*"order": [[0,"asc"]],*/
      "columnDefs": [{
        "targets": [0],
        "orderable": false,
      }, ],
    });

}


function resumenSOLTEC(){ 

  var requestResumenSoltec             = new Object();
  requestResumenSoltec["idProceso"]  = $("#cboProceso").val();

  $.ajax({
      url: base_url+'/Dashboard/selectResumenSoltec',
      type: "POST",     
      dataType: 'json',
      data:requestResumenSoltec,    
      cache: false,
      success: function(data, textStatus, jqXHR){
        if(jqXHR.status == 200){
              console.log(data.data);

              // Radialize the colors
              Highcharts.setOptions({
                  colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
                      return {
                          radialGradient: {
                              cx: 0.5,
                              cy: 0.3,
                              r: 0.7
                          },
                          stops: [
                              [0, color],
                              [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
                          ]
                      };
                  })
              });

              // Build the chart
              Highcharts.chart('container', {
                  chart: {
                      plotBackgroundColor: null,
                      plotBorderWidth: null,
                      plotShadow: false,
                      type: 'pie'
                  },
                  title: {
                      text: '<b>SOLUCIONES TECNOLÓGICAS</b>'
                  },
                  tooltip: {
                      pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                  },
                  plotOptions: {
                      pie: {
                          allowPointSelect: true,
                          cursor: 'pointer',
                          dataLabels: {
                              enabled: true,
                              format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                              style: {
                                  color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                              },
                              connectorColor: 'silver'
                          }
                      }
                  },
                  series: [{
                      name: 'PORCENTAJE',
                      data: data.data
                          
                  }]
              });





          }
      }
  });

}










/*function cantidadGerencias(){

   	$.ajax({
      	type:'POST',
      	url: base_url+'/Dashboard/getGerencias',
      	dataType: 'json',
      	//data:'id='+id,
      	success: function(data, textStatus, jqXHR){
			console.log(data.data);
			if(jqXHR.status == 200){
		        if(data.status){
		        	//var datos = JSON.parse(data);
		        	$('#gerencias').html(data.data);
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



function cantidadUsuarios(){

   	$.ajax({
      	type:'POST',
      	url: base_url+'/Dashboard/getUsuarios',
      	dataType: 'json',
      	//data:'id='+id,
      	success: function(data, textStatus, jqXHR){
			console.log(data.data);
			if(jqXHR.status == 200){
		        if(data.status){
		        	//var datos = JSON.parse(data);
		        	$('#usuarios').html(data.data);
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
}*/
