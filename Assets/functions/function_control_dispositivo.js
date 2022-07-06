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
  // $('#cboconsultaRecepcion').selectpicker();
});


var eleccion = $('#cboProceso option:selected').attr('data');
//$('#txtdata').val(eleccion);
if (eleccion == 2) {
    $('#divAgrupacionRecepcion').show();
    $('#divAvanceAgrupRecepcion').removeAttr('style');
    
}else{
    $('#divAgrupacionRecepcion').hide();
    $('#divAvanceAgrupRecepcion').css("display","none");
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
  enabledAvance(etapa);
  cargaAvanceFase(etapa);
  cargaAvanceOdpe(etapa);
  //cargaAvanceAgrupacion(etapa);
}



function resetCbo(etapa){
  $('#sign_add'+etapa+'Dispositivo')[0].reset();
  $('#sign_add'+etapa+'Dispositivo').validate().resetForm();
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
  /*$('#cboconsulta'+etapa).selectpicker('destroy');
  $('#cboconsulta'+etapa).html( '<option value="">[ SELECCIONE TIPO DE C&Eacute;DULA ]</option>' ).selectpicker('refresh');*/
  enabledAvance(etapa);
}

function resetInpbarra(etapa) {
    $("#rotulo"+etapa).prop('disabled', true).val("");
    $("#txtValidacion"+etapa).val('1');
    $('#btnIncid'+etapa).hide();
    $('#btnResetInput'+etapa).hide();
    $('#msj_mesa_next').hide();
}

function habilInpbarra(etapa) {
    $("#rotulo"+etapa).prop('disabled', false).val("").focus();
    $("#txtValidacion"+etapa).val('1');

}

function inhabilitaEscbarra(etapa) {
    $("#rotulo"+etapa).prop('disabled', true);
    $('#btnIncid'+etapa).removeAttr('style');
    $('#btnResetInput'+etapa).removeAttr('style');
  }


function resetInput(etapa){
  $("#rotulo"+etapa).prop('disabled', false).val("").focus();
  $("#txtValidacion"+etapa).val('1');
  $('#btnIncid'+etapa).css("display","none");
  $('#btnResetInput'+etapa).css("display","none");
  // $('#msj_mesa_next').hide();
}
/* FIN RESET*/


/*CARGA AVANCE FASE*/
function cargaAvanceFase(etapa){

    var requestAvanceFase             = new Object();
    requestAvanceFase["idProceso"]    = $("#cboProceso").val();
    requestAvanceFase["idMaterial"]   = $("#idMaterial").val();
    requestAvanceFase["idEtapa"]      = $("#txtIdEtapa"+etapa).val();
    requestAvanceFase["idFase"]       = $("#cbofase"+etapa).val();
    requestAvanceFase["nomfase"]      = $('#cbofase'+etapa+' option:selected').text();
    requestAvanceFase["validacion"]   = $("#txtValidacion"+etapa).val();

    $.ajax({
      url: base_url+'/Control_dispositivo/getAvanceFase',
      type: "POST",     
      dataType: 'json',
      data:requestAvanceFase,    
      cache: false,
            
      success: function(data, textStatus, jqXHR){
        // console.log(data);
        if(jqXHR.status == 200){
               
            $('#tbl_dispositivo'+etapa+'AvanceFase tbody').html(data.data);
            $('#nomFase'+etapa).html('<strong>'+data.nomFase+'</strong>');
            $('#nomMaterialDisp').html('<strong>'+data.nomDisp+'</strong>');
        }

      },
          
    });
}


function cboSoltecDispositivo(etapa){ 
  resetInpbarra(etapa);
  cargaAvanceFase(etapa);
  setTimeout(function(){ 
      cargaAvanceOdpe(etapa);
  }, 120);

  if($('#cbofase'+etapa).val() != ''){ 
    var requestSolucion         = new Object();
    requestSolucion["idProceso"] = $("#cboProceso").val();
    
      $.ajax({
          url: base_url+'/Control_dispositivo/getSelectSolucion',
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
    requestAvanceOdpe["idSolucion"] = $("#cbosoltec"+etapa).val();
    requestAvanceOdpe["nomOdpe"]    = $('#cboodpe'+etapa+' option:selected').text();
    requestAvanceOdpe["validacion"] = $("#txtValidacion"+etapa).val();

    $.ajax({
      url: base_url+'/Control_dispositivo/getAvanceOdpe',
      type: "POST",     
      dataType: 'json',
      data:requestAvanceOdpe,    
      cache: false,
            
      success: function(data, textStatus, jqXHR){
        // console.log(data);
        if(jqXHR.status == 200){
            
            $('#tbl_dispositivo'+etapa+'AvanceOdpe tbody').html(data.data);
            $('#nomOdpe'+etapa).html('<strong>'+data.nomOdpe+'</strong>');
        }

      },
          
    });
}


function cboOdpeDispositivo(etapa){ 

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
      url: base_url+'/Control_dispositivo/getSelectOdpe',
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
      cargaAvanceOdpe(etapa);
      //cargaAvanceAgrupacion(etapa);
      enabledAvance(etapa);
    }, 120);
}


function cboDepartamentoDispositivo(etapa){

    resetInpbarra(etapa);
    cargaAvanceOdpe(etapa);
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
      url: base_url+'/Control_dispositivo/getSelectDepartamento',
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


function cboAgrupacionDispositivo(etapa){ 
  
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
      url: base_url+'/Control_dispositivo/getSelectAgrupacion',
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


function cboProvinciaDispositivo(etapa){

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
      url: base_url+'/Control_dispositivo/getSelectProvincia',
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


function cboDistritoDispositivo(etapa){

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
      url: base_url+'/Control_dispositivo/getSelectDistrito',
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


/*CARGA DE BARRAS RECEPCION*/
function setTipoDispositivo(etapa){
    if ($('#cbodist'+etapa).val() != ""){
        habilInpbarra(etapa);
        $('#btnIncid'+etapa).hide();
        $('#btnResetInput'+etapa).hide();

        var requestBarra            = new Object();
        // requestBarra["idMaterial"]  = $("#cbomaterial"+etapa).val();
        requestBarra["idProceso"]   = $("#cboProceso").val();
        
        $.ajax({
          url: base_url+'/Control_dispositivo/getBarra',
          type: "POST",     
          dataType: 'json',
          data:requestBarra,    
          cache: false,
                
          success: function(data, textStatus, jqXHR){
            // console.log(data);
            if(jqXHR.status == 200){
              document.getElementById('rotulo'+etapa).maxLength = data.data[0].DIGITO;
            }

          },
              
        });

    } else {
        resetInpbarra(etapa);
    }
}


/*INPUT ROTULO RECEPCION*/
function inpRotulo(etapa){ 
  //var validar = $('#addControlCedula').click;
  if (event.keyCode == 13 || event.which == 13 ) {

    var departamento = $("#cbodepart"+etapa).val();
    var provincia = $("#cboprov"+etapa).val();
    var distrito = $("#cbodist"+etapa).val();

    var cboubigeo = departamento+provincia+distrito;
    var rotulo = $("#rotulo"+etapa).val().toUpperCase().trim();
    var validacion = $("#txtValidacion"+etapa).val();
    
    var nomdepartamento = $('#cbodepart'+etapa+' option:selected').text();
    var nomprovincia = $('#cboprov'+etapa+' option:selected').text();
    var nomdistrito = $('#cbodist'+etapa+' option:selected').text();
    var etapaControl = $('#txtIdEtapa'+etapa).val();

    var requestDispositivo               = new Object();
    requestDispositivo["idMaterial"]     = $("#idMaterial").val();
    requestDispositivo["idProceso"]      = $("#cboProceso").val();
    requestDispositivo["idEtapa"]        = $("#txtIdEtapa"+etapa).val();
    requestDispositivo["idFase"]         = $("#cbofase"+etapa).val();
    requestDispositivo["idSolucion"]     = $("#cbosoltec"+etapa).val();
    requestDispositivo["idOdpe"]         = $("#cboodpe"+etapa).val();
    requestDispositivo["idAgrupacion"]   = $("#cboagrupacion"+etapa).val();
    requestDispositivo["idDepartamento"] = $("#cbodepart"+etapa).val();
    requestDispositivo["idProvincia"]    = $("#cboprov"+etapa).val();
    requestDispositivo["idDistrito"]     = $("#cbodist"+etapa).val();
    requestDispositivo["cboubigeo"]      = cboubigeo;
    requestDispositivo["rotulo"]         = rotulo;
    requestDispositivo["validacion"]     = validacion;
    requestDispositivo["idEleccion"]     = eleccion;
    requestDispositivo["nomdepartamento"]= nomdepartamento;
    requestDispositivo["nomprovincia"]   = nomprovincia;
    requestDispositivo["nomdistrito"]    = nomdistrito;
    requestDispositivo["etapa"]          = etapa;

    $.ajax({
          url: base_url+'/Control_dispositivo/getBarra',
          type: "POST",     
          dataType: 'json',
          data:requestDispositivo,    
          cache: false,
                
          success: function(data, textStatus, jqXHR){
            // console.log(data);
            if(jqXHR.status == 200){

                console.log(data.data);

                // validando rotulo Formato
                var longitudP   = (data.data[0].CODIGO != null ) ? data.data[0].CODIGO.length : '0';
                var pcodigoP    = (data.data[0].CODIGO != null ) ? data.data[0].CODIGO : '';

                //var longitudC   = (data.data[1].CODIGO != null ) ? data.data[1].CODIGO.length : '0';
                //var pcodigoC    = (data.data[1].CODIGO != null ) ? data.data[1].CODIGO : '';

                var mesa    = rotulo.substr(0, 6);   
                var codigo  = rotulo.substr(6, longitudP);
                // alert(mesa+' '+codigo+' '+pcodigoP+' '+pcodigoC);
                /*console.log('pref-ubi: '+preUbigeo+'cod-ubi: '+cUbigeo+'suf-ubi: '
                  +sufUbigeo+'pref-rot: '+preRotulo+'cod-rot: '+cRotulo+'suf-rot: '
                  +sufRotulo+'mesa: '+mesa+'electores: '+electores);*/
                $('#txtMesaIncidencia').val(mesa).prop('disabled',true);

                //Formato Rotulo
                if (rotulo.length != data.data[0].DIGITO ) {
                    swal({  title:  'CONTROL DE DISPOSITIVOS',
                            text:   'Verificar la cantidad de Digitos del Codigo de Barras',
                            type:   "error",
                            timer: 4000
                        });
                    $('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
                    inhabilitaEscbarra(etapa);
                
                //}else if((codigo.length != longitudP || codigo != pcodigoP) && (codigo.length != longitudC || codigo != pcodigoC)){    
                }else if( codigo.length != longitudP || codigo != pcodigoP ){
                    swal({  title:  'CONTROL DE DISPOSITIVOS',
                            text:   'El formato del Codigo de Barras no coincide',
                            type:   "error",
                            timer: 4000
                        });
                    $('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
                    inhabilitaEscbarra(etapa);
                    
                }else{
                    

                    $('#msj_'+etapa).removeClass('alert alert-outline-danger').html('');
                      
                      requestDispositivo["mesa"]       = mesa;
                      requestDispositivo["codigo"]     = codigo;
                    
                      $.ajax({

                        url: base_url+'/Control_dispositivo/validarMesa',
                        type: "POST",     
                        dataType: 'json',
                        data:requestDispositivo,    
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
                                $('#msj_'+etapa).removeClass('alert alert-outline-danger').removeClass('alert alert-outline-warning').addClass('alert alert-outline-success').html('<span class="alert-icon"><i class="zmdi zmdi-check-circle"></i></span><strong>Correcto!</strong> El Dispositivo USB ha sido Recepcionado').show(10).delay(4000).hide(10);
                                $('#btnIncid'+etapa).css("display","none");
                                $('#btnResetInput'+etapa).css("display","none");                                                                                                                                                                                                  
                                cargaAvanceFase(etapa);
                                cargaAvanceOdpe(etapa);
                                /*cargaAvanceAgrupacion(etapa);*/
                                habilInpbarra(etapa);

                              }

                              $('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
                              return false;
                            }
                            
                          }

                        },
                            
                      });
                }

            }

          },
              
        });

  }

}


function enabledAvance(etapa){
  if($("#cboodpe"+etapa).val() != ''){
    $( '#recibido'+etapa ).attr({'onclick':'resumenMesas("'+etapa+'", "RECIBIDOS", 1)','href':'#modal_resumenEscaneadas'});
    $( '#faltante'+etapa ).attr({'onclick':'resumenMesas("'+etapa+'", "FALTANTES", 2)','href':'#modal_resumenFaltantes'});
    $( '#agrupacion'+etapa ).attr({'onclick':'cargaAvanceAgrupacion("'+etapa+'")','href':'#modal_resumenAgrupacion'});
  }else{
    $( '#recibido'+etapa ).removeAttr("onclick href");
    $( '#faltante'+etapa ).removeAttr("onclick href");
    $( '#agrupacion'+etapa ).removeAttr("onclick href");
  }
}



function resumenMesas(etapa,tipo,valor){ 

    $('#titleMaterialResumen'+valor).html('<b>ETAPA DE '+etapa.toUpperCase()+'</b>');
    $('#titleResumen'+valor).html('<b>DISPOSITIVOS '+tipo+'</b>');

    var validacion = $("#txtValidacion"+etapa).val();  

    var requestResumenMesas               = new Object();
    requestResumenMesas["idMaterial"]     = $("#idMaterial").val();
    requestResumenMesas["idProceso"]      = $("#cboProceso").val();
    requestResumenMesas["idFase"]         = $("#cbofase"+etapa).val();
    requestResumenMesas["idEtapa"]        = $("#txtIdEtapa"+etapa).val();
    requestResumenMesas["idSolucion"]     = $("#cbosoltec"+etapa).val();
    requestResumenMesas["idOdpe"]         = $("#cboodpe"+etapa).val();
    requestResumenMesas["nomOdpe"]        = $('#cboodpe'+etapa+' option:selected').text();
    requestResumenMesas["validacion"]     = validacion;  

    $('#nomOdpeEscaneadas').html('<b>'+$('#cboodpe'+etapa+' option:selected').text()+'</b>');
    $('#nomOdpeFaltantes').html('<b>'+$('#cboodpe'+etapa+' option:selected').text()+'</b>');

    if(valor == 1){
        var url = base_url+'/Control_dispositivo/mesasEscaneadas';
    }else{
        var url = base_url+'/Control_dispositivo/mesasFaltantes';
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
      {"data":"PAQUETE"},
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
          url: base_url+'/Control_dispositivo/getSelectIncidencia',
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
          url: base_url+'/Control_dispositivo/setIncidencia',
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


