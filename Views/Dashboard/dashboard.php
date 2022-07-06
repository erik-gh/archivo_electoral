<!DOCTYPE html>
<html lang="es">
   <!-- HEAD --> 
  <?php headAdmin($data); ?>
  <body class="layout layout-header-fixed layout-left-sidebar-fixed">
    <div class="site-overlay"></div>
    <div class="site-header">
      <!-- HEADER -->
      <?php headerAdmin($data); ?>
    </div>
    <div class="site-main">
      <div class="site-left-sidebar">
        <!-- SIDEBAR MENU -->
        <?php sidebarAdmin($data); ?>
      </div>
      <div class="site-content">
        <div class="panel panel-default panel-table">
          <div class="panel-heading">
            <h3 class="m-y-0 text-danger text-center font-18"><b><?= $data['page_title'] ?></b></h3>
          </div>
          
          <div class="panel-body p-b-0">
            <div class="row m-b-30">
              <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="form-group">
                  <div class="input-group-prepend">
                    <select class="form-control" name="cboProceso" id="cboProceso" data-dropup-auto="false" data-live-search="true" data-size="6" onchange="cboProcesoCarga()" data-serach-live="true">
                          <option value="">[ SELECCIONE PROCESO ]</option>
                    </select>                                           
                    <!-- <div class="help-block with-errors">gtgtg</div> -->
                  </div>                                    
                </div>
              </div>
            </div>

            <h3 class="panel-title text-success text-center"><B>RESUMEN GENERAL</B></h3><br>
            <div class="panel-subtitle text-center">INFORMACI&Oacute;N GENERALES</div><br>

            <div id="tbl_resumenDetalleGeneral">
              <div class="widget-statistics">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6">
                        <div class="ws-item m-b-30">
                            <div class="wsi-icon bg-success">
                                <i class="zmdi zmdi-receipt"></i>
                            </div>
                            <h4 class="m-b-0" id="cantSoltec">0</h4>
                            <p class="text-muted">SOL. TECNOL.</p>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6">
                        <div class="ws-item m-b-30">
                            <div class="wsi-icon bg-warning">
                                <i class="zmdi zmdi-apps"></i>
                            </div>
                            <h4 class="m-b-0" id="cantOdpe">0</h4>
                            <p class="text-muted">ODPEs</p>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6">
                        <div class="ws-item m-b-30">
                            <div class="wsi-icon bg-danger">
                                <i class="zmdi zmdi-city"></i>
                            </div>
                            <h4 class="m-b-0" id="cantDistrito">0</h4>
                            <p class="text-muted">DISTRITOS</p>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6">
                        <div class="ws-item m-b-30">
                            <div class="wsi-icon bg-info">
                                <i class="zmdi zmdi-home"></i>
                            </div>
                            <h4 class="m-b-0" id="cantLocal">0</h4>
                            <p class="text-muted">LOCALES</p>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6">
                        <div class="ws-item m-b-30">
                            <div class="wsi-icon bg-success">
                                <i class="zmdi zmdi-tablet"></i>
                            </div>
                            <h4 class="m-b-0" id="cantMesas">0</h4>
                            <p class="text-muted">MESAS</p>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6">
                        <div class="ws-item m-b-30">
                            <div class="wsi-icon bg-primary">
                                <i class="zmdi zmdi-accounts-alt"></i>
                            </div>
                            <h4 class="m-b-0" id="cantElectores">0</h4>
                            <p class="text-muted">ELECTORES H&Aacute;BILES</p>
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
          <div class="flot-chart-example" style="height: 50px"></div>
        </div>
        <div class="row">
          <div class="col-md-7">
            <div class="panel panel-default panel-table">
              <div class="panel-heading">
                <!--<div class="panel-tools">
                  <a href="#" class="tools-icon">
                    <i class="zmdi zmdi-refresh"></i>
                  </a>
                  <a href="#" class="tools-icon">
                    <i class="zmdi zmdi-close"></i>
                  </a>
                </div>-->
                <h3 class="panel-title text-center"><b>RESUMEN POR ODPE</b></h3><br>
                <div class="panel-subtitle text-center">INFORMACI&Oacute;N</div>
              </div>
              <div class="panel-body">
                <div class="table-responsive">
                  <div id="tbl_resumenDetalleODPE" class="dataTables_wrapper form-inline" role="grid">
                      <table id="tableResumenOdpe" class="display table table-bordered table-hover" cellspacing="0" width="100%">
                        <thead class="text-center font-table">
                            <tr class="bg-primary">
                                <th class="text-center" width="15%">Nº</th>
                                <th class="text-center" width="25%">ODPE</th>
                                <th class="text-center" width="15%">DISTRITOS</th>
                                <th class="text-center" width="15%">LOCALES</th>
                                <th class="text-center" width="15%">MESAS</th>
                                <th class="text-center" width="15%">ELECTORES</th>
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
          <div class="col-md-5">
            <div class="panel panel-default panel-table">
              <div class="panel-heading">
                <!--<div class="panel-tools">
                  <a href="#" class="tools-icon">
                    <i class="zmdi zmdi-refresh"></i>
                  </a>
                  <a href="#" class="tools-icon">
                    <i class="zmdi zmdi-close"></i>
                  </a>
                </div>-->
                <h3 class="panel-title text-center"><b>SOLUCIONES TECNOL&Oacute;GICAS</b></h3><br>
                <div class="panel-subtitle text-center">INFORMACI&Oacute;N</div>
              </div>
              <div class="panel-body">
                <div class="panel-body">
                  <div class="table-responsive">
                    <div id="tbl_resumenDetalleSOLTEC" class="dataTables_wrapper form-inline" role="grid">

                      <div id="container" style="min-width: 310px; height: 430px; max-width: 600px; margin: 0 auto"></div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal PASSWORD -->
        <div class="modal fade" id="modal_newpass" role="dialog" data-keyboard="false" data-backdrop="static" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="zmdi zmdi-close"></i>
                  </span>
                </button> -->
                <h4 id="title" class="modal-title text-center text-primary font-16"><b>CAMBIAR CONTRASE&Ntilde;A</b></h4>
              </div>
              <div class="modal-body">
                <div class="col-lg-1"></div>
                <div class="col-lg-10">
                  <form class="form-horizontal" id="form_updatePassword" method="POST" autocomplete="off" >
                    <input class="form-control" type="hidden" id="txtIDpass" name="txtIDpass">
                    <input class="form-control" type="hidden" id="txtcontrolpass" name="txtcontrolpass" value="2">
                    <div class="panel ">
                      <div class="panel-body">
                        <div class="row">
                          <!--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                              <label>Contrase&ntilde;a Actual</label>
                              <div class="input-group-prepend">
                                <input type="password" class="form-control vld" name="txtpassword" id="txtpassword" required/>
                              </div>
                            </div>
                          </div>-->
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                              <label>Nueva Contrase&ntilde;a</label>
                              <div class="input-group-prepend">
                                <input type="password" class="form-control vld" name="txtnewpassword" id="txtnewpassword" required/>
                              </div>
                            </div>
                          </div>                       
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                              <label>Repetir Contrase&ntilde;a</label>
                              <div class="input-group-prepend">
                                <input type="password" class="form-control vld" name="txtnewpassword2" id="txtnewpassword2" required/>
                              </div>
                            </div>
                          </div>                         
                          <label class="custom-control custom-control-primary custom-checkbox active">
                            <input id="view_checkbox_newpass" class="custom-control-input" type="checkbox" name="custom" onclick="mostrarContrasenanueva();">
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-label">Mostrar Contrase&ntilde;a</span>
                          </label>
                        </div>
                        <div class="row clearfix m-t-30">
                          <div class="pull-right">
                            <button type="submit" class="btn btn-outline-primary" id="updatePass"><i class="zmdi zmdi-refresh zmdi-hc-fw m-r-5"></i><span>Guardar</span></button>
                            <!--<a class="btn btn-outline-danger" data-dismiss="modal" id="cancelPpass" onclick="cancelPass();"><i class="zmdi zmdi-close zmdi-hc-fw m-r-5"></i><span>Cerrar</span></a>-->
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
        <!-- #END# MODAL PASSWORD -->

      </div>
      <div class="site-footer">
        2021 © Sistema
      </div>
    </div>
    
    <!-- FOOTER -->
    <?php footerAdmin($data); ?>
    <script type="text/javascript">
      <?php if ($data['request_password'] == 0){ ?>
        $('#modal_newpass').modal('show');
      <?php } ?>
    </script>
    <script src="<?= media();?>/js/Highcharts/code/highcharts.js"></script>
    <script src="<?= media();?>/js/Highcharts/code/modules/exporting.js"></script>
    <script src="<?= media();?>/js/Highcharts/code/modules/export-data.js"></script>
    
  </body>

<!-- Mirrored from big-bang-studio.com/cosmos/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 10 Jan 2019 12:53:30 GMT -->
</html>