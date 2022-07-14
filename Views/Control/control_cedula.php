<!DOCTYPE html>
<html lang="es">
<head>
</head>
<div class="panel-body">
    <div class="row">
        <input type="hidden" class="form-control input-sm" id="idMaterial" value="1">
        <div class="col-md-12">
            <ul class="nav nav-tabs nav-tabs-custom m-b-15">
                <li class="active">
                    <a href="#tab-recepcion_cedula" role="tab" data-toggle="tab" aria-expanded="true" onClick="cargaCbo('Recepcion')">
                        <i class="zmdi zmdi-assignment-check"></i> RECEPCI&Oacute;N</a>
                </li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade active in" id="tab-recepcion_cedula">
                    <div class="row">
                        <div class="col-md-5 col-sm-5">
                            <div class="panel panel-default panel-table m-b-0">
                                <div class="panel-heading">
                                    <h4 class="text-center text-info font-12" id="titleProceso"><strong>RECEPCI&Oacute;N DE DOCUMENTOS</strong></h4>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <form class="form-horizontal" id="sign_addRecepcionCedula" method="POST" autocomplete="off" action="javascript:void(0);">
                                                <input class="form-control" type="hidden" id="txtIDUsuarioRecepcion" name="txtIDUsuarioRecepcion">
                                                <input class="form-control" type="hidden" id="txtIdEtapaRecepcion" name="txtIdEtapaRecepcion" value="1">
                                                <input class="form-control" type="hidden" id="txtValidacionRecepcion" name="txtValidacionRecepcion" value="1">
                                                <!-- Aqui se debe de modificar -->
                                                <div class="form-group form-group-sm">
                                                    <label class="col-sm-4 control-label" for="form-control-1">FASE</label>
                                                    <div class="col-sm-8 z-9">
                                                        <select class="form-control" name="cbofaseRecepcion" id="cbofaseRecepcion" data-dropup-auto="false" data-size="6"
                                                                data-live-search="true" onChange="cboSolucionTecnologica('Recepcion');" required>
                                                            <option value="">[ SELECCIONE UNA FASE ]</option>
                                                            <option value="1">SUFRAGIO</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group form-group-sm">
                                                    <label class="col-sm-4 control-label" for="form-control-1">SOLUCI&Oacute;N TECNOL&Oacute;G.</label>
                                                    <div class="col-sm-8 z-8">
                                                        <select class="form-control" name="cbosoltecRecepcion" id="cbosoltecRecepcion" data-dropup-auto="false"
                                                                data-size="6" data-live-search="true" onChange="cboOdpe('Recepcion');" required>
                                                            <option value="">[ SELECCIONE UNA SOL. TECN. ]</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group form-group-sm">
                                                    <label class="col-sm-4 control-label" for="form-control-1">ODPE</label>
                                                    <div class="col-sm-8 z-7">
                                                        <select class="form-control" name="cboodpeRecepcion" id="cboodpeRecepcion" data-dropup-auto="false" data-size="6"
                                                                data-live-search="true" onChange="cboDepartamento('Recepcion');" required>
                                                            <option value="">[ SELECCIONE UNA ODPE ]</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- Aqui se debe de modificar de agrupacion politica a Consulta-->
                                                <div class="form-group form-group-sm">
                                                    <label class="col-sm-4 control-label" for="form-control-1">CONSULTA</label>
                                                    <div class="col-sm-8 z-6">
                                                        <select class="form-control" name="cboagrupacionRecepcion" id="cboagrupacionRecepcion" data-dropup-auto="false"
                                                                data-size="6" data-live-search="true" onChange="cboAgrupacionCedula('Recepcion');" required>
                                                            <option value="">[ SELECCIONE UNA CONSULTA ]</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group form-group-sm">
                                                    <label class="col-sm-4 control-label" for="form-control-1">DEPARTAMENTO</label>
                                                    <div class="col-sm-8 z-5">
                                                        <select class="form-control" name="cbodepartRecepcion" id="cbodepartRecepcion" data-dropup-auto="false"
                                                                data-size="6" data-live-search="true" onChange="cboProvinciaCedula('Recepcion');" required>
                                                            <option value="">[ SELECCIONE UN DEPARTAMENTO ]</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group form-group-sm">
                                                    <label class="col-sm-4 control-label" for="form-control-1">PROVINCIA</label>
                                                    <div class="col-sm-8 z-4">
                                                        <select class="form-control" name="cboprovRecepcion" id="cboprovRecepcion" data-dropup-auto="false"
                                                                data-size="6" data-live-search="true" onChange="cboDistritoCedula('Recepcion')" required>
                                                            <option value="">[ SELECCIONE UNA PROVINCIA ]</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group form-group-sm">
                                                    <label class="col-sm-4 control-label" for="form-control-1">DISTRITO</label>
                                                    <div class="col-sm-8 z-3">
                                                        <select class="form-control" name="cbodistRecepcion" id="cbodistRecepcion" data-dropup-auto="false"
                                                                data-size="6" data-live-search="true" onChange="cboConsultaCedula('Recepcion')" required>
                                                            <option value="">[ SELECCIONE UN DISTRITO ]</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- Aqui se edita de cedula a Tipo sobre -->
                                                <div class="form-group form-group-sm">
                                                    <label class="col-sm-4 control-label" for="form-control-1">TIPO SOBRE</label>
                                                    <div class="col-sm-8 z-2">
                                                        <select class="form-control" name="cboconsultaRecepcion" id="cboconsultaRecepcion" data-size="6"
                                                                data-dropup-auto="false" data-live-search="true" onChange="selTipoDocumento('Recepcion');" required>
                                                            <option value="">[ SELECCIONE TIPO DE SOBRE ]</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- Aqui se editar de UBIGEO a DOCUMENTO -->
                                                <div class="form-group form-group-sm">
                                                    <label class="col-sm-4 control-label" for="form-control-14">TIPO DOCUMENTO</label>
                                                    <div class="col-sm-8 z-2">
                                                        <select class="form-control" name="cboconsultaDocumento" id="cboconsultaDocumento" data-size="6"
                                                                data-dropup-auto="false" data-live-search="true" onChange="selTipoCedula('Recepcion');" required>
                                                            <option value="">[ SELECCIONE TIPO DE DOCUMENTO ]</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- Aqui se editar de ROUTULO a NUMERO DE MESA -->
                                                <div class="form-group form-group-sm">
                                                    <label class="col-sm-4 control-label" for="form-control-14">N. MESA</label>
                                                    <div class="col-sm-8">
                                                        <input id="rotuloRecepcion" name="rotuloRecepcion" class="form-control" type="text"
                                                               placeholder="C&oacute;digo de Barras numero de Mesa" style="text-transform: uppercase;" disabled
                                                               onKeyPress="inpRotulo('Recepcion');">
                                                    </div>
                                                </div>
                                                <input type="hidden" id="idConsultaRecepcion">
                                                <div class="form-group form-group-sm">
                                                    <div class="col-sm-12 text-right">
                                                        <button class="btn bg-success btn-sm" id="btnResetInputRecepcion" type="button"
                                                                style="display: none;" onclick="resetInput('Recepcion')">
                                                            <i class="zmdi zmdi-minus-circle-outline zmdi-hc-fw m-r-5"></i><span> LIMPIAR</span>
                                                        </button>
                                                        <a class="btn bg-danger btn-sm" href="#modal_incidencia" id="btnIncidRecepcion" data-toggle="modal"
                                                           style="display: none;" onClick="modalIncidencia('Recepcion',1)">
                                                            <i class="zmdi zmdi-info-outline zmdi-hc-fw m-r-5"></i><span> INCIDENCIA</span></a>
                                                    </div>
                                                </div>
                                                <div class="col-sm-offset-1 col-sm-11 text-center m-t-20">
                                                    <div id="msj_Recepcion"></div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Panel de los cuadros de avances -->
                        <div class="col-md-7 col-sm-7">
                            <div class="panel panel-default panel-table m-b-0">
                                <div class="panel-heading">
                                    <h4 class="text-center text-info font-12"><strong>AVANCE GENERAL DE RECEPCI&Oacute;N DOCUMENTOS</strong></h4>
                                </div>
                                <div class="panel-body">
                                    <h4 class="">AVANCE GENERAL POR SOLUCION TECNOLOGICA</h4>
                                    <div class="table-responsive">
                                        <div class="clearfix">
                                            <div class="pull-right">
                                                <a class="btn btn-blue btn-sm" data-dismiss="modal" id="updateRecepcion"
                                                   onclick="cargaAvanceFase('Recepcion'); cargaAvanceOdpe('Recepcion')" disabled>
                                                    <i class="zmdi zmdi-refresh zmdi-hc-fw"></i><span></span></a>
                                            </div>
                                        </div>
                                        <div id="tbl_cedulaAvanceFaseRecepcion" class="dataTables_wrapper form-inline" role="grid">
                                            FASE: <span id="nomFaseRecepcion"></span><br><br>
                                            <table id="tbl_cedulaRecepcionAvanceFase" class="display table table-bordered table-hover" cellspacing="0" width="100%">
                                                <thead class="text-center font-table">
                                                <tr class="text-primary">
                                                    <th class="text-center" width="15%"></th>
                                                    <th class="text-center" width="15%">TOTAL</th>
                                                    <th class="text-center" width="15%">RECIBIDAS</th>
                                                    <th class="text-center" width="15%">POR RECIBIR</th>
                                                    <th class="text-center" width="20%">% RECIBIDOS</th>
                                                    <th class="text-center" width="20%">% POR RECIBIR</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr class="text-center font-table">
                                                    <td>MESAS</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>0 %</td>
                                                    <td>0 %</td>
                                                </tr>
                                                <tr class="text-center font-table">
                                                    <td>PAQUETES</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>0 %</td>
                                                    <td>0 %</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <h4 class="">AVANCE GENERAL POR ODPE</h4>
                                    <div class="table-responsive">
                                        <div class="clearfix">
                                            <div class="pull-right">
                                                <a class="btn btn-black btn-sm" data-dismiss="modal" id="recibidoRecepcion" data-toggle="modal" onclick="">
                                                    <i class="zmdi zmdi-view-compact zmdi-hc-fw m-r-5"></i><span> RECIBIDOS</span></a>
                                                <a class="btn btn-purple btn-sm" data-dismiss="modal" id="faltanteRecepcion" data-toggle="modal" onclick="">
                                                    <i class="zmdi zmdi-view-dashboard zmdi-hc-fw m-r-5"></i><span> FALTANTES</span></a>
                                                <span id="divAvanceAgrupRecepcion" style="display: none">
			                                       		<a class="btn btn-success btn-sm" data-dismiss="modal" id="agrupacionRecepcion" data-toggle="modal" onclick="">
                                                            <i class="zmdi zmdi-view-dashboard zmdi-hc-fw m-r-5"></i><span> POR AGRUPACION</span></a>
                                                </span>
                                            </div>
                                        </div>
                                        <div id="tbl_cedulaAvanceOdpeRecepcion" class="dataTables_wrapper form-inline" role="grid">ODPE: <span id="nomOdpeRecepcion"></span><br><br>
                                            <table id="tbl_cedulaRecepcionAvanceOdpe" class="display table table-bordered table-hover" cellspacing="0" width="100%">
                                                <thead class="text-center font-table">
                                                <tr class="text-primary">
                                                    <th class="text-center" width="14%">SOL. TEC.</th>
                                                    <th class="text-center" width="14%">TOTAL MESAS</th>
                                                    <th class="text-center" width="14%">TOTAL PAQUETES</th>
                                                    <th class="text-center" width="14%">RECIBIDAS</th>
                                                    <th class="text-center" width="14%">POR RECIBIR</th>
                                                    <th class="text-center" width="15%">% RECIBIDOS</th>
                                                    <th class="text-center" width="15%">% POR RECIBIR</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <!--<tr class="text-center font-table">
                                                    <td>--</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>% 0</td>
                                                    <td>% 0</td>
                                                </tr>-->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= media(); ?>/functions/<?= $data['page_function_js'] ?>"></script>
<!--<script type="text/javascript" src="js/control_cedula.js"></script>-->
</html>