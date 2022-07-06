// JavaScript Document
$(document).ready(function(){

   	  cboProceso();
      $('#tableIncidencia').DataTable({});
      $('#cboMaterialInc').selectpicker('destroy');
      $('#cboMaterialInc').html( '<option value="">[ SELECCIONE MATERIAL ]</option>' ).selectpicker('refresh');
      $('#cboEtapaInc').selectpicker('destroy');
      $('#cboEtapaInc').html( '<option value="">[ SELECCIONE ETAPA ]</option>' ).selectpicker('refresh');
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

function cboProceso(){ 

  $.ajax({
      type: "GET",
      async : false,
      url: base_url+'/Incidencia/getSelectProceso', 
      success: function(data, textStatus, jqXHR){
        if(jqXHR.status == 200){
              //console.log(data);
              $("#cboProcesoInc").selectpicker('destroy');
              $("#cboProcesoInc").html(data).selectpicker('refresh');

          }
      }
  });
}


function cboMaterial(){
    $('#tableIncidencia').DataTable().clear().draw();
    $('#cboEtapaInc').selectpicker('destroy');
    $('#cboEtapaInc').html( '<option value="">[ SELECCIONE ETAPA ]</option>' ).selectpicker('refresh');
    
    var requestMaterial           = new Object();
    requestMaterial["idProceso"]  = $("#cboProcesoInc").val();

    $.ajax({
      url: base_url+'/Incidencia/getSelectMaterial',
      type: "POST",     
          // dataType: 'json',
      data:requestMaterial,    
      cache: false,
            
      success: function(data, textStatus, jqXHR){
        // console.log(data);
        if(jqXHR.status == 200){

          $('#cboMaterialInc').selectpicker('destroy');
          $('#cboMaterialInc').html(data).selectpicker('refresh');

        }

      },
          
    });
}


function cboEtapa(){ 
    
    var requestEtapa            = new Object();
    requestEtapa["idProceso"]   = $("#cboProcesoInc").val();
    requestEtapa["idMaterial"]  = $("#cboMaterialInc").val();

    $.ajax({
      url: base_url+'/Incidencia/getSelectEtapa',
      type: "POST",     
          // dataType: 'json',
      data:requestEtapa,    
      cache: false,
            
      success: function(data, textStatus, jqXHR){
        // console.log(data);
        if(jqXHR.status == 200){

          $('#cboEtapaInc').selectpicker('destroy');
          $('#cboEtapaInc').html(data).selectpicker('refresh');

        }

      },
          
    });

}


function cboListaIncid(){ 

    var requestListaIncidencia           = new Object();
    requestListaIncidencia["idProceso"]  = $("#cboProcesoInc").val();
    requestListaIncidencia["idMaterial"] = $("#cboMaterialInc").val();
    requestListaIncidencia["idEtapa"]    = $("#cboEtapaInc").val();


    var tableIncidencia = $('#tableIncidencia').DataTable({
      //"processing": true,
      //"serverSide": true,
      "destroy": true,
      "order": [],
      "language": {
        "url": base_url+'/Assets/js/es-pe.json'
      },
      "ajax": {
        "url": base_url+'/Incidencia/getIncidencias',
        "type": "POST",
        "data" : requestListaIncidencia,
        "dataType": "json",
        "cache": false,
      },
      "columns": [
      {"data":"ORDEN"}, 
      {"data":"CODIGO_SOLUCION"},
      {"data":"NOMBRE_ODPE"}, 
      {"data":"NRO_MESA"},
      {"data":"INCIDENCIA"},
      {"data":"ODPE_INCIDENCIA"},
      {"data":"USUARIO"},
      {"data":"FECHA_INCIDENCIA"},
      {"data":"ESTADO"},
      {"data":"OPCIONES"}, 
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


function verIncidencia(id){
    $('#txtCtrlIDIncidencia').val(id);
    $('#txtcontrolCtrlIncidencia').val('1');

    var etapa = $('#cboEtapaIncidencia').val();

    if(etapa == 2){
      $('#divCantIncidencia').show();
    }else{
      $('#divCantIncidencia').hide();
    }

    $.ajax({
        type:'GET',
        url: base_url+"/Incidencia/getIncidencia/"+id,
        dataType:'json',
        success: function(data, textStatus, jqXHR){
          
          if(jqXHR.status == 200){
            console.log(data);
            if(data.status){
              
              var estado = (data.data.ESTADO == 3) ? true : false;
             
              $('#titleIncidenciaControl').html('<b>INCIDENCIA DE LA MESA '+data.data.NRO_MESA+'</b>')
              $('#txtMesaIncidencia').val(data.data.NRO_MESA).attr('disabled',true);
              $('#txtdescripIncidencia').val(data.data.INCIDENCIA).attr('disabled',true);
              $('#txtObservacionIncidencia').val(data.data.OBSERVACION).attr('readonly', estado);
              $('#txtCantIncidencia').val(data.data.CANTIDAD).attr('readonly', true);
              $('#cboEstadoIncidencia').selectpicker('val',data.data.ESTADO).attr('disabled', estado).selectpicker('refresh');
              $('#updateCtrlIncidencia').attr('disabled', estado);

              if(data.data.ESTADO == 2){
                $('#obsrv_2').show();
                $('#txtObservacionIncidencia').attr('readonly',true);
                $('#txtObservacion2Incidencia').addClass('vld');
              }else if (data.data.ESTADO == 3){
                 $('#obsrv_2').hide();
                  $('#txtObservacion2Incidencia').removeClass('vld');
              }else{
                 $('#txtObservacion2Incidencia').removeClass('vld');;
                 $('#obsrv_2').hide();
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
}


function cancelIncidencia(){
  //alert('cancelar');
    $('#txtcontrolCtrlIncidencia').val('0');
    $('#modal_incidencia').modal('hide');
    $('#form_registerCtrlIncidencia')[0].reset();
    $('#form_registerCtrlIncidencia').validate().resetForm();
    $('#form_registerCtrlIncidencia .form-group').removeClass('has-success');
}


function eliminarIncidecnia (id){
    
    $('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').removeClass('btn btn-warning');
    swal({  title: "Eliminar Incidencia",
        text: "¿Desea eliminar esta Incidencia?",
        type: "warning",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#ff9600",
        confirmButtonText: "Aceptar",
        closeOnConfirm: false },
        function(){ 
            $.ajax({
              type:'DELETE',
              url: base_url+"/Incidencia/delIncidencia/"+id,
              dataType:'json',
              success: function(data, textStatus, jqXHR){
                  if(jqXHR.status == 200){
                    console.log(data);
                    if(data.status){

                      swal(data.title, data.msg, "success");
                      $('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
                      $('#tableIncidencia').DataTable().ajax.reload();
                      cancelIncidencia();
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


function validarCamposIncidencia(){
  var $inputs = $('#form_registerCtrlIncidencia .vld'); 
  var formvalido = true; 
 
  $inputs.each(function() { 
    if($(this).val().length == 0){ 
      formvalido = false;
    }
  });
  // console.log($inputs);
  return formvalido; 
}


/* REGISTER PROCESOS */
$("#form_registerCtrlIncidencia").submit(function() {
    
    var requestUpdIncidencia                  = new Object();
    requestUpdIncidencia["idIncidencia"]      = $("#txtCtrlIDIncidencia").val();
    requestUpdIncidencia['controlIncidencia'] = $("#txtcontrolCtrlIncidencia").val();
    requestUpdIncidencia["estado"]            = $("#cboEstadoIncidencia").val();
    requestUpdIncidencia["observacion1"]      = $("#txtObservacionIncidencia").val().toUpperCase().trim();
    requestUpdIncidencia["observacion2"]      = $("#txtObservacion2Incidencia").val().toUpperCase().trim();

    if (validarCamposIncidencia()) {
          $.ajax({
              url: base_url+'/Incidencia/setIncidencia',
            type: "POST",     
            dataType: 'json',
            data:requestUpdIncidencia,    
            cache: false,
              
            success: function(data, textStatus, jqXHR){
              console.log(data.msg);

              if(jqXHR.status == 200){
                if(data.status){
              /*console.log(textStatus);
                  console.log(jqXHR.status);*/
                  swal({  title:  data.title,
                          text:   data.msg,
                          type:   "success"},
                          function(){ 
                            setTimeout(function() {
                              $('#tableIncidencia').DataTable().ajax.reload();
                              $('#modal_incidencia').modal('hide');
                              cancelIncidencia();

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
    //return false;
});