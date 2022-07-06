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
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="m-y-0 text-danger text-center font-18"><b><?= $data['page_title'] ?></b></h3>
          </div>
          <div class="panel-body">
            <div class="row">
              
              <div class="col-md-12">
                <ul class="nav nav-tabs nav-tabs-custom m-b-15">
                  <li class="active">
                    <a href="#tab-proceso" role="tab" data-toggle="tab" aria-expanded="true">
                      <i class="zmdi zmdi-labels"></i> PROCESO</a>
                  </li>
                  <li class="">
                    <a href="#tab-consulta" role="tab" data-toggle="tab" aria-expanded="false">
                      <i class="zmdi zmdi-print"></i> CONSULTAS</a>
                  </li>
                  <li class="">
                    <a href="#tab-etapa" role="tab" data-toggle="tab" aria-expanded="false">
                      <i class="zmdi zmdi-view-module"></i> ETAPAS</a>
                  </li>
                  <li class="">
                    <a href="#tab-solucion" role="tab" data-toggle="tab" aria-expanded="false">
                      <i class="zmdi zmdi-assignment-check"></i> SOLUCI&Oacute;N TECNOL&Oacute;GICA</a>
                  </li>
                  <li class="">
                    <a href="#tab-material" role="tab" data-toggle="tab" aria-expanded="false">
                      <i class="zmdi zmdi-tablet"></i> MATERIALES</a>
                  </li>
                  <li class="">
                    <a href="#tab-incidencia" role="tab" data-toggle="tab" aria-expanded="false">
                      <i class="zmdi zmdi-view-module"></i> INCIDENCIAS</a>
                  </li>
                  <li class="">
                    <a href="#tab-asignar" role="tab" data-toggle="tab" aria-expanded="false" onclick="cboEtapaAsignar(); multicIncidencias();">
                      <i class="zmdi zmdi-assignment-check"></i> ASIGNAR INCIDENCIA</a>
                  </li>
                  <li class="">
                    <a href="#tab-dispositivo" role="tab" data-toggle="tab" aria-expanded="false">
                      <i class="zmdi zmdi-assignment-check"></i> DISPOSITIVOS USB</a>
                  </li>
                </ul>

                <div class="tab-content">
                  <div role="tabpanel" class="tab-pane fade active in" id="tab-proceso">
                    <div class="row">
                      <div class="col-md-4 col-sm-4">
                        <div class="panel panel-default panel-table m-b-0">
                          <div class="panel-heading">
                            <h4 class="text-center text-primary font-12" id="titleProceso"><strong>REGISTRAR PROCESO</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="row">
                              <!-- <div class="col-lg-1"></div> -->
                              <div class="col-lg-12">
                                <form class="form" id="form_registerProceso" method="POST" autocomplete="off" action="javascript:void(0);">
                                  <input class="form-control" type="hidden" id="txtIDProceso" name="txtIDProceso">
                                  <input class="form-control" type="hidden" id="txtcontrolProceso" name="txtcontrolProceso" value="0">
                                  <div class="panel panel-default">
                                    <div class="panel-body">
                                      <!-- <h5 class="text-blue-grey m-b-15"><strong>DATOS PERSONALES</strong></h5> -->
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="form-group">
                                            <label>Tipo Proceso</label>
                                            <select class="form-control" name="cbotipoproceso" id="cbotipoproceso" data-dropup-auto="false" data-size="10" data-live-search="true" required>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="form-group">
                                            <label>Código Proceso</label>
                                            <div class="input-group-prepend">
                                              <input class="form-control vld" type="text" id="txtcodproceso" name="txtcodproceso" required>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="form-group">
                                            <label>Nombre Proceso</label>
                                            <div class="input-group-prepend"> 
                                              <input class="form-control vld" type="text" id="txtnomproceso" name="txtnomproceso" required>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="form-group">
                                            <label>Fecha Inicio</label>
                                            <div class="input-group-prepend">
                                              <input class="form-control vld" type="date" id="txtfechainicio" name="txtfechainicio" required>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="form-group">
                                            <label>Fecha Cierre</label>
                                            <div class="input-group-prepend">
                                              <input class="form-control vld" type="date" id="txtfechacierre" name="txtfechacierre" required>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <!-- <h5 class="text-blue-grey m-b-15"><strong>DATOS DEL USUARIO</strong></h5> -->
                                      <div class="row" id="estado_proceso" style="display: none;">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="switches-stacked">
                                            <label>Activo</label>
                                            <label class="switch switch-primary">  
                                              <input type="checkbox" id="chkestadoProceso" name="chkestadoProceso" class="s-input">
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
                                          <button type="submit" class="btn btn-outline-primary" id="agregarProceso"><i class="zmdi zmdi-check zmdi-hc-fw m-r-5"></i><span> Guardar</span></button>
                                          <button type="submit" class="btn btn-outline-primary" id="updateProceso" style="display: none;"><i class="zmdi zmdi-refresh zmdi-hc-fw m-r-5"></i><span> Actualizar</span></button>
                                          <a class="btn btn-outline-danger" id="cancelProceso" onclick="cancelProceso();"><i class="zmdi zmdi-close zmdi-hc-fw m-r-5"></i><span>Cancelar</span></a>
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
                            <h4 class="text-center text-primary font-12"><strong>LISTA DE PROCESOS</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="table-responsive">
                              <div id="tbl_proceso" class="dataTables_wrapper form-inline" role="grid">
                                <table id="tableProcesos" class="display table table-bordered table-hover" cellspacing="0" width="100%">
                                  <thead class="text-center font-table">
                                      <tr class="bg-primary">
                                          <th class="text-center" width="5%">Nº</th>
                                          <th class="text-center" width="15%">COD. PROCESO</th>
                                          <th class="text-center" width="30%">NOMBRE PROCESO</th>
                                          <th class="text-center" width="15%">FECHA INICIO</th>
                                          <th class="text-center" width="15%">FECHA FIN</th>
                                          <th class="text-center" width="10%">ESTADO</th>
                                          <th class="text-center" width="10%">ACCI&Oacute;N</th>
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
                 
                  <div role="tabpanel" class="tab-pane fade" id="tab-consulta"> 
                    <div class="row">
                      <div class="col-md-4 col-sm-4">
                        <div class="panel panel-default panel-table m-b-0">
                          <div class="panel-heading">
                            <h4 class="text-center text-primary font-12" id="titleConsulta"><strong>REGISTRAR CONSULTA</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="row">
                              <!-- <div class="col-lg-1"></div> -->
                              <div class="col-lg-12">
                                <form class="form" id="form_registerConsulta" method="POST" autocomplete="off" action="javascript:void(0);">
                                  <input class="form-control" type="hidden" id="txtIDConsulta" name="txtIDConsulta">
                                  <input class="form-control" type="hidden" id="txtcontrolConsulta" name="txtcontrolConsulta" value="0">
                                  <div class="panel panel-default">
                                    <div class="panel-body">
                                      <!-- <h5 class="text-blue-grey m-b-15"><strong>DATOS PERSONALES</strong></h5> -->
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="form-group">
                                            <label>Consulta Electoral</label>
                                            <div class="input-group-prepend">
                                              <input class="form-control vld" type="text" id="txtconsulta" name="txtconsulta" required>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="form-group">
                                            <label>Descripcion</label>
                                            <div class="input-group-prepend">
                                              <input class="form-control vld" type="text" id="txtdescripcion" name="txtdescripcion" required>
                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="row" id="estado_consulta" style="display: none;">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="switches-stacked">
                                            <label>Activo</label>
                                            <label class="switch switch-primary">  
                                              <input type="checkbox" id="chkestadoConsulta" name="chkestadoConsulta" class="s-input">
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
                                          <button type="submit" class="btn btn-outline-primary" id="agregarConsulta"><i class="zmdi zmdi-check zmdi-hc-fw m-r-5"></i><span> Guardar</span></button>
                                          <button type="submit" class="btn btn-outline-primary" id="updateConsulta" style="display: none;"><i class="zmdi zmdi-refresh zmdi-hc-fw m-r-5"></i><span> Actualizar</span></button>
                                          <a class="btn btn-outline-danger" id="cancelConsulta" onclick="cancelConsulta();"><i class="zmdi zmdi-close zmdi-hc-fw m-r-5"></i><span>Cancelar</span></a>
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
                            <h4 class="text-center text-primary font-12"><strong>LISTA DE CONSULTAS ELECTORALES</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="table-responsive">
                              <div id="tbl_consulta" class="dataTables_wrapper form-inline" role="grid">
                                <table id="tableConsultas" class="display table table-bordered table-hover" cellspacing="0" width="100%">
                                  <thead class="text-center font-table">
                                    <tr class="bg-primary">
                                      <th class="text-center" width="5%">Nº</th>
                                      <th class="text-center" width="35%">CONSULTA</th>
                                      <th class="text-center" width="30%">DESCRIPCI&Oacute;N</th>
                                      <th class="text-center" width="15%">ESTADO</th>
                                      <th class="text-center" width="15%">ACCI&Oacute;N</th>
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

                  <div role="tabpanel" class="tab-pane fade" id="tab-etapa">
                    <div class="row">
                      <div class="col-md-12 col-sm-12">
                        <div class="panel panel-default panel-table m-b-0">
                          <div class="panel-heading">
                            <h4 class="text-center text-primary font-12"><strong>LISTA DE ETAPAS ELECTORALES</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="table-responsive">
                              <div id="tbl_etapa" class="dataTables_wrapper form-inline" role="grid">
                                <table id="tableEtapas" class="display table table-bordered table-hover" cellspacing="0" width="100%">
                                  <thead class="text-center font-table">
                                    <tr class="bg-primary">
                                      <th class="text-center" width="5%">Nº</th>
                                      <th class="text-center" width="25%">ETAPA</th>
                                      <th class="text-center" width="40%">DESCRIPCI&Oacute;N</th>
                                      <th class="text-center" width="15%">ESTADO</th>
                                      <th class="text-center" width="15%">ACCI&Oacute;N</th>
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

                  <div role="tabpanel" class="tab-pane fade" id="tab-solucion">
                    <div class="row">
                      <div class="col-md-4 col-sm-4">
                        <div class="panel panel-default panel-table m-b-0">
                          <div class="panel-heading">
                            <h4 class="text-center text-primary font-12" id="titleSolucion"><strong>REGISTRAR SOLUCI&Oacute;N TECNOL&Oacute;GICA</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="row">
                              <!-- <div class="col-lg-1"></div> -->
                              <div class="col-lg-12">
                                <form class="form" id="form_registerSolucion" method="POST" autocomplete="off" action="javascript:void(0);">
                                  <input class="form-control" type="hidden" id="txtIDSolucion" name="txtIDSolucion">
                                  <input class="form-control" type="hidden" id="txtcontrolSolucion" name="txtcontrolSolucion" value="0">
                                  <div class="panel panel-default">
                                    <div class="panel-body">
                                      <!-- <h5 class="text-blue-grey m-b-15"><strong>DATOS PERSONALES</strong></h5> -->
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="form-group">
                                            <label>Soluci&oacute;n Tecnol&oacute;gica</label>
                                            <div class="input-group-prepend">
                                              <input class="form-control vld" type="text" id="txtsolucion" name="txtsolucion" required>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="form-group">
                                            <label>Descripci&oacute;n</label>
                                            <div class="input-group-prepend">
                                              <input class="form-control vld" type="text" id="txtdescripcionSolucion" name="txtdescripcionSolucion" required>
                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="row" id="estado_solucion" style="display: none;">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="switches-stacked">
                                            <label>Activo</label>
                                            <label class="switch switch-primary">  
                                              <input type="checkbox" id="chkestadoSolucion" name="chkestadoSolucion" class="s-input">
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
                                          <button type="submit" class="btn btn-outline-primary" id="agregarSolucion"><i class="zmdi zmdi-check zmdi-hc-fw m-r-5"></i><span> Guardar</span></button>
                                          <button type="submit" class="btn btn-outline-primary" id="updateSolucion" style="display: none;"><i class="zmdi zmdi-refresh zmdi-hc-fw m-r-5"></i><span> Actualizar</span></button>
                                          <a class="btn btn-outline-danger" id="cancelSolucion" onclick="cancelSolucion();"><i class="zmdi zmdi-close zmdi-hc-fw m-r-5"></i><span>Cancelar</span></a>
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
                            <h4 class="text-center text-primary font-12"><strong>LISTA DE SOLUCIONES TECNOLOGICAS</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="table-responsive">
                              <div id="tbl_solucion" class="dataTables_wrapper form-inline" role="grid">
                                <table id="tableSoluciones" class="display table table-bordered table-hover" cellspacing="0" width="100%">
                                  <thead class="text-center font-table">
                                    <tr class="bg-primary">
                                      <th class="text-center" width="5%">Nº</th>
                                      <th class="text-center" width="10%">SOLUCION TECNOLOGICA</th>
                                      <th class="text-center" width="60%">DESCRIPCI&Oacute;N</th>
                                      <th class="text-center" width="15%">ESTADO</th>
                                      <th class="text-center" width="10%">ACCI&Oacute;N</th>
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

                  <div role="tabpanel" class="tab-pane fade" id="tab-material">
                    <div class="row">
                      <div class="col-md-12 col-sm-12">
                        <div class="panel panel-default panel-table m-b-0">
                          <div class="panel-heading">
                            <h4 class="text-center text-primary font-12"><strong>LISTA DE MATERIALES ELECTORALES</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="table-responsive">
                              <div id="tbl_material" class="dataTables_wrapper form-inline" role="grid">
                                <table id="tableMateriales" class="display table table-bordered table-hover" cellspacing="0" width="100%">
                                  <thead class="text-center font-table">
                                    <tr class="bg-primary">
                                      <th class="text-center" width="5%">Nº</th>
                                      <th class="text-center" width="20%">MATERIAL</th>
                                      <th class="text-center" width="45%">DESCRIPCI&Oacute;N</th>
                                      <th class="text-center" width="15%">ESTADO</th>
                                      <th class="text-center" width="15%">ACCI&Oacute;N</th>
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
                                <form class="form" id="form_registerIncidencia" method="POST" autocomplete="off" action="javascript:void(0);">
                                  <input class="form-control" type="hidden" id="txtIDIncidencia" name="txtIDIncidencia">
                                  <input class="form-control" type="hidden" id="txtcontrolIncidencia" name="txtcontrolIncidencia" value="0">
                                  <div class="panel panel-default">
                                    <div class="panel-body">
                                      <!-- <h5 class="text-blue-grey m-b-15"><strong>DATOS PERSONALES</strong></h5> -->
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="form-group">
                                            <label>Incidencia</label>
                                            <div class="input-group-prepend">
                                              <input class="form-control vld" type="text" id="txtincidencia" name="txtincidencia" required>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="form-group">
                                            <label>Descripci&oacute;n</label>
                                            <div class="input-group-prepend">
                                              <input class="form-control vld" type="text" id="txtdescripcionIncidencia" name="txtdescripcionIncidencia" required>
                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="row" id="estado_incidencia" style="display: none;">
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
                                          <a class="btn btn-outline-danger" id="cancelIncidencia" onclick="cancelIncidencia();"><i class="zmdi zmdi-close zmdi-hc-fw m-r-5"></i><span>Cancelar</span></a>
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
                            <h4 class="text-center text-primary font-12"><strong>LISTA DE INCIDENCIAS ELECOTRALES</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="table-responsive">
                              <div id="tbl_incidencia" class="dataTables_wrapper form-inline" role="grid">
                                <table id="tableIncidencias" class="display table table-bordered table-hover" cellspacing="0" width="100%">
                                  <thead class="text-center font-table">
                                    <tr class="bg-primary">
                                      <th class="text-center" width="10%">Nº</th>
                                      <th class="text-center" width="35%">INCIDENCIA</th>
                                      <th class="text-center" width="35%">DESCRIPCI&Oacute;N</th>
                                      <th class="text-center" width="10%">ESTADO</th>
                                      <th class="text-center" width="10%">ACCI&Oacute;N</th>
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

                  <div role="tabpanel" class="tab-pane fade" id="tab-asignar">
                    <div class="row">

                      <div class="col-md-4 col-sm-4">
                        <div class="panel panel-default panel-table m-b-0">
                          <div class="panel-heading">
                            <h4 class="text-center text-primary font-12" id="titleAsignar"><strong>ASIGNAR INCIDENCIA</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="row">
                              <!-- <div class="col-lg-1"></div> -->
                              <div class="col-lg-12">
                                <form class="form" id="form_registerAsignar" method="POST" autocomplete="off" action="javascript:void(0);">
                                  <input class="form-control" type="hidden" id="txtIDAsignar" name="txtIDAsignar">
                                  <input class="form-control" type="hidden" id="txtcontrolAsignar" name="txtcontrolAsignar" value="0">
                                  <div class="panel panel-default">
                                    <div class="panel-body">
                                      <!-- <h5 class="text-blue-grey m-b-15"><strong>DATOS PERSONALES</strong></h5> -->
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="form-group">
                                            <label>Etapa</label>
                                            <select class="form-control" name="cboincidenciaAsignar" id="cboincidenciaAsignar" data-dropup-auto="false" data-size="10" data-live-search="true" required>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="form-group">
                                            <label>Incidencias</label>
                                            <select data-dropup-auto="false" title="[ Seleccione Incidencias ]" data-size="6" name="multiIncidencia" id="multiIncidencia" class="form-control selectpicker" multiple data-selected-text-format="count > 3" data-live-search="true" noneSelectedText show-menu-arrow required>

                                            </select>
                                            <span id="errormultiIncidencia" class="font-error"></span>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="clearfix m-t-30">
                                        <div class="pull-right">
                                          <button type="submit" class="btn btn-outline-primary" id="agregarAsignar"><i class="zmdi zmdi-check zmdi-hc-fw m-r-5"></i><span> Guardar</span></button>
                                          <button type="submit" class="btn btn-outline-primary" id="updateAsignar" style="display: none;"><i class="zmdi zmdi-refresh zmdi-hc-fw m-r-5"></i><span> Actualizar</span></button>
                                          <a class="btn btn-outline-danger" data-dismiss="modal" id="cancelAsignar" onclick="cancelAsignar();"><i class="zmdi zmdi-close zmdi-hc-fw m-r-5"></i><span>Cancelar</span></a>
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
                            <h4 class="text-center text-primary font-12"><strong>INCIDENCIAS ASIGNADAS</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="table-responsive">
                              <div id="tbl_asignar" class="dataTables_wrapper form-inline" role="grid">
                                <table id="tableAsignar" class="display table table-bordered table-hover" cellspacing="0" width="100%">
                                  <thead class="text-center font-table">
                                    <tr class="bg-primary">
                                      <th class="text-center" width="10%">Nº</th>
                                      <th class="text-center" width="20%">ETAPA</th>
                                      <th class="text-center" width="60%">IBCIDENCIAS ASIGNADAS</th>
                                      <th class="text-center" width="10%">ACCI&Oacute;N</th>
                                    </tr>
                                  </thead>
                                  <tbody class="font-table">

                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div role="tabpanel" class="tab-pane fade" id="tab-dispositivo">
                    <div class="row">
                      <div class="col-md-4 col-sm-4">
                        <div class="panel panel-default panel-table m-b-0">
                          <div class="panel-heading">
                            <h4 class="text-center text-primary font-12" id="titleDispositivo"><strong>REGISTRAR DISPOSITIVOS USB</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="row">
                              <!-- <div class="col-lg-1"></div> -->
                              <div class="col-lg-12">
                                <form class="form" id="form_registerDispositivo" method="POST" autocomplete="off" action="javascript:void(0);">
                                  <input class="form-control" type="hidden" id="txtIDDispositivo" name="txtIDDispositivo">
                                  <input class="form-control" type="hidden" id="txtcontrolDispositivo" name="txtcontrolDispositivo" value="0">
                                  <div class="panel panel-default">
                                    <div class="panel-body">
                                      <!-- <h5 class="text-blue-grey m-b-15"><strong>DATOS PERSONALES</strong></h5> -->
                                      <!-- <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="form-group">
                                            <label>Soluci&oacute;n Tecnol&oacute;gica</label>
                                            <div class="input-group-prepend">
                                              <input class="form-control vld" type="text" id="txtdispositivo" name="txtdispositivo" required>
                                            </div>
                                          </div>
                                        </div>
                                      </div> -->
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="form-group">
                                            <label>Descripci&oacute;n</label>
                                            <div class="input-group-prepend">
                                              <input class="form-control vld" type="text" id="txtdescripcionDispositivo" name="txtdescripcionDispositivo" required>
                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="row" id="estado_dispositivo" style="display: none;">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="switches-stacked">
                                            <label>Activo</label>
                                            <label class="switch switch-primary">  
                                              <input type="checkbox" id="chkestadoDispositivo" name="chkestadoDispositivo" class="s-input">
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
                                          <button type="submit" class="btn btn-outline-primary" id="agregarDispositivo"><i class="zmdi zmdi-check zmdi-hc-fw m-r-5"></i><span> Guardar</span></button>
                                          <button type="submit" class="btn btn-outline-primary" id="updateDispositivo" style="display: none;"><i class="zmdi zmdi-refresh zmdi-hc-fw m-r-5"></i><span> Actualizar</span></button>
                                          <a class="btn btn-outline-danger" id="cancelDispositivo" onclick="cancelDispositivo();"><i class="zmdi zmdi-close zmdi-hc-fw m-r-5"></i><span>Cancelar</span></a>
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
                            <h4 class="text-center text-primary font-12"><strong>LISTA DE DISPOSITIVOS USB</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="table-responsive">
                              <div id="tbl_dispositivo" class="dataTables_wrapper form-inline" role="grid">
                                <table id="tableDispositivos" class="display table table-bordered table-hover" cellspacing="0" width="100%">
                                  <thead class="text-center font-table">
                                    <tr class="bg-primary">
                                      <th class="text-center" width="10%">Nº</th>
                                      <th class="text-center" width="60%">DESCRIPCI&Oacute;N</th>
                                      <th class="text-center" width="15%">ESTADO</th>
                                      <th class="text-center" width="15%">ACCI&Oacute;N</th>
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

                </div>
              </div>
            </div>
          </div>
        </div>


        <!-- Modal ETAPA -->
        <div class="modal fade" id="modal_etapa" role="dialog" data-keyboard="false" data-backdrop="static" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="zmdi zmdi-close"></i>
                  </span>
                </button>
                <h4 class="modal-title text-center text-primary" id="titleEtapa">EDITAR ETAPA</h4>
              </div>
              <div class="modal-body">
                <div class="col-lg-1"></div>
                <div class="col-lg-10">
                  <form class="form-horizontal" id="form_registerEtapa" method="POST" autocomplete="off" >
                    <input class="form-control" type="hidden" id="txtIDEtapa" name="txtIDEtapa">
                    <input class="form-control" type="hidden" id="txtcontrolEtapa" name="txtcontrolEtapa" value="0">
                    <div class="panel ">
                      <div class="panel-body">
                        <div class="row">
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                              <label>Etapa</label>
                              <div class="input-group-prepend">
                                <input type="text" class="form-control vld" name="txtetapa" id="txtetapa" required/>
                              </div>
                            </div>
                          </div>                       
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                              <label>Descripci&oacute;n</label>
                              <div class="input-group-prepend">
                                <input type="text" class="form-control vld" name="txtdescripcionEtapa" id="txtdescripcionEtapa" required/>
                              </div>
                            </div>
                          </div>
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                             <div class="switches-stacked">
                                <label>Activo</label>
                                <label class="switch switch-primary">  
                                  <input type="checkbox" id="chkestadoEtapa" name="chkestadoEtapa" class="s-input">
                                  <span class="s-content">
                                    <span class="s-track"></span>
                                    <span class="s-handle"></span>
                                  </span>
                                </label>
                              </div>
                            </div>
                          </div>                     
                        </div>
                        <div class="row clearfix m-t-30">
                          <div class="pull-right">
                            <button type="submit" class="btn btn-outline-primary" id="updateEtapa"><i class="zmdi zmdi-refresh zmdi-hc-fw m-r-5"></i><span>Actualizar</span></button>
                            <a class="btn btn-outline-danger" data-dismiss="modal" id="cancelEtapa" onclick="cancelEtapa();"><i class="zmdi zmdi-close zmdi-hc-fw m-r-5"></i><span>Cerrar</span></a>
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
        <!-- #END# Modal ETAPA -->

        <!-- Modal SOLUCION -->
        <!-- <div class="modal fade" id="modal_solucion" role="dialog" data-keyboard="false" data-backdrop="static" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="zmdi zmdi-close"></i>
                  </span>
                </button>
                <h4 class="modal-title text-center text-primary" id="titleSolucion">EDITAR SOLUCI&Oacute;N TECNOL&Oacute;GICA</h4>
              </div>
              <div class="modal-body">
                <div class="col-lg-1"></div>
                <div class="col-lg-10">
                  <form class="form-horizontal" id="form_registerSolucionModal" method="POST" autocomplete="off" >
                    <input class="form-control" type="hidden" id="txtIDSolucion" name="txtIDSolucion">
                    <input class="form-control" type="hidden" id="txtcontrolSolucion" name="txtcontrolSolucion" value="0">
                    <div class="panel ">
                      <div class="panel-body">
                        <div class="row">
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                              <label>Soluci&oacute;n Tecnol&oacute;gica</label>
                              <div class="input-group-prepend">
                                <input type="text" class="form-control vld" name="txtsolucion" id="txtsolucion" required/>
                              </div>
                            </div>
                          </div>                       
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                              <label>Descripci&oacute;n</label>
                              <div class="input-group-prepend">
                                <input type="text" class="form-control vld" name="txtdescripcionSolucion" id="txtdescripcionSolucion" required/>
                              </div>
                            </div>
                          </div>
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                             <div class="switches-stacked">
                                <label>Activo</label>
                                <label class="switch switch-primary">  
                                  <input type="checkbox" id="chkestadoSolucion" name="chkestadoSolucion" class="s-input">
                                  <span class="s-content">
                                    <span class="s-track"></span>
                                    <span class="s-handle"></span>
                                  </span>
                                </label>
                              </div>
                            </div>
                          </div>                     
                        </div>
                        <div class="row clearfix m-t-30">
                          <div class="pull-right">
                            <button type="submit" class="btn btn-outline-primary" id="updateSolucion"><i class="zmdi zmdi-refresh zmdi-hc-fw m-r-5"></i><span>Actualizar</span></button>
                            <a class="btn btn-outline-danger" data-dismiss="modal" id="cancelSolucion" onclick="cancelSolucion();"><i class="zmdi zmdi-close zmdi-hc-fw m-r-5"></i><span>Cerrar</span></a>
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
        </div> -->
        <!-- #END# Modal SOLUCION -->

        <!-- Modal MATERIAL -->
        <div class="modal fade" id="modal_material" role="dialog" data-keyboard="false" data-backdrop="static" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="zmdi zmdi-close"></i>
                  </span>
                </button>
                <h4 class="modal-title text-center text-primary" id="titleMaterial">EDITAR MATERIAL</h4>
              </div>
              <div class="modal-body">
                <div class="col-lg-1"></div>
                <div class="col-lg-10">
                  <form class="form-horizontal" id="form_registerMaterial" method="POST" autocomplete="off" >
                    <input class="form-control" type="hidden" id="txtIDMaterial" name="txtIDMaterial">
                    <input class="form-control" type="hidden" id="txtcontrolMaterial" name="txtcontrolMaterial" value="0">
                    <div class="panel ">
                      <div class="panel-body">
                        <div class="row">
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                              <label>Material</label>
                              <div class="input-group-prepend">
                                <input type="text" class="form-control vld" name="txtmaterial" id="txtmaterial" required/>
                              </div>
                            </div>
                          </div>                       
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                              <label>Descripci&oacute;n</label>
                              <div class="input-group-prepend">
                                <input type="text" class="form-control vld" name="txtdescripcionMaterial" id="txtdescripcionMaterial" required/>
                              </div>
                            </div>
                          </div>
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                             <div class="switches-stacked">
                                <label>Activo</label>
                                <label class="switch switch-primary">  
                                  <input type="checkbox" id="chkestadoMaterial" name="chkestadoMaterial" class="s-input">
                                  <span class="s-content">
                                    <span class="s-track"></span>
                                    <span class="s-handle"></span>
                                  </span>
                                </label>
                              </div>
                            </div>
                          </div>                     
                        </div>
                        <div class="row clearfix m-t-30">
                          <div class="pull-right">
                            <button type="submit" class="btn btn-outline-primary" id="updateMaterial"><i class="zmdi zmdi-refresh zmdi-hc-fw m-r-5"></i><span>Actualizar</span></button>
                            <a class="btn btn-outline-danger" data-dismiss="modal" id="cancelMaterial" onclick="cancelMaterial();"><i class="zmdi zmdi-close zmdi-hc-fw m-r-5"></i><span>Cerrar</span></a>
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
        <!-- #END# Modal MATERIAL -->

      </div>
      <div class="site-footer">
        2021 © Sistema
      </div>
    </div>
    
    <!-- FOOTER -->
    <?php footerAdmin($data); ?>
  </body>

</html>