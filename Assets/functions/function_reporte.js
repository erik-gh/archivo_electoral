// JavaScript Document
$(document).ready(function(){
    resetCbo();
    $('#tableAvanceGeneral').DataTable({});
    $('#tableAvanceOdpe').DataTable({});
    $('#tableUsuarioMesa').DataTable({});
    $('#tableAvanceGeneralOtros').DataTable({});
    cboProceso();
    cboCargaAvance();

    
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


/*================================================  FUNCTIONS REPORT  ================================================*/
function resetCbo(){
    
    $("#cboSoltecReporteAvance").selectpicker();
    
    $("#cboMaterialReporteOdpe").selectpicker();
    $("#cboEtapaReporteOdpe").selectpicker();

    $("#cboMaterialReporteUsuario").selectpicker();
    $("#cboEtapaReporteUsuario").selectpicker();
    $("#cboOdpeReporteUsuario").selectpicker();

    $("#cboMaterialReporteGrafico").selectpicker();
    $("#cboEtapaReporteGrafico").selectpicker();
    $("#cboOdpeReporteGrafico").selectpicker();

    $("#cboMaterialReporteRendimiento").selectpicker();
    $("#cboEtapaReporteRendimiento").selectpicker();

    $("#cboSolTecReporteEstadistico").selectpicker();
    $("#cboOdpeReporteEstadistico").selectpicker();
    $("#cboDepartReporteEstadistico").selectpicker();
    $("#cboProvReporteEstadistico").selectpicker();
    $("#cboDistReporteEstadistico").selectpicker();

    $("#cboMaterialReporteRendimiento_Otros").selectpicker();
    $("#cboEtapaReporteRendimiento_Otros").selectpicker();
}


function cboProceso(){ 
    resetCbo();
    $.ajax({
        type: "GET",
        async : false,
        url: base_url+'/Reporte/getSelectProceso', 
        success: function(data, textStatus, jqXHR){
            if(jqXHR.status == 200){
                //console.log(data);
                /*$("#cboProcesoInc").selectpicker('destroy');
                $("#cboProcesoInc").html(data).selectpicker('refresh');*/
                $("#cboProcesoReporteAvance").selectpicker('destroy');
                $("#cboProcesoReporteAvance").html(data).selectpicker('refresh');
                $("#cboProcesoReporteOdpe").selectpicker('destroy');
                $("#cboProcesoReporteOdpe").html(data).selectpicker('refresh');
                $("#cboProcesoReporteUsuario").selectpicker('destroy');
                $("#cboProcesoReporteUsuario").html(data).selectpicker('refresh');
                $("#cboProcesoReporteGrafico").selectpicker('destroy');
                $("#cboProcesoReporteGrafico").html(data).selectpicker('refresh');
                $("#cboProcesoReporteRendimiento").selectpicker('destroy');
                $("#cboProcesoReporteRendimiento").html(data).selectpicker('refresh');
                $("#cboProcesoReporteEstadistico").selectpicker('destroy');
                $("#cboProcesoReporteEstadistico").html(data).selectpicker('refresh');
                $("#cboProcesoReporteConsulta").selectpicker('destroy');
                $("#cboProcesoReporteConsulta").html(data).selectpicker('refresh');
                $("#cboProcesoReporteAvance_Otros").selectpicker('destroy');
                $("#cboProcesoReporteAvance_Otros").html(data).selectpicker('refresh');
                $("#cboProcesoReporteRendimiento_Otros").selectpicker('destroy');
                $("#cboProcesoReporteRendimiento_Otros").html(data).selectpicker('refresh');


            }
        }
    });
}


function cboSolucion(){
   
    var proceso = $("#cboProcesoReporteAvance").val();
    var requestSolucion         = new Object();
    requestSolucion["idProceso"] = $("#cboProcesoReporteAvance").val();

    $.ajax({
        url: base_url+'/Reporte/getSelectSolucion',
        type: "POST",     
         // dataType: 'json',
        data:requestSolucion,    
        cache: false,

        success: function(data, textStatus, jqXHR){
            // console.log(data);
            if(jqXHR.status == 200){

                $('#cboSoltecReporteAvance').selectpicker('destroy');
                $('#cboSoltecReporteAvance').html(data).selectpicker('refresh');

            }
        },

    });
    return false;
}


function cboCargaAvance(){ 
    var dataBase = $('#cboProcesoReporteAvance option:selected').attr('database');
    var proceso = $("#cboProcesoReporteAvance").val();
    var nomProceso = (proceso != '') ? $("#cboProcesoReporteAvance option:selected").text() : '';
    var nomProcesoGrafica = (proceso != '') ? 'GRAFICA DE AVANCE GENERAL DE MATERIALES' : '';

    var requestReporteGeneral           = new Object();
    requestReporteGeneral["idProceso"]  = $("#cboProcesoReporteAvance").val();
    requestReporteGeneral["idSolucion"] = $("#cboSoltecReporteAvance").val();
    requestReporteGeneral["dataBase"]   = dataBase;

    $('#titleProceso').html('<b>'+nomProceso+'</b>');
    $('#titleProcesoGrafica').html('<b>'+nomProcesoGrafica+'</b>');
    // if(proceso != ''){
        //$('#tbl_cargaAvance').html('<img src="'+media+'/images/loading.gif" width="40">').addClass('text-center').show();
        // $('#cboProcesoReporteAvance').blur().attr('disabled',true);

    var tableAvanceGeneral = $('#tableAvanceGeneral').DataTable({
        "processing": true,
        // "serverSide": true,
        "destroy": true,
        "order": [],
        "language": {
            "url": base_url+'/Assets/js/es-pe.json'
        },
        "ajax": {
            "url": base_url+'/Reporte/getAvanceGeneral',
            "type": "POST",
            "data" : requestReporteGeneral,
            "dataType": "json",
            "cache": false,
        },
        "columns": [
        {"data":"NOMBRE_ODPE"}, 
        {"data":"META"},
        {"data":"CEDULA"}, 
        {"data":"LISTA"},
        {"data":"DOCUMENTO"},
        {"data":"RELACION"},
        {"data":"CONTINGENCIA"},
        {"data":"EMPAREJAMIENTO"},
        {"data":"DISPOSITIVOS"},
        ],
        "resonsieve":"true",
        "dDestroy": true,
        "iDisplayLength": 10,
        // "order": [[0,"asc"]],
        "columnDefs": [{
            "targets": [2,3,4,5,6,7,8],
            // "orderable": false,
            "createdCell": function(td, cellData, rowData, row, col){
                if (cellData == "100 %") {
                    // $(td).css('background-color','#E0F8EC');
                    $(td).css({'background-color':'#1d87e4','color':'#FFFFFF' });
                }else if(cellData == ""){
                   $(td).css({'background-color':'#F2F2F2','color':'#F2F2F2' });
               }
           },
       },],
    });



    $.ajax({
        url: base_url+'/Reporte/getAvanceGeneralGrafica',
        type: "POST",     
        dataType: 'json',
        data:requestReporteGeneral,    
        cache: false,

        success: function(data, textStatus, jqXHR){
            // console.log(data);
            if(jqXHR.status == 200){

                var gaugeOptions = {

                    chart: {
                        type: 'solidgauge'
                    },

                    title: null,

                    pane: {
                        center: ['40%', '85%'],
                        size: '120%',
                        startAngle: -90,
                        endAngle: 90,
                        background: {
                            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#EEE',
                            innerRadius: '60%',
                            outerRadius: '100%',
                            shape: 'arc'
                        }
                    },

                    tooltip: {
                        enabled: false
                    },

                    // the value axis
                    yAxis: {
                        stops: [
                            [0.1, '#DF5353'], // red
                            [0.4, '#DDDF0D'], // yellow
                            [0.7, '#3383FF'], // blue
                            [0.9, '#55BF3B']  // green
                        ],
                        lineWidth: 0,
                        minorTickInterval: null,
                        tickAmount: 2,
                        title: {
                            y: -70
                        },
                        labels: {
                            y: 18
                        }
                    },

                    plotOptions: {
                        solidgauge: {
                            dataLabels: {
                                y: 5,
                                borderWidth: 0,
                                useHTML: true
                            }
                        }
                    }
                };

    
                var chartActapadron = Highcharts.chart('container-cedula', Highcharts.merge(gaugeOptions, {
                    yAxis: {
                        min: 0,
                        max: 100,
                        title: {
                            text: 'CEDULA'
                        }
                    },

                    series: [{
                        name: 'CEDULA',
                        data: [parseFloat(data.data.CEDULA)],
                        dataLabels: {
                            format: '<div style="text-align:center"><span style="font-size:20px;color:' +
                                ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
                                   '<span style="font-size:12px;color:silver">% avance</span></div>'
                        },
                        tooltip: {
                            valueSuffix: ' avance'
                        }
                    }]
                }));


                var chartActapadron = Highcharts.chart('container-lista', Highcharts.merge(gaugeOptions, {
                    yAxis: {
                        min: 0,
                        max: 100,
                        title: {
                            text: 'LISTA DE ELECTORES'
                        }
                    },

                    series: [{
                        name: 'LISTA DE ELECTORES',
                        data: [parseFloat(data.data.LISTA)],
                        dataLabels: {
                            format: '<div style="text-align:center"><span style="font-size:20px;color:' +
                                ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
                                   '<span style="font-size:12px;color:silver">% avance</span></div>'
                        },
                        tooltip: {
                            valueSuffix: ' avance'
                        }
                    }]
                }));


                var chartActapadron = Highcharts.chart('container-documento', Highcharts.merge(gaugeOptions, {
                    yAxis: {
                        min: 0,
                        max: 100,
                        title: {
                            text: 'DOCUMENTO ELECTORALES'
                        }
                    },

                    series: [{
                        name: 'DOCUMENTO ELECTORALES',
                        data: [parseFloat(data.data.DOCUMENTO)],
                        dataLabels: {
                            format: '<div style="text-align:center"><span style="font-size:20px;color:' +
                                ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
                                   '<span style="font-size:12px;color:silver">% avance</span></div>'
                        },
                        tooltip: {
                            valueSuffix: ' avance'
                        }
                    }]
                }));



                var chartActapadron = Highcharts.chart('container-relacion', Highcharts.merge(gaugeOptions, {
                    yAxis: {
                        min: 0,
                        max: 100,
                        title: {
                            text: 'RELACION DE ELECTORES'
                        }
                    },

                    series: [{
                        name: 'RELACION DE ELECTORES',
                        data: [parseFloat(data.data.RELACION)],
                        dataLabels: {
                            format: '<div style="text-align:center"><span style="font-size:20px;color:' +
                                ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
                                   '<span style="font-size:12px;color:silver">% avance</span></div>'
                        },
                        tooltip: {
                            valueSuffix: ' avance'
                        }
                    }]
                }));



                var chartActapadron = Highcharts.chart('container-emparejamiento', Highcharts.merge(gaugeOptions, {
                    yAxis: {
                        min: 0,
                        max: 100,
                        title: {
                            text: 'EMPAREJAMIENTO'
                        }
                    },

                    series: [{
                        name: 'EMPAREJAMIENTO',
                        data: [parseFloat(data.data.EMPAREJAMIENTO)],
                        dataLabels: {
                            format: '<div style="text-align:center"><span style="font-size:20px;color:' +
                                ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
                                   '<span style="font-size:12px;color:silver">% avance</span></div>'
                        },
                        tooltip: {
                            valueSuffix: ' avance'
                        }
                    }]
                }));


                var chartActapadron = Highcharts.chart('container-dispositivo', Highcharts.merge(gaugeOptions, {
                    yAxis: {
                        min: 0,
                        max: 100,
                        title: {
                            text: 'DISPOSITIVOS ELECTRÓNICOS'
                        }
                    },

                    series: [{
                        name: 'DISPOSITIVOS ELECTRÓNICOS',
                        data: [parseFloat(data.data.DISPOSITIVOS)],
                        dataLabels: {
                            format: '<div style="text-align:center"><span style="font-size:20px;color:' +
                                ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
                                   '<span style="font-size:12px;color:silver">% avance</span></div>'
                        },
                        tooltip: {
                            valueSuffix: ' avance'
                        }
                    }]
                }));
               

            }
        },

    });
        
    return false;
}


function verDetalle(id, idSolucion){
    $('#tab-avance-general').removeClass('active in');
    $('#tab-avance-detalle').addClass('active in');
    $('#li-general').removeClass('active');
    $('#li-detalle').addClass('active');

    var proceso = $("#cboProcesoReporteAvance").val();
    var nomProceso = (proceso != '') ? $("#cboProcesoReporteAvance option:selected").text() : '';
    var nomProcesoGrafica = (proceso != '') ? 'GRAFICA DE AVANCE GENERAL DE MATERIALES' : '';

    var requestReporteGeneralDetalle           = new Object();
    requestReporteGeneralDetalle["idProceso"]  = $("#cboProcesoReporteAvance").val();
    requestReporteGeneralDetalle["idSolucion"] = $("#cboSoltecReporteAvance").val();
    requestReporteGeneralDetalle["idOdpe"]     = id;
    requestReporteGeneralDetalle["idSolucion"] = idSolucion;

    $('#titleProcesoDetalle').html('<b>'+nomProceso+'</b>');
    //if(proceso != '' && odpe != ''){
    $('#tbl_cargaAvanceGeneralDetalle').html('<img src="'+media+'/images/loading.gif" width="40">').addClass('text-center').show();
        //$('#cboProcesoReporte').blur().attr('disabled',true);

    $.ajax({
        url: base_url+'/Reporte/getAvanceGeneralDetalle',
        type: "POST",     
        dataType: 'json',
        data:requestReporteGeneralDetalle,    
        cache: false,

        success: function(data, textStatus, jqXHR){
            // console.log(data);
            if(jqXHR.status == 200){

                $('#tbl_cargaAvanceGeneralDetalle').html(data.data).removeClass('text-center').show();
               

            }
        },

    });

    return false;
}


function verGraficaOdpe(){ 
    
    var proceso = $("#cboProcesoReporteAvance").val();
    var nomProceso = (proceso != '') ? $("#cboProcesoReporteAvance option:selected").text() : '';

    var requestReporteGeneralOdpe           = new Object();
    requestReporteGeneralOdpe["idProceso"]  = $("#cboProcesoReporteAvance").val();
    requestReporteGeneralOdpe["idSolucion"] = $("#cboSoltecReporteAvance").val();
    requestReporteGeneralOdpe["Solucion"]   = $("#cboSoltecReporteAvance option:selected").text();

    $('#titleProcesoDetalleOdpe').html('<b>'+nomProceso+'</b>');

    if(proceso != ''){
        
        $('#tab-avance-general').removeClass('active in');
        $('#tab-avance-grafica-odpe').addClass('active in');
        $('#li-general').removeClass('active');
        $('#li-grafica-odpe').addClass('active');


        $.ajax({
            url: base_url+'/Reporte/getAvanceGeneralGraficaOdpe',
            type: "POST",     
            dataType: 'json',
            data:requestReporteGeneralOdpe,    
            cache: false,

            success: function(data, textStatus, jqXHR){
                // console.log(data);
                var meta = '';
                var cedula = '';
                var emparejamiento = '';
                var nombre_odpe = '';

                for (var i = 0; i < data.cantidad; i++) {
                    meta += 100.00+',';  
                }

                var array = (meta.slice(0,-1)).split(',');
                //console.log(array.map(parseFloat));
                
                $.each(data.data, function(i, row){
                    cedula          += row.CEDULA+',';
                    emparejamiento  += row.EMPAREJAMIENTO+',';
                    nombre_odpe     += row.NOMBRE_ODPE+',';
                });

                var arrayCedula         = (cedula.slice(0,-1)).split(',');
                var arrayEmparejamiento = (emparejamiento.slice(0,-1)).split(',');
                var arraynombre_odpe    = (nombre_odpe.slice(0,-1)).split(',');
                //console.log(arrayCed.map(parseFloat));
                

                if(jqXHR.status == 200){

                    Highcharts.chart('container', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'AVANCE GENERAL POR ODPE'
                        },
                        subtitle: {
                            text: 'LISTA DE ODPE / ORC'
                        },
                        xAxis: {
                            categories: arraynombre_odpe ,
                            crosshair: true
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: 'AVANCE ( % )'
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                '<td style="padding:0"><b>{point.y:.1f} %</b></td></tr>',
                            footerFormat: '</table>',
                            shared: true,
                            useHTML: true
                        },
                        plotOptions: {
                            column: {
                                pointPadding: 0.2,
                                borderWidth: 0
                            }
                        },
                        series: [{
                                name: 'META',    
                                data: array.map(parseFloat)

                                },{
                                name: 'CEDULAS',
                                data: arrayCedula.map(parseFloat)

                                },{
                                name: 'EMPAREJAMIENTO',
                                data: arrayEmparejamiento.map(parseFloat)

                                },]
                    });
                   

                }
            },

        });


    }else{
        swal({  title:  'REPORTES GENERALES',
                text:   'Debe seleccionar Proceso',
                type:   "warning",
                timer: 5000
            });
        $('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').addClass('btn btn-warning');
    }

    return false;
}


function backGeneral(){
    $('#tab-avance-general').addClass('active in');
    $('#tab-avance-detalle').removeClass('active in');
    $('#tab-avance-grafica-odpe').removeClass('active in');
    $('#li-general').addClass('active');
    $('#li-detalle').removeClass('active');
    $('#li-grafica-odpe').removeClass('active');
}


function exportarReporteGeneral(){ 
    var proceso = $("#cboProcesoReporteAvance").val();
    var nomProceso = (proceso != '') ? $("#cboProcesoReporteAvance option:selected").text() : '';

    var requestReporteGeneralExportar           = new Object();
    requestReporteGeneralExportar["idProceso"]  = $("#cboProcesoReporteAvance").val();
    requestReporteGeneralExportar["idSolucion"] = $("#cboSoltecReporteAvance").val();
    requestReporteGeneralExportar["nomProceso"] = nomProceso;

    if(proceso != ''){
        $.ajax({
            url: base_url+'/Reporte/getExportarGeneral',
            type: "POST",     
            dataType: 'json',
            data:requestReporteGeneralExportar,    
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
                        swal({  title:  data.title,
                                text:   data.msg,
                                type:   "warning"},
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
            error:  function(jqXHR,textStatus,errorThrown){
                console.log(errorThrown);
                // console.log(textStatus);
                // console.log(jqXHR.status);
            }
        });
    }else{
        swal({  title:  'REPORTES GENERALES',
                text:   'Debe seleccionar Proceso',
                type:   "warning",
                timer: 5000
            });
        $('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').addClass('btn btn-warning');
    }
    return false;
}


function eliminarfile(id){
      
    $.ajax({
        type:'DELETE',
        url: base_url+'/Reporte/eliminarfile/'+id,
        success: function(data){

        }
    });
    return false;
}



/*===== STEP 2 ======*/
function cboMaterial(){
    
    $('#tableAvanceOdpe').DataTable().clear().draw();
    $('#titleMaterialEtapa').html('');
    $('#cboEtapaReporteOdpe').selectpicker('destroy');
    $('#cboEtapaReporteOdpe').html( '<option value="">[ SELECCIONE UNA ETAPA ]</option>' ).selectpicker('refresh');

    var proceso = $("#cboProcesoReporteOdpe").val();
    var requestMaterial         = new Object();
    requestMaterial["idProceso"] = $("#cboProcesoReporteOdpe").val();

    $.ajax({
        url: base_url+'/Reporte/getSelectMaterial',
        type: "POST",     
         // dataType: 'json',
        data:requestMaterial,    
        cache: false,

        success: function(data, textStatus, jqXHR){
            // console.log(data);
            if(jqXHR.status == 200){

                $('#cboMaterialReporteOdpe').selectpicker('destroy');
                $('#cboMaterialReporteOdpe').html(data).selectpicker('refresh');

            }
        },

    });
    return false;
}


function cboEtapa(){ 
    $('#tableAvanceOdpe').DataTable().clear().draw();
    $('#titleMaterialEtapa').html('');
    var requestEtapa            = new Object();
    requestEtapa["idProceso"]   = $("#cboProcesoReporteOdpe").val();
    requestEtapa["idMaterial"]  = $("#cboMaterialReporteOdpe").val();

    $.ajax({
      url: base_url+'/Reporte/getSelectEtapa',
      type: "POST",     
          // dataType: 'json',
      data:requestEtapa,    
      cache: false,
            
      success: function(data, textStatus, jqXHR){
        // console.log(data);
        if(jqXHR.status == 200){

          $('#cboEtapaReporteOdpe').selectpicker('destroy');
          $('#cboEtapaReporteOdpe').html(data).selectpicker('refresh');

        }

      },
          
    });
}


function cargaAvanceODPE(){
    var proceso = $("#cboProcesoReporteOdpe").val();
    var material = $("#cboMaterialReporteOdpe").val();
    var etapa = $("#cboEtapaReporteOdpe").val();

    var nomProceso = (proceso != '') ? $("#cboProcesoReporteOdpe option:selected").text() : '';

    var nomMaterial = $("#cboMaterialReporteOdpe option:selected").text();
    var nomEtapa = $("#cboEtapaReporteOdpe option:selected").text();

    var requestReporteOdpe           = new Object();
    requestReporteOdpe["idProceso"]  = $("#cboProcesoReporteOdpe").val();
    requestReporteOdpe["idMaterial"] = $("#cboMaterialReporteOdpe").val();
    requestReporteOdpe["idEtapa"]    = $("#cboEtapaReporteOdpe").val();

    $('#titleMaterialEtapa').html('<b>'+nomMaterial+' - '+nomEtapa+'</b>');
    if(etapa != ''){
        //$('#tbl_cargaAvance').html('<img src="'+media+'/images/loading.gif" width="40">').addClass('text-center').show();
        // $('#cboProcesoReporteOdpe').blur().attr('disabled',true);

        var tableAvanceOdpe = $('#tableAvanceOdpe').DataTable({
            "processing": true,
            // "serverSide": true,
            "destroy": true,
            "order": [],
            "language": {
                "url": base_url+'/Assets/js/es-pe.json'
            },
            "ajax": {
                "url": base_url+'/Reporte/getAvanceOdpe',
                "type": "POST",
                "data" : requestReporteOdpe,
                "dataType": "json",
                "cache": false,
            },
            "columns": [
            {"data":"NOMBRE_ODPE"}, 
            {"data":"SOLUCIONTECNOLOGICA"},
            {"data":"TOTAL"},
            {"data":"RECIBIDO"}, 
            {"data":"FALTANTE"},
            {"data":"PORC_RECIBIDO"},
            {"data":"PORC_FALTANTE"},
            ],
            "resonsieve":"true",
            "dDestroy": true,
            "iDisplayLength": 10,
            // "order": [[0,"asc"]],
            "columnDefs": [{
                "targets": [0],
                // "orderable": false,
                /*"createdCell": function(td, cellData, rowData, row, col){
                    if (cellData == "100 %") {
                        $(td).css('background-color','#E0F8EC');
                    }else if(cellData == ""){
                       $(td).css({'background-color':'#F2F2F2','color':'#F2F2F2' });
                   }
               },*/
           },],
        });

    }else{
        $('#tableAvanceOdpe').DataTable().clear().draw();
        $('#titleMaterialEtapa').html('');
    }

  return false;
}


function exportarReporteOdpe(){ 
    var proceso = $("#cboProcesoReporteOdpe").val();
    var material = $("#cboMaterialReporteOdpe").val();
    var etapa = $("#cboEtapaReporteOdpe").val();

    var nomProceso = (proceso != '') ? $("#cboProcesoReporteOdpe option:selected").text() : '';
    var nomMaterial = $("#cboMaterialReporteOdpe option:selected").text();
    var nomEtapa = $("#cboEtapaReporteOdpe option:selected").text();

    var requestReporteOdpeExportar              = new Object();
    requestReporteOdpeExportar["idProceso"]     = $("#cboProcesoReporteOdpe").val();
    requestReporteOdpeExportar["idMaterial"]    = $("#cboMaterialReporteOdpe").val();
    requestReporteOdpeExportar["idEtapa"]       = $("#cboEtapaReporteOdpe").val();
    requestReporteOdpeExportar["nomProceso"]    = nomProceso;
    requestReporteOdpeExportar["nomMaterial"]   = nomMaterial;
    requestReporteOdpeExportar["nomEtapa"]      = nomEtapa;
    
    var getExportarOdpe = (etapa != '' ) ? 'getExportarOdpe' : 'getExportarOdpeMaterial' ;

    if(proceso != '' && material != ''){
        $.ajax({
            url: base_url+'/Reporte/'+getExportarOdpe,
            type: "POST",     
            dataType: 'json',
            data:requestReporteOdpeExportar,    
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
                        swal({  title:  data.title,
                                text:   data.msg,
                                type:   "warning"},
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
            error:  function(jqXHR,textStatus,errorThrown){
                console.log(errorThrown);
                // console.log(textStatus);
                // console.log(jqXHR.status);
            }
        });
    }else{
        swal({  title:  'REPORTES GENERALES',
                text:   'Debe seleccionar por lo menos Proceso - Material',
                type:   "warning",
                timer: 5000
            });
        $('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').addClass('btn btn-warning');
    }
    return false;
}



/*===== STEP 3 ======*/
function cboMaterialUsuarioMesa(){ 

    $('#tableUsuarioMesa').DataTable().clear().draw();
    $('#titleUsuarioMesa').html('');
    $('#cboEtapaReporteUsuario').selectpicker('destroy');
    $('#cboEtapaReporteUsuario').html( '<option value="">[ SELECCIONE UNA ETAPA ]</option>' ).selectpicker('refresh');
    $('#cboOdpeReporteUsuario').selectpicker('destroy');
    $('#cboOdpeReporteUsuario').html( '<option value="">[ SELECCIONE UNA ODPE ]</option>' ).selectpicker('refresh');

    var proceso = $("#cboProcesoReporteUsuario").val();
    var requestMaterial         = new Object();
    requestMaterial["idProceso"] = $("#cboProcesoReporteUsuario").val();

    $.ajax({
        url: base_url+'/Reporte/getSelectMaterial',
        type: "POST",     
         // dataType: 'json',
        data:requestMaterial,    
        cache: false,

        success: function(data, textStatus, jqXHR){
            // console.log(data);
            if(jqXHR.status == 200){

                $('#cboMaterialReporteUsuario').selectpicker('destroy');
                $('#cboMaterialReporteUsuario').html(data).selectpicker('refresh');

            }
        },

    });
    return false;
}


function cboEtapaUsuarioMesa(){ 

    $('#tableUsuarioMesa').DataTable().clear().draw();
    $('#titleUsuarioMesa').html('');
    $('#cboOdpeReporteUsuario').selectpicker('destroy');
    $('#cboOdpeReporteUsuario').html( '<option value="">[ SELECCIONE UNA ODPE ]</option>' ).selectpicker('refresh');

    var requestEtapa            = new Object();
    requestEtapa["idProceso"]   = $("#cboProcesoReporteUsuario").val();
    requestEtapa["idMaterial"]  = $("#cboMaterialReporteUsuario").val();

    $.ajax({
      url: base_url+'/Reporte/getSelectEtapa',
      type: "POST",     
          // dataType: 'json',
      data:requestEtapa,    
      cache: false,
            
      success: function(data, textStatus, jqXHR){
        // console.log(data);
        if(jqXHR.status == 200){

          $('#cboEtapaReporteUsuario').selectpicker('destroy');
          $('#cboEtapaReporteUsuario').html(data).selectpicker('refresh');

        }

      },
          
    });
}


function cboOdpeUsuarioMesa(){ 

    $('#tableUsuarioMesa').DataTable().clear().draw();
    $('#titleUsuarioMesa').html('');

    var requestOdpe            = new Object();
    requestOdpe["idProceso"]   = $("#cboProcesoReporteUsuario").val();
    requestOdpe["idMaterial"]  = $("#cboMaterialReporteUsuario").val();
    requestOdpe["idEtapa"]     = $("#cboEtapaReporteUsuario").val();

    $.ajax({
      url: base_url+'/Reporte/getSelectOdpe',
      type: "POST",     
          // dataType: 'json',
      data:requestOdpe,    
      cache: false,
            
      success: function(data, textStatus, jqXHR){
        // console.log(data);
        if(jqXHR.status == 200){

          $('#cboOdpeReporteUsuario').selectpicker('destroy');
          $('#cboOdpeReporteUsuario').html(data).selectpicker('refresh');

        }

      },
          
    });
}


function cargaUsuarioMesa (){
    var proceso     = $("#cboProcesoReporteUsuario").val();
    var material    = $("#cboMaterialReporteUsuario").val();
    var etapa       = $("#cboEtapaReporteUsuario").val();
    var odpe        = $("#cboOdpeReporteUsuario").val();

    var nomProceso = (proceso != '') ? $("#cboProcesoReporteUsuario option:selected").text() : '';

    var nomMaterial = $("#cboMaterialReporteUsuario option:selected").text();
    var nomEtapa = $("#cboEtapaReporteUsuario option:selected").text();
    var nomOdpe = $("#cboOdpeReporteUsuario option:selected").text();

    var requestReporteUsuarioMesa           = new Object();
    requestReporteUsuarioMesa["idProceso"]  = $("#cboProcesoReporteUsuario").val();
    requestReporteUsuarioMesa["idMaterial"] = $("#cboMaterialReporteUsuario").val();
    requestReporteUsuarioMesa["idEtapa"]    = $("#cboEtapaReporteUsuario").val();
    requestReporteUsuarioMesa["idOdpe"]     = $("#cboOdpeReporteUsuario").val();

    $('#titleUsuarioMesa').html('<b>'+nomMaterial+' - '+nomEtapa+' - '+nomOdpe+'</b>');
    if(odpe != ''){
        //$('#tbl_cargaAvance').html('<img src="'+media+'/images/loading.gif" width="40">').addClass('text-center').show();
        // $('#cboProcesoReporteOdpe').blur().attr('disabled',true);

        var tableUsuarioMesa = $('#tableUsuarioMesa').DataTable({
            "processing": true,
            // "serverSide": true,
            "destroy": true,
            "order": [],
            "language": {
                "url": base_url+'/Assets/js/es-pe.json'
            },
            "ajax": {
                "url": base_url+'/Reporte/getUsuarioMesa',
                "type": "POST",
                "data" : requestReporteUsuarioMesa,
                "dataType": "json",
                "cache": false,
            },
            "columns": [
            {"data":"CODIGO_SOLUCION"}, 
            {"data":"DEPARTAMENTO_UBI"},
            {"data":"PROVINCIA_UBI"},
            {"data":"DISTRITO_UBI"}, 
            {"data":"NRO_MESA"},
            {"data":"USUARIO"},
            {"data":"FECHA_HORA"},
            ],
            "resonsieve":"true",
            "dDestroy": true,
            "iDisplayLength": 10,
            // "order": [[0,"asc"]],
            "columnDefs": [{
                "targets": [0],
                // "orderable": false,
                /*"createdCell": function(td, cellData, rowData, row, col){
                    if (cellData == "100 %") {
                        $(td).css('background-color','#E0F8EC');
                    }else if(cellData == ""){
                       $(td).css({'background-color':'#F2F2F2','color':'#F2F2F2' });
                   }
               },*/
           },],
        });

    }else{
        $('#tableUsuarioMesa').DataTable().clear().draw();
        $('#titleUsuarioMesa').html('');
    }

  return false;
}


function exportarReporteUsuarioMesa(){ 
    var proceso     = $("#cboProcesoReporteUsuario").val();
    var material    = $("#cboMaterialReporteUsuario").val();
    var etapa       = $("#cboEtapaReporteUsuario").val();
    var odpe        = $("#cboOdpeReporteUsuario").val();

    var nomProceso = (proceso != '') ? $("#cboProcesoReporteUsuario option:selected").text() : '';
    var nomMaterial = $("#cboMaterialReporteUsuario option:selected").text();
    var nomEtapa = $("#cboEtapaReporteUsuario option:selected").text();
    var nomOdpe = $("#cboOdpeReporteUsuario option:selected").text();

    var requestReporteUsuarioMesaExportar              = new Object();
    requestReporteUsuarioMesaExportar["idProceso"]     = $("#cboProcesoReporteUsuario").val();
    requestReporteUsuarioMesaExportar["idMaterial"]    = $("#cboMaterialReporteUsuario").val();
    requestReporteUsuarioMesaExportar["idEtapa"]       = $("#cboEtapaReporteUsuario").val();
    requestReporteUsuarioMesaExportar["idOdpe"]        = $("#cboOdpeReporteUsuario").val();
    requestReporteUsuarioMesaExportar["nomProceso"]    = nomProceso;
    requestReporteUsuarioMesaExportar["nomMaterial"]   = nomMaterial;
    requestReporteUsuarioMesaExportar["nomEtapa"]      = nomEtapa;
    requestReporteUsuarioMesaExportar["nomOdpe"]       = nomOdpe;

    if(proceso != '' && material != '' && etapa != '' && etapa != ''){
        $.ajax({
            url: base_url+'/Reporte/getExportarUsuarioMesa',
            type: "POST",     
            dataType: 'json',
            data:requestReporteUsuarioMesaExportar,    
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
                        swal({  title:  data.title,
                                text:   data.msg,
                                type:   "warning"},
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
            error:  function(jqXHR,textStatus,errorThrown){
                console.log(errorThrown);
                // console.log(textStatus);
                // console.log(jqXHR.status);
            }
        });
    }else{
        swal({  title:  'REPORTES GENERALES',
                text:   'Debe seleccionar Proceso - Material - Etapa - Odpe',
                type:   "warning",
                timer: 5000
            });
        $('.confirm').removeClass('btn btn-success').removeClass('btn btn-danger').addClass('btn btn-warning');
    }
    return false;
}



/*===== STEP 4 ======*/
function cboMaterialRendimiento(){ 
    $('#tbl_Rendimiento').hide();
    $('#tableRendimiento').DataTable().clear().draw();
    $('#titleRendimiento').html('');
    $('#cboEtapaReporteRendimiento').selectpicker('destroy');
    $('#cboEtapaReporteRendimiento').html( '<option value="">[ SELECCIONE UNA ETAPA ]</option>' ).selectpicker('refresh');

    var proceso = $("#cboProcesoReporteRendimiento").val();
    var requestMaterial         = new Object();
    requestMaterial["idProceso"] = $("#cboProcesoReporteRendimiento").val();

    $.ajax({
        url: base_url+'/Reporte/getSelectMaterial',
        type: "POST",     
         // dataType: 'json',
        data:requestMaterial,    
        cache: false,

        success: function(data, textStatus, jqXHR){
            // console.log(data);
            if(jqXHR.status == 200){

                $('#cboMaterialReporteRendimiento').selectpicker('destroy');
                $('#cboMaterialReporteRendimiento').html(data).selectpicker('refresh');

            }
        },

    });
    return false;
}


function cboEtapaRendimiento(){ 
    
    $('#tbl_Rendimiento').hide();
    $('#tableRendimiento').DataTable().clear().draw();
    $('#titleRendimiento').html('');


    var requestEtapa            = new Object();
    requestEtapa["idProceso"]   = $("#cboProcesoReporteRendimiento").val();
    requestEtapa["idMaterial"]  = $("#cboMaterialReporteRendimiento").val();

    $.ajax({
      url: base_url+'/Reporte/getSelectEtapa',
      type: "POST",     
          // dataType: 'json',
      data:requestEtapa,    
      cache: false,
            
      success: function(data, textStatus, jqXHR){
        // console.log(data);
        if(jqXHR.status == 200){

          $('#cboEtapaReporteRendimiento').selectpicker('destroy');
          $('#cboEtapaReporteRendimiento').html(data).selectpicker('refresh');

        }

      },
          
    });
}


function cargaRendimiento(){
    var proceso     = $("#cboProcesoReporteRendimiento").val();
    var material    = $("#cboMaterialReporteRendimiento").val();
    var etapa       = $("#cboEtapaReporteRendimiento").val();

    var nomProceso = (proceso != '') ? $("#cboProcesoReporteRendimiento option:selected").text() : '';

    var nomMaterial = $("#cboMaterialReporteRendimiento option:selected").text();
    var nomEtapa = $("#cboEtapaReporteRendimiento option:selected").text();

    var requestReporteRendimiento           = new Object();
    requestReporteRendimiento["idProceso"]  = $("#cboProcesoReporteRendimiento").val();
    requestReporteRendimiento["idMaterial"] = $("#cboMaterialReporteRendimiento").val();
    requestReporteRendimiento["idEtapa"]    = $("#cboEtapaReporteRendimiento").val();

    $('#titleRendimiento').html('<b>'+nomMaterial+' - '+nomEtapa+'</b>');
    if(etapa != ''){
        //$('#tbl_cargaAvance').html('<img src="'+media+'/images/loading.gif" width="40">').addClass('text-center').show();
        // $('#cboProcesoReporteOdpe').blur().attr('disabled',true);
        $.ajax({
            url: base_url+'/Reporte/getSelectRendimiento',
            type: "POST",     
            dataType: 'json',
            data:requestReporteRendimiento,    
            cache: false,
                
            success: function(data, textStatus, jqXHR){
                console.log((data.data));
                if(jqXHR.status == 200){

                    
                    $('#tbl_Rendimiento').html(data.data).removeClass('text-center').show();


                }

            },
              
        });
       

    }else{
        $('#tbl_Rendimiento').hide();
        $('#titleRendimiento').html('');
    }

  return false;
}








/*===== STEP 5 ======*/
function cboMaterialGrafico(){ 
    $('#tbl_cargaGrafico').hide();
    $('#titleOdpeGrafico').html('');
    $('#cboEtapaReporteGrafico').selectpicker('destroy');
    $('#cboEtapaReporteGrafico').html( '<option value="">[ SELECCIONE UNA ETAPA ]</option>' ).selectpicker('refresh');
    $('#cboOdpeReporteGrafico').selectpicker('destroy');
    $('#cboOdpeReporteGrafico').html( '<option value="">[ SELECCIONE UNA ODPE ]</option>' ).selectpicker('refresh');

    var proceso = $("#cboProcesoReporteGrafico").val();
    var requestMaterial         = new Object();
    requestMaterial["idProceso"] = $("#cboProcesoReporteGrafico").val();

    $.ajax({
        url: base_url+'/Reporte/getSelectMaterial',
        type: "POST",     
         // dataType: 'json',
        data:requestMaterial,    
        cache: false,

        success: function(data, textStatus, jqXHR){
            // console.log(data);
            if(jqXHR.status == 200){

                $('#cboMaterialReporteGrafico').selectpicker('destroy');
                $('#cboMaterialReporteGrafico').html(data).selectpicker('refresh');

            }
        },

    });
    return false;
}


function cboEtapaGrafico(){ 
    $('#tbl_cargaGrafico').hide();
    $('#titleOdpeGrafico').html('');
    $('#cboOdpeReporteGrafico').selectpicker('destroy');
    $('#cboOdpeReporteGrafico').html( '<option value="">[ SELECCIONE UNA ODPE ]</option>' ).selectpicker('refresh');

    var requestEtapa            = new Object();
    requestEtapa["idProceso"]   = $("#cboProcesoReporteGrafico").val();
    requestEtapa["idMaterial"]  = $("#cboMaterialReporteGrafico").val();

    $.ajax({
      url: base_url+'/Reporte/getSelectEtapa',
      type: "POST",     
          // dataType: 'json',
      data:requestEtapa,    
      cache: false,
            
      success: function(data, textStatus, jqXHR){
        // console.log(data);
        if(jqXHR.status == 200){

          $('#cboEtapaReporteGrafico').selectpicker('destroy');
          $('#cboEtapaReporteGrafico').html(data).selectpicker('refresh');

        }

      },
          
    });
}


function cboOdpeGrafico(){ 
    $('#tbl_cargaGrafico').hide();
    $('#titleOdpeGrafico').html('');

    var requestOdpe            = new Object();
    requestOdpe["idProceso"]   = $("#cboProcesoReporteGrafico").val();
    requestOdpe["idMaterial"]  = $("#cboMaterialReporteGrafico").val();
    requestOdpe["idEtapa"]     = $("#cboEtapaReporteGrafico").val();

    $.ajax({
      url: base_url+'/Reporte/getSelectOdpe',
      type: "POST",     
          // dataType: 'json',
      data:requestOdpe,    
      cache: false,
            
      success: function(data, textStatus, jqXHR){
        // console.log(data);
        if(jqXHR.status == 200){

          $('#cboOdpeReporteGrafico').selectpicker('destroy');
          $('#cboOdpeReporteGrafico').html(data).selectpicker('refresh');

        }

      },
          
    });
}


function cargaOdpeGrafico(){
    var proceso     = $("#cboProcesoReporteGrafico").val();
    var material    = $("#cboMaterialReporteGrafico").val();
    var etapa       = $("#cboEtapaReporteGrafico").val();
    var odpe        = $("#cboOdpeReporteGrafico").val();

    var nomProceso = (proceso != '') ? $("#cboProcesoReporteGrafico option:selected").text() : '';

    var nomMaterial = $("#cboMaterialReporteGrafico option:selected").text();
    var nomEtapa = $("#cboEtapaReporteGrafico option:selected").text();
    var nomOdpe = $("#cboOdpeReporteGrafico option:selected").text();

    var requestReporteOdpeGrafica           = new Object();
    requestReporteOdpeGrafica["idProceso"]  = $("#cboProcesoReporteGrafico").val();
    requestReporteOdpeGrafica["idMaterial"] = $("#cboMaterialReporteGrafico").val();
    requestReporteOdpeGrafica["idEtapa"]    = $("#cboEtapaReporteGrafico").val();
    requestReporteOdpeGrafica["idOdpe"]     = $("#cboOdpeReporteGrafico").val();

    $('#titleOdpeGrafico').html('<b>'+nomMaterial+' - '+nomEtapa+' - '+nomOdpe+'</b>');
    if(odpe != ''){
        //$('#tbl_cargaAvance').html('<img src="'+media+'/images/loading.gif" width="40">').addClass('text-center').show();
        // $('#cboProcesoReporteOdpe').blur().attr('disabled',true);
        $.ajax({
            url: base_url+'/Reporte/getSelectOdpeGrafica',
            type: "POST",     
            dataType: 'json',
            data:requestReporteOdpeGrafica,    
            cache: false,
                
            success: function(data, textStatus, jqXHR){
                // console.log((data.data).length);
                if(jqXHR.status == 200){

                    var width = 300*(data.cantidad); 

                    var contenido = '<div style="width:'+width+'px; height: 400px; margin: 0 auto">';

                                    $.each(data.data, function(i, row){
                    contenido +=    '    <div id="container-'+row.CODIGO_SOLUCION+'" style="width: 300px; height: 200px; float: left"></div>';
                                    });
                    contenido +=    '</div> ';

                    $('#tbl_cargaGrafico').html(contenido).removeClass('text-center').show();

                    var gaugeOptions = {

                        chart: {
                            type: 'solidgauge'
                        },

                        title: null,

                        pane: {
                            center: ['50%', '85%'],
                            size: '140%',
                            startAngle: -90,
                            endAngle: 90,
                            background: {
                                backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#EEE',
                                innerRadius: '60%',
                                outerRadius: '100%',
                                shape: 'arc'
                            }
                        },

                        tooltip: {
                            enabled: false
                        },

                        // the value axis
                        yAxis: {
                            stops: [
                                [0.1, '#DF5353'], // red
                                [0.4, '#DDDF0D'], // yellow
                                [0.7, '#3383FF'], // blue
                                [0.9, '#55BF3B']  // green
                            ],
                            lineWidth: 0,
                            minorTickInterval: null,
                            tickAmount: 2,
                            title: {
                                y: -70
                            },
                            labels: {
                                y: 16
                            }
                        },

                        plotOptions: {
                            solidgauge: {
                                dataLabels: {
                                    y: 5,
                                    borderWidth: 0,
                                    useHTML: true
                                }
                            }
                        }
                    };

                    $.each(data.data, function(i, row){
                        var chartSpeed = Highcharts.chart('container-'+row.CODIGO_SOLUCION, Highcharts.merge(gaugeOptions, {
                            yAxis: {
                                min: 0,
                                max: 100,
                                title: {
                                    text: row.CODIGO_SOLUCION
                                }
                            },

                            credits: {
                                enabled: false
                            },

                            series: [{
                                name: row.CODIGO_SOLUCION,
                                data: [ parseFloat(row.PORC_RECIBIDOS) ],
                                dataLabels: {
                                    format: '<div style="text-align:center"><span style="font-size:25px;color:' +
                                        ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
                                           '<span style="font-size:12px;color:silver">Mesas %</span></div>'
                                },
                                tooltip: {
                                    valueSuffix: ' MESAS %'
                                }
                            }]

                        }));
                    });



                }

            },
              
        });
       

    }else{
        $('#tbl_cargaGrafico').hide();
        $('#titleOdpeGrafico').html('');
    }

  return false;
}



/*===== STEP 6 ======*/
function cboSolTecEstadistico(){ 
    $('#tbl_cargaEstadistico').hide();
    $('#cboOdpeReporteEstadistico').selectpicker('destroy');
    $('#cboOdpeReporteEstadistico').html( '<option value="">[ SELECCIONE UNA ODPE ]</option>' ).selectpicker('refresh');
    $('#cboDepartReporteEstadistico').selectpicker('destroy');
    $('#cboDepartReporteEstadistico').html( '<option value="">[ SELECCIONE UN DEPARTAMENTO ]</option>' ).selectpicker('refresh');
    $('#cboProvReporteEstadistico').selectpicker('destroy');
    $('#cboProvReporteEstadistico').html( '<option value="">[ SELECCIONE UNA PROVINCIA ]</option>' ).selectpicker('refresh');
    $('#cboDistReporteEstadistico').selectpicker('destroy');
    $('#cboDistReporteEstadistico').html( '<option value="">[ SELECCIONE UN DISTRiTO ]</option>' ).selectpicker('refresh');

    var proceso = $("#cboProcesoReporteEstadistico").val();
    var requestSoltec         = new Object();
    requestSoltec["idProceso"] = $("#cboProcesoReporteEstadistico").val();

    $.ajax({
        url: base_url+'/Reporte/getSelectSoltec',
        type: "POST",     
         // dataType: 'json',
        data:requestSoltec,    
        cache: false,

        success: function(data, textStatus, jqXHR){
            // console.log(data);
            if(jqXHR.status == 200){

                $('#cboSolTecReporteEstadistico').selectpicker('destroy');
                $('#cboSolTecReporteEstadistico').html(data).selectpicker('refresh');
                // reporteEstadistico();
            }
        },

    });
    return false;
}


function cboOdpeEstadistico(){ 
    $('#tbl_cargaEstadistico').hide();
    $('#cboDepartReporteEstadistico').selectpicker('destroy');
    $('#cboDepartReporteEstadistico').html( '<option value="">[ SELECCIONE UN DEPARTAMENTO ]</option>' ).selectpicker('refresh');
    $('#cboProvReporteEstadistico').selectpicker('destroy');
    $('#cboProvReporteEstadistico').html( '<option value="">[ SELECCIONE UNA PROVINCIA ]</option>' ).selectpicker('refresh');
    $('#cboDistReporteEstadistico').selectpicker('destroy');
    $('#cboDistReporteEstadistico').html( '<option value="">[ SELECCIONE UN DISTRiTO ]</option>' ).selectpicker('refresh');

    var proceso = $("#cboProcesoReporteEstadistico").val();
    var requestOpdeEst              = new Object();
    requestOpdeEst["idProceso"]     = $("#cboProcesoReporteEstadistico").val();
    requestOpdeEst["idSolucion"]    = $("#cboSolTecReporteEstadistico").val();

    $.ajax({
        url: base_url+'/Reporte/getSelectOdpeEst',
        type: "POST",     
         // dataType: 'json',
        data:requestOpdeEst,    
        cache: false,

        success: function(data, textStatus, jqXHR){
            // console.log(data);
            if(jqXHR.status == 200){

                $('#cboOdpeReporteEstadistico').selectpicker('destroy');
                $('#cboOdpeReporteEstadistico').html(data).selectpicker('refresh');
                // reporteEstadistico();
            }
        },

    });
    return false;
}


function cboDepartEstadistico(){ 

    $('#cboProvReporteEstadistico').selectpicker('destroy');
    $('#cboProvReporteEstadistico').html( '<option value="">[ SELECCIONE UNA PROVINCIA ]</option>' ).selectpicker('refresh');
    $('#cboDistReporteEstadistico').selectpicker('destroy');
    $('#cboDistReporteEstadistico').html( '<option value="">[ SELECCIONE UN DISTRiTO ]</option>' ).selectpicker('refresh');

    var proceso = $("#cboProcesoReporteEstadistico").val();
    var requestDepartamento             = new Object();
    requestDepartamento["idProceso"]    = $("#cboProcesoReporteEstadistico").val();
    requestDepartamento["idSolucion"]   = $("#cboSolTecReporteEstadistico").val();
    requestDepartamento["idOdpe"]       = $("#cboOdpeReporteEstadistico").val();

    $.ajax({
        url: base_url+'/Reporte/getSelectDepartamento',
        type: "POST",     
         // dataType: 'json',
        data:requestDepartamento,    
        cache: false,

        success: function(data, textStatus, jqXHR){
            // console.log(data);
            if(jqXHR.status == 200){

                $('#cboDepartReporteEstadistico').selectpicker('destroy');
                $('#cboDepartReporteEstadistico').html(data).selectpicker('refresh');
                reporteEstadistico();
            }
        },

    });
    return false;
}


function cboProvEstadistico(){ 

    $('#cboDistReporteEstadistico').selectpicker('destroy');
    $('#cboDistReporteEstadistico').html( '<option value="">[ SELECCIONE UN DISTRiTO ]</option>' ).selectpicker('refresh');

    var proceso = $("#cboProcesoReporteEstadistico").val();
    var requestDepartamento             = new Object();
    requestDepartamento["idProceso"]    = $("#cboProcesoReporteEstadistico").val();
    requestDepartamento["idSolucion"]   = $("#cboSolTecReporteEstadistico").val();
    requestDepartamento["idOdpe"]       = $("#cboOdpeReporteEstadistico").val();
    requestDepartamento["departamento"] = $("#cboDepartReporteEstadistico").val();

    $.ajax({
        url: base_url+'/Reporte/getSelectProvincia',
        type: "POST",     
         // dataType: 'json',
        data:requestDepartamento,    
        cache: false,

        success: function(data, textStatus, jqXHR){
            // console.log(data);
            if(jqXHR.status == 200){

                $('#cboProvReporteEstadistico').selectpicker('destroy');
                $('#cboProvReporteEstadistico').html(data).selectpicker('refresh');
                reporteEstadistico();
            }
        },

    });
    return false;
}


function cboDistEstadistico(){ 

    var proceso = $("#cboProcesoReporteEstadistico").val();
    var requestDepartamento             = new Object();
    requestDepartamento["idProceso"]    = $("#cboProcesoReporteEstadistico").val();
    requestDepartamento["idSolucion"]   = $("#cboSolTecReporteEstadistico").val();
    requestDepartamento["idOdpe"]       = $("#cboOdpeReporteEstadistico").val();
    requestDepartamento["departamento"] = $("#cboDepartReporteEstadistico").val();
    requestDepartamento["provincia"]    = $("#cboProvReporteEstadistico").val();

    $.ajax({
        url: base_url+'/Reporte/getSelectDistrito',
        type: "POST",     
         // dataType: 'json',
        data:requestDepartamento,    
        cache: false,

        success: function(data, textStatus, jqXHR){
            // console.log(data);
            if(jqXHR.status == 200){

                $('#cboDistReporteEstadistico').selectpicker('destroy');
                $('#cboDistReporteEstadistico').html(data).selectpicker('refresh');
                reporteEstadistico();
            }
        },

    });
    return false;
}


function reporteEstadistico(){

    var proceso = $("#cboProcesoReporteEstadistico").val();
    var nomProceso = (proceso != '') ? $("#cboProcesoReporteEstadistico option:selected").text() : '';

    var requestEstadistico             = new Object();
    requestEstadistico["idProceso"]    = $("#cboProcesoReporteEstadistico").val();
    requestEstadistico["idSolucion"]   = $("#cboSolTecReporteEstadistico").val();
    requestEstadistico["idOdpe"]       = $("#cboOdpeReporteEstadistico").val();
    requestEstadistico["departamento"] = $("#cboDepartReporteEstadistico").val();
    requestEstadistico["provincia"]    = $("#cboProvReporteEstadistico").val();
    requestEstadistico["distrito"]     = $('#cboDistReporteEstadistico').val();
    requestEstadistico["idEleccion"]   = $('#cboProcesoReporteEstadistico option:selected').attr('data');
    requestEstadistico["nomProceso"]   = nomProceso;

    $('#tbl_cargaEstadistico').html('<img src="'+media+'/images/loading.gif" width="40">').addClass('text-center').show();

    $.ajax({
        url: base_url+'/Reporte/getEstadistico',
        type: "POST",     
        dataType: 'json',
        data:requestEstadistico,    
        cache: false,

        success: function(data, textStatus, jqXHR){
            // console.log(data);
            if(jqXHR.status == 200){

                $('#tbl_cargaEstadistico').html(data.data).removeClass('text-center').height(1500).show();

            }
        },

    });
    return false;
}


function exportarReporteEstadisticoPDF(){
    
    var proceso = $("#cboProcesoReporteEstadistico").val();
    var nomProceso = (proceso != '') ? $("#cboProcesoReporteEstadistico option:selected").text() : '';
    var nomOdpe = $("#cboOdpeReporteEstadistico option:selected").text();
    var nomSolucion = $("#cboSolTecReporteEstadistico option:selected").text();

    var requestEstadistico              = new Object();
    requestEstadistico["idProceso"]     = $("#cboProcesoReporteEstadistico").val();
    requestEstadistico["idSolucion"]    = $("#cboSolTecReporteEstadistico").val();
    requestEstadistico["idOdpe"]        = $("#cboOdpeReporteEstadistico").val();
    requestEstadistico["departamento"]  = $("#cboDepartReporteEstadistico").val();
    requestEstadistico["provincia"]     = $("#cboProvReporteEstadistico").val();
    requestEstadistico["distrito"]      = $('#cboDistReporteEstadistico').val();
    requestEstadistico["idEleccion"]    = $('#cboProcesoReporteEstadistico option:selected').attr('data');
    requestEstadistico["nomProceso"]    = nomProceso;
    requestEstadistico["nomOdpe"]       = nomOdpe;
    requestEstadistico["nomSolucion"]   = nomSolucion;
	
    $.ajax({
      	type:'POST',
      	url: base_url+"/Reporte/getEstadisticoPDF",
      	dataType:'json',
        data:requestEstadistico,    
        cache: false,
      	success: function(data, textStatus, jqXHR){
	       	
	       	if(jqXHR.status == 200){
	       		console.log(data);
		        if(data.status){
			        			        
		        	window.open(base_url+'/'+data.data+'.pdf');
			        setTimeout(function() {
			        	eliminarfile(data.data+'.pdf');
			        },5000);;
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


/*===== STEP 7 ======*/
function cboMesaConsulta(){ 
    var proceso = $("#cboProcesoReporteConsulta").val();
    $('#tbl_ConsultaMesa').hide();
    $('#txtMesa').html('');
    $('#txtSoltec').html('');
    $('#txtOdpe').html('');
    $('#txtDepartamento').html('');
    $('#txtProvincia').html('');
    $('#txtDistrito').html('');
    $('#txtLocal').html('');
    $('#txtNroElectores').html('');
    $('#fileMesa').html('');
    
    if(proceso != ''){
      $('#txtMesaReporteConsulta').val('').attr("disabled", false).focus();
      
    }else{
      $('#txtMesaReporteConsulta').val('').attr("disabled", true);
    }
    
}



function reporteConsultMesa(){
    var proceso = $("#cboProcesoReporteConsulta").val();
    var mesa = $('#txtMesaReporteConsulta').val();   
    
    var requestConsultaMesa             = new Object();
    requestConsultaMesa["idProceso"]    = $("#cboProcesoReporteConsulta").val();
    requestConsultaMesa["nroMesa"]      = $("#txtMesaReporteConsulta").val();    

    if(mesa.length == 6){

        $.ajax({
            url: base_url+'/Reporte/getConsultaMesa',
            type: "POST",     
            dataType: 'json',
            data:requestConsultaMesa,    
            cache: false,

            success: function(data, textStatus, jqXHR){
                // console.log(data);
                if(jqXHR.status == 200){
                    // alert() 
                    $('#tbl_ConsultaMesa').html(data.data).show();
                    $('#txtMesa').html('<b> MESA Nº '+data.consultaMesa.detalle[0].NRO_MESA+'</b>');
                    $('#txtSoltec').html(data.consultaMesa.detalle[0].SOLUCIONTECNOLOGICA);
                    $('#txtOdpe').html(data.consultaMesa.detalle[0].NOMBRE_ODPE);
                    $('#txtDepartamento').html(data.consultaMesa.detalle[0].DEPARTAMENTO_UBI);
                    $('#txtProvincia').html(data.consultaMesa.detalle[0].PROVINCIA_UBI);
                    $('#txtDistrito').html(data.consultaMesa.detalle[0].DISTRITO_UBI);
                    $('#txtLocal').html(data.consultaMesa.detalle[0].NOMBRE_LOCAL);
                    $('#txtNroElectores').html(data.consultaMesa.detalle[0].NRO_ELECTORES);
                    $('#fileMesa').html('<a href="Assets/documents/uploads/scan_mesas/'+data.consultaMesa.detalle[0].NRO_MESA+'.txt" target="_blank">DESCARGAR</a>');

                }
            },

        });

    }else{
      $('#tbl_ConsultaMesa').hide();
      $('#txtMesa').html('');
      $('#txtSoltec').html('');
      $('#txtOdpe').html('');
      $('#txtDepartamento').html('');
      $('#txtProvincia').html('');
      $('#txtDistrito').html('');
      $('#txtLocal').html('');
      $('#txtNroElectores').html('');
      $('#fileMesa').html('');
    }

  }





/*===== STEP 8 - OTROS MATERIALES ======*/
function cboMaterialRendimiento_Otros(){ 
    $('#tbl_Rendimiento_Otros').hide();
    $('#tableRendimiento').DataTable().clear().draw();
    $('#titleRendimiento_Otros').html('');
    $('#cboEtapaReporteRendimiento_Otros').selectpicker('destroy');
    $('#cboEtapaReporteRendimiento_Otros').html( '<option value="">[ SELECCIONE UNA ETAPA ]</option>' ).selectpicker('refresh');

    var proceso = $("#cboProcesoReporteRendimiento_Otros").val();
    var requestMaterial         = new Object();
    requestMaterial["idProceso"] = $("#cboProcesoReporteRendimiento_Otros").val();

    $.ajax({
        url: base_url+'/Reporte/getSelectMaterial_Otros',
        type: "POST",     
         // dataType: 'json',
        data:requestMaterial,    
        cache: false,

        success: function(data, textStatus, jqXHR){
            // console.log(data);
            if(jqXHR.status == 200){

                $('#cboMaterialReporteRendimiento_Otros').selectpicker('destroy');
                $('#cboMaterialReporteRendimiento_Otros').html(data).selectpicker('refresh');

            }
        },

    });
    return false;
}


function cboEtapaRendimiento_Otros(){ 
    
    $('#tbl_Rendimiento_Otros').hide();
    $('#tableRendimiento').DataTable().clear().draw();
    $('#titleRendimiento_Otros').html('');


    var requestEtapa            = new Object();
    requestEtapa["idProceso"]   = $("#cboProcesoReporteRendimiento_Otros").val();
    requestEtapa["idMaterial"]  = $("#cboMaterialReporteRendimiento_Otros").val();

    $.ajax({
      url: base_url+'/Reporte/getSelectEtapa_Otros',
      type: "POST",     
          // dataType: 'json',
      data:requestEtapa,    
      cache: false,
            
      success: function(data, textStatus, jqXHR){
        // console.log(data);
        if(jqXHR.status == 200){

          $('#cboEtapaReporteRendimiento_Otros').selectpicker('destroy');
          $('#cboEtapaReporteRendimiento_Otros').html(data).selectpicker('refresh');

        }

      },
          
    });
}


function cargaRendimiento_Otros(){
    var proceso     = $("#cboProcesoReporteRendimiento_Otros").val();
    var material    = $("#cboMaterialReporteRendimiento_Otros").val();
    var etapa       = $("#cboEtapaReporteRendimiento_Otros").val();

    var nomProceso = (proceso != '') ? $("#cboProcesoReporteRendimiento_Otros option:selected").text() : '';

    var nomMaterial = $("#cboMaterialReporteRendimiento_Otros option:selected").text();
    var nomEtapa = $("#cboEtapaReporteRendimiento_Otros option:selected").text();

    var requestReporteRendimiento           = new Object();
    requestReporteRendimiento["idProceso"]  = $("#cboProcesoReporteRendimiento_Otros").val();
    requestReporteRendimiento["idMaterial"] = $("#cboMaterialReporteRendimiento_Otros").val();
    requestReporteRendimiento["idEtapa"]    = $("#cboEtapaReporteRendimiento_Otros").val();

    $('#titleRendimiento_Otros').html('<b>'+nomMaterial+' - '+nomEtapa+'</b>');
    if(etapa != ''){
        //$('#tbl_cargaAvance').html('<img src="'+media+'/images/loading.gif" width="40">').addClass('text-center').show();
        // $('#cboProcesoReporteOdpe').blur().attr('disabled',true);
        $.ajax({
            url: base_url+'/Reporte/getSelectRendimiento_Otros',
            type: "POST",     
            dataType: 'json',
            data:requestReporteRendimiento,    
            cache: false,
                
            success: function(data, textStatus, jqXHR){
                console.log((data.data));
                if(jqXHR.status == 200){

                    
                    $('#tbl_Rendimiento_Otros').html(data.data).removeClass('text-center').show();


                }

            },
              
        });
       

    }else{
        $('#tbl_Rendimiento_Otros').hide();
        $('#titleRendimiento_Otros').html('');
    }

  return false;
}





function cboCargaAvanceOtros(){ 
    var proceso = $("#cboProcesoReporteAvance_Otros").val();
    var nomProceso = (proceso != '') ? $("#cboProcesoReporteAvance_Otros option:selected").text() : '';

    var requestReporteGeneralOtros           = new Object();
    requestReporteGeneralOtros["idProceso"]  = $("#cboProcesoReporteAvance_Otros").val();

    $('#titleProcesoOtros').html('<b>'+nomProceso+'</b>');
    // if(proceso != ''){
        //$('#tbl_cargaAvance').html('<img src="'+media+'/images/loading.gif" width="40">').addClass('text-center').show();
        // $('#cboProcesoReporteAvance_Otros').blur().attr('disabled',true);
    if($("#cboProcesoReporteAvance_Otros").val() != ''){
        var tableAvanceGeneralOtros = $('#tableAvanceGeneralOtros').DataTable({
            "dom": 'Bfrtip',
            "buttons": [
                {
                    "extend": 'excelHtml5',
                    "title": 'REPORTE DE CEDULAS DE RESERVA'
                },
                {
                    "extend": 'pdfHtml5',
                    "title": 'REPORTE DE CEDULAS DE RESERVA'
                }
            ],
            "processing": true,
            // "serverSide": true,
            "destroy": true,
            "order": [],
            "language": {
                "url": base_url+'/Assets/js/es-pe.json'
            },
            "ajax": {
                "url": base_url+'/Reporte/getAvanceGeneralOtros',
                "type": "POST",
                "data" : requestReporteGeneralOtros,
                "dataType": "json",
                "cache": false,
            },
            "columns": [
            {"data":"NOMBRE_ODPE"}, 
            {"data":"CANTIDAD_TOTAL"},
            {"data":"CANTIDAD_RECIBIDA"},
            {"data":"RESTO"}, 
            ],
            "resonsieve":"true",
            "dDestroy": true,
            "iDisplayLength": 10,
            // "order": [[0,"asc"]],
            "columnDefs": [{
                //"targets": [2,3,4,5,6,7,8],
                // "orderable": false,
                /*"createdCell": function(td, cellData, rowData, row, col){
                    if (cellData == "100 %") {
                        // $(td).css('background-color','#E0F8EC');
                        $(td).css({'background-color':'#1d87e4','color':'#FFFFFF' });
                    }else if(cellData == ""){
                       $(td).css({'background-color':'#F2F2F2','color':'#F2F2F2' });
                   }
               },*/
           },],
        });

    }else{
        
        //$('#tableAvanceGeneralOtros tbody').empty();
        $('#tableAvanceGeneralOtros').DataTable().clear().draw();
    
    }
    return false;
}













function viewAsistenciaX(){

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



function cancelreportAsistenciaX(){
      
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
  

function exportarAsistenciaX(){ 
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



function eliminarfileX(id){
      
	$.ajax({
		type:'DELETE',
		url: base_url+'/ReportAsistencia/eliminarfile/'+id,
		success: function(data){

		}
	});
   	return false;
}