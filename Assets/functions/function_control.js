// JavaScript Document
$(document).ready(function(){

	CboProceso();	
	
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



/*================================================  FUNCTIONS CONTROL GENERAL  ================================================*/

function CboProceso(){
	$.ajax({
	    type: "GET",
	    async : false,
	    url: base_url+'/Control/getSelectProceso', 
	    success: function(data, textStatus, jqXHR){
	    	if(jqXHR.status == 200){
	            //console.log(data);
	            $("#cboProceso").selectpicker('destroy');
	            $("#cboProceso").html(data).selectpicker('refresh');

	        }
	    }
	});
}


function panelTabs(id){
	var proceso = $('#cboProceso').val(); 
	if(proceso != '' ){
		//$('#carga_panel').show()
		//$('#carga_panel').load('Views/Control/control_'+id+'.php');

		$.ajax({
		    type: "GET",
		    async : false,
		    url: base_url+'/Control/getSelectPanel/'+id, 
		    success: function(data, textStatus, jqXHR){
		    	if(jqXHR.status == 200){
		            //console.log(data);
		            $('#carga_panel').show()
		            $("#carga_panel").html(data);

		        }
		    }
		});


	}else{
		swal("Alerta!", "Debe Seleccionar un Proceso", "warning");
		$('.confirm').removeClass('btn btn-danger').removeClass('btn btn-success').addClass('btn btn-warning');

	}

}


function cbomateriales(){
	var proceso  =   $('#cboProceso').val();
	$('#carga_panel').hide();
}



function array(){

	/*const numeros  = [1, 2, 8, 3, 4, 4, 5];
	let duplicados = [];
	 
	const tempArray = [...numeros].sort(); //alert(tempArray)
	 
	for (let i = 0; i < tempArray.length; i++) {
	  if (tempArray[i + 1] === tempArray[i]) {
	    duplicados.push(tempArray[i]);
	  }
	}
	 
	console.log(duplicados); // [2, 4]*/



	/*array =[1, 2, 1, 1, 1, 1, 3, 4];
	otraVariableX = array[0];
	valoresNC = [];
	valoresC = [];
	for (var i = 0; i < array.length; i++) {

	  if (otraVariableX != array[i]) {
	    valoresNC.push('pos: ' + (i+1) + ' -----   valor: '+array[i]);

	  }else{
	  	valoresC.push(array[i]);
	  }
	}

	console.log(valoresNC);
	console.log(valoresC.length);
	console.log(array.length)	*/


}

function barcode(){
//var Quagga = require('quagga');
	
	for (var i = 0; i < 51; i++) {
		Quagga.decodeSingle({
		    decoder: {
		        readers: 	[	
		        				"code_128_reader",
		                        "ean_reader",
		                        "ean_8_reader",
		                        "code_39_reader",
		                        "code_39_vin_reader",
		                        "codabar_reader",
		                        "upc_reader",
		                        "upc_e_reader",
		                        "i2of5_reader"
		    				] // List of active readers
		    },
		    locate: true, // try to locate the barcode in the image
		    src: 'Assets/images/barcodes'+i+'.jpg', // or 'data:image/jpg;base64,' + data

		}, function(result){
			
			$('#codes1').val(result.codeResult.code);

		});
		/*setTimeout(function(){ 
			var codes1 = $('#codes1').val($('#codes').val());
			//$('#codes').val('');
			//$('#codes1').val($('#codes').val()+','+codes1);
		}, 250);*/

		//$('#codes0').val('');
		//$('#codes1').val($('#codes0').val()+','+codes1);
	}
}