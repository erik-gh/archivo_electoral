<!DOCTYPE html>
<html lang="es">
  
  <?php headAdmin($data); ?>
  <body class="layout layout-header-fixed layout-left-sidebar-fixed">
    <div class="site-overlay"></div>
    <div class="site-header">
      
      <?php headerAdmin($data); ?>
    </div>
    <div class="site-main">
      <div class="site-left-sidebar">

        <?php sidebarAdmin($data); ?>
      </div>
      <div class="site-content">

        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="m-y-0 text-danger text-center font-18"><b><?= $data['page_title'] ?></b></h3>
          </div>
          <div class="panel-body">
            <div class="row">
              
              <div class="col-md-12">
                <ul class="nav nav-tabs nav-tabs-custom m-b-15">
                  <li class="active">
                    <a href="#tab-Listaincidencia" role="tab" data-toggle="tab" aria-expanded="true">
                      <i class="zmdi zmdi-assignment-check"></i> LSTA DE INCIDENCIAS</a>
                  </li>
                  <!--<li class="">
                    <a href="#tab-incidencia" role="tab" data-toggle="tab" aria-expanded="false">
                      <i class="zmdi zmdi-account-add"></i> AGREGAR INCIDENCIA</a>
                  </li>-->
                </ul>

                <div class="tab-content">
                  <div role="tabpanel" class="tab-pane fade active in" id="tab-Listaincidencia">
                    <div class="row">
                      <div class="col-md-3 col-sm-3">
                        <div class="panel panel-default panel-table m-b-0">
                          <div class="panel-heading">
                            <h4 class="text-center text-primary font-12" id="titleProceso"><strong>CONTROL DE INCIDENCIAS</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="row">
                              <!-- <div class="col-lg-1"></div> -->
                              <div class="col-lg-12">
                                <form class="form" id="sign_registerProceso" method="POST" autocomplete="off" action="javascript:void(0);">
                                  <input class="form-control" type="hidden" id="txtIDProceso" name="txtIDProceso">
                                  <input class="form-control" type="hidden" id="txtcontrolProceso" name="txtcontrolProceso" value="0">
                                  <div class="panel panel-default">
                                    <div class="panel-body">
                                      <!-- <h5 class="text-blue-grey m-b-15"><strong>DATOS PERSONALES</strong></h5> -->
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 z-8">
                                          <div class="form-group">
                                            <label>Proceso</label>
                                            <select class="form-control" name="cboProcesoInc" id="cboProcesoInc" data-dropup-auto="false" data-size="10" data-live-search="true" onChange="cboMaterial();" required>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 z-7">
                                          <div class="form-group">
                                            <label>Material</label>
                                            <select class="form-control" name="cboMaterialInc" id="cboMaterialInc" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboEtapa();" required>
                                            <option value="">[ SELECCIONE MATERIAL ]</option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 z-6">
                                          <div class="form-group">
                                            <label>Etapa</label>
                                            <select class="form-control" name="cboEtapaInc" id="cboEtapaInc" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboListaIncid();" required>
                                              <option value="">[ SELECCIONE ETAPA ]</option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </form>
                              </div>
                              <!-- <div class="col-lg-1"></div> -->
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-9 col-sm-9">
                        <div class="panel panel-default panel-table m-b-0">
                          <div class="panel-heading">
                            <h4 class="text-center text-primary font-12"><strong>LISTA DE INCIDENCIAS</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="table-responsive">
                              <div id="tbl_incidencia" class="dataTables_wrapper form-inline" role="grid">
                                <table id="tableIncidencia" class="display table table-bordered table-hover" cellspacing="0" width="100%">
                                  <thead class="text-center font-table">
                                    <tr class="bg-primary">
                                      <th class="text-center" width="5%">Nº</th>
                                      <th class="text-center" width="10%">SOL. TEC.</th>
                                      <th class="text-center" width="10%">ODPE</th>
                                      <th class="text-center" width="8%">MESA</th>
                                      <th class="text-center" width="14%">INCIDENCIA</th>
                                      <th class="text-center" width="14%">ODPE INCIDENCIA</th>
                                      <th class="text-center" width="15%">USUARIO</th>
                                      <th class="text-center" width="12%">F. INCIDENCIA</th>
                                      <th class="text-center" width="9%">ESTADO</th>
                                      <th class="text-center" width="5%">ACCI&Oacute;N</th>
                                    </tr>
                                  </thead>
                                  <tbody class="text-center font-table">

                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div role="tabpanel" class="tab-pane fade" id="tab-incidencia"> 
                    <div class="row">
                      <div class="col-md-4 col-sm-4">
                        <div class="panel panel-default panel-table m-b-0">
                          <div class="panel-heading">
                            <h4 class="text-center text-primary font-12" id="titleIncidencia"><strong>REGISTRAR INCIDENCIA</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="row">
                              <!-- <div class="col-lg-1"></div> -->
                              <div class="col-lg-12">
                                <form class="form" id="sign_registerIncidencia" method="POST" autocomplete="off" action="javascript:void(0);">
                                  <input class="form-control" type="hidden" id="txtIDIncidencia" name="txtIDIncidencia">
                                  <input class="form-control" type="hidden" id="txtcontrolIncidencia" name="txtcontrolIncidencia" value="0">
                                  <div class="panel panel-default">
                                    <div class="panel-body">
                                      <!-- <h5 class="text-blue-grey m-b-15"><strong>DATOS PERSONALES</strong></h5> -->
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="form-group">
                                            <label>Incidencia</label>
                                            <input class="form-control vld" type="text" id="txtIncidencia" name="txtIncidencia" required>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="form-group">
                                            <label>Descricpci&oacute;n</label>
                                            <input class="form-control vld" type="text" id="txtdescripcionIncidencia" name="txtdescripcionIncidencia" required>
                                          </div>
                                        </div>
                                      </div>
                                      <!-- <h5 class="text-blue-grey m-b-15"><strong>DATOS DEL USUARIO</strong></h5> -->
                                      <div class="row" id="estado_Incidencia" style="display: none;">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="switches-stacked">
                                            <label>Activo</label>
                                            <label class="switch switch-primary">  
                                              <input type="checkbox" id="chkestadoIncidencia" name="chkestadoIncidencia" class="s-input">
                                              <span class="s-content">
                                                <span class="s-track"></span>
                                                <span class="s-handle"></span>
                                              </span>
                                            </label>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="clearfix m-t-30">
                                        <div class="pull-right">
                                          <button type="submit" class="btn btn-outline-primary" id="agregarIncidencia"><i class="zmdi zmdi-check zmdi-hc-fw m-r-5"></i><span> Guardar</span></button>
                                          <button type="submit" class="btn btn-outline-primary" id="updateIncidencia" style="display: none;"><i class="zmdi zmdi-refresh zmdi-hc-fw m-r-5"></i><span> Actualizar</span></button>
                                          <a class="btn btn-outline-danger" data-dismiss="modal" id="cancelIncidencia" onclick="cancelIncidencia();"><i class="zmdi zmdi-close zmdi-hc-fw m-r-5"></i><span>Cancelar</span></a>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </form>
                              </div>
                              <!-- <div class="col-lg-1"></div> -->
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-8 col-sm-8">
                        <div class="panel panel-default panel-table m-b-0">
                          <div class="panel-heading">
                            <h4 class="text-center text-primary font-12"><strong>LISTA DE INCIDENCIAS ELECTORALES</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="table-responsive">
                              <div id="tbl_Incidencia" class="dataTables_wrapper form-inline" role="grid">
                                  <!--<table id="tbl_usuariolista" class="display table table-bordered table-hover" cellspacing="0" width="100%">
                                                                        
                                  </table>-->
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
        </div>

        <!-- Modal Incidencia -->
        <div class="modal fade" id="modal_incidencia" role="dialog" data-keyboard="false" data-backdrop="static" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="zmdi zmdi-close"></i>
                  </span>
                </button>
                <h4 class="modal-title text-center text-primary" id="titleIncidenciaControl"></h4>
              </div>
              <div class="modal-body">
                <div class="col-lg-1"></div>
                <div class="col-lg-10">
                  <form class="form-horizontal" id="form_registerCtrlIncidencia" method="POST" autocomplete="off" >
                    <input class="form-control" type="hidden" id="txtCtrlIDIncidencia" name="txtCtrlIDIncidencia">
                    <input class="form-control" type="hidden" id="txtcontrolCtrlIncidencia" name="txtcontrolCtrlIncidencia" value="0">
                    <div class="panel ">
                      <div class="panel-body">
                        <div class="row">
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                              <label>Mesa</label>
                              <input type="text" class="form-control vld" name="txtMesaIncidencia" id="txtMesaIncidencia" required/>
                            </div>
                          </div>                       
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                              <label>Incidencia</label>
                              <input type="text" class="form-control vld" name="txtdescripIncidencia" id="txtdescripIncidencia" required/>
                            </div>
                          </div>
                           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="divCantIncidencia">
                            <div class="form-group">
                              <label>Cantidad</label>
                              <input type="text" class="form-control vld" name="txtCantIncidencia" id="txtCantIncidencia" required/>
                            </div>
                          </div>
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 z-8">
                            <div class="form-group">
                              <label>Estado</label>
                              <select class="form-control" name="cboEstadoIncidencia" id="cboEstadoIncidencia" data-dropup-auto="false" data-size="10" data-live-search="true" required>
                                <option value="">[ SELECCIONE ESTADO ]</option>
                                <option value="1">NO RESUELTO</option>
                                <option value="2">EN PROCESO</option>
                                <option value="3">RESUELTO</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                              <label>Observaci&oacute;n</label>
                              <textarea class="form-control rounded-0 vld" id="txtObservacionIncidencia" name="txtObservacionIncidencia" rows="4" required style="text-align: justify; text-transform: uppercase;"></textarea>                            
                            </div>
                          </div>
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="obsrv_2">
                            <div class="form-group">
                              <label>Observaci&oacute;n</label>
                              <textarea class="form-control rounded-0" id="txtObservacion2Incidencia" name="txtObservacion2Incidencia" rows="4" required style="text-align: justify; text-transform: uppercase;"></textarea>                            
                            </div>
                          </div>                
                        </div>
                        <div class="row clearfix m-t-30">
                          <div class="pull-right">
                            <button type="submit" class="btn btn-outline-primary" id="updateCtrlIncidencia"><i class="zmdi zmdi-refresh zmdi-hc-fw m-r-5"></i><span>Guardar</span></button>
                            <a class="btn btn-outline-danger" data-dismiss="modal" id="cancelCtrlIncidencia" onclick="cancelIncidencia();"><i class="zmdi zmdi-close zmdi-hc-fw m-r-5"></i><span>Cerrar</span></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="col-lg-1"></div>
              </div>
              <div class="modal-footer"></div>
            </div>
          </div>
        </div>
        <!-- #END# Modal Incidencia -->

      </div>
      <div class="site-footer">
        2019 © Sistema
      </div>
    </div>
    
    <!-- FOOTER -->
    <?php footerAdmin($data); ?>
  </body>

<!-- Mirrored from big-bang-studio.com/cosmos/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 10 Jan 2019 12:53:30 GMT -->
</html>