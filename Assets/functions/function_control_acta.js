// JavaScript Document
$(document).ready(function(){
  // alert('ok');

  cboMaterialActa();
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
    $('#divAgrupacionEmparejamiento').hide();
    $('#divAvanceAgrupRecepcion').removeAttr('style');
    $('#divAvanceAgrupEmparejamiento').removeAttr('style');
    
}else{
    $('#divAgrupacionRecepcion').hide();
    $('#divAgrupacionEmparejamiento').hide();
    $('#divAvanceAgrupRecepcion').css("display","none");
    $('#divAvanceAgrupEmparejamiento').css("display","none");
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
  cboMaterialActa();
  enabledAvance(etapa);
  cargaAvanceFase(etapa);
  cargaAvanceOdpe(etapa);
  //cargaAvanceAgrupacion(etapa);
}

function cargaCboEmparejamiento(etapa){
  
    resetCbo(etapa);
    resetInpbarra(etapa);
    cboMaterialActa();
    enabledAvance(etapa);
    // cargaAvanceFase(etapa);
    // cargaAvanceOdpe(etapa);
    /*cargaAvanceAgrupacion(etapa);*/
    $('#cbofase'+etapa).selectpicker('destroy');
    $('#cbofase'+etapa).html('<option value="">[ SELECCIONE UNA FASE ]</option><option value="1">SUFRAGIO</option>').selectpicker('refresh');
    
}

function resetCbo(etapa){
  /*$('#sign_add'+etapa+'Acta')[0].reset();
  $('#sign_add'+etapa+'Acta').validate().resetForm();*/
  $('#cbofase'+etapa).selectpicker('destroy');
  $('#cbofase'+etapa).html('<option value="">[ SELECCIONE UNA FASE ]</option>').selectpicker('refresh');
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
    $("#lista"+etapa).prop('disabled', true).val("");
    $("#rotulo"+etapa).prop('disabled', true).val("");
    $("#txtValidacion"+etapa).val('1');
    $('#btnIncid'+etapa).hide();
    $('#btnResetInput'+etapa).hide();
    $('#msj_mesa_next').hide();
}

function habilInpbarra(etapa) {
    $("#rotulo"+etapa).prop('disabled', false).val("").focus();
    $("#lista"+etapa).prop('disabled', false).val("").focus();
    $("#txtValidacion"+etapa).val('1');
}

function inhabilitaEscbarra(etapa) {
    $("#lista"+etapa).prop('disabled', true);
    $("#rotulo"+etapa).prop('disabled', true);
    $('#btnIncid'+etapa).removeAttr('style');
    $('#btnResetInput'+etapa).removeAttr('style');
  }


function resetInput(etapa){
  $("#rotulo"+etapa).prop('disabled', false).val("").focus();
  $("#txtValidacion"+etapa).val('1');
  $('#btnIncid'+etapa).css("display","none");
  $('#btnResetInput'+etapa).css("display","none");
  $("#lista"+etapa).prop('disabled', false).val("").focus();
  // $('#msj_mesa_next').hide();
}
/* FIN RESET*/



function cboMaterialActa(){

    var requestSolucion         = new Object();
    requestSolucion["idProceso"] = $("#cboProceso").val();
    
      $.ajax({
          url: base_url+'/Control_acta/getSelectMaterial',
          type: "POST",     
          // dataType: 'json',
          data:requestSolucion,    
          cache: false,
            
          success: function(data, textStatus, jqXHR){
            // console.log(data);
            if(jqXHR.status == 200){

              $('#cbomaterialRecepcion').selectpicker('destroy');
              $('#cbomaterialRecepcion').html(data).selectpicker('refresh');

              $('#cbomaterialEmparejamiento').selectpicker('destroy');
              $('#cbomaterialEmparejamiento').html(data).selectpicker('refresh');

            }

          },
          
      });
      return false;
}


function cboFaseActa(etapa){ //alert(etapa);
    resetInpbarra(etapa);
    if($('#cbomaterial'+etapa).val() != ''){ 
        //resetCbo(etapa);
        $('#cbofase'+etapa).selectpicker('destroy');
        $('#cbofase'+etapa).html('<option value="">[ SELECCIONE UNA FASE ]</option><option value="1">SUFRAGIO</option>').selectpicker('refresh');
        $('#cbosoltec'+etapa).selectpicker('destroy');
        $('#cbosoltec'+etapa).html( '<option value="">[ SELECCIONE UNA SOL. TECN. ]</option>' ).selectpicker('refresh');
        $('#cboodpe'+etapa).selectpicker('destroy');
        $('#cboodpe'+etapa).html( '<option value="">[ SELECCIONE UNA ODPE ]</option>' ).selectpicker('refresh');
        $('#cbodepart'+etapa).selectpicker('destroy');
        $('#cbodepart'+etapa).html( '<option value="">[ SELECCIONE UN DEPARTAMENTO ]</option>' ).selectpicker('refresh');
        $('#cboprov'+etapa).selectpicker('destroy');
        $('#cboprov'+etapa).html( '<option value="">[ SELECCIONE UNA PROVINCIA ]</option>' ).selectpicker('refresh');
        $('#cbodist'+etapa).selectpicker('destroy');
        $('#cbodist'+etapa).html( '<option value="">[ SELECCIONE UN DISTRITO ]</option>' ).selectpicker('refresh');
        // cargaAvanceOdpe(etapa);
        /*cargaAvanceAgrupacion(etapa);*/
        setTimeout(function(){ 
          // cargaAvanceFase(etapa);
          enabledAvance(etapa);
        }, 100);
    }else{
        resetCbo(etapa);
    }
}


/*CARGA AVANCE FASE*/
function cargaAvanceFase(etapa){

    var requestAvanceFase             = new Object();
    requestAvanceFase["idProceso"]    = $("#cboProceso").val();
    requestAvanceFase["idMaterial"]   = $("#cbomaterial"+etapa).val();
    requestAvanceFase["idEtapa"]      = $("#txtIdEtapa"+etapa).val();
    requestAvanceFase["idFase"]       = $("#cbofase"+etapa).val();
    requestAvanceFase["nommaterial"]  = $('#cbomaterial'+etapa+' option:selected').text();
    requestAvanceFase["nomfase"]      = $('#cbofase'+etapa+' option:selected').text();
    requestAvanceFase["validacion"]   = $("#txtValidacion"+etapa).val();

    $.ajax({
      url: base_url+'/Control_acta/getAvanceFase',
      type: "POST",     
      dataType: 'json',
      data:requestAvanceFase,    
      cache: false,
            
      success: function(data, textStatus, jqXHR){
        // console.log(data);
        if(jqXHR.status == 200){
               
            $('#tbl_acta'+etapa+'AvanceFase tbody').html(data.data);
            $('#nomFase'+etapa).html('<strong>'+data.nomFase+'</strong>');
            $('#nomMaterial'+etapa).html('<strong>'+data.nomMaterial+'</strong>');
            $('#nomMaterialEmparejamiento').html('<strong>'+data.nomEmp+'</strong>');
        }

      },
          
    });
}


function cboSoltecActa(etapa){ 
  resetInpbarra(etapa);
  // cargaAvanceFase(etapa);
  setTimeout(function(){ 
      // cargaAvanceOdpe(etapa);
  }, 120);

  if($('#cbofase'+etapa).val() != '' && $('#cbomaterialRecepcion').val() != 5){ 
    var requestSolucion         = new Object();
    requestSolucion["idProceso"] = $("#cboProceso").val();
    
      $.ajax({
          url: base_url+'/Control_acta/getSelectSolucion',
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

  }else if($('#cbofase'+etapa).val() != '' && $('#cbomaterialRecepcion').val() == 5){

      $('#cbosoltec'+etapa).selectpicker('destroy');
      $('#cbosoltec'+etapa).html('<option value="">[ SELECCIONE UNA SOL. TECN. ]</option><option value="2">SEA</option>').selectpicker('refresh');
  
  }else{
      resetCbo(etapa);
      // cargaAvanceAgrupacion(etapa);
      $('#cbofase'+etapa).selectpicker('destroy');
      $('#cbofase'+etapa).html('<option value="">[ SELECCIONE UNA FASE ]</option><option value="1">SUFRAGIO</option>').selectpicker('refresh');

  }
}



/*CARGA AVANCE ODPE*/
function cargaAvanceOdpe(etapa){

    var requestAvanceOdpe           = new Object();
    requestAvanceOdpe["idProceso"]  = $("#cboProceso").val();
    requestAvanceOdpe["idMaterial"] = $("#cbomaterial"+etapa).val();
    requestAvanceOdpe["idEtapa"]    = $("#txtIdEtapa"+etapa).val();
    requestAvanceOdpe["idFase"]     = $("#cbofase"+etapa).val();
    requestAvanceOdpe["idOdpe"]     = $("#cboodpe"+etapa).val();
    requestAvanceOdpe["idSolucion"] = $("#cbosoltec"+etapa).val();
    requestAvanceOdpe["nomOdpe"]    = $('#cboodpe'+etapa+' option:selected').text();
    requestAvanceOdpe["validacion"] = $("#txtValidacion"+etapa).val();

    $.ajax({
      url: base_url+'/Control_acta/getAvanceOdpe',
      type: "POST",     
      dataType: 'json',
      data:requestAvanceOdpe,    
      cache: false,
            
      success: function(data, textStatus, jqXHR){
        // console.log(data);
        if(jqXHR.status == 200){
            
             $('#tbl_acta'+etapa+'AvanceOdpe tbody').html(data.data);
            $('#nomOdpe'+etapa).html('<strong>'+data.nomOdpe+'</strong>');
        }

      },
          
    });
}


/*CARGA AVANCE AGRUPACION*/
function cargaAvanceAgrupacion(etapa){

  var requestAvanceAgrupacion           = new Object();
  requestAvanceAgrupacion["idProceso"]  = $("#cboProceso").val();
  requestAvanceAgrupacion["idEtapa"]    = $("#txtIdEtapa"+etapa).val();
  requestAvanceAgrupacion["idMaterial"] = ($("#txtIdEtapa"+etapa).val() == 4) ? 2 : $("#cbomaterial"+etapa).val();
  requestAvanceAgrupacion["idFase"]     = $("#cbofase"+etapa).val();
  requestAvanceAgrupacion["idOdpe"]     = $("#cboodpe"+etapa).val();
  requestAvanceAgrupacion["nomOdpe"]    = $('#cboodpe'+etapa+' option:selected').text();
  requestAvanceAgrupacion["validacion"] = $("#txtValidacion"+etapa).val();
  requestAvanceAgrupacion["nomEtapa"]   = etapa;

  if($("#txtIdEtapa"+etapa).val() == 1){
    var nomEtapa = 'RECEPCIÖN';
  }else if($("#txtIdEtapa"+etapa).val() == 2){
    var nomEtapa = 'CONTROL DE CALIDAD';
  }else{
    var nomEtapa = 'EMPAQUETADO';
  }

  $.ajax({
    url: base_url+'/Control_acta/getAvanceAgrupacion',
    type: "POST",     
    dataType: 'json',
    data:requestAvanceAgrupacion,    
    cache: false,
          
    success: function(data, textStatus, jqXHR){
      // console.log(data);
      if(jqXHR.status == 200){
             
          $('#tbl_actaAvanceAgrupacion tbody').html(data.data);
          $('#nomOdpeAgrupacion').html('<strong>'+data.nomOdpe+'</strong>');
          $('#nomEtapaAgrupacion').html('<strong>'+nomEtapa+'</strong>');
      }

    },
        
  });
}


function verTotalAgrup(idAgrupacion,agrupacion, etapa, valor){ 
  
  var requestTotalAgrupacion               = new Object();
  requestTotalAgrupacion["idProceso"]      = $("#cboProceso").val();
  requestTotalAgrupacion["idEtapa"]        = $("#txtIdEtapa"+etapa).val();
  requestTotalAgrupacion["idMaterial"]     = ($("#txtIdEtapa"+etapa).val() == 4) ? 2 : $("#cbomaterial"+etapa).val();
  requestTotalAgrupacion["idFase"]         = $("#cbofase"+etapa).val();
  requestTotalAgrupacion["idSolucion"]     = $("#cbosoltec"+etapa).val();
  requestTotalAgrupacion["idOdpe"]         = $("#cboodpe"+etapa).val();
  requestTotalAgrupacion["nomOdpe"]        = $('#cboodpe'+etapa+' option:selected').text();
  requestTotalAgrupacion["validacion"]     = $("#txtValidacion"+etapa).val();
  requestTotalAgrupacion["idAgrupacion"]   = idAgrupacion;
  requestTotalAgrupacion["nomAgrupacion"]  = agrupacion;
  requestTotalAgrupacion["idValor"]        = valor;

  if($("#txtIdEtapa"+etapa).val() == 1){
    var nomEtapa = 'RECEPCIÖN';
  }else if($("#txtIdEtapa"+etapa).val() == 2){
    var nomEtapa = 'CONTROL DE CALIDAD';
  }else{
    var nomEtapa = 'EMPAQUETADO';
  }

  $.ajax({
    url: base_url+'/Control_acta/getTotalAgrupacion',
    type: "POST",     
    dataType: 'json',
    data:requestTotalAgrupacion,    
    cache: false,
          
    success: function(data, textStatus, jqXHR){
      // console.log(data);
      if(jqXHR.status == 200){
          $('#modal_totalAgrupacion').modal('show');
          $('#tbl_actaTotalAgrupacion tbody').html(data.data);
          $('#titleTotalAgrupacion').html('<strong>'+data.nomAgrupacion+'</strong>');
          $('#nomOdpeTotalAgrupacion').html('<strong>'+data.nomOdpe+'</strong>');
          $('#nroTotalAgrupacion').html('<strong>'+data.cantidadMesa+' MESAS</strong>');
          $('#nomEtapaTotalAgrupacion').html('<strong>'+nomEtapa+'</strong>');
      }

    },
        
  });
}


function closeAgrupacion(){
  $('#tbl_actaAvanceAgrupacion tbody').html('');
}


function cboOdpeActa(etapa){ 

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
      url: base_url+'/Control_acta/getSelectOdpe',
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


function cboDepartamentoActa(etapa){

    resetInpbarra(etapa);
    // cargaAvanceOdpe(etapa);
    enabledAvance(etapa);

    $('#cboprov'+etapa).selectpicker('destroy');
    $('#cboprov'+etapa).html( '<option value="">[ SELECCIONE UNA PROVINCIA ]</option>' ).selectpicker('refresh');
    $('#cbodist'+etapa).selectpicker('destroy');
    $('#cbodist'+etapa).html( '<option value="">[ SELECCIONE UN DISTRITO ]</option>' ).selectpicker('refresh');
    $('#cboconsulta'+etapa).selectpicker('destroy');
    $('#cboconsulta'+etapa).html( '<option value="">[ SELECCIONE TIPO DE C&Eacute;DULA ]</option>' ).selectpicker('refresh');

    var eleccionN = (eleccion == 1 || (eleccion == 2 && etapa == 'Emparejamiento')) ? 1 : eleccion ;
      
    var requestDepartamento           = new Object();
    requestDepartamento["idProceso"]  = $("#cboProceso").val();
    requestDepartamento["idSolucion"] = $("#cbosoltec"+etapa).val();
    requestDepartamento["idOdpe"]     = $("#cboodpe"+etapa).val();
    requestDepartamento["idEleccion"] = eleccionN;

    $.ajax({
      url: base_url+'/Control_acta/getSelectDepartamento',
      type: "POST",     
          // dataType: 'json',
      data:requestDepartamento,    
      cache: false,
            
      success: function(data, textStatus, jqXHR){
        // console.log(data);
        if(jqXHR.status == 200){

          if(eleccion == 1 || (eleccion == 2 && etapa == 'Emparejamiento') ){
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


function cboAgrupacionActa(etapa){ 
  
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
      url: base_url+'/Control_acta/getSelectAgrupacion',
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


function cboProvinciaActa(etapa){

  resetInpbarra(etapa);
  $('#cbodist'+etapa).selectpicker('destroy');
  $('#cbodist'+etapa).html( '<option value="">[ SELECCIONE UN DISTRITO ]</option>' ).selectpicker('refresh');
  $('#cboconsulta'+etapa).selectpicker('destroy');
  $('#cboconsulta'+etapa).html( '<option value="">[ SELECCIONE TIPO DE C&Eacute;DULA ]</option>' ).selectpicker('refresh');

  var eleccionN = (eleccion == 1 || (eleccion == 2 && etapa == 'Emparejamiento')) ? 1 : eleccion ;
  
  var requestProvincia                 = new Object();
    requestProvincia["idProceso"]      = $("#cboProceso").val();
    requestProvincia["idSolucion"]     = $("#cbosoltec"+etapa).val();
    requestProvincia["idOdpe"]         = $("#cboodpe"+etapa).val();
    requestProvincia["idAgrupacion"]   = $("#cboagrupacion"+etapa).val();
    requestProvincia["idDepartamento"] = $("#cbodepart"+etapa).val();
    requestProvincia["idEleccion"]     = eleccionN;
    
    $.ajax({
      url: base_url+'/Control_acta/getSelectProvincia',
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


function cboDistritoActa(etapa){

  resetInpbarra(etapa);
  $('#cboconsulta'+etapa).selectpicker('destroy');
  $('#cboconsulta'+etapa).html( '<option value="">[ SELECCIONE TIPO DE C&Eacute;DULA ]</option>' ).selectpicker('refresh');

  var eleccionN = (eleccion == 1 || (eleccion == 2 && etapa == 'Emparejamiento')) ? 1 : eleccion ;

  var requestDsitrito                  = new Object();
    requestDsitrito["idProceso"]       = $("#cboProceso").val();
    requestDsitrito["idSolucion"]      = $("#cbosoltec"+etapa).val();
    requestDsitrito["idOdpe"]          = $("#cboodpe"+etapa).val();
    requestDsitrito["idAgrupacion"]    = $("#cboagrupacion"+etapa).val();
    requestDsitrito["idDepartamento"]  = $("#cbodepart"+etapa).val();
    requestDsitrito["idProvincia"]     = $("#cboprov"+etapa).val();
    requestDsitrito["idEleccion"]      = eleccionN;
    
    $.ajax({
      url: base_url+'/Control_acta/getSelectDistrito',
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
function setTipoActa(etapa){
    if ($('#cbodist'+etapa).val() != ""){
        habilInpbarra(etapa);
        $('#btnIncid'+etapa).hide();
        $('#btnResetInput'+etapa).hide();

        var requestBarra            = new Object();
        requestBarra["idMaterial"]  = $("#cbomaterial"+etapa).val();
        requestBarra["idProceso"]   = $("#cboProceso").val();
        
        $.ajax({
          url: base_url+'/Control_acta/getBarra',
          type: "POST",     
          dataType: 'json',
          data:requestBarra,    
          cache: false,
                
          success: function(data, textStatus, jqXHR){
            // console.log(data);
            if(jqXHR.status == 200){
              document.getElementById('rotulo'+etapa).maxLength = data.data.DIGITO;
            }

          },
              
        });

    } else {
        resetInpbarra(etapa);
    }
}


/*CARGA DE BARRAS EMPAREJAMIENTO*/
function setTipoActaEparejamiento(etapa){

  if($('#cbodist'+etapa).val() != '' ){ 
        habilInpbarra(etapa);
        $('#btnIncid'+etapa).hide();
        $('#btnResetInput'+etapa).hide();

        var requestBarra            = new Object();
        requestBarra["idProceso"]   = $("#cboProceso").val();

        $.ajax({
          url: base_url+'/Control_acta/getBarraEmparejamiento',
          type: "POST",     
          dataType: 'json',
          data:requestBarra,    
          cache: false,
                
          success: function(data, textStatus, jqXHR){
            // console.log(data);
            if(jqXHR.status == 200){

              /*document.getElementById('lista'+etapa).maxLength = data.data[0].DIGITO;
              document.getElementById('rotulo'+etapa).maxLength = data.data[1].DIGITO;*/

              $('#materialLista'+etapa).val(data.data[0].ID_MATERIAL);
              $('#materialDoc'+etapa).val(data.data[1].ID_MATERIAL);
              ordenEmparejamiento(etapa)
            }

          },
              
        });

  }else{
    resetInpbarra(etapa);
  }
}


function ordenEmparejamiento(etapa){

    var requestOrdenEmparejamiento               = new Object();
    requestOrdenEmparejamiento["idProceso"]      = $("#cboProceso").val();
    requestOrdenEmparejamiento["idMaterial"]     = $('#materialLista'+etapa).val();;
    requestOrdenEmparejamiento["idFase"]         = $("#cbofase"+etapa).val();
    requestOrdenEmparejamiento["idEtapa"]        = $("#txtIdEtapa"+etapa).val();
    requestOrdenEmparejamiento["idSolucion"]     = $("#cbosoltec"+etapa).val();
    requestOrdenEmparejamiento["idOdpe"]         = $("#cboodpe"+etapa).val();
    requestOrdenEmparejamiento["idAgrupacion"]   = $("#cboagrupacion"+etapa).val();
    requestOrdenEmparejamiento["idDepartamento"] = $("#cbodepart"+etapa).val();
    requestOrdenEmparejamiento["idProvincia"]    = $("#cboprov"+etapa).val();
    requestOrdenEmparejamiento["idDistrito"]     = $("#cbodist"+etapa).val();
    requestOrdenEmparejamiento["validacion"]     = $("#txtValidacion"+etapa).val();
    requestOrdenEmparejamiento["idEleccion"]     = eleccion;

    //if(distrito != ''){
        $.ajax({
          url: base_url+'/Control_acta/ordenEmparejamiento',
          type: "POST",     
          dataType: 'json',
          data:requestOrdenEmparejamiento,    
          cache: false,
                
          success: function(data, textStatus, jqXHR){
            console.log(data);
            if(jqXHR.status == 200){

                if(data.status){
                  
                  var html= '<div>'+
                                '<strong style= "font-size:16px;">ATENCI&Oacute;N!</strong> '+
                                'La Mesa a Emparejar es la N° <br><b style= "font-size:26px;">'+data.data.NRO_MESA+'</b><br>'+ 
                                'Departamento: <b style= "font-size:14px;">'+data.data.DEPARTAMENTO_UBI+'</b><br>'+ 
                                'Provincia: <b style= "font-size:14px;">'+data.data.PROVINCIA_UBI+'</b><br>'+
                                'Distrito: <b style= "font-size:14px;">'+data.data.DISTRITO_UBI+'</b><br>'+
                                'Local: <b style= "font-size:14px;">'+data.data.NOMBRE_LOCAL+'</b><br>';
                      html += (eleccion == 2) ?  
                                'Partido Político: <b style= "font-size:18px;">'+data.data.AGRUPACION+'</b><br></div>' : '</div>';

                  $('#msj_mesa_next').addClass('alert alert-outline-info').html(html).show();
                  return false;

                }else{
                  $('#msj_mesa_next').addClass('alert alert-outline-info').html(html).hide();
                  swal({  title:  data.title,
                          text:   data.msg,
                          type:   "success",
                          timer:  4000
                      });
                  $("#listaEmparejamiento").prop("disabled", true);
                  $("#rotuloEmparejamiento").prop("disabled", true);
                  $('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');

                  return false;
                }
            }

          },
              
        });
}



function inpLista(etapa) {

      if(event.keyCode==13){
        document.getElementById("rotulo"+etapa).focus();
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
    
    var nommaterial = $('#cbomaterial'+etapa+' option:selected').text();
    var nomdepartamento = $('#cbodepart'+etapa+' option:selected').text();
    var nomprovincia = $('#cboprov'+etapa+' option:selected').text();
    var nomdistrito = $('#cbodist'+etapa+' option:selected').text();
    var etapaControl = $('#txtIdEtapa'+etapa).val();

    var requestActa               = new Object();
    requestActa["idProceso"]      = $("#cboProceso").val();
    requestActa["idMaterial"]     = $("#cbomaterial"+etapa).val();
    requestActa["idEtapa"]        = $("#txtIdEtapa"+etapa).val();
    requestActa["idFase"]         = $("#cbofase"+etapa).val();
    requestActa["idSolucion"]     = $("#cbosoltec"+etapa).val();
    requestActa["idOdpe"]         = $("#cboodpe"+etapa).val();
    requestActa["idAgrupacion"]   = $("#cboagrupacion"+etapa).val();
    requestActa["idDepartamento"] = $("#cbodepart"+etapa).val();
    requestActa["idProvincia"]    = $("#cboprov"+etapa).val();
    requestActa["idDistrito"]     = $("#cbodist"+etapa).val();
    requestActa["cboubigeo"]      = cboubigeo;
    requestActa["rotulo"]         = rotulo;
    requestActa["validacion"]     = validacion;
    requestActa["idEleccion"]     = eleccion;
    requestActa["nomdepartamento"]= nomdepartamento;
    requestActa["nomprovincia"]   = nomprovincia;
    requestActa["nomdistrito"]    = nomdistrito;
    requestActa["etapa"]          = etapa;
    requestActa["nommaterial"]    = nommaterial;

    $.ajax({
          url: base_url+'/Control_acta/getBarra',
          type: "POST",     
          dataType: 'json',
          data:requestActa,    
          cache: false,
                
          success: function(data, textStatus, jqXHR){
            // console.log(data);
            if(jqXHR.status == 200){

                console.log(data.data);

                // validando rotulo Formato
                var longitud   = (data.data.CODIGO != null ) ? data.data.CODIGO.length : '0';
                var pcodigo    = (data.data.CODIGO != null ) ? data.data.CODIGO : '';


                var mesa    = rotulo.substr(0, 6);   
                var codigo  = rotulo.substr(6, longitud);
                // alert(mesa+' '+electores);
                /*console.log('pref-ubi: '+preUbigeo+'cod-ubi: '+cUbigeo+'suf-ubi: '
                  +sufUbigeo+'pref-rot: '+preRotulo+'cod-rot: '+cRotulo+'suf-rot: '
                  +sufRotulo+'mesa: '+mesa+'electores: '+electores);*/
                $('#txtMesaIncidencia').val(mesa).prop('disabled',true);

                //Formato Rotulo
                if (rotulo.length != data.data.DIGITO ) {
                    swal({  title:  'CONTROL DE ACTA PADRON',
                            text:   'Verificar la cantidad de Digitos del Codigo de Barras de '+nommaterial,
                            type:   "error",
                            timer: 4000
                        });
                    $('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
                    inhabilitaEscbarra(etapa);
                    
                }else if(codigo.length != longitud || codigo != pcodigo){
                    swal({  title:  'CONTROL DE ACTA PADRON',
                            text:   'El formato del Codigo de '+nommaterial+' no coincide',
                            type:   "error",
                            timer: 4000
                        });
                    $('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
                    inhabilitaEscbarra(etapa);
                    
                }else{
                    // alert(1)
                    $('#msj_'+etapa).removeClass('alert alert-outline-danger').html('');
                      
                      requestActa["mesa"]    = mesa;
                      requestActa["codigo"]  = codigo;
                    
                      $.ajax({

                        url: base_url+'/Control_acta/validarMesa',
                        type: "POST",     
                        dataType: 'json',
                        data:requestActa,    
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
                                $('#msj_'+etapa).removeClass('alert alert-outline-danger').removeClass('alert alert-outline-warning').addClass('alert alert-outline-success').html('<span class="alert-icon"><i class="zmdi zmdi-check-circle"></i></span><strong>Correcto!</strong> El Documento Electoral ha sido Recepcionado').show(10).delay(4000).hide(10);
                                $('#btnIncid'+etapa).css("display","none");
                                $('#btnResetInput'+etapa).css("display","none");                                                                                                                                                                                                  
                                // cargaAvanceFase(etapa);
                                // cargaAvanceOdpe(etapa);
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


/*INPUT ROTULO RECEPCION*/
function inpRotuloEmparejamiento(etapa){
  //var validar = $('#addControlCedula').click;
  if (event.keyCode == 13 || event.which == 13 ) {

    var departamento = $("#cbodepart"+etapa).val();
    var provincia = $("#cboprov"+etapa).val();
    var distrito = $("#cbodist"+etapa).val();

    var cboubigeo = departamento+provincia+distrito;
    var listaElect = $("#lista"+etapa).val().toUpperCase().trim();
    var docElect = $("#rotulo"+etapa).val().toUpperCase().trim();
    var validacion = $("#txtValidacion"+etapa).val();
    
    var nommaterial = $('#cbomaterial'+etapa+' option:selected').text();
    var nomdepartamento = $('#cbodepart'+etapa+' option:selected').text();
    var nomprovincia = $('#cboprov'+etapa+' option:selected').text();
    var nomdistrito = $('#cbodist'+etapa+' option:selected').text();
    var etapaControl = $('#txtIdEtapa'+etapa).val();

    var requestActaEmparejamiento               = new Object();
    requestActaEmparejamiento["idProceso"]      = $("#cboProceso").val();
    requestActaEmparejamiento["idMaterial"]     = $("#materialLista"+etapa).val();
    requestActaEmparejamiento["idMaterialDoc"]  = $("#materialDoc"+etapa).val();
    requestActaEmparejamiento["idEtapa"]        = $("#txtIdEtapa"+etapa).val();
    requestActaEmparejamiento["idFase"]         = $("#cbofase"+etapa).val();
    requestActaEmparejamiento["idSolucion"]     = $("#cbosoltec"+etapa).val();
    requestActaEmparejamiento["idOdpe"]         = $("#cboodpe"+etapa).val();
    requestActaEmparejamiento["idAgrupacion"]   = $("#cboagrupacion"+etapa).val();
    requestActaEmparejamiento["idDepartamento"] = $("#cbodepart"+etapa).val();
    requestActaEmparejamiento["idProvincia"]    = $("#cboprov"+etapa).val();
    requestActaEmparejamiento["idDistrito"]     = $("#cbodist"+etapa).val();
    requestActaEmparejamiento["cboubigeo"]      = cboubigeo;
    requestActaEmparejamiento["listaElect"]     = listaElect;
    requestActaEmparejamiento["DocElect"]       = docElect;
    requestActaEmparejamiento["validacion"]     = validacion;
    requestActaEmparejamiento["idEleccion"]     = eleccion;
    requestActaEmparejamiento["nomdepartamento"]= nomdepartamento;
    requestActaEmparejamiento["nomprovincia"]   = nomprovincia;
    requestActaEmparejamiento["nomdistrito"]    = nomdistrito;
    requestActaEmparejamiento["etapa"]          = etapa;
    requestActaEmparejamiento["nommaterial"]    = nommaterial;

    $.ajax({
          url: base_url+'/Control_acta/getBarraEmparejamiento',
          type: "POST",     
          dataType: 'json',
          data:requestActaEmparejamiento,    
          cache: false,
                
          success: function(data, textStatus, jqXHR){
            // console.log(data);
            if(jqXHR.status == 200){

                console.log(data.data);

                // validando rotulo Formato
                var longitudLista = (data.data[0].CODIGO != null ) ? data.data[0].CODIGO.length : '0';
                var pcodigoLsita  = (data.data[0].CODIGO != null ) ? data.data[0].CODIGO : '';
                var mesaLista     = listaElect.substr(0, 6);   
                var codigoLista   = listaElect.substr(6, longitudLista);
                
                var longitudDoc   = (data.data[1].CODIGO != null ) ? data.data[1].CODIGO.length : '0';
                var pcodigoDoc    = (data.data[1].CODIGO != null ) ? data.data[1].CODIGO : '';
                var mesaDoc       = docElect.substr(0, 6);   
                var codigoDoc     = docElect.substr(6, longitudDoc);

                /*alert('LISTA: Long:'+longitudLista+' - cod:'+pcodigoLsita+' - mesa:'+mesaLista+' - '+codigoLista);
                alert('Doc:   Long:'+longitudDoc+' - cod:'+pcodigoDoc+' - mesa:'+mesaDoc+' - '+codigoDoc);*/
                /*console.log('pref-ubi: '+preUbigeo+'cod-ubi: '+cUbigeo+'suf-ubi: '
                  +sufUbigeo+'pref-rot: '+preRotulo+'cod-rot: '+cRotulo+'suf-rot: '
                  +sufRotulo+'mesa: '+mesa+'electores: '+electores);*/
                //Formato Rotulo

                $('#txtMesaIncidencia').val(mesaLista).prop('disabled',true);


                if (listaElect.length != data.data[0].DIGITO ) {
                    swal({  title:  'CONTROL DE ACTA PADRON',
                            text:   'Verificar la cantidad de Digitos de la Lista de Electores',
                            type:   "error",
                            timer: 4000
                        });
                    $('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
                    inhabilitaEscbarra(etapa);
                
                }else if(codigoLista.length != longitudLista || codigoLista != pcodigoLsita){
                    swal({  title:  'CONTROL DE ACTA PADRON',
                            text:   'El formato del Codigo de la Lista de Electores no coincide',
                            type:   "error",
                            timer: 4000
                        });
                    $('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
                    inhabilitaEscbarra(etapa);

                } else if (docElect.length != data.data[1].DIGITO ) {
                    swal({  title:  'CONTROL DE ACTA PADRON',
                            text:   'Verificar la cantidad de Digitos del Documento Electoral',
                            type:   "error",
                            timer: 4000
                        });
                    $('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
                    inhabilitaEscbarra(etapa);
                
                }else if(codigoDoc.length != longitudDoc || codigoDoc != pcodigoDoc){
                    swal({  title:  'CONTROL DE ACTA PADRON',
                            text:   'El formato del Codigo del Documento Electoral no coincide',
                            type:   "error",
                            timer: 4000
                        });
                    $('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
                    inhabilitaEscbarra(etapa);

                }else if(mesaLista != mesaDoc){
                    swal({  title:  'CONTROL DE ACTA PADRON',
                            text:   'Los Numeros de Mesa no coincide',
                            type:   "error",
                            timer: 5000
                        });
                    $('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
                    inhabilitaEscbarra(etapa);

                /*$('#msj_'+etapa).addClass('alert alert-outline-danger').html('<span class="alert-icon"><i class="zmdi zmdi-close-circle"></i></span><strong>Error!</strong> Los N&uacute;meros de Mesa no coincide').show(10).delay(4000).hide(10);
                inhabilitaEscbarra(etapa)*/
                    
                }else{
                    
                    $('#msj_'+etapa).removeClass('alert alert-outline-danger').html('');
                      
                      requestActaEmparejamiento["mesa"]    = mesaLista;
                      requestActaEmparejamiento["codigo"]  = codigoLista;
                    
                      $.ajax({

                        url: base_url+'/Control_acta/validarMesa',
                        type: "POST",     
                        dataType: 'json',
                        data:requestActaEmparejamiento,    
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
                                $('#msj_'+etapa).removeClass('alert alert-outline-danger').removeClass('alert alert-outline-warning').addClass('alert alert-outline-success').html('<span class="alert-icon"><i class="zmdi zmdi-check-circle"></i></span><strong>Correcto!</strong> El Documento Electoral ha sido Recepcionado').show(10).delay(4000).hide(10);
                                $('#btnIncid'+etapa).css("display","none");
                                $('#btnResetInput'+etapa).css("display","none");                                                                                                                                                                                                  
                                ordenEmparejamiento(etapa);
                                // cargaAvanceFase(etapa);
                                // cargaAvanceOdpe(etapa);
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

    var requestResumenMesas               = new Object();
    requestResumenMesas["idMaterial"]     = $("#cbomaterial"+etapa).val();
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
        var url = base_url+'/Control_acta/mesasEscaneadas';
    }else{
        var url = base_url+'/Control_acta/mesasFaltantes';
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
          url: base_url+'/Control_acta/getSelectIncidencia',
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
    var consulta = ( eleccion == 2 && etapa == 'Emparejamiento') ? $("#idConsulta"+etapa).val() : $("#cboconsulta"+etapa).val() ; 
    var eleccionN = (eleccion == 1 || (eleccion == 2 && etapa == 'Emparejamiento')) ? 1 : eleccion ;

    var material = ($("#txtIdEtapa"+etapa).val() != 4) ? $("#cbomaterial"+etapa).val() : $("#materialLista"+etapa).val();

    var requestIncidencia               = new Object();
    requestIncidencia["idMaterial"]     = material;
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
          url: base_url+'/Control_acta/setIncidencia',
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


