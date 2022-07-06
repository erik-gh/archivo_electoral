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
            <div class="form-wizard">
              <div class="fw-header">
                <ul class="nav nav-pills">
                  <li class="active"><a href="#tab1" data-toggle="tab">Paso 1 <span class="chevron"></span></a></li>
                  <li><a href="#tab2" data-toggle="tab">Paso 2 <span class="chevron"></span></a></li>
                  <li><a href="#tab3" data-toggle="tab">Paso 3 <span class="chevron"></span></a></li>
                  <li><a href="#tab4" data-toggle="tab">Paso 4 <span class="chevron"></span></a></li>
                  <li><a href="#tab5" data-toggle="tab">Paso 5 <span class="chevron"></span></a></li>
                  <!-- <li><a href="#tab6" data-toggle="tab">Paso 6 <span class="chevron"></span></a></li>
                  <li><a href="#tab7" data-toggle="tab">Paso 7 <span class="chevron"></span></a></li> -->
                  <li><a href="#tab8" data-toggle="tab">Paso 6 <span class="chevron"></span></a></li>
                  <!-- <li><a href="#tab9" data-toggle="tab">Paso 9 <span class="chevron"></span></a></li> -->
                </ul>
              </div>
              <div class="tab-content p-x-15">
                <div class="tab-pane active" id="tab1">
                  <div class="row">
                    <div class="col-md-2 col-sm-2"></div>
                    <div class="col-md-2 col-sm-2">
                      <form class="form-horizontal" id="sign_registerProceso" method="POST" autocomplete="off" action="javascript:void(0);">
                        <div class="form-group">
                          <label class="control-label font-18">Seleccione:</label><br><br>
                          <div class="custom-controls-stacked">
                            <label class="custom-control custom-control-primary custom-radio">
                              <input class="custom-control-input vld" type="radio" name="radioProceso" id="radioProceso1" value="1" onclick="crearProceso_radio()" required>
                              <span class="custom-control-indicator"></span>
                              <span class="custom-control-label font-16">Crear Par&aacute;metros</span>
                            </label><br>
                            <label class="custom-control custom-control-primary custom-radio">
                              <input class="custom-control-input vld" type="radio" name="radioProceso" id="radioProceso2" value="2" onclick="crearProceso_radio()" required>
                              <span class="custom-control-indicator"></span>
                              <span class="custom-control-label font-16">Editar Par&aacute;metros</span>
                            </label>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="col-md-4 col-sm-4">
                      <form class="form-horizontal" id="sign_registerCrearProceso1" method="POST" autocomplete="off" action="javascript:void(0);">
                        <input class="form-control" type="hidden" id="txtIDProceso" name="txtIDProceso">
                        <input class="form-control" type="hidden" id="txtcontrolProceso" name="txtcontrolProceso" value="0">
                        <div class="form-group z-9">
                          <label>Proceso</label>
                            <select class="form-control selectpicker" name="cbocrearProceso" id="cbocrearProceso" data-live-search="true" required>
                              <option value="">[ Seleccione Proceso ]</option>
                            </select>
                        </div>

                        <div class="form-group z-8">
                          <label>Solucion Tecnologica</label>
                          <select data-dropup-auto="false" title="[ Seleccione Solucion Tecnologica ]" data-size="6" name="multiSolucion" id="multiSolucion" class="form-control selectpicker" multiple data-selected-text-format="count > 3" data-live-search="true" noneSelectedText show-menu-arrow disabled required>

                          </select>
                          <span id="errormultiSolucion" class="font-error"></span>
                        </div>
                        <div class="form-group z-7">
                          <label>Etapa</label>
                          <select data-dropup-auto="false" title="[ Seleccione Etapa ]" data-size="6" name="multiEtapa" id="multiEtapa" class="form-control selectpicker" multiple data-selected-text-format="count > 3" data-live-search="true" noneSelectedText show-menu-arrow disabled required>

                          </select>
                          <span id="errormultiEtapa" class="font-error"></span>
                        </div>
                        <div class="form-group">
                          <div class="pull-right">
                            <button type="submit" class="btn btn-primary" id="agregarCrearProceso" disabled=""><i class="zmdi zmdi-check zmdi-hc-fw m-r-5"></i><span> Guardar</span></button>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="col-md-4 col-sm-4"></div>
                  </div>
                </div>

                <div class="tab-pane" id="tab2">
                  <!-- <h3 class="m-t-0 m-b-30">Crear Proceso</h3> -->
                  <div class="row">
                    <div class="col-md-3 col-sm-3"></div>
                    <div class="col-md-6 col-sm-6">
                      <div class=" m-b-0">
                          <input class="form-control" type="hidden"  id="idProcesoConsulta" name="idProcesoConsulta" required>
                        <!-- <div class="panel-heading"> -->
                          <h4 class="text-center text-primary font-14"><strong>LISTA DE CONSULTAS ELECTORALES</strong></h4><br>
                        <!-- </div> -->
                        <!-- <div class="panel-body"> -->
                          <div class="table-responsive">
                            <div id="tblcrearProcesoConsulta" class="dataTables_wrapper form-inline" role="grid">
                              <table id="tableConsultaProceso" class="display table table-bordered table-hover" cellspacing="0" width="100%">
                                <thead class="text-center font-table">
                                  <tr class="bg-primary">
                                    <th class="text-center" width="10%">ITEM</th>
                                    <th class="text-center" width="25%">CONSULTA</th>
                                    <th class="text-center" width="20%">Nº PAQUETES</th>
                                    <th class="text-center" width="10%">Nº CARTELES</th>
                                  </tr>
                                </thead>
                                <tbody class="text-center font-table">
                                </tbody>
                              </table>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="pull-right">
                              <button type="button" class="btn btn-primary" id="agregarAsignarConsulta" onclick="guardarConsulta()"><i class="zmdi zmdi-check zmdi-hc-fw m-r-5"></i><span> Guardar</span></button>
                            </div>
                          </div>
                        <!-- </div> -->
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-3"></div>
                  </div>
                </div>

                <div class="tab-pane" id="tab3">
                  <!-- <h3 class="m-t-0 m-b-30">Crear Proceso</h3> -->
                  <div class="row">
                    <!-- <div class="col-md-3 col-sm-3"></div> -->
                    <div class="col-md-12 col-sm-12">
                      <div class=" m-b-0">
                          <input class="form-control" type="hidden"  id="idProcesoCedula" name="idProcesoCedula" required>
                        <!-- <div class="panel-heading"> -->
                          <h4 class="text-center text-primary font-12"><strong>C&Oacute;DIGOS DE CEDULA</strong></h4><br>
                        <!-- </div> -->
                        <!-- <div class="panel-body"> -->
                          <div class="table-responsive">
                            <div id="tblcrearProcesoCedula" class="dataTables_wrapper form-inline" role="grid">
                              <table id="tableCedulaProceso" class="display table table-bordered table-hover" cellspacing="0" width="100%">
                                <thead class="text-center font-table">
                                  <tr class="bg-primary">
                                    <th class="text-center" width="14%">CONSULTA</th>
                                    <th class="text-center" width="20%">TIPO</th>
                                    <th class="text-center" width="11%">CANT DIG. UBIGEO</th>
                                    <th class="text-center" width="11%">COD. MATERIAL. UBIGEO</th> 
                                    <th class="text-center" width="11%">COD CONSULTA UBIGEO</th>
                                    <th class="text-center" width="11%">CANT DIG. ROTULO</th>
                                    <th class="text-center" width="11%">TIPO MATERIAL ROTULO</th> 
                                    <th class="text-center" width="11%">COD CONSULTA ROTULO</th>
                                  </tr>
                                </thead>
                                <tbody class="text-center font-table">

                                </tbody>
                              </table>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="pull-right">
                              <button type="button" class="btn btn-primary" id="agregarAsignarCedula" onclick="guardarCedulas();"><i class="zmdi zmdi-check zmdi-hc-fw m-r-5"></i><span> Guardar</span></button>
                            </div>
                          </div>
                        <!-- </div> -->
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-3"></div>
                  </div>
                </div>

                <div class="tab-pane" id="tab4">
                  <!-- <h3 class="m-t-0 m-b-30">Crear Proceso</h3> -->
                  <div class="row">
                    <!-- <div class="col-md-3 col-sm-3"></div> -->
                    <div class="col-md-12 col-sm-12">
                      <div class=" m-b-0">
                          <input class="form-control" type="hidden"  id="idProcesoActa" name="idProcesoActa" required>
                        <!-- <div class="panel-heading"> -->
                          <h4 class="text-center text-primary font-12"><strong>C&Oacute;DIGOS DE ACTA PADR&Oacute;N</strong></h4><br>
                        <!-- </div> -->
                        <!-- <div class="panel-body"> -->
                          <div class="table-responsive">
                            <div id="tblcrearProcesoActa" class="dataTables_wrapper form-inline" role="grid">
                              <table id="tableActaProceso" class="display table table-bordered table-hover" cellspacing="0" width="100%">
                                <thead class="text-center font-table">
                                    <tr class="bg-primary">
                                        <th class="text-center" width="10s%">Nº</th>
                                        <th class="text-center" width="30%">MATERIAL</th>
                                        <th class="text-center" width="20%">CANT. DIGITOS</th>
                                        <th class="text-center" width="20%">C&Oacute;DIGO</th> 
                                        <th class="text-center" width="20%">DIG. RESTANTES</th> 
                                    </tr>
                                </thead>
                                <tbody class="text-center font-table">
                                </tbody>
                              </table>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="pull-right">
                              <button type="button" class="btn btn-primary" id="agregarAsignarActa" onclick="guardarActa()"><i class="zmdi zmdi-check zmdi-hc-fw m-r-5"></i><span> Guardar</span></button>
                            </div>
                          </div>
                        <!-- </div> -->
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-3"></div>
                  </div>
                </div>

                <div class="tab-pane" id="tab5">
                  <!-- <h3 class="m-t-0 m-b-30">Crear Proceso</h3> -->
                  <div class="row">
                    <!-- <div class="col-md-3 col-sm-3"></div> -->
                    <div class="col-md-12 col-sm-12">
                      <div class=" m-b-0">
                          <input class="form-control" type="hidden"  id="idProcesoDispositivo" name="idProcesoDispositivo" required>
                        <!-- <div class="panel-heading"> -->
                          <h4 class="text-center text-primary font-12"><strong>C&Oacute;DIGOS DE DISPOSITIVOS ELECTR&Oacute;NICOS</strong></h4><br>
                        <!-- </div> -->
                        <!-- <div class="panel-body"> -->
                          <div class="table-responsive">
                            <div id="tblcrearProcesoDispositivo" class="dataTables_wrapper form-inline" role="grid">
                              <table id="tableDispositivoProceso" class="display table table-bordered table-hover" cellspacing="0" width="100%">
                                <thead class="text-center font-table">
                                  <tr class="bg-primary">
                                    <th class="text-center" width="10%">Nº</th>
                                    <th class="text-center" width="25%">MATERIAL</th>
                                    <th class="text-center" width="15%">CANT. DIGITOS</th>
                                    <th class="text-center" width="15%">PREFIJO</th> 
                                    <th class="text-center" width="15%">C&Oacute;DIGO</th> 
                                    <th class="text-center" width="20%">DIG. RESTANTES</th> 
                                  </tr>
                                </thead>
                                <tbody class="text-center font-table">
                                </tbody>
                              </table>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="pull-right">
                              <button type="button" class="btn btn-primary" id="agregarAsignarDispositivo" onclick="guardarDispositivo()"><i class="zmdi zmdi-check zmdi-hc-fw m-r-5"></i><span> Guardar</span></button>
                            </div>
                          </div>
                        <!-- </div> -->
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-3"></div>
                  </div>
                </div>

                <div class="tab-pane" id="tab8">
                  <!-- <h3 class="m-t-0 m-b-30">Crear Proceso</h3> -->
                  <div class="row">
                    <!-- <div class="col-md-3 col-sm-3"></div> -->
                    <div class="col-md-12 col-sm-12">
                      <div class=" m-b-0">
                          <input class="form-control" type="hidden"  id="idProcesoReserva" name="idProcesoReserva" required>
                        <!-- <div class="panel-heading"> -->
                          <h4 class="text-center text-primary font-12"><strong>C&Oacute;DIGOS DE CEDULA DE RESERVA</strong></h4><br>
                        <!-- </div> -->
                        <!-- <div class="panel-body"> -->
                          <div class="table-responsive">
                            <div id="tblcrearProcesoReserva" class="dataTables_wrapper form-inline" role="grid">
                              <table id="tableReservaProceso" class="display table table-bordered table-hover" cellspacing="0" width="100%">
                                <thead class="text-center font-table">
                                  <tr class="bg-primary">
                                    <th class="text-center" width="12%">CONSULTA</th>
                                    <th class="text-center" width="18%">TIPO</th>
                                    <th class="text-center" width="10%">CANT DIG. UBIGEO</th>
                                    <th class="text-center" width="10%">TIPO MATERIAL UBIGEO</th> 
                                    <th class="text-center" width="10%">C&Oacute;D. CONSULTA UBIGEO</th>
                                    <th class="text-center" width="10%">CANT DIG. ROTULO</th>
                                    <th class="text-center" width="10%">C&Oacute;D. ROTULO</th> 
                                    <th class="text-center" width="10%">CANT. RESERVA</th>
                                    <th class="text-center" width="10%">C&Oacute;D. CONSULTA</th> 
                                  </tr>
                                </thead>
                                <tbody class="text-center font-table">
                                </tbody>
                              </table>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="pull-right">
                              <button type="button" class="btn btn-primary" id="agregarAsignarReserva" onclick="guardarReserva()"><i class="zmdi zmdi-check zmdi-hc-fw m-r-5"></i><span> Guardar</span></button>
                            </div>
                          </div>
                        <!-- </div> -->
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-3"></div>
                  </div>
                </div>

              </div>
              <div class="fw-footer">
                <ul class="pager wizard">
                  <li class="previous first" style="display:none"><a href="#">Primero</a></li>
                  <li class="previous"><a href="#">Anterior</a></li>
                  <li class="next last" style="display:none"><a href="#">&Uacute;ltimo</a></li>
                  <li class="next"><a href="#">Siguiente</a></li>
                </ul>
              </div>
              <div id="bar" class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
              </div>

            </div>
          </div>
        </div>



      </div>
      <div class="site-footer">
        2021 © Sistema
      </div>
    </div>
    
    <!-- FOOTER -->
    <?php footerAdmin($data); ?>
  </body>

</html>