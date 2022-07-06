// JavaScript Document
$(document).ready(function(){
  // alert('ok');
  $('#cbofaseRecepcion').selectpicker();
  $('#cbosoltecRecepcion').selectpicker();
  $('#cboodpeRecepcion').selectpicker();
  $('#cboagrupacionRecepcion').selectpicker();
  $('#cbodepartRecepcion').selectpicker();
  $('#cboprovRecepcion').selectpicker();
  $('#cbodistRecepcion').selectpicker();
  $('#cboconsultaRecepcion').selectpicker();
});


var eleccion = $('#cboProceso option:selected').attr('data');
//$('#txtdata').val(eleccion);
if (eleccion == 2) {
    $('#divAgrupacionRecepcion').show();
    $('#divAgrupacionControl').show();
    $('#divAgrupacionEmpaque').hide();
    $('#divConsultaEmpaque').hide();
    $('#divAvanceAgrupRecepcion').removeAttr('style');
    $('#divAvanceAgrupControl').removeAttr('style');
    $('#divAvanceAgrupEmpaque').removeAttr('style');
    
}else{
    $('#divAgrupacionRecepcion').hide();
    $('#divAgrupacionControl').hide();
    $('#divAgrupacionEmpaque').hide();
    $('#divConsultaEmpaque').show();
    $('#divAvanceAgrupRecepcion').css("display","none");
    $('#divAvanceAgrupControl').css("display","none");
    $('#divAvanceAgrupEmpaque').css("display","none");
}


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

/*RESET DE COMBO E IMPUT*/
function cargaCbo(etapa){
  /*$('#cbofase'+etapa).selectpicker();
  $('#cbosoltec'+etapa).selectpicker();
  $('#cboodpe'+etapa).selectpicker();
  $('#cboagrupacion'+etapa).selectpicker();
  $('#cbodepart'+etapa).selectpicker();
  $('#cboprov'+etapa).selectpicker();
  $('#cbodist'+etapa).selectpicker();
  $('#cboconsulta'+etapa).selectpicker();*/
  resetCbo(etapa);
  resetInpbarra(etapa);
  //enabledAvance(etapa);
  cargaAvanceFase(etapa);
  cargaAvanceOdpe(etapa);
  //cargaAvanceAgrupacion(etapa);
}

function resetCbo(etapa){
  $('#sign_add'+etapa+'Reserva')[0].reset();
  $('#sign_add'+etapa+'Reserva').validate().resetForm();
  $('#cbofase'+etapa).selectpicker('destroy');
  $('#cbofase'+etapa).html('<option value="">[ SELECCIONE UNA FASE ]</option><option value="1">SUFRAGIO</option>').selectpicker('refresh');
  $('#cbosoltec'+etapa).selectpicker('destroy');
  $('#cbosoltec'+etapa ).html( '<option value="">[ SELECCIONE UNA SOL. TECN. ]</option>' ).selectpicker('refresh');
  $('#cboodpe'+etapa).selectpicker('destroy');
  $('#cboodpe'+etapa).html( '<option value="">[ SELECCIONE UNA ODPE ]</option>' ).selectpicker('refresh');
  $('#cboagrupacion'+etapa).selectpicker('destroy');
  $('#cboagrupacion'+etapa).html( '<option value="">[ SELECCIONE UNA AGRUP. POLITICA  ]</option>' ).selectpicker();
  $('#cbodepart'+etapa).selectpicker('destroy');
  $('#cbodepart'+etapa).html( '<option value="">[ SELECCIONE UN DEPARTAMENTO ]</option>' ).selectpicker('refresh');
  $('#cboprov'+etapa).selectpicker('destroy');
  $('#cboprov'+etapa).html( '<option value="">[ SELECCIONE UNA PROVINCIA ]</option>' ).selectpicker('refresh');
  $('#cbodist'+etapa).selectpicker('destroy');
  $('#cbodist'+etapa).html( '<option value="">[ SELECCIONE UN DISTRITO ]</option>' ).selectpicker('refresh');
  $('#cboconsulta'+etapa).selectpicker('destroy');
  $('#cboconsulta'+etapa).html( '<option value="">[ SELECCIONE TIPO DE C&Eacute;DULA ]</option>' ).selectpicker('refresh');
  enabledAvance(etapa);
}

function resetInpbarra(etapa) {
    $("#ubigeo"+etapa).prop('disabled', true).val("");
    $("#rotulo"+etapa).prop('disabled', true).val("");
    $("#txtValidacion"+etapa).val('1');
    $('#btnIncid'+etapa).hide();
    $('#btnResetInput'+etapa).hide();
    $('#add'+etapa+'Reserva').hide();
    $('#msj_mesa_next').hide();
}

function habilInpbarra(etapa) {
    $("#ubigeo"+etapa).prop('disabled', false).val("").focus();
    $("#rotulo"+etapa).prop('disabled', false).val("");
    $("#txtValidacion"+etapa).val('1');
}

function inhabilitaEscbarra(etapa) {
    $("#ubigeo"+etapa).prop('disabled', true);
    $("#rotulo"+etapa).prop('disabled', true);
    $('#btnIncid'+etapa).removeAttr('style');
    $('#btnResetInput'+etapa).removeAttr('style');
    //$('#add'+etapa+'Reserva').removeAttr('style');
  }

function habilBtnValidar(etapa) {
    $("#ubigeo"+etapa).prop('disabled', true);
    $("#rotulo"+etapa).prop('disabled', true);
    $('#btnIncid'+etapa).removeAttr('style');
    $('#add'+etapa+'Reserva').removeAttr('style');
    $('#btnResetInput'+etapa).removeAttr('style');
  }

function resetInput(etapa){
  $("#ubigeo"+etapa).prop('disabled', false).val("").focus();
  $("#rotulo"+etapa).prop('disabled', false).val("");
  $("#txtValidacion"+etapa).val('1');
  $('#btnIncid'+etapa).css("display","none");
  $('#btnResetInput'+etapa).css("display","none");
  $('#add'+etapa+'Reserva').css("display","none");
}
/* FIN RESET*/


/*CARGA AVANCE FASE*/
function cargaAvanceFase(etapa){

    var requestAvanceFase           = new Object();
    requestAvanceFase["idProceso"]  = $("#cboProceso").val();
    requestAvanceFase["idMaterial"] = $("#idMaterial").val();
    requestAvanceFase["idEtapa"]    = $("#txtIdEtapa"+etapa).val();
    requestAvanceFase["idFase"]     = $("#cbofase"+etapa).val();
    requestAvanceFase["nomfase"]    = $('#cbofase'+etapa+' option:selected').text();
    requestAvanceFase["validacion"] = $("#txtValidacion"+etapa).val();

    $.ajax({
      url: base_url+'/Control_reserva/getAvanceFase',
      type: "POST",     
      dataType: 'json',
      data:requestAvanceFase,    
      cache: false,
            
      success: function(data, textStatus, jqXHR){
        // console.log(data);
        if(jqXHR.status == 200){
               
            $('#tbl_reserva'+etapa+'AvanceFase tbody').html(data.data);
            $('#nomFase'+etapa).html('<strong>'+data.nomFase+'</strong>');
        }

      },
          
    });
}
          

function cboSoltecReserva(etapa){
  resetInpbarra(etapa);
  // cargaAvanceFase(etapa);
  cargaAvanceOdpe(etapa);
   setTimeout(function(){ 
      // cargaAvanceOdpe(etapa);
    }, 120);

  if($('#cbofase'+etapa).val() != ''){ 
    var requestSolucion         = new Object();
    requestSolucion["idProceso"] = $("#cboProceso").val();
    
      $.ajax({
          url: base_url+'/Control_reserva/getSelectSolucion',
          type: "POST",     
          // dataType: 'json',
          data:requestSolucion,    
          cache: false,
            
          success: function(data, textStatus, jqXHR){
            // console.log(data);
            if(jqXHR.status == 200){

              $('#cbosoltec'+etapa).selectpicker('destroy');
              $('#cbosoltec'+etapa).html(data).selectpicker('refresh');

            }

          },
          
      });
      return false;

  }else{
        
      resetCbo(etapa);

  }
}



/*CARGA AVANCE ODPE*/
function cargaAvanceOdpe(etapa){

    var requestAvanceOdpe           = new Object();
    requestAvanceOdpe["idProceso"]  = $("#cboProceso").val();
    requestAvanceOdpe["idMaterial"] = $("#idMaterial").val();
    requestAvanceOdpe["idEtapa"]    = $("#txtIdEtapa"+etapa).val();
    requestAvanceOdpe["idFase"]     = $("#cbofase"+etapa).val();
    requestAvanceOdpe["idOdpe"]     = $("#cboodpe"+etapa).val();
    requestAvanceOdpe["nomOdpe"]    = $('#cboodpe'+etapa+' option:selected').text();
    requestAvanceOdpe["validacion"] = $("#txtValidacion"+etapa).val();

    $.ajax({
      url: base_url+'/Control_reserva/getAvanceOdpe',
      type: "POST",     
      dataType: 'json',
      data:requestAvanceOdpe,    
      cache: false,
            
      success: function(data, textStatus, jqXHR){
        // console.log(data);
        if(jqXHR.status == 200){
               
            $('#tbl_reserva'+etapa+'AvanceOdpe tbody').html(data.data);
            $('#nomOdpe'+etapa).html('<strong>'+data.nomOdpe+'</strong>');
        }

      },
          
    });
}


function cboOdpeReserva(etapa){ 

    resetInpbarra(etapa);
    $('#cbodepart'+etapa).selectpicker('destroy');
    $('#cbodepart'+etapa).html( '<option value="">[ SELECCIONE UN DEPARTAMENTO ]</option>' ).selectpicker('refresh');
    $('#cboprov'+etapa).selectpicker('destroy');
    $('#cboprov'+etapa).html( '<option value="">[ SELECCIONE UNA PROVINCIA ]</option>' ).selectpicker('refresh');
    $('#cbodist'+etapa).selectpicker('destroy');
    $('#cbodist'+etapa).html( '<option value="">[ SELECCIONE UN DISTRITO ]</option>' ).selectpicker('refresh');
    $('#cboconsulta'+etapa).selectpicker('destroy');
    $('#cboconsulta'+etapa).html( '<option value="">[ SELECCIONE TIPO DE C&Eacute;DULA ]</option>' ).selectpicker('refresh');
      
    var requestOdpe           = new Object();
    requestOdpe["idProceso"]  = $("#cboProceso").val();
    requestOdpe["idSolucion"] = $("#cbosoltec"+etapa).val();

    $.ajax({
      url: base_url+'/Control_reserva/getSelectOdpe',
      type: "POST",     
          // dataType: 'json',
      data:requestOdpe,    
      cache: false,
            
      success: function(data, textStatus, jqXHR){
        // console.log(data);
        if(jqXHR.status == 200){

          $('#cboodpe'+etapa).selectpicker('destroy');
          $('#cboodpe'+etapa).html(data).selectpicker('refresh');

        }

      },
          
    });

    setTimeout(function(){ 
      // cargaAvanceOdpe(etapa);
      //cargaAvanceAgrupacion(etapa);
      enabledAvance(etapa);
    }, 120);
}


function cboDepartamentoReserva(etapa){

    resetInpbarra(etapa);
    // cargaAvanceOdpe(etapa);
    enabledAvance(etapa);

    $('#cboprov'+etapa).selectpicker('destroy');
    $('#cboprov'+etapa).html( '<option value="">[ SELECCIONE UNA PROVINCIA ]</option>' ).selectpicker('refresh');
    $('#cbodist'+etapa).selectpicker('destroy');
    $('#cbodist'+etapa).html( '<option value="">[ SELECCIONE UN DISTRITO ]</option>' ).selectpicker('refresh');
    $('#cboconsulta'+etapa).selectpicker('destroy');
    $('#cboconsulta'+etapa).html( '<option value="">[ SELECCIONE TIPO DE C&Eacute;DULA ]</option>' ).selectpicker('refresh');

    var eleccionN = (eleccion == 1 || (eleccion == 2 && etapa == 'Empaque')) ? 1 : eleccion ;
      
    var requestDepartamento           = new Object();
    requestDepartamento["idProceso"]  = $("#cboProceso").val();
    requestDepartamento["idSolucion"] = $("#cbosoltec"+etapa).val();
    requestDepartamento["idOdpe"]     = $("#cboodpe"+etapa).val();
    requestDepartamento["idEleccion"] = eleccionN;

    $.ajax({
      url: base_url+'/Control_reserva/getSelectDepartamento',
      type: "POST",     
          // dataType: 'json',
      data:requestDepartamento,    
      cache: false,
            
      success: function(data, textStatus, jqXHR){
        // console.log(data);
        if(jqXHR.status == 200){

          if(eleccion == 1 || (eleccion == 2 && etapa == 'Empaque') ){
            $('#cbodepart'+etapa).selectpicker('destroy');
            $('#cbodepart'+etapa).html(data).selectpicker('refresh');

          }else{
            $('#cboagrupacion'+etapa).selectpicker('destroy');
            $('#cboagrupacion'+etapa).html(data).selectpicker('refresh');
            $('#cbodepart'+etapa).selectpicker('destroy');
            $('#cbodepart'+etapa).html( '<option value="">[ SELECCIONE UN DEPARTAMENTO ]</option>' ).selectpicker('refresh');

          }

        }

      },
          
    });
}


function cboAgrupacionReserva(etapa){ 
  
  resetInpbarra(etapa);  
  $('#cboprov'+etapa).selectpicker('destroy');
  $('#cboprov'+etapa).html( '<option value="">[ SELECCIONE UNA PROVINCIA ]</option>' ).selectpicker('refresh');
  $('#cbodist'+etapa).selectpicker('destroy');
  $('#cbodist'+etapa).html( '<option value="">[ SELECCIONE UN DISTRITO ]</option>' ).selectpicker('refresh');
  $('#cboconsulta'+etapa).selectpicker('destroy');
  $('#cboconsulta'+etapa).html( '<option value="">[ SELECCIONE TIPO DE C&Eacute;DULA ]</option>' ).selectpicker('refresh');
  
  var requestAgrupacion                 = new Object();
    requestAgrupacion["idProceso"]      = $("#cboProceso").val();
    requestAgrupacion["idSolucion"]     = $("#cbosoltec"+etapa).val();
    requestAgrupacion["idOdpe"]         = $("#cboodpe"+etapa).val();
    requestAgrupacion["idAgrupacion"]   = $("#cboagrupacion"+etapa).val();
    requestAgrupacion["idEleccion"]     = eleccion;

    $.ajax({
      url: base_url+'/Control_reserva/getSelectAgrupacion',
      type: "POST",     
          // dataType: 'json',
      data:requestAgrupacion,    
      cache: false,
            
      success: function(data, textStatus, jqXHR){
        // console.log(data);
        if(jqXHR.status == 200){
            $('#cbodepart'+etapa).selectpicker('destroy');
            $('#cbodepart'+etapa).html(data).selectpicker('refresh');   

        }

      },
          
    });
}


function cboProvinciaReserva(etapa){

  resetInpbarra(etapa);
  $('#cbodist'+etapa).selectpicker('destroy');
  $('#cbodist'+etapa).html( '<option value="">[ SELECCIONE UN DISTRITO ]</option>' ).selectpicker('refresh');
  $('#cboconsulta'+etapa).selectpicker('destroy');
  $('#cboconsulta'+etapa).html( '<option value="">[ SELECCIONE TIPO DE C&Eacute;DULA ]</option>' ).selectpicker('refresh');

  var eleccionN = (eleccion == 1 || (eleccion == 2 && etapa == 'Empaque')) ? 1 : eleccion ;
  
  var requestProvincia                 = new Object();
    requestProvincia["idProceso"]      = $("#cboProceso").val();
    requestProvincia["idSolucion"]     = $("#cbosoltec"+etapa).val();
    requestProvincia["idOdpe"]         = $("#cboodpe"+etapa).val();
    requestProvincia["idAgrupacion"]   = $("#cboagrupacion"+etapa).val();
    requestProvincia["idDepartamento"] = $("#cbodepart"+etapa).val();
    requestProvincia["idEleccion"]     = eleccionN;
    
    $.ajax({
      url: base_url+'/Control_reserva/getSelectProvincia',
      type: "POST",     
          // dataType: 'json',
      data:requestProvincia,    
      cache: false,
            
      success: function(data, textStatus, jqXHR){
        // console.log(data);
        if(jqXHR.status == 200){

            $('#cboprov'+etapa).selectpicker('destroy');
            $('#cboprov'+etapa).html(data).selectpicker('refresh');

        }

      },
          
    });
}


function cboDistritoReserva(etapa){

  resetInpbarra(etapa);
  $('#cboconsulta'+etapa).selectpicker('destroy');
  $('#cboconsulta'+etapa).html( '<option value="">[ SELECCIONE TIPO DE C&Eacute;DULA ]</option>' ).selectpicker('refresh');

  var eleccionN = (eleccion == 1 || (eleccion == 2 && etapa == 'Empaque')) ? 1 : eleccion ;

  var requestDsitrito                  = new Object();
    requestDsitrito["idProceso"]       = $("#cboProceso").val();
    requestDsitrito["idSolucion"]      = $("#cbosoltec"+etapa).val();
    requestDsitrito["idOdpe"]          = $("#cboodpe"+etapa).val();
    requestDsitrito["idAgrupacion"]    = $("#cboagrupacion"+etapa).val();
    requestDsitrito["idDepartamento"]  = $("#cbodepart"+etapa).val();
    requestDsitrito["idProvincia"]     = $("#cboprov"+etapa).val();
    requestDsitrito["idEleccion"]      = eleccionN;
    
    $.ajax({
      url: base_url+'/Control_reserva/getSelectDistrito',
      type: "POST",     
          // dataType: 'json',
      data:requestDsitrito,    
      cache: false,
            
      success: function(data, textStatus, jqXHR){
        // console.log(data);
        if(jqXHR.status == 200){

            $('#cbodist'+etapa).selectpicker('destroy');
            $('#cbodist'+etapa).html(data).selectpicker('refresh');

        }

      },
          
    });
}


function cboConsultaReserva(etapa){
  $("#idConsultaEmpaque").val("");
  resetInpbarra(etapa);
  var etapaControl = $('#txtIdEtapa'+etapa).val();
  var eleccionN = (eleccion == 1 || (eleccion == 2 && etapa == 'Empaque')) ? 1 : eleccion ;

  var requestConsulta                 = new Object();
    requestConsulta["idMaterial"]     = $("#idMaterial").val();
    requestConsulta["idProceso"]      = $("#cboProceso").val();
    requestConsulta["idSolucion"]     = $("#cbosoltec"+etapa).val();
    requestConsulta["idOdpe"]         = $("#cboodpe"+etapa).val();
    requestConsulta["idAgrupacion"]   = $("#cboagrupacion"+etapa).val();
    requestConsulta["idDepartamento"] = $("#cbodepart"+etapa).val();
    requestConsulta["idProvincia"]    = $("#cboprov"+etapa).val();
    requestConsulta["idDistrito"]     = $("#cbodist"+etapa).val();
    requestConsulta["idEleccion"]     = eleccionN;


  if(eleccion == 2 && etapa == 'Empaque'){
    if(etapaControl==3){
        habilInpbarra(etapa);
        //ordenEmpaquetado(etapa);
    }
  }else{ 

    $.ajax({
      url: base_url+'/Control_reserva/getSelectConsulta',
      type: "POST",     
          // dataType: 'json',
      data:requestConsulta,    
      cache: false,
            
      success: function(data, textStatus, jqXHR){
        // console.log(data);
        if(jqXHR.status == 200){

            $('#cboconsulta'+etapa).selectpicker('destroy');
            $('#cboconsulta'+etapa).html(data).selectpicker('refresh');

        }

      },
          
    });

  }
}


/*CARGA COD BARRAS*/
function selTipoReserva(etapa){
    if ($('#cboconsulta'+etapa).val() != ""){
        habilInpbarra(etapa);
        $('#btnIncid'+etapa).hide();
        $('#btnResetInput'+etapa).hide();

        var etapaControl = $('#txtIdEtapa'+etapa).val();
        var validacion = $("#txtValidacion"+etapa).val();      
        var eleccionN = (eleccion == 1 || (eleccion == 2 && etapa == 'Empaque')) ? 1 : eleccion ;

        var requestConsulta               = new Object();
        requestConsulta["idMaterial"]     = $("#idMaterial").val();
        requestConsulta["idProceso"]      = $("#cboProceso").val();
        requestConsulta["idSolucion"]     = $("#cbosoltec"+etapa).val();
        requestConsulta["idOdpe"]         = $("#cboodpe"+etapa).val();
        requestConsulta["idAgrupacion"]   = $("#cboagrupacion"+etapa).val();
        requestConsulta["idDepartamento"] = $("#cbodepart"+etapa).val();
        requestConsulta["idProvincia"]    = $("#cboprov"+etapa).val();
        requestConsulta["idDistrito"]     = $("#cbodist"+etapa).val();
        requestConsulta["consulta"]       = $("#cboconsulta"+etapa).val();
        requestConsulta["idEleccion"]     = eleccionN;


        $.ajax({
          url: base_url+'/Control_reserva/getBarra',
          type: "POST",     
          dataType: 'json',
          data:requestConsulta,    
          cache: false,
                
          success: function(data, textStatus, jqXHR){
            // console.log(data);
            if(jqXHR.status == 200){

                document.getElementById('ubigeo'+etapa).maxLength = data.data.DIG_UBIGEO;
                document.getElementById('rotulo'+etapa).maxLength = data.data.DIG_ROTULO;

                if(etapaControl==3){
                  
                  ordenEmpaquetado(etapa);

                }
            }

          },
              
        });

    } else {
        resetInpbarra(etapa);
    }
}



function ordenEmpaquetado(etapa){

    var etapaControl = $('#txtIdEtapa'+etapa).val();
    var validacion = $("#txtValidacion"+etapa).val();  
    var consulta = ( eleccion == 2 && etapa == 'Empaque') ? $("#idConsulta"+etapa).val() : $("#cboconsulta"+etapa).val() ;    
    var eleccionN = (eleccion == 1 || (eleccion == 2 && etapa == 'Empaque')) ? 1 : eleccion ;

    var departamento = $("#cbodepart"+etapa).val();
    var provincia = $("#cboprov"+etapa).val();
    var distrito = $("#cbodist"+etapa).val();

    var cboubigeo = departamento+provincia+distrito;
    var nomdepartamento = $('#cbodepart'+etapa+' option:selected').text();
    var nomprovincia = $('#cboprov'+etapa+' option:selected').text();
    var nomdistrito = $('#cbodist'+etapa+' option:selected').text();
    var etapaControl = $('#txtIdEtapa'+etapa).val();

    var requestOrdenEmpaquetado               = new Object();
    requestOrdenEmpaquetado["idMaterial"]     = $("#idMaterial").val();
    requestOrdenEmpaquetado["idProceso"]      = $("#cboProceso").val();
    requestOrdenEmpaquetado["idFase"]         = $("#cbofase"+etapa).val();
    requestOrdenEmpaquetado["idEtapa"]        = $("#txtIdEtapa"+etapa).val();
    requestOrdenEmpaquetado["idSolucion"]     = $("#cbosoltec"+etapa).val();
    requestOrdenEmpaquetado["idOdpe"]         = $("#cboodpe"+etapa).val();
    requestOrdenEmpaquetado["idAgrupacion"]   = $("#cboagrupacion"+etapa).val();
    requestOrdenEmpaquetado["idDepartamento"] = $("#cbodepart"+etapa).val();
    requestOrdenEmpaquetado["idProvincia"]    = $("#cboprov"+etapa).val();
    requestOrdenEmpaquetado["idDistrito"]     = $("#cbodist"+etapa).val();
    requestOrdenEmpaquetado["consulta"]       = consulta;
    requestOrdenEmpaquetado["validacion"]     = validacion;
    requestOrdenEmpaquetado["idEleccion"]     = eleccionN;
    requestOrdenEmpaquetado["etapa"]          = etapa;
    requestOrdenEmpaquetado["cboubigeo"]      = cboubigeo;
    requestOrdenEmpaquetado["nomdepartamento"]= nomdepartamento;
    requestOrdenEmpaquetado["nomprovincia"]   = nomprovincia;
    requestOrdenEmpaquetado["nomdistrito"]    = nomdistrito;

    //if(distrito != ''){
        $.ajax({
          url: base_url+'/Control_reserva/ordenEmpaquetado',
          type: "POST",     
          dataType: 'json',
          data:requestOrdenEmpaquetado,    
          cache: false,
                
          success: function(data, textStatus, jqXHR){
            console.log(data);
            if(jqXHR.status == 200){

                if(data.status){
                  
                  var html= '<div>'+
                                '<strong style= "font-size:16px;">ATENCI&Oacute;N!</strong> '+
                                'El codigo de Reserva a Empaquetar es la N° <br><b style= "font-size:26px;">'+data.mesa_next+'</b><br>'+ 
                                'Departamento: <b style= "font-size:14px;">'+data.departamento+'</b><br>'+ 
                                'Provincia: <b style= "font-size:14px;">'+data.provincia+'</b><br>'+
                                'Distrito: <b style= "font-size:14px;">'+data.distrito+'</b><br>'+
                            '</div>';

                  $('#msj_mesa_next').addClass('alert alert-outline-info').html(html).show();
                  return false;

                }else{
                  $('#msj_mesa_next').addClass('alert alert-outline-info').html(html).hide();
                  swal({  title:  data.title,
                          text:   data.msg,
                          type:   "success",
                          timer:  4000
                      });
                  $("#rotuloEmpaque").prop("disabled", true);
                  $("#ubigeoEmpaque").prop("disabled", true);
                  $('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
                  return false;
                }
            }

          },
              
        });
}


function inpUbigeo(etapa) {
  
  if(event.keyCode==13){
    document.getElementById("rotulo"+etapa).focus();
  }
}

/*INPUT ROTULO*/
function inpRotulo(etapa){
  //var validar = $('#addControlCedula').click;
  if (event.keyCode == 13 || event.which == 13 ) {

    var departamento = $("#cbodepart"+etapa).val();
    var provincia = $("#cboprov"+etapa).val();
    var distrito = $("#cbodist"+etapa).val();

    var cboubigeo = departamento+provincia+distrito;
    var ubigeo = $("#ubigeo"+etapa).val().toUpperCase().trim();
    var rotulo = $("#rotulo"+etapa).val().toUpperCase().trim();
    var validacion = $("#txtValidacion"+etapa).val();
    var consulta = ( eleccion == 2 && etapa == 'Empaque') ? $("#idConsulta"+etapa).val() : $("#cboconsulta"+etapa).val() ; 
    var eleccionN = (eleccion == 1 || (eleccion == 2 && etapa == 'Empaque')) ? 1 : eleccion ;

    var nomdepartamento = $('#cbodepart'+etapa+' option:selected').text();
    var nomprovincia = $('#cboprov'+etapa+' option:selected').text();
    var nomdistrito = $('#cbodist'+etapa+' option:selected').text();
    var etapaControl = $('#txtIdEtapa'+etapa).val();

    var requestCedula               = new Object();
    requestCedula["idMaterial"]     = $("#idMaterial").val();
    requestCedula["idProceso"]      = $("#cboProceso").val();
    requestCedula["idEtapa"]        = $("#txtIdEtapa"+etapa).val();
    requestCedula["idFase"]         = $("#cbofase"+etapa).val();
    requestCedula["idSolucion"]     = $("#cbosoltec"+etapa).val();
    requestCedula["idOdpe"]         = $("#cboodpe"+etapa).val();
    requestCedula["idAgrupacion"]   = $("#cboagrupacion"+etapa).val();
    requestCedula["idDepartamento"] = $("#cbodepart"+etapa).val();
    requestCedula["idProvincia"]    = $("#cboprov"+etapa).val();
    requestCedula["idDistrito"]     = $("#cbodist"+etapa).val();
    requestCedula["consulta"]       = consulta;
    requestCedula["cboubigeo"]      = cboubigeo;
    requestCedula["ubigeo"]         = ubigeo;
    requestCedula["rotulo"]         = rotulo;
    requestCedula["validacion"]     = validacion;
    requestCedula["idEleccion"]     = eleccionN;
    requestCedula["nomdepartamento"]= nomdepartamento;
    requestCedula["nomprovincia"]   = nomprovincia;
    requestCedula["nomdistrito"]    = nomdistrito;
    requestCedula["etapa"]          = etapa;

   /* $.ajax({
          url: base_url+'/Control_reserva/getBarra',
          type: "POST",     
          dataType: 'json',
          data:requestCedula,    
          cache: false,
                
          success: function(data, textStatus, jqXHR){
            // console.log(data);
            if(jqXHR.status == 200){

                console.log(data.data);
                // validando ubigeo Formato
                var preUbigeo  = ubigeo.substr(0, data.data.PREF_UBIGEO.length);     
                var cUbigeo    = ubigeo.substr(data.data.PREF_UBIGEO.length, 6);
                var sufUbigeo  = ubigeo.substr(data.data.PREF_UBIGEO.length+6, data.data.SUF_UBIGEO.length);
                // validando rotulo Formato
                var preRotulo  = rotulo.substr(0, data.data.PREF_ROTULO.length);
                var cRotulo    = rotulo.substr(data.data.PREF_ROTULO.length, 9);
                var sufRotulo  = rotulo.substr(data.data.PREF_ROTULO.length+9, data.data.SUF_ROTULO.length);
                var mesa       = cRotulo.substr(0, 6);   
                var electores  = cRotulo.substr(6,3);*/

                /*console.log('pref-ubi: '+preUbigeo+'cod-ubi: '+cUbigeo+'suf-ubi: '
                  +sufUbigeo+'pref-rot: '+preRotulo+'cod-rot: '+cRotulo+'suf-rot: '
                  +sufRotulo+'mesa: '+mesa+'electores: '+electores);*/
                /*$('#txtMesaIncidencia').val(mesa).prop('disabled',true);

                if (ubigeo.length != data.data.DIG_UBIGEO ) {
                    swal({  title:  'CONTROL DE CEDULAS',
                            text:   'Verificar la cantidad de Digitos del Ubigeo',
                            type:   "error",
                            timer: 4000
                        });
                    $('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
                    inhabilitaEscbarra(etapa);

                }else if(preUbigeo.length != data.data.PREF_UBIGEO.length || preUbigeo != data.data.PREF_UBIGEO){
                    swal({  title:  'CONTROL DE CEDULAS',
                            text:   'El Tipo de Material del Ubigeo no coincide',
                            type:   "error",
                            timer: 4000
                        });
                    $('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
                    inhabilitaEscbarra(etapa);                    

                }else if(sufUbigeo.length != data.data.SUF_UBIGEO.length || sufUbigeo != data.data.SUF_UBIGEO){
                    swal({  title:  'CONTROL DE CEDULAS',
                            text:   'El Tipo de Consulta del Ubigeo no coincide',
                            type:   "error",
                            timer: 4000
                        });
                    $('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
                    inhabilitaEscbarra(etapa);

                    
                //Formato Rotulo
                }else if (rotulo.length != data.data.DIG_ROTULO ) {
                    swal({  title:  'CONTROL DE CEDULAS',
                            text:   'Verificar la cantidad de Digitos del Rotulo',
                            type:   "error",
                            timer: 4000
                        });
                    $('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
                    inhabilitaEscbarra(etapa);
                    
                }else if(preRotulo.length != data.data.PREF_ROTULO.length || preRotulo != data.data.PREF_ROTULO){
                    swal({  title:  'CONTROL DE CEDULAS',
                            text:   'El Tipo de Material del Rotulo no coincide',
                            type:   "error",
                            timer: 4000
                        });
                    $('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
                    inhabilitaEscbarra(etapa);
                    
                }else if(sufRotulo != data.data.SUF_ROTULO){
                    swal({  title:  'CONTROL DE CEDULAS',
                            text:   'El Tipo de Consulta del Rotulo no coincide',
                            type:   "error",
                            timer: 4000
                        });
                    $('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
                    inhabilitaEscbarra(etapa);*/
                    
               /* }else{
                    //alert(1)
                    $('#msj_'+etapa).removeClass('alert alert-outline-danger').html('');
                      
                      requestCedula["cUbigeo"]    = cUbigeo;
                      requestCedula["cRotulo"]    = cRotulo;
                      requestCedula["mesa"]       = mesa;
                      requestCedula["electores"]  = electores;*/

                     
                      var mesa  = rotulo.substr(5, 4); 
                      $('#txtMesaIncidencia').val(mesa).prop('disabled',true);
                    
                      $.ajax({

                        url: base_url+'/Control_reserva/validarMesa',
                        type: "POST",     
                        dataType: 'json',
                        data:requestCedula,    
                        cache: false,
                              
                        success: function(data, textStatus, jqXHR){
                          // console.log(data);
                          if(jqXHR.status == 200){
                            if(!data.status){                        
                              swal({  title:  data.title,
                                      text:   data.msg,
                                      type:   "error",
                                      timer:  4000
                              });
                              $('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
                              
                              if(data.valor == 0){
                                inhabilitaEscbarra(etapa);

                              }else if(data.valor == 1){
                                habilBtnValidar(etapa);
                                $("#txtValidacion"+etapa).val('2');

                              }else{
                                habilInpbarra(etapa);

                              }
                              return false;

                            }else{
                              
                              /*swal({  title:  data.title,
                                        text:   data.msg,
                                        type:   "success",
                                        timer:  4000
                                      });*/
                              if(data.valor == 3){
                                $('#msj_'+etapa).removeClass('alert alert-outline-danger').removeClass('alert alert-outline-warning').addClass('alert alert-outline-success').html('<span class="alert-icon"><i class="zmdi zmdi-check-circle"></i></span><strong>Correcto!</strong> El Paquete de Cedulas ha sido Recepcionado').show(10).delay(4000).hide(10);
                                $('#btnIncid'+etapa).css("display","none");
                                $('#btnResetInput'+etapa).css("display","none");                                                                                                                                                                                                  
                                // cargaAvanceFase(etapa);
                                // cargaAvanceOdpe(etapa);
                                /*cargaAvanceAgrupacion(etapa);*/
                                
                                if(etapaControl == 1){
                                  habilInpbarra(etapa);
                                }else if(etapaControl == 2){
                                  habilBtnValidar(etapa);
                                  $("#txtValidacion"+etapa).val('2');
                                }else{
                                  ordenEmpaquetado(etapa);
                                  habilInpbarra(etapa);
                                }

                              }else{
                                $('#msj_'+etapa).removeClass('alert alert-outline-danger').removeClass('alert alert-outline-warning').addClass('alert alert-outline-success').html('<span class="alert-icon"><i class="zmdi zmdi-check-circle"></i></span><strong>Correcto!</strong> El Paquete de Cedulas ha sido Validado').show(10).delay(4000).hide(10);
                                resetInput(etapa);
                                // cargaAvanceFase(etapa);
                                // cargaAvanceOdpe(etapa);
                                /*cargaAvanceAgrupacion(etapa);*/
                              }
                              $('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
                              return false;
                            }
                            
                          }

                        },
                            
                      });
                // }

         /*   }

          },
              
        });*/

  }

}


function inpRotuloValidar(etapa){

    var departamento = $("#cbodepart"+etapa).val();
    var provincia = $("#cboprov"+etapa).val();
    var distrito = $("#cbodist"+etapa).val();
    var rotulo = $("#rotulo"+etapa).val().toUpperCase().trim();

    var cboubigeo = departamento+provincia+distrito;
    var validacion = $("#txtValidacion"+etapa).val();
    var consulta = ( eleccion == 2 && etapa == 'Empaque') ? $("#idConsulta"+etapa).val() : $("#cboconsulta"+etapa).val() ; 
    var eleccionN = (eleccion == 1 || (eleccion == 2 && etapa == 'Empaque')) ? 1 : eleccion ;

    var requestCedula               = new Object();
    requestCedula["idMaterial"]     = $("#idMaterial").val();
    requestCedula["idProceso"]      = $("#cboProceso").val();
    requestCedula["idEtapa"]        = $("#txtIdEtapa"+etapa).val();
    requestCedula["idSolucion"]     = $("#cbosoltec"+etapa).val();
    requestCedula["idOdpe"]         = $("#cboodpe"+etapa).val();
    //requestCedula["mesa"]           = $('#txtMesaIncidencia').val();
    requestCedula["mesa"]           = rotulo.substr(5, 4);
    requestCedula["consulta"]       = consulta;
    requestCedula["cUbigeo"]        = cboubigeo;
    requestCedula["validacion"]     = validacion;
   

    $.ajax({

      url: base_url+'/Control_reserva/validarCedula',
      type: "POST",     
      dataType: 'json',
      data:requestCedula,    
      cache: false,

      success: function(data, textStatus, jqXHR){

        if(jqXHR.status == 200){
          if(!data.status){                        
            
            swal({  title:  data.title,
                    text:   data.msg,
                    type:   "error",
                    timer:  4000
                  });

            $('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');

            return false;

          }else{
            
              $('#msj_'+etapa).removeClass('alert alert-outline-danger').removeClass('alert alert-outline-warning').addClass('alert alert-outline-success').html('<span class="alert-icon"><i class="zmdi zmdi-check-circle"></i></span><strong>Correcto!</strong> El Paquete de Cedulas ha sido Validado').show(10).delay(4000).hide(10);
              resetInput(etapa);
              // cargaAvanceFase(etapa);
              // cargaAvanceOdpe(etapa);
              /*cargaAvanceAgrupacion(etapa);*/
            
            $('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
            return false;
          }

        }

      },

    });
          
}


function enabledAvance(etapa){
  if($("#cboodpe"+etapa).val() != ''){
    $( '#recibido'+etapa ).attr({'onclick':'resumenMesas("'+etapa+'", "RECIBIDAS", 1)','href':'#modal_resumenEscaneadas'});
    $( '#faltante'+etapa ).attr({'onclick':'resumenMesas("'+etapa+'", "FALTANTES", 2)','href':'#modal_resumenFaltantes'});
    $( '#agrupacion'+etapa ).attr({'onclick':'cargaAvanceAgrupacion("'+etapa+'")','href':'#modal_resumenAgrupacion'});
    $( '#update'+etapa ).attr('disabled',false);
  }else{
    $( '#recibido'+etapa ).removeAttr("onclick href");
    $( '#faltante'+etapa ).removeAttr("onclick href");
    $( '#agrupacion'+etapa ).removeAttr("onclick href");
    $( '#update'+etapa ).attr('disabled',true);
  }
}



function resumenMesas(etapa,tipo,valor){ 

    $('#titleMaterialResumen'+valor).html('<b>ETAPA DE '+etapa.toUpperCase()+'</b>');
    $('#titleResumen'+valor).html('<b>MESAS '+tipo+'</b>');

    var validacion = $("#txtValidacion"+etapa).val();  
    var consulta = ( eleccion == 2 && etapa == 'Empaque') ? $("#idConsulta"+etapa).val() : $("#cboconsulta"+etapa).val() ;    

    var requestResumenMesas               = new Object();
    requestResumenMesas["idMaterial"]     = $("#idMaterial").val();
    requestResumenMesas["idProceso"]      = $("#cboProceso").val();
    requestResumenMesas["idFase"]         = $("#cbofase"+etapa).val();
    requestResumenMesas["idEtapa"]        = $("#txtIdEtapa"+etapa).val();
    requestResumenMesas["idSolucion"]     = $("#cbosoltec"+etapa).val();
    requestResumenMesas["idOdpe"]         = $("#cboodpe"+etapa).val();
    requestResumenMesas["nomOdpe"]        = $('#cboodpe'+etapa+' option:selected').text();
    requestResumenMesas["consulta"]       = consulta;
    requestResumenMesas["validacion"]     = validacion;  

    $('#nomOdpeEscaneadas').html('<b>'+$('#cboodpe'+etapa+' option:selected').text()+'</b>');
    $('#nomOdpeFaltantes').html('<b>'+$('#cboodpe'+etapa+' option:selected').text()+'</b>');


    if(valor == 1){
        var url = base_url+'/Control_reserva/mesasEscaneadas';
    }else{
        var url = base_url+'/Control_reserva/mesasFaltantes';
    }


    var tableMesas = $('#tableMesas'+valor).DataTable({
      //"processing": true,
      //"serverSide": true,
      "destroy": true,
      "order": [],
      "language": {
        "url": base_url+'/Assets/js/es-pe.json'
      },
      "ajax": {
        "url": url,
        "type": "POST",
        "data" : requestResumenMesas,
        "dataType": "json",
        "cache": false,
      },
      "columns": [
      {"data":"ORDEN"}, 
      {"data":"CODIGO_SOLUCION"},
      {"data":"DEPARTAMENTO_UBI"}, 
      {"data":"PROVINCIA_UBI"},
      {"data":"DISTRITO_UBI"},
      {"data":"NRO_MESA"},
      {"data":"NRO_ELECTORES"},
      {"data":"TIPO_CEDULA"}, 
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



function modalIncidencia(etapa,id){
 
  var idEtapa = $("#txtIdEtapa"+etapa).val();
  // $('#txtIDEtapa').val(id);

  $('#titleIncidencia').html('<b>INCIDENCIAS EN LA ETAPA DE '+etapa.toUpperCase()+'</b>');
  $('#agregarIncidencia').attr('onclick', 'addIncidencia("'+etapa+'")');
  if(idEtapa == 2){
    $('#divCantIncidencia').show();
  }else{
    $('#divCantIncidencia').hide();
  }


    var requestIncidenciaCbo         = new Object();
    requestIncidenciaCbo["idEtapa"]  = idEtapa;
    
      $.ajax({
          url: base_url+'/Control_reserva/getSelectIncidencia',
          type: "POST",     
          // dataType: 'json',
          data:requestIncidenciaCbo,    
          cache: false,
            
          success: function(data, textStatus, jqXHR){
            // console.log(data);
            if(jqXHR.status == 200){

              $('#cboIncidencia').selectpicker('destroy');
              $('#cboIncidencia').html(data).selectpicker('refresh');

            }

          },
          
      });

}


$("#cboIncidencia").on("change", function() {
  $('#cboIncidencia-error').hide();
  $('#errorincidencia').hide();
})



function cancelIncidencia(etapa){
    //$('#sign_registerIncidencia')[0].reset();
    $('#sign_registerIncidencia').validate().resetForm();
    $('#sign_registerIncidencia .form-group').removeClass('has-success');
    $('#errorincidencia').hide();
    habilInpbarra(etapa);
}


function addIncidencia(etapa){ //alert(etapa)



    var departamento = $("#cbodepart"+etapa).val();
    var provincia = $("#cboprov"+etapa).val();
    var distrito = $("#cbodist"+etapa).val();

    var cboubigeo = departamento+provincia+distrito;
    var validacion = $("#txtValidacion"+etapa).val();
    var consulta = ( eleccion == 2 && etapa == 'Empaque') ? $("#idConsulta"+etapa).val() : $("#cboconsulta"+etapa).val() ; 
    var eleccionN = (eleccion == 1 || (eleccion == 2 && etapa == 'Empaque')) ? 1 : eleccion ;

    var requestIncidencia               = new Object();
    requestIncidencia["idMaterial"]     = $("#idMaterial").val();
    requestIncidencia["idProceso"]      = $("#cboProceso").val();
    requestIncidencia["idEtapa"]        = $("#txtIdEtapa"+etapa).val();
    requestIncidencia["idOdpe"]         = $("#cboodpe"+etapa).val();
    requestIncidencia["idIncidencia"]   = $("#cboIncidencia").val();
    requestIncidencia["mesa"]           = $('#txtMesaIncidencia').val();
    requestIncidencia["cantidad"]       = $('#txtCantIncidencia').val();
    requestIncidencia["consulta"]       = consulta;
    requestIncidencia["cUbigeo"]        = cboubigeo;
    requestIncidencia["validacion"]     = validacion;

    //var mesa = rotulo.substr(0, 6); //alert(mesa);  
    
    
      if($("#cboIncidencia").val().length != 0){

        
        $.ajax({
          url: base_url+'/Control_reserva/setIncidencia',
          type: "POST",     
          dataType: 'json',
          data:requestIncidencia,    
          cache: false,
                
          success: function(data, textStatus, jqXHR){
            console.log(data);
            if(jqXHR.status == 200){

                if(data.status){
                /*console.log(textStatus);
                  console.log(jqXHR.status);*/                 
                  swal({  title:  data.title,
                          text:   data.msg,
                          type:   "success"},
                          function(){ 
                            setTimeout(function() {
                              $('#btnIncid'+etapa).css("display","none");
                              $('#btnResetInput'+etapa).css("display","none");
                              habilInpbarra(etapa);
                              $('#modal_incidencia').modal('hide');
                              $("#ubigeo"+etapa).focus();
                            },10)
                      });
                  $('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
                  return false;

                }else{
                  swal({  title:  data.title,
                    text:   data.msg,
                    type:   "error"},
                    function(){ 
                      setTimeout(function() {
                          //$('#txtcargo').focus();
                      }, 10)
                  });
                  $('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
                  return false;
                }
            }

          },
              
        });
      }else{
        $('#errorincidencia').html('Este campo es obligatorio.').show();
      }
    
  return false;
};


