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


$( "#form_login" ).submit(function() {
    var user = $('#username').val();
    var pass = $('#password').val();
    var total = user.length * pass.length;

    var requestLogin 		= new Object();
    requestLogin["username"]= $("#username").val();
	requestLogin["password"]= $("#password").val();

    if (total>0){
        $('#username').blur().attr('readonly',true);
        $('#password').blur().attr('readonly',true);
        $('#enviar').attr('disabled',true);
        $('#back').hide();
        // $('#preloader-msj').show().addClass('spinner-border');
        $('#msj_sign_in').html('<img src="'+media+'/images/loading.gif" width="40">').removeClass('alert alert-outline-danger').show();
        // $('#preloader-msj');
        $.ajax({
            url: base_url+'/Login/loginUser',
	        type: "POST",     
	        dataType: 'json',
	        data:requestLogin,    
	        cache: false,
	        	
	        success: function(data, textStatus, jqXHR){
	        	var statusCode = jqXHR.status;
	        	if(statusCode==200){
	        		if(data.status){
	        			setTimeout(function(){
							window.location = base_url+'/dashboard';
	        			}, 2000)
		        		
	        		}else{
	        			setTimeout(function(){
							$('#msj_sign_in').addClass('alert alert-outline-danger').html('<span class="alert-icon"><i class="zmdi zmdi-close-circle"></i></span>'+data.msg).show(10).delay(3000).hide(10);
		        			$('#username').attr('readonly',false);
		        			$('#password').attr('readonly',false).val('').focus();
                  			$('#enviar').attr('disabled',false);
                  			setTimeout(function(){ $('#back').show(); }, 3065);
	        			}, 2000)
		        	}
	        	}else{
	        		$('#msj_sign_in').addClass('alert alert-outline-danger').html('<span class="alert-icon"><i class="zmdi zmdi-close-circle"></i></span><strong>Atención!</strong> Al procesar los Datos').show(10).delay(3000).hide(10);
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