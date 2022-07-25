// JavaScript Document
$(document).ready(function () {
    cboOdpe();
    $('#cboodpeRecepcion').selectpicker();
    $('#cbosoltecRecepcion').selectpicker();
    $('#cboconsultaRecepcion').selectpicker();
    $('#cbodepartRecepcion').selectpicker();
    $('#cboprovRecepcion').selectpicker();
    $('#cbodistRecepcion').selectpicker();
    $('#cbosobreRecepcion').selectpicker();
    $('#cbosufragioRecepcion').selectpicker();
    $('#cbodocumentoRecepcion').selectpicker();
});

var eleccion = $('#cboProceso option:selected').attr('data');
//$('#txtdata').val(eleccion);
// var eleccion = 1;
if (eleccion == 2) {
    $('#divAgrupacionRecepcion').show();
} else {
    $('#divAgrupacionRecepcion').hide();
}

/* ** FUNCIONES DE LOS COMBOS ** */
function cboOdpe() {
    console.log('REVIsando');
    var requestSolucion = new Object();
    requestSolucion["idProceso"] = $("#cboProceso").val();
    $.ajax({
        url: base_url + '/Control_cedula/getSelectOdpe',
        type: "POST",
        data: requestSolucion,
        cache: false,
        success: function (data, textStatus, jqXHR) {
            if (jqXHR.status == 200) {
                $('#cboodpeRecepcion').selectpicker('destroy');
                $('#cboodpeRecepcion').html(data).selectpicker('refresh');
            }
        },
    });
    return false;
}

function cboSolucionTecnologica(etapa) {
    resetInpbarra(etapa);
    $('#cbodepart' + etapa).selectpicker('destroy');
    $('#cbodepart' + etapa).html('<option value="">[ SELECCIONE UN DEPARTAMENTO ]</option>').selectpicker('refresh');
    $('#cboprov' + etapa).selectpicker('destroy');
    $('#cboprov' + etapa).html('<option value="">[ SELECCIONE UNA PROVINCIA ]</option>').selectpicker('refresh');
    $('#cbodist' + etapa).selectpicker('destroy');
    $('#cbodist' + etapa).html('<option value="">[ SELECCIONE UN DISTRITO ]</option>').selectpicker('refresh');
    $('#cboconsulta' + etapa).selectpicker('destroy');
    $('#cboconsulta' + etapa).html('<option value="">[ SELECCIONE UNA CONSULTA ]</option>').selectpicker('refresh');
    $('#cbosobre' + etapa).selectpicker('destroy');
    $('#cbosobre' + etapa).html('<option value="">[ SELECCIONE TIPO DE SOBRE ]</option>').selectpicker('refresh');
    $('#cbosufragio' + etapa).selectpicker('destroy');
    $('#cbosufragio' + etapa).html('<option value="">[ SELECCIONE TIPO DE SUFRAGIO ]</option>').selectpicker('refresh');
    $('#cbodocumento' + etapa).selectpicker('destroy');
    $('#cbodocumento' + etapa).html('<option value="">[ SELECCIONE UN DOCUMENTO ]</option>').selectpicker('refresh');

    var requestOdpe = new Object();
    requestOdpe["idOdpe"] = $("#cboodpe" + etapa).val();

    $.ajax({
        url: base_url + '/Control_cedula/getSelectSolucion',
        type: "POST",
        data: requestOdpe,
        cache: false,
        success: function (data, textStatus, jqXHR) {
            // console.log(data);
            if (jqXHR.status == 200) {
                $('#cbosoltec' + etapa).selectpicker('destroy');
                $('#cbosoltec' + etapa).html(data).selectpicker('refresh');
            }
        },
    });
    setTimeout(function () {
        // cargaAvanceOdpe(etapa);
        //cargaAvanceAgrupacion(etapa);
        enabledAvance(etapa);
    }, 120);

}

function cboDepartamento(etapa) {
    resetInpbarra(etapa);
    // cargaAvanceOdpe(etapa);
    enabledAvance(etapa);
    $('#cboprov' + etapa).selectpicker('destroy');
    $('#cboprov' + etapa).html('<option value="">[ SELECCIONE UNA PROVINCIA ]</option>').selectpicker('refresh');
    $('#cbodist' + etapa).selectpicker('destroy');
    $('#cbodist' + etapa).html('<option value="">[ SELECCIONE UN DISTRITO ]</option>').selectpicker('refresh');
    $('#cboconsulta' + etapa).selectpicker('destroy');
    $('#cboconsulta' + etapa).html('<option value="">[ SELECCIONE UNA CONSULTA  ]</option>').selectpicker('refresh');
    $('#cbosobre' + etapa).selectpicker('destroy');
    $('#cbosobre' + etapa).html('<option value="">[ SELECCIONE TIPO DE SOBRE ]</option>').selectpicker('refresh');
    $('#cbosufragio' + etapa).selectpicker('destroy');
    $('#cbosufragio' + etapa).html('<option value="">[ SELECCIONE TIPO DE SUFRAGIO ]</option>').selectpicker('refresh');
    $('#cbodocumento' + etapa).selectpicker('destroy');
    $('#cbodocumento' + etapa).html('<option value="">[ SELECCIONE UN SUFRAGIO ]</option>').selectpicker('refresh');

    var eleccionN = (eleccion == 1 || (eleccion == 2 && etapa == 'Empaque')) ? 1 : eleccion;
    // var eleccionN = eleccion;
    var requestDepartamento = new Object();
    requestDepartamento["idProceso"] = $("#cboProceso").val();
    requestDepartamento["idSolucion"] = $("#cbosoltec" + etapa).val();
    requestDepartamento["idOdpe"] = $("#cboodpe" + etapa).val();
    requestDepartamento["idEleccion"] = eleccionN;

    $.ajax({
        url: base_url + '/Control_cedula/getSelectDepartamento',
        type: "POST",
        data: requestDepartamento,
        cache: false,
        success: function (data, textStatus, jqXHR) {
            // console.log(data);
            if (jqXHR.status == 200) {

                if (eleccion == 1 || (eleccion == 2 && etapa == 'Empaque')) {
                    $('#cbodepart' + etapa).selectpicker('destroy');
                    $('#cbodepart' + etapa).html(data).selectpicker('refresh');

                } else {
                    $('#cbodepart' + etapa).selectpicker('destroy');
                    $('#cbodepart' + etapa).html('<option value="">[ SELECCIONE UN DEPARTAMENTO ]</option>').selectpicker('refresh');
                }
            }
        },
    });
}

function cboProvincia(etapa) {
    cboConsulta(etapa);
    resetInpbarra(etapa);
    $('#cbodist' + etapa).selectpicker('destroy');
    $('#cbodist' + etapa).html('<option value="">[ SELECCIONE UN DISTRITO ]</option>').selectpicker('refresh');
    $('#cboconsulta' + etapa).selectpicker('destroy');
    $('#cboconsulta' + etapa).html('<option value="">[ SELECCIONE UNA CONSULTA  ]</option>').selectpicker('refresh');
    $('#cbosobre' + etapa).selectpicker('destroy');
    $('#cbosobre' + etapa).html('<option value="">[ SELECCIONE TIPO DE SOBRE ]</option>').selectpicker('refresh');
    $('#cbosufragio' + etapa).selectpicker('destroy');
    $('#cbosufragio' + etapa).html('<option value="">[ SELECCIONE TIPO DE SUFRAGIO ]</option>').selectpicker('refresh');
    $('#cbodocumento' + etapa).selectpicker('destroy');
    $('#cbodocumento' + etapa).html('<option value="">[ SELECCIONE UN SUFRAGIO ]</option>').selectpicker('refresh');

    var eleccionN = (eleccion == 1 || (eleccion == 2 && etapa == 'Empaque')) ? 1 : eleccion;
    // var eleccionN = eleccion;
    var requestProvincia = new Object();
    requestProvincia["idProceso"] = $("#cboProceso").val();
    requestProvincia["idSolucion"] = $("#cbosoltec" + etapa).val();
    requestProvincia["idOdpe"] = $("#cboodpe" + etapa).val();
    // requestProvincia["idAgrupacion"] = $("#cboagrupacion" + etapa).val();
    requestProvincia["idDepartamento"] = $("#cbodepart" + etapa).val();
    requestProvincia["idEleccion"] = eleccionN;

    $.ajax({
        url: base_url + '/Control_cedula/getSelectProvincia',
        type: "POST",
        // dataType: 'json',
        data: requestProvincia,
        cache: false,
        success: function (data, textStatus, jqXHR) {
            if (jqXHR.status == 200) {
                $('#cboprov' + etapa).selectpicker('destroy');
                $('#cboprov' + etapa).html(data).selectpicker('refresh');
            }
        },
    });
}

function cboDistrito(etapa) {
    resetInpbarra(etapa);
    $('#cboconsulta' + etapa).selectpicker('destroy');
    $('#cboconsulta' + etapa).html('<option value="">[ SELECCIONE UNA CONSULTA  ]</option>').selectpicker('refresh');
    $('#cbosobre' + etapa).selectpicker('destroy');
    $('#cbosobre' + etapa).html('<option value="">[ SELECCIONE UN SOBRE ]</option>').selectpicker('refresh');
    $('#cbosufragio' + etapa).selectpicker('destroy');
    $('#cbosufragio' + etapa).html('<option value="">[ SELECCIONE TIPO DE SUFRAGIO ]</option>').selectpicker('refresh');
    $('#cbodocumento' + etapa).selectpicker('destroy');
    $('#cbodocumento' + etapa).html('<option value="">[ SELECCIONE UN SUFRAGIO ]</option>').selectpicker('refresh');

    var eleccionN = (eleccion == 1 || (eleccion == 2 && etapa == 'Empaque')) ? 1 : eleccion;
    // var eleccionN = eleccion;
    var requestDsitrito = new Object();
    requestDsitrito["idProceso"] = $("#cboProceso").val();
    requestDsitrito["idSolucion"] = $("#cbosoltec" + etapa).val();
    requestDsitrito["idOdpe"] = $("#cboodpe" + etapa).val();
    // requestDsitrito["idAgrupacion"] = $("#cboagrupacion" + etapa).val();
    requestDsitrito["idDepartamento"] = $("#cbodepart" + etapa).val();
    requestDsitrito["idProvincia"] = $("#cboprov" + etapa).val();
    requestDsitrito["idEleccion"] = eleccionN;

    $.ajax({
        url: base_url + '/Control_cedula/getSelectDistrito',
        type: "POST",
        // dataType: 'json',
        data: requestDsitrito,
        cache: false,
        success: function (data, textStatus, jqXHR) {
            // console.log(data);
            if (jqXHR.status == 200) {
                $('#cbodist' + etapa).selectpicker('destroy');
                $('#cbodist' + etapa).html(data).selectpicker('refresh');
            }
        },
    });
}

function cboConsulta(etapa) {
    resetInpbarra(etapa);
    $('#cbosobre' + etapa).selectpicker('destroy');
    $('#cbosobre' + etapa).html('<option value="">[ SELECCIONE TIPO DE SOBRE ]</option>').selectpicker('refresh');
    $('#cbosufragio' + etapa).selectpicker('destroy');
    $('#cbosufragio' + etapa).html('<option value="">[ SELECCIONE TIPO DE SUFRAGIO ]</option>').selectpicker('refresh');
    $('#cbodocumento' + etapa).selectpicker('destroy');
    $('#cbodocumento' + etapa).html('<option value="">[ SELECCIONE UN SUFRAGIO ]</option>').selectpicker('refresh');

    var requestConsulta = new Object();
    requestConsulta["idProceso"] = $("#cboProceso").val();
    requestConsulta["idOdpe"] = $("#cboodpe" + etapa).val();
    requestConsulta["idDepartamento"] = $("#cbodepart" + etapa).val();
    requestConsulta["idProvincia"] = $("#cboprov" + etapa).val();
    requestConsulta["idDistrito"] = $("#cbodist" + etapa).val();
    $.ajax({
        url: base_url + '/Control_cedula/getSelectConsulta',
        type: "POST",
        // dataType: 'json',
        data: requestConsulta,
        cache: false,
        success: function (data, textStatus, jqXHR) {
            // console.log(data);
            if (jqXHR.status == 200) {
                $('#cboconsulta' + etapa).selectpicker('destroy');
                $('#cboconsulta' + etapa).html(data).selectpicker('refresh');
            }
        },
    });
    setTimeout(function () {
        // cargaAvanceOdpe(etapa);
        //cargaAvanceAgrupacion(etapa);
        enabledAvance(etapa);
    }, 120);
}

function cboSobre(etapa) {
    $('#cbosufragio' + etapa).selectpicker('destroy');
    $('#cbosufragio' + etapa).html('<option value="">[ SELECCIONE TIPO DE SUFRAGIO ]</option>').selectpicker('refresh');
    $('#cbodocumento' + etapa).selectpicker('destroy');
    $('#cbodocumento' + etapa).html('<option value="">[ SELECCIONE UN DOCUMENTO ]</option>').selectpicker('refresh');
    resetInpbarra(etapa);
    var requestConsulta = new Object();
    requestConsulta["idSolucion"] = $("#cbosoltec" + etapa).val();
    if (eleccion == 2 && etapa == 'Empaque') {
        if (etapaControl == 3) {
            habilInpbarra(etapa);
            ordenEmpaquetado(etapa);
        }
    } else {
        $.ajax({
            url: base_url + '/Control_cedula/getSelectSobre',
            type: "POST",
            // dataType: 'json',
            data: requestConsulta,
            cache: false,
            success: function (data, textStatus, jqXHR) {
                // console.log(data);
                if (jqXHR.status == 200) {
                    $('#cbosobre' + etapa).selectpicker('destroy');
                    $('#cbosobre' + etapa).html(data).selectpicker('refresh');
                }
            },
        });
    }
}

function cboSufragio(etapa) {
    $('#cbodocumento' + etapa).selectpicker('destroy');
    $('#cbodocumento' + etapa).html('<option value="">[ SELECCIONE UN DOCUMENTO ]</option>').selectpicker('refresh');
    console.log('Aqui vente');
    resetInpbarra(etapa);
    var requestConsulta = new Object();
    // requestConsulta["idSolucion"] = $("#cbosoltec" + etapa).val();
    requestConsulta["idConsulta"] = $("#cboconsulta" + etapa).val();
    if (eleccion == 2 && etapa == 'Empaque') {
        if (etapaControl == 3) {
            habilInpbarra(etapa);
            ordenEmpaquetado(etapa);
        }
    } else {
        $.ajax({
            url: base_url + '/Control_cedula/getSelectSufragio',
            type: "POST",
            // dataType: 'json',
            data: requestConsulta,
            cache: false,
            success: function (data, textStatus, jqXHR) {
                // console.log(data);
                if (jqXHR.status == 200) {
                    $('#cbosufragio' + etapa).selectpicker('destroy');
                    $('#cbosufragio' + etapa).html(data).selectpicker('refresh');
                }
            },
        });
    }
}

function cboDocumento(etapa) {
    resetInpbarra(etapa);
    var requestConsulta = new Object();

    requestConsulta["idSolucion"] = $("#cbosoltec" + etapa).val();
    requestConsulta["idSobre"] = $("#cbosobre" + etapa).val();
    $.ajax({
        url: base_url + '/Control_cedula/getSelectDocumento',
        type: "POST",
        // dataType: 'json',
        data: requestConsulta,
        cache: false,
        success: function (data, textStatus, jqXHR) {
            // console.log(data);
            if (jqXHR.status == 200) {
                $('#cbodocumento' + etapa).selectpicker('destroy');
                $('#cbodocumento' + etapa).html(data).selectpicker('refresh');
            }
        },
    });
}

/* ** FUNCIONES DE LOS COMBOS ** */

function SoloNum() {
    if ((event.keyCode < 48) || (event.keyCode > 57))
        event.returnValue = false;
}

function SoloLetras() {
    if ((event.keyCode != 32) && (event.keyCode < 65) || (event.keyCode > 90) && (event.keyCode < 97) || (event.keyCode > 122) && (event.keyCode < 164))
        event.returnValue = false;
}

function Validador(correo) {
    var tester = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-]+)\.)+([a-zA-Z0-9]{2,4})+$/;
    return tester.test(correo);
}

/*RESET DE COMBO E IMPUT*/
function cargaCbo(etapa) {
    resetCbo(etapa);
    resetInpbarra(etapa);
    cargaAvanceFase(etapa);
    cargaAvanceOdpe(etapa);
}

function resetCbo(etapa) {
    $('#sign_add' + etapa + 'Cedula')[0].reset();
    $('#sign_add' + etapa + 'Cedula').validate().resetForm();

    $('#cbofase' + etapa).selectpicker('destroy');
    $('#cbofase' + etapa).html('<option value="">[ SELECCIONE UNA FASE ]</option><option value="1">SUFRAGIO</option>').selectpicker('refresh');
    $('#cbosoltec' + etapa).selectpicker('destroy');
    $('#cbosoltec' + etapa).html('<option value="">[ SELECCIONE UNA SOL. TECN. ]</option>').selectpicker('refresh');
    $('#cboodpe' + etapa).selectpicker('destroy');
    $('#cboodpe' + etapa).html('<option value="">[ SELECCIONE UNA ODPE ]</option>').selectpicker('refresh');
    $('#cboagrupacion' + etapa).selectpicker('destroy');
    $('#cboagrupacion' + etapa).html('<option value="">[ SELECCIONE UNA AGRUP. POLITICA  ]</option>').selectpicker();
    $('#cbodepart' + etapa).selectpicker('destroy');
    $('#cbodepart' + etapa).html('<option value="">[ SELECCIONE UN DEPARTAMENTO ]</option>').selectpicker('refresh');
    $('#cboprov' + etapa).selectpicker('destroy');
    $('#cboprov' + etapa).html('<option value="">[ SELECCIONE UNA PROVINCIA ]</option>').selectpicker('refresh');
    $('#cbodist' + etapa).selectpicker('destroy');
    $('#cbodist' + etapa).html('<option value="">[ SELECCIONE UN DISTRITO ]</option>').selectpicker('refresh');
    $('#cboconsulta' + etapa).selectpicker('destroy');
    $('#cboconsulta' + etapa).html('<option value="">[ SELECCIONE TIPO DE C&Eacute;DULA ]</option>').selectpicker('refresh');
    enabledAvance(etapa);
}

function resetInpbarra(etapa) {
    $("#mesa" + etapa).prop('disabled', true).val("");
    // $("#rotulo" + etapa).prop('disabled', true).val("");
    $("#txtValidacion" + etapa).val('1');
    $('#btnIncid' + etapa).hide();
    $('#btnResetInput' + etapa).hide();
    $('#add' + etapa + 'Cedula').hide();
    $('#msj_mesa_next').hide();
}

function habilInpbarra(etapa) {
    $("#mesa" + etapa).prop('disabled', false).val("").focus();
    // $("#rotulo" + etapa).prop('disabled', false).val("");
    $("#txtValidacion" + etapa).val('1');
}

function inhabilitaEscbarra(etapa) {
    $("#mesa" + etapa).prop('disabled', true);
    // $("#rotulo" + etapa).prop('disabled', true);
    $('#btnIncid' + etapa).removeAttr('style');
    $('#btnResetInput' + etapa).removeAttr('style');
    //$('#add'+etapa+'Cedula').removeAttr('style');
}

function habilBtnValidar(etapa) {
    $("#mesa" + etapa).prop('disabled', true);
    // $("#rotulo" + etapa).prop('disabled', true);
    $('#btnIncid' + etapa).removeAttr('style');
    $('#add' + etapa + 'Cedula').removeAttr('style');
    $('#btnResetInput' + etapa).removeAttr('style');
}

function resetInput(etapa) {
    $("#mesa" + etapa).prop('disabled', false).val("").focus();
    // $("#rotulo" + etapa).prop('disabled', false).val("");
    $("#txtValidacion" + etapa).val('1');
    $('#btnIncid' + etapa).css("display", "none");
    $('#btnResetInput' + etapa).css("display", "none");
    $('#add' + etapa + 'Cedula').css("display", "none");
}

/* FIN RESET*/

/*CARGA AVANCE FASE*/
function cargaAvanceFase(etapa) {
    var requestAvanceFase = new Object();
    requestAvanceFase["idProceso"] = $("#cboProceso").val();
    requestAvanceFase["idMaterial"] = $("#idMaterial").val();
    requestAvanceFase["idEtapa"] = $("#txtIdEtapa" + etapa).val();
    requestAvanceFase["idFase"] = $("#cbofase" + etapa).val();
    requestAvanceFase["nomfase"] = $('#cbofase' + etapa + ' option:selected').text();
    requestAvanceFase["validacion"] = $("#txtValidacion" + etapa).val();

    $.ajax({
        url: base_url + '/Control_cedula/getAvanceFase',
        type: "POST",
        dataType: 'json',
        data: requestAvanceFase,
        cache: false,
        success: function (data, textStatus, jqXHR) {
            if (jqXHR.status == 200) {
                $('#tbl_cedula' + etapa + 'AvanceFase tbody').html(data.data);
                $('#nomFase' + etapa).html('<strong>' + data.nomFase + '</strong>');
            }
        },
    });
}

/*CARGA AVANCE ODPE*/
function cargaAvanceOdpe(etapa) {

    var requestAvanceOdpe = new Object();
    requestAvanceOdpe["idProceso"] = $("#cboProceso").val();
    requestAvanceOdpe["idMaterial"] = $("#idMaterial").val();
    requestAvanceOdpe["idEtapa"] = $("#txtIdEtapa" + etapa).val();
    requestAvanceOdpe["idFase"] = $("#cbofase" + etapa).val();
    requestAvanceOdpe["idOdpe"] = $("#cboodpe" + etapa).val();
    requestAvanceOdpe["nomOdpe"] = $('#cboodpe' + etapa + ' option:selected').text();
    requestAvanceOdpe["validacion"] = $("#txtValidacion" + etapa).val();

    $.ajax({
        url: base_url + '/Control_cedula/getAvanceOdpe',
        type: "POST",
        dataType: 'json',
        data: requestAvanceOdpe,
        cache: false,
        success: function (data, textStatus, jqXHR) {
            // console.log(data);
            if (jqXHR.status == 200) {
                $('#tbl_cedula' + etapa + 'AvanceOdpe tbody').html(data.data);
                $('#nomOdpe' + etapa).html('<strong>' + data.nomOdpe + '</strong>');
            }
        },
    });
}

/* ** CARGA AVANCE AGRUPACION ** */
function cargaAvanceAgrupacion(etapa) {
    var requestAvanceAgrupacion = new Object();
    requestAvanceAgrupacion["idProceso"] = $("#cboProceso").val();
    requestAvanceAgrupacion["idMaterial"] = $("#idMaterial").val();
    requestAvanceAgrupacion["idEtapa"] = $("#txtIdEtapa" + etapa).val();
    requestAvanceAgrupacion["idFase"] = $("#cbofase" + etapa).val();
    requestAvanceAgrupacion["idOdpe"] = $("#cboodpe" + etapa).val();
    requestAvanceAgrupacion["nomOdpe"] = $('#cboodpe' + etapa + ' option:selected').text();
    requestAvanceAgrupacion["validacion"] = $("#txtValidacion" + etapa).val();
    requestAvanceAgrupacion["nomEtapa"] = etapa;

    if ($("#txtIdEtapa" + etapa).val() == 1) {
        var nomEtapa = 'RECEPCIÖN';
    } else if ($("#txtIdEtapa" + etapa).val() == 2) {
        var nomEtapa = 'CONTROL DE CALIDAD';
        var nomEtapa = 'CONTROL DE CALIDAD';
    } else {
        var nomEtapa = 'EMPAQUETADO';
    }
    $.ajax({
        url: base_url + '/Control_cedula/getAvanceAgrupacion',
        type: "POST",
        dataType: 'json',
        data: requestAvanceAgrupacion,
        cache: false,
        success: function (data, textStatus, jqXHR) {
            if (jqXHR.status == 200) {
                $('#tbl_cedulaAvanceAgrupacion tbody').html(data.data);
                $('#nomOdpeAgrupacion').html('<strong>' + data.nomOdpe + '</strong>');
                $('#nomEtapaAgrupacion').html('<strong>' + nomEtapa + '</strong>');
            }
        },
    });
}

function closeAgrupacion() {
    $('#tbl_cedulaAvanceAgrupacion tbody').html('');
}

function verTotalAgrup(idAgrupacion, agrupacion, etapa, valor) {

    var requestTotalAgrupacion = new Object();
    requestTotalAgrupacion["idProceso"] = $("#cboProceso").val();
    requestTotalAgrupacion["idMaterial"] = $("#idMaterial").val();
    requestTotalAgrupacion["idEtapa"] = $("#txtIdEtapa" + etapa).val();
    requestTotalAgrupacion["idFase"] = $("#cbofase" + etapa).val();
    requestTotalAgrupacion["idSolucion"] = $("#cbosoltec" + etapa).val();
    requestTotalAgrupacion["idOdpe"] = $("#cboodpe" + etapa).val();
    requestTotalAgrupacion["nomOdpe"] = $('#cboodpe' + etapa + ' option:selected').text();
    requestTotalAgrupacion["validacion"] = $("#txtValidacion" + etapa).val();
    requestTotalAgrupacion["idAgrupacion"] = idAgrupacion;
    requestTotalAgrupacion["nomAgrupacion"] = agrupacion;
    requestTotalAgrupacion["idValor"] = valor;

    if ($("#txtIdEtapa" + etapa).val() == 1) {
        var nomEtapa = 'RECEPCIÖN';
    } else if ($("#txtIdEtapa" + etapa).val() == 2) {
        var nomEtapa = 'CONTROL DE CALIDAD';
    } else {
        var nomEtapa = 'EMPAQUETADO';
    }
    $.ajax({
        url: base_url + '/Control_cedula/getTotalAgrupacion',
        type: "POST",
        dataType: 'json',
        data: requestTotalAgrupacion,
        cache: false,

        success: function (data, textStatus, jqXHR) {
            // console.log(data);
            if (jqXHR.status == 200) {
                $('#modal_totalAgrupacion').modal('show');
                $('#tbl_cedulaTotalAgrupacion tbody').html(data.data);
                $('#titleTotalAgrupacion').html('<strong>' + data.nomAgrupacion + '</strong>');
                $('#nomOdpeTotalAgrupacion').html('<strong>' + data.nomOdpe + '</strong>');
                $('#nroTotalAgrupacion').html('<strong>' + data.cantidadMesa + ' MESAS</strong>');
                $('#nomEtapaTotalAgrupacion').html('<strong>' + nomEtapa + '</strong>');
            }
        },
    });
}

/* *** CARGA COD BARRAS ****** */
function selecMesa(etapa) {
    console.log('Se ingreso aqui!!!')
    if ($('#cboconsulta' + etapa).val() != "") {
        habilInpbarra(etapa);
        $('#btnIncid' + etapa).hide();
        $('#btnResetInput' + etapa).hide();

        var etapaControl = $('#txtIdEtapa' + etapa).val();
        var validacion = $("#txtValidacion" + etapa).val();
        var eleccionN = (eleccion == 1 || (eleccion == 2 && etapa == 'Empaque')) ? 1 : eleccion;
        // var eleccionN = eleccion;

        var requestConsulta = new Object();
        requestConsulta["idProceso"] = $("#cboProceso").val();
        requestConsulta["idSolucion"] = $("#cbosoltec" + etapa).val();
        requestConsulta["idOdpe"] = $("#cboodpe" + etapa).val();
        requestConsulta["idDepartamento"] = $("#cbodepart" + etapa).val();
        requestConsulta["idProvincia"] = $("#cboprov" + etapa).val();
        requestConsulta["idDistrito"] = $("#cbodist" + etapa).val();
        requestConsulta["idConsulta"] = $("#cboconsulta" + etapa).val();
        requestConsulta["idSobre"] = $("#cbosobre" + etapa).val();
        requestConsulta["idSufragio"] = $("#cbosufragio" + etapa).val();
        requestConsulta["idDocumento"] = $("#cbodocumento" + etapa).val();
        requestConsulta["idEleccion"] = eleccionN;

        $.ajax({
            url: base_url + '/Control_cedula/getBarra',
            type: "POST",
            dataType: 'json',
            data: requestConsulta,
            cache: false,
            success: function (data, textStatus, jqXHR) {
                console.log(data);
                if (jqXHR.status == 200) {
                    document.getElementById('mesa' + etapa).maxLength = data.data.cant_digito;
                    /*                    if (etapaControl == 3) {
                                            ordenEmpaquetado(etapa);
                                        }*/
                }
            },
        });
    } else {
        resetInpbarra(etapa);
    }
}

function ordenEmpaquetado(etapa) {

    var etapaControl = $('#txtIdEtapa' + etapa).val();
    var validacion = $("#txtValidacion" + etapa).val();
    var consulta = (eleccion == 2 && etapa == 'Empaque') ? $("#idConsulta" + etapa).val() : $("#cboconsulta" + etapa).val();
    var eleccionN = (eleccion == 1 || (eleccion == 2 && etapa == 'Empaque')) ? 1 : eleccion;
    // var eleccionN = eleccion;

    var requestOrdenEmpaquetado = new Object();
    requestOrdenEmpaquetado["idMaterial"] = $("#idMaterial").val();
    requestOrdenEmpaquetado["idProceso"] = $("#cboProceso").val();
    requestOrdenEmpaquetado["idFase"] = $("#cbofase" + etapa).val();
    requestOrdenEmpaquetado["idEtapa"] = $("#txtIdEtapa" + etapa).val();
    requestOrdenEmpaquetado["idSolucion"] = $("#cbosoltec" + etapa).val();
    requestOrdenEmpaquetado["idOdpe"] = $("#cboodpe" + etapa).val();
    requestOrdenEmpaquetado["idAgrupacion"] = $("#cboagrupacion" + etapa).val();
    requestOrdenEmpaquetado["idDepartamento"] = $("#cbodepart" + etapa).val();
    requestOrdenEmpaquetado["idProvincia"] = $("#cboprov" + etapa).val();
    requestOrdenEmpaquetado["idDistrito"] = $("#cbodist" + etapa).val();
    requestOrdenEmpaquetado["consulta"] = consulta;
    requestOrdenEmpaquetado["validacion"] = validacion;
    requestOrdenEmpaquetado["idEleccion"] = eleccion;
    requestOrdenEmpaquetado["etapa"] = etapa;

    //if(distrito != ''){
    $.ajax({
        url: base_url + '/Control_cedula/ordenEmpaquetado',
        type: "POST",
        dataType: 'json',
        data: requestOrdenEmpaquetado,
        cache: false,

        success: function (data, textStatus, jqXHR) {
            console.log(data);
            if (jqXHR.status == 200) {
                if (data.status) {
                    var html = '<div>' +
                        '<strong style= "font-size:16px;">ATENCI&Oacute;N!</strong> ' +
                        'La Mesa a Empaquetar es la N° <br><b style= "font-size:26px;">' + data.data.NRO_MESA + '</b><br>' +
                        'Departamento: <b style= "font-size:14px;">' + data.data.DEPARTAMENTO_UBI + '</b><br>' +
                        'Provincia: <b style= "font-size:14px;">' + data.data.PROVINCIA_UBI + '</b><br>' +
                        'Distrito: <b style= "font-size:14px;">' + data.data.DISTRITO_UBI + '</b><br>' +
                        'Local: <b style= "font-size:14px;">' + data.data.NOMBRE_LOCAL + '</b><br>';
                    html += (eleccion == 2) ?
                        'Consulta: <b style= "font-size:14px;">' + data.data.TIPO_CEDULA + '</b><br>' +
                        'Partido Político: <b style= "font-size:18px;">' + data.data.AGRUPACION + '</b><br></div>' : '</div>';
                    $('#msj_mesa_next').addClass('alert alert-outline-info').html(html).show();
                    if (eleccion == 2) {
                        document.getElementById('ubigeo' + etapa).maxLength = data.data.DIG_UBIGEO;
                        document.getElementById('rotulo' + etapa).maxLength = data.data.DIG_ROTULO;
                        $("#idConsultaEmpaque").val(data.data.SUF_ROTULO);
                    }
                    return false;
                } else {
                    $('#msj_mesa_next').addClass('alert alert-outline-info').html(html).hide();
                    swal({
                        title: data.title,
                        text: data.msg,
                        type: "success",
                        timer: 4000
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
    if (event.keyCode == 13) {
        document.getElementById("rotulo" + etapa).focus();
    }
}

/*INPUT ROTULO*/

function inpMesa(etapa) {
    console.log('Ingreso de mesa !!!');
    //var validar = $('#addControlCedula').click;
    if (event.keyCode == 13 || event.which == 13) {

        var validacion = $("#txtValidacion" + etapa).val();
        // var eleccionN = (eleccion == 1 || (eleccion == 2 && etapa == 'Empaque')) ? 1 : eleccion;
        // var eleccionV = eleccion;

        // var etapaControl = $('#txtIdEtapa' + etapa).val();

        var requestDocMesa = new Object();
        requestDocMesa["idProceso"] = $("#cboProceso").val();
        requestDocMesa["idSolucion"] = $("#cbosoltec" + etapa).val();
        requestDocMesa["idOdpe"] = $("#cboodpe" + etapa).val();
        requestDocMesa["idDepartamento"] = $("#cbodepart" + etapa).val();
        requestDocMesa["idProvincia"] = $("#cboprov" + etapa).val();
        requestDocMesa["idDistrito"] = $("#cbodist" + etapa).val();
        requestDocMesa["idConsulta"] = $("#cboconsulta" + etapa).val();
        requestDocMesa["idSobre"] = $("#cbosobre" + etapa).val();
        requestDocMesa["idSufragio"] = $("#cbosufragio" + etapa).val();
        requestDocMesa["idDocumento"] = $("#cbodocumento" + etapa).val();
        requestDocMesa["codMesa"] = $("#mesa" + etapa).val();

        requestDocMesa["validacion"] = validacion;
        $.ajax({
            url: base_url + '/Control_cedula/ingresarMesa',
            type: "POST",
            dataType: 'json',
            data: requestDocMesa,
            cache: false,
            success: function (data, textStatus, jqXHR) {
                // console.log(data);
                if (jqXHR.status == 200) {
                    if (!data.status) {
                        swal({
                            title: data.title,
                            text: data.msg,
                            type: "error",
                            timer: 4000
                        });
                        $('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');

                        if (data.valor == 0) {
                            inhabilitaEscbarra(etapa);

                        } else if (data.valor == 1) {
                            habilBtnValidar(etapa);
                            $("#txtValidacion" + etapa).val('2');
                            setTimeout(function () {
                                //$('#txtcargo').focus();
                                $('#archivo').trigger('click');
                            }, 500)

                        } else {
                            habilInpbarra(etapa);
                        }
                        return false;
                    } else {
                        if (data.valor == 3) {
                            $('#msj_' + etapa).removeClass('alert alert-outline-danger').removeClass('alert alert-outline-warning').addClass('alert alert-outline-success').html('<span class="alert-icon"><i class="zmdi zmdi-check-circle"></i></span><strong>Correcto!</strong> El Paquete de Cedulas ha sido Recepcionado').show(10).delay(4000).hide(10);
                            $('#btnIncid' + etapa).css("display", "none");
                            $('#btnResetInput' + etapa).css("display", "none");
                            // cargaAvanceFase(etapa);
                            // cargaAvanceOdpe(etapa);
                            /*cargaAvanceAgrupacion(etapa);*/

                            if (etapaControl == 1) {
                                habilInpbarra(etapa);
                            } else if (etapaControl == 2) {
                                habilBtnValidar(etapa);
                                $("#txtValidacion" + etapa).val('2');
                                setTimeout(function () {
                                    //$('#txtcargo').focus();
                                    $('#archivo').trigger('click');
                                }, 500)
                            } else {
                                ordenEmpaquetado(etapa);
                                habilInpbarra(etapa);
                            }
                        } else {
                            $('#msj_' + etapa).removeClass('alert alert-outline-danger').removeClass('alert alert-outline-warning').addClass('alert alert-outline-success').html('<span class="alert-icon"><i class="zmdi zmdi-check-circle"></i></span><strong>Correcto!</strong> El Paquete de Cedulas ha sido Validado').show(10).delay(4000).hide(10);
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
    }
}

function inpRotuloValidar(etapa) {

    var departamento = $("#cbodepart" + etapa).val();
    var provincia = $("#cboprov" + etapa).val();
    var distrito = $("#cbodist" + etapa).val();
    // var rotulo = $("#rotulo" + etapa).val().toUpperCase().trim();

    var cboubigeo = departamento + provincia + distrito;
    var validacion = $("#txtValidacion" + etapa).val();
    var consulta = (eleccion == 2 && etapa == 'Empaque') ? $("#idConsulta" + etapa).val() : $("#cboconsulta" + etapa).val();
    // var eleccionN = (eleccion == 1 || (eleccion == 2 && etapa == 'Empaque')) ? 1 : eleccion ;
    var eleccionN = eleccion;

    var requestCedula = new Object();
    requestCedula["idMaterial"] = $("#idMaterial").val();
    requestCedula["idProceso"] = $("#cboProceso").val();
    requestCedula["idEtapa"] = $("#txtIdEtapa" + etapa).val();
    requestCedula["idSolucion"] = $("#cbosoltec" + etapa).val();
    requestCedula["idOdpe"] = $("#cboodpe" + etapa).val();
    //requestCedula["mesa"]           = $('#txtMesaIncidencia').val();
    requestCedula["mesa"] = rotulo.substr(1, 6);
    requestCedula["consulta"] = consulta;
    requestCedula["cUbigeo"] = cboubigeo;
    requestCedula["validacion"] = validacion;

    if ($('#archivo').val() != '') {

        $("#archivo").upload(base_url + '/Control_cedula/importarTxt',
            {

                nombre_archivo: $("#archivo").val(), mesa: rotulo.substr(1, 6),

            },
            function (data, textStatus, jqXHR) {
                // if(jqXHR.status == 200){
                console.log(data);
                //Subida finalizada.
                // $("#barraProgreso").css('width','0%');

                if (data.status) {

                    //swal(data.title, data.msg, "success");
                    requestCedula["txtValidator"] = data.data;

                    $.ajax({

                        url: base_url + '/Control_cedula/validarCedula',
                        type: "POST",
                        dataType: 'json',
                        data: requestCedula,
                        cache: false,

                        success: function (data, textStatus, jqXHR) {

                            if (jqXHR.status == 200) {
                                if (!data.status) {

                                    swal({
                                        title: data.title,
                                        text: data.msg,
                                        type: "error",
                                        timer: 4000
                                    });

                                    if (data.valor == 0) {

                                        setTimeout(function () {
                                            //$('#txtcargo').focus();
                                            $('#archivo').trigger('click');
                                        }, 500)

                                    }

                                    $('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');

                                    return false;

                                } else {

                                    $('#msj_' + etapa).removeClass('alert alert-outline-danger').removeClass('alert alert-outline-warning').addClass('alert alert-outline-success').html('<span class="alert-icon"><i class="zmdi zmdi-check-circle"></i></span><strong>Correcto!</strong> El Paquete de Cedulas ha sido Validado').show(10).delay(4000).hide(10);
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

                } else {

                    swal(data.title, data.msg, "error");
                    $('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
                    return false;
                }
            },
            function (progreso, valor) {
                //Barra de progreso.
                //$("#barraProgreso").css('width',valor+'%');
                //$("#barraProgreso").html('Completado '+valor+'%')
            });
    } else {
        swal({
            title: 'CONTROL DE CEDULAS',
            text: 'No se ha cargado ningun archivo de validacion',
            type: "error",
            timer: 4000
            //$('#txtcargo').focus();
            //$('#archivo').trigger('click');
        });

        setTimeout(function () {
            //$('#txtcargo').focus();
            $('#archivo').trigger('click');
        }, 500)
        $('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
        return false;
    }

}

function enabledAvance(etapa) {
    if ($("#cboodpe" + etapa).val() != '') {
        $('#recibido' + etapa).attr({
            'onclick': 'resumenMesas("' + etapa + '", "RECIBIDAS", 1)',
            'href': '#modal_resumenEscaneadas'
        });
        $('#faltante' + etapa).attr({
            'onclick': 'resumenMesas("' + etapa + '", "FALTANTES", 2)',
            'href': '#modal_resumenFaltantes'
        });
        $('#agrupacion' + etapa).attr({
            'onclick': 'cargaAvanceAgrupacion("' + etapa + '")',
            'href': '#modal_resumenAgrupacion'
        });
        $('#update' + etapa).attr('disabled', false);
    } else {
        $('#recibido' + etapa).removeAttr("onclick href");
        $('#faltante' + etapa).removeAttr("onclick href");
        $('#agrupacion' + etapa).removeAttr("onclick href");
        $('#update' + etapa).attr('disabled', true);
    }
}

function resumenMesas(etapa, tipo, valor) {

    $('#titleMaterialResumen' + valor).html('<b>ETAPA DE ' + etapa.toUpperCase() + '</b>');
    $('#titleResumen' + valor).html('<b>MESAS ' + tipo + '</b>');

    var validacion = $("#txtValidacion" + etapa).val();
    var consulta = (eleccion == 2 && etapa == 'Empaque') ? $("#idConsulta" + etapa).val() : $("#cboconsulta" + etapa).val();

    var requestResumenMesas = new Object();
    requestResumenMesas["idMaterial"] = $("#idMaterial").val();
    requestResumenMesas["idProceso"] = $("#cboProceso").val();
    requestResumenMesas["idFase"] = $("#cbofase" + etapa).val();
    requestResumenMesas["idEtapa"] = $("#txtIdEtapa" + etapa).val();
    requestResumenMesas["idSolucion"] = $("#cbosoltec" + etapa).val();
    requestResumenMesas["idOdpe"] = $("#cboodpe" + etapa).val();
    requestResumenMesas["nomOdpe"] = $('#cboodpe' + etapa + ' option:selected').text();
    requestResumenMesas["consulta"] = consulta;
    requestResumenMesas["validacion"] = validacion;
    requestResumenMesas["eleccion"] = eleccion;

    $('#nomOdpeEscaneadas').html('<b>' + $('#cboodpe' + etapa + ' option:selected').text() + '</b>');
    $('#nomOdpeFaltantes').html('<b>' + $('#cboodpe' + etapa + ' option:selected').text() + '</b>');

    if (valor == 1) {
        var url = base_url + '/Control_cedula/mesasEscaneadas';
    } else {
        var url = base_url + '/Control_cedula/mesasFaltantes';
    }

    if (eleccion == 1) {
        var tableMesas = $('#tableMesas' + valor).DataTable({
            //"processing": true,
            //"serverSide": true,
            "destroy": true,
            "order": [],
            "language": {
                "url": base_url + '/Assets/js/es-pe.json'
            },
            "ajax": {
                "url": url,
                "type": "POST",
                "data": requestResumenMesas,
                "dataType": "json",
                "cache": false,
            },
            "columns": [
                {"data": "ORDEN"},
                {"data": "CODIGO_SOLUCION"},
                {"data": "DEPARTAMENTO_UBI"},
                {"data": "PROVINCIA_UBI"},
                {"data": "DISTRITO_UBI"},
                {"data": "NRO_MESA"},
                {"data": "NRO_ELECTORES"},
                {"data": "CONSULTA"},
            ],
            "resonsieve": "true",
            "dDestroy": true,
            "iDisplayLength": 10,
            /*"order": [[0,"asc"]],*/
            "columnDefs": [{
                "targets": [0],
                "orderable": false,
            },],
        });
    } else {
        var tableMesas = $('#tableMesas' + valor).DataTable({
            //"processing": true,
            //"serverSide": true,
            "destroy": true,
            "order": [],
            "language": {
                "url": base_url + '/Assets/js/es-pe.json'
            },
            "ajax": {
                "url": url,
                "type": "POST",
                "data": requestResumenMesas,
                "dataType": "json",
                "cache": false,
            },
            "columns": [
                {"data": "ORDEN"},
                {"data": "CODIGO_SOLUCION"},
                {"data": "DEPARTAMENTO_UBI"},
                {"data": "PROVINCIA_UBI"},
                {"data": "DISTRITO_UBI"},
                {"data": "NRO_MESA"},
                {"data": "NRO_ELECTORES"},
                {"data": "CONSULTA"},
                {"data": "AGRUPACION"},
            ],
            "resonsieve": "true",
            "dDestroy": true,
            "iDisplayLength": 10,
            /*"order": [[0,"asc"]],*/
            "columnDefs": [{
                "targets": [0],
                "orderable": false,
            },],
        });
    }
}

function modalIncidencia(etapa, id) {

    var idEtapa = $("#txtIdEtapa" + etapa).val();
    // $('#txtIDEtapa').val(id);

    $('#titleIncidencia').html('<b>INCIDENCIAS EN LA ETAPA DE ' + etapa.toUpperCase() + '</b>');
    $('#agregarIncidencia').attr('onclick', 'addIncidencia("' + etapa + '")');
    if (idEtapa == 2) {
        $('#divCantIncidencia').show();
    } else {
        $('#divCantIncidencia').hide();
    }
    var requestIncidenciaCbo = new Object();
    requestIncidenciaCbo["idEtapa"] = idEtapa;

    $.ajax({
        url: base_url + '/Control_cedula/getSelectIncidencia',
        type: "POST",
        // dataType: 'json',
        data: requestIncidenciaCbo,
        cache: false,

        success: function (data, textStatus, jqXHR) {
            // console.log(data);
            if (jqXHR.status == 200) {

                $('#cboIncidencia').selectpicker('destroy');
                $('#cboIncidencia').html(data).selectpicker('refresh');
            }
        },
    });
}

$("#cboIncidencia").on("change", function () {
    $('#cboIncidencia-error').hide();
    $('#errorincidencia').hide();
})

function cancelIncidencia(etapa) {
    //$('#sign_registerIncidencia')[0].reset();
    $('#sign_registerIncidencia').validate().resetForm();
    $('#sign_registerIncidencia .form-group').removeClass('has-success');
    $('#errorincidencia').hide();
    habilInpbarra(etapa);
}

function addIncidencia(etapa) { //alert(etapa)

    var departamento = $("#cbodepart" + etapa).val();
    var provincia = $("#cboprov" + etapa).val();
    var distrito = $("#cbodist" + etapa).val();

    var cboubigeo = departamento + provincia + distrito;
    var validacion = $("#txtValidacion" + etapa).val();
    var consulta = (eleccion == 2 && etapa == 'Empaque') ? $("#idConsulta" + etapa).val() : $("#cboconsulta" + etapa).val();
    // var eleccionN = (eleccion == 1 || (eleccion == 2 && etapa == 'Empaque')) ? 1 : eleccion ;
    var eleccionN = eleccion;

    var requestIncidencia = new Object();
    requestIncidencia["idMaterial"] = $("#idMaterial").val();
    requestIncidencia["idProceso"] = $("#cboProceso").val();
    requestIncidencia["idEtapa"] = $("#txtIdEtapa" + etapa).val();
    requestIncidencia["idOdpe"] = $("#cboodpe" + etapa).val();
    requestIncidencia["idIncidencia"] = $("#cboIncidencia").val();
    requestIncidencia["mesa"] = $('#txtMesaIncidencia').val();
    requestIncidencia["cantidad"] = $('#txtCantIncidencia').val();
    requestIncidencia["consulta"] = consulta;
    requestIncidencia["cUbigeo"] = cboubigeo;
    requestIncidencia["validacion"] = validacion;

    //var mesa = rotulo.substr(0, 6); //alert(mesa);

    if ($("#cboIncidencia").val().length != 0) {

        $.ajax({
            url: base_url + '/Control_cedula/setIncidencia',
            type: "POST",
            dataType: 'json',
            data: requestIncidencia,
            cache: false,
            success: function (data, textStatus, jqXHR) {
                console.log(data);
                if (jqXHR.status == 200) {

                    if (data.status) {
                        /*console.log(textStatus);
                          console.log(jqXHR.status);*/
                        swal({
                                title: data.title,
                                text: data.msg,
                                type: "success"
                            },
                            function () {
                                setTimeout(function () {
                                    $('#btnIncid' + etapa).css("display", "none");
                                    $('#btnResetInput' + etapa).css("display", "none");
                                    habilInpbarra(etapa);
                                    $('#modal_incidencia').modal('hide');
                                    $("#mesa" + etapa).focus();
                                }, 10)
                            });
                        $('.confirm').removeClass('btn btn-danger').removeClass('btn btn-warning').addClass('btn btn-success');
                        return false;

                    } else {
                        swal({
                                title: data.title,
                                text: data.msg,
                                type: "error"
                            },
                            function () {
                                setTimeout(function () {
                                    //$('#txtcargo').focus();
                                }, 10)
                            });
                        $('.confirm').removeClass('btn btn-success').removeClass('btn btn-warning').addClass('btn btn-danger');
                        return false;
                    }
                }
            },
        });
    } else {
        $('#errorincidencia').html('Este campo es obligatorio.').show();
    }
    return false;
};


