<!DOCTYPE html>
<html lang="es">

<!-- Mirrored from big-bang-studio.com/cosmos/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 10 Jan 2019 12:50:15 GMT -->
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
                    <a href="#tab-avance" role="tab" data-toggle="tab" aria-expanded="true" onclick="//cboProceso();">
                      <i class="zmdi zmdi-apps"></i> REPORTE AVANCE GENERAL</a>
                  </li>
                  <li class="">
                    <a href="#tab-odpe" role="tab" data-toggle="tab" aria-expanded="true" onclick="//cboProceso();">
                      <i class="zmdi zmdi-apps"></i> REPORTE ODPE</a>
                  </li>
                  <li class="">
                    <a href="#tab-usuario" role="tab" data-toggle="tab" aria-expanded="false" onclick="//cboProceso();">
                      <i class="zmdi zmdi-tablet"></i> REPORTE USUARIO - MESA</a>
                  </li>
                  <li class="">
                    <a href="#tab-rendimiento" role="tab" data-toggle="tab" aria-expanded="false" onclick="//cboProceso();">
                      <i class="zmdi zmdi-tablet"></i> REPORTE RENDIMIENTO</a>
                  </li>
                  <li class="">
                    <a href="#tab-grafico" role="tab" data-toggle="tab" aria-expanded="false" onclick="//cboProceso();">
                      <i class="zmdi zmdi-dns"></i> REPORTE GR&Aacute;FICO ODPE</a>
                  </li> 
                  <li class="">
                    <a href="#tab-estadistico" role="tab" data-toggle="tab" aria-expanded="false" onclick="//cboProceso();">
                      <i class="zmdi zmdi-dns"></i> REPORTE ESTAD&Iacute;STICO</a>
                  </li>
                  <li class="">
                    <a href="#tab-estado_mesa" role="tab" data-toggle="tab" aria-expanded="false" onclick="//cboProceso();">
                      <i class="zmdi zmdi-dns"></i> CONSULTA MESA</a>
                  </li>
                  <li class="">
                    <a href="#tab-otros-materiales" role="tab" data-toggle="tab" aria-expanded="false" onclick="//cboProceso();">
                      <i class="zmdi zmdi-dns"></i> OTROS MATERIALES</a>
                  </li>
                </ul>
                <div class="tab-content">
                  <div role="tabpanel" class="tab-pane fade active in" id="tab-avance">
                    <div class="row">
                      <div class="col-md-12 col-sm-12">
                        <div class="panel panel-default panel-table m-b-0">
                          <div class="panel-heading">
                            <h4 class="text-center text-primary font-12" id="titlePerfil"><strong>REPORTE AVANCE GENERAL DE MATERIALES</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="col-lg-12">
                              <form class="form" id="sign_registerColaborador" autocomplete="off">
                                <input class="form-control" type="hidden" id="txtIDColaborador" name="txtIDColaborador">
                                <input class="form-control" type="hidden" id="txtcontrolColaborador" name="txtcontrolColaborador" value="0">
                                <div class="panel panel-default">
                                  <!-- <div class="panel-heading">
                                    <h4 class="panel-title text-blue-grey font-12"><strong>DATOS DE LA INSTITUCI&Oacute;N</strong></h4>
                                  </div> -->
                                  <div class="panel-body">
                                    <!-- <h5 class="text-blue-grey m-b-15"><strong>DATOS LABORALES</strong></h5> -->
                                    <ul class="nav nav-tabs nav-tabs-custom m-b-15">
                                      <li class="active" id="li-general">
                                        <a href="#tab-avance-general" role="tab" data-toggle="tab" aria-expanded="true" style="display: none">
                                          <i class="zmdi zmdi-apps"></i> REPORTE AVANCE GENERAL</a>
                                      </li>
                                      <li class="" id="li-detalle">
                                        <a href="#tab-avance-detalle" role="tab" data-toggle="tab" aria-expanded="true" style="display: none">
                                          <i class="zmdi zmdi-apps"></i> REPORTE AVANCE DETALLADO</a>
                                      </li>
                                      <li class="" id="li-grafica-odpe">
                                        <a href="#tab-avance-grafica-odpe" role="tab" data-toggle="tab" aria-expanded="true" style="display: none">
                                          <i class="zmdi zmdi-apps"></i> REPORTE AVANCE GRAFIA ODPE</a>
                                      </li>
                                    </ul>
                                    <div class="tab-content">
                                      <div role="tabpanel" class="tab-pane fade active in" id="tab-avance-general">
                                        <div class="row">
                                          <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 z-8">
                                            <div class="form-group">
                                              <label>PROCESO</label>
                                              <select class="form-control" name="cboProcesoReporteAvance" id="cboProcesoReporteAvance" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboCargaAvance(), cboSolucion()" required>
                                                <option value="">[ SELECCIONE PROCESO ]</option>
                                              </select>
                                            </div>
                                          </div>
                                          <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 z-7">
                                            <div class="form-group">
                                              <label>SOLUCI&Oacute;N TECNOL&oacute;GICA</label>
                                              <select class="form-control" name="cboSoltecReporteAvance" id="cboSoltecReporteAvance" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboCargaAvance()" required>
                                                <option value="">[ SELECCIONE UNA SOL. TECN. ]</option>
                                              </select>
                                            </div>
                                          </div>
                                          <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 z-7">
                                            <div class="clearfix m-t-30">
                                                <div class="pull-right">
                                                   <a class="btn btn-blue btn-sm" data-dismiss="modal" id="updateRecepcion"  onclick="cboCargaAvance();"><i class="zmdi zmdi-refresh zmdi-hc-fw"></i><span></span></a>
                                                </div>
                                          </div>
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="panel panel-default panel-table m-b-0">
                                              <div class="panel-body">                                        
                                                <div class="table-responsive">
                                                  <div id="tbl_cargaAvance" class="dataTables_wrapper form-inline" role="grid">
                                                    <h4 class="text-center text-danger" id="titleProceso"></h4>
                                                    <div class="clearfix">
                                                      <div class="pull-left">
                                                        <a class="btn btn-success text-right" onclick="exportarReporteGeneral();"><i class="zmdi zmdi-download zmdi-hc-fw m-r-5"></i><span>DESCARGAR</span></a><br><br>
                                                      </div>
                                                      <div class="pull-right">
                                                        <a class="btn btn-black" id="verGrafico" onclick="verGraficaOdpe()"><i class="zmdi zmdi-apps zmdi-hc-fw m-r-5"></i><span> VER GRAFICO ODPE </span></a> 
                                                      </div>
                                                    </div><br>
                                                    <div class="table-responsive">
                                                        <table id="tableAvanceGeneral" class="display table table-bordered " cellspacing="0" width="100%">
                                                          <thead class="text-center font-table">
                                                            <tr class="bg-primary">
                                                              <th class="text-center" width="18%">ODPE</th>
                                                              <th class="text-center" width="10%">META</th>
                                                              <th class="text-center" width="10%">CEDULAS</th>
                                                              <th class="text-center" width="10%">LISTA DE ELECTORES</th>
                                                              <th class="text-center" width="10%">DOCUMENTOS ELECTORALES</th>
                                                              <th class="text-center" width="10%">RELACION DE ELECTORES</th>
                                                              <th class="text-center" width="12%">DOCUMENTOS DE CONTINGENCIA</th>
                                                              <th class="text-center" width="10%">EMPAREJAMIENTO</th>
                                                              <th class="text-center" width="10%">DISPOSITIVOS</th>
                                                            </tr>
                                                          </thead>
                                                          <tbody class="text-center font-table">
                                                          </tbody>
                                                        </table>

                                                        <br><br><br>
                                                        <h4 class="text-center text-danger" id="titleProcesoGrafica"></h4>
                                                        <br> 

                                                        <div style="width: 900px; height: 400px; margin: 0 auto">
                                                          <div id="container-cedula" style="width: 300px; height: 200px; float: left"></div>
                                                          <div id="container-lista" style="width: 300px; height: 200px; float: left"></div>
                                                          <div id="container-documento" style="width: 300px; height: 200px; float: left"></div>
                                                          <div id="container-relacion" style="width: 300px; height: 200px; float: left"></div>
                                                          <div id="container-emparejamiento" style="width: 300px; height: 200px; float: left"></div>
                                                          <div id="container-dispositivo" style="width: 300px; height: 200px; float: left"></div>
                                                        </div>

                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div role="tabpanel" class="tab-pane fade" id="tab-avance-detalle">
                                        <div class="row">
                                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            
                                                
                                                <div class="clearfix">
                                                  <div class="pull-left">
                                                      <a class="btn btn-black" id="downloadPlantilla" onclick="backGeneral()"><i class="zmdi zmdi-long-arrow-return  zmdi-hc-fw m-r-5" ></i><span> Regresar</span></a>
                                                  </div>
                                                </div><br>                                        
                                                <div class="table-responsive">
                                                  <div id="tbl_cargaAvanceDetalle" class="dataTables_wrapper form-inline" role="grid">
                                                    <h4 class="text-center text-danger" id="titleProcesoDetalle"></h4>
                                                    <br>
                                                    <h4 class="text-blue-grey" id="titleOdpeDetalle"></h4>
                                                    <div id="tbl_cargaAvanceGeneralDetalle" class="dataTables_wrapper form-inline" role="grid">

                                                    </div>
                                                  </div>
                                                </div>

                                              
                                          </div>
                                        </div>
                                      </div>

                                      <div role="tabpanel" class="tab-pane fade" id="tab-avance-grafica-odpe">
                                        <div class="row">
                                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            
                                                
                                                <div class="clearfix">
                                                  <div class="pull-left">
                                                      <a class="btn btn-black" id="downloadPlantilla" onclick="backGeneral()"><i class="zmdi zmdi-long-arrow-return  zmdi-hc-fw m-r-5" ></i><span> Regresar</span></a>
                                                  </div>
                                                </div><br>                                        
                                                <div class="table-responsive">
                                                  <div id="tbl_cargaAvanceGraficaOdpe" class="dataTables_wrapper form-inline" role="grid">
                                                    <h4 class="text-center text-danger" id="titleProcesoDetalleOdpe"></h4>
                                                    <br>
                                                    <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                                                  </div>
                                                </div>

                                              
                                          </div>
                                        </div>
                                      </div>

                                    </div>

                                  </div>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div role="tabpanel" class="tab-pane fade" id="tab-odpe">
                    <div class="row">
                      <div class="col-md-12 col-sm-12">
                        <div class="panel panel-default panel-table m-b-0">
                          <div class="panel-heading">
                            <h4 class="text-center text-primary font-12" id="titlePerfil"><strong>REPORTE GENERAL POR ODPE</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="col-lg-12">
                              <form class="form" id="sign_registerColaborador" autocomplete="off">
                                <input class="form-control" type="hidden" id="txtIDColaborador" name="txtIDColaborador">
                                <input class="form-control" type="hidden" id="txtcontrolColaborador" name="txtcontrolColaborador" value="0">
                                <div class="panel panel-default">
                                  <!-- <div class="panel-heading">
                                    <h4 class="panel-title text-blue-grey font-12"><strong>DATOS DE LA INSTITUCI&Oacute;N</strong></h4>
                                  </div> -->
                                  <div class="panel-body">
                                    <!-- <h5 class="text-blue-grey m-b-15"><strong>DATOS LABORALES</strong></h5> -->
                                    <div class="row">
                                      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 z-8">
                                        <div class="form-group">
                                          <label>PROCESO</label>
                                          <select class="form-control" name="cboProcesoReporteOdpe" id="cboProcesoReporteOdpe" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboMaterial()" required>
                                            <option value="">[ SELECCIONE UN PROCESO ]</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 z-7">
                                        <div class="form-group">
                                          <label>MATERIAL</label>
                                            <select class="form-control" name="cboMaterialReporteOdpe" id="cboMaterialReporteOdpe" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboEtapa()" required>
                                              <option value="">[ SELECCIONE UN MATERIAL ]</option>
                                            </select>
                                        </div>
                                      </div>
                                      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 z-6">
                                        <div class="form-group">
                                          <label>ETAPA</label>
                                          <select class="form-control" name="cboEtapaReporteOdpe" id="cboEtapaReporteOdpe" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cargaAvanceODPE()" required>
                                              <option value="">[ SELECCIONE UNA ETAPA ]</option>
                                            </select>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="panel panel-default panel-table m-b-0">
                                          <div class="panel-body">                                        
                                            <div class="table-responsive">
                                              <div id="tbl_cargaOdpe" class="dataTables_wrapper form-inline" role="grid">
                                                    <h4 class="text-center text-danger" id="titleMaterialEtapa"></h4>
                                                    <div class="clearfix">
                                                      <div class="pull-left">
                                                        <a class="btn btn-success text-right" onclick="exportarReporteOdpe();"><i class="zmdi zmdi-download zmdi-hc-fw m-r-5"></i><span>DESCARGAR</span></a><br><br>
                                                      </div>
                                                      <!-- <div class="pull-right">
                                                        <a class="btn btn-black" id="verGrafico" onclick="verGraficaOdpe()"><i class="zmdi zmdi-apps zmdi-hc-fw m-r-5"></i><span> VER GRAFICO ODPE </span></a> 
                                                      </div> -->
                                                    </div><br>
                                                    <div class="table-responsive">
                                                        <table id="tableAvanceOdpe" class="display table table-bordered " cellspacing="0" width="100%">
                                                          <thead class="text-center font-table">
                                                            <tr class="bg-primary">
                                                              <th class="text-center" width="20%">ODPE</th>
                                                              <th class="text-center" width="10%">SOL. TEC.</th>
                                                              <th class="text-center" width="14%">TOTAL MESAS</th>
                                                              <th class="text-center" width="14%">RECIBIDAS</th>
                                                              <th class="text-center" width="14%">POR RECIBIR</th>
                                                              <th class="text-center" width="14%">% RECIBIDOS</th>
                                                              <th class="text-center" width="14%">% POR RECIBIR</th>
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
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div role="tabpanel" class="tab-pane fade" id="tab-usuario">
                    <div class="row">
                      <div class="col-md-12 col-sm-12">
                        <div class="panel panel-default panel-table m-b-0">
                          <div class="panel-heading">
                            <h4 class="text-center text-primary font-12" id="titlePerfil"><strong>REPORTE GENERAL USUARIO - MESA</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="col-lg-12">
                              <form class="form" id="sign_registerColaborador" autocomplete="off">
                                <input class="form-control" type="hidden" id="txtIDColaborador" name="txtIDColaborador">
                                <input class="form-control" type="hidden" id="txtcontrolColaborador" name="txtcontrolColaborador" value="0">
                                <div class="panel panel-default">
                                  <!-- <div class="panel-heading">
                                    <h4 class="panel-title text-blue-grey font-12"><strong>DATOS DE LA INSTITUCI&Oacute;N</strong></h4>
                                  </div> -->
                                  <div class="panel-body">
                                    <!-- <h5 class="text-blue-grey m-b-15"><strong>DATOS LABORALES</strong></h5> -->
                                    <div class="row">
                                      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 z-8">
                                        <div class="form-group">
                                          <label>PROCESO</label>
                                          <select class="form-control" name="cboProcesoReporteUsuario" id="cboProcesoReporteUsuario" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboMaterialUsuarioMesa()" required>
                                            <option value="">[ SELECCIONE UN PROCESO ]</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 z-7">
                                        <div class="form-group">
                                          <label>MATERIAL</label>
                                            <select class="form-control" name="cboMaterialReporteUsuario" id="cboMaterialReporteUsuario" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboEtapaUsuarioMesa()" required>
                                              <option value="">[ SELECCIONE UN MATERIAL ]</option>
                                            </select>
                                        </div>
                                      </div>
                                      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 z-6">
                                        <div class="form-group">
                                          <label>ETAPA</label>
                                          <select class="form-control" name="cboEtapaReporteUsuario" id="cboEtapaReporteUsuario" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboOdpeUsuarioMesa()" required>
                                              <option value="">[ SELECCIONE UNA ETAPA ]</option>
                                            </select>
                                        </div>
                                      </div>
                                      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 z-5">
                                        <div class="form-group">
                                          <label>ODPE</label>
                                          <select class="form-control" name="cboOdpeReporteUsuario" id="cboOdpeReporteUsuario" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cargaUsuarioMesa()" required>
                                              <option value="">[ SELECCIONE UNA ODPE ]</option>
                                            </select>
                                        </div>
                                      </div>
                                    </div>
                                    
                                    <div class="row">
                                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="panel panel-default panel-table m-b-0">
                                          <div class="panel-body">                                        
                                            <div class="table-responsive">
                                              <div id="tbl_cargaUsuarioMesa" class="dataTables_wrapper form-inline" role="grid">
                                                  <h4 class="text-center text-danger" id="titleUsuarioMesa"></h4>
                                                    <div class="clearfix">
                                                      <div class="pull-left">
                                                        <a class="btn btn-success text-right" onclick="exportarReporteUsuarioMesa();"><i class="zmdi zmdi-download zmdi-hc-fw m-r-5"></i><span>DESCARGAR</span></a><br><br>
                                                      </div>
                                                      <!-- <div class="pull-right">
                                                        <a class="btn btn-black" id="verGrafico" onclick="verGraficaOdpe()"><i class="zmdi zmdi-apps zmdi-hc-fw m-r-5"></i><span> VER GRAFICO ODPE </span></a> 
                                                      </div> -->
                                                    </div><br>
                                                    <div class="table-responsive">
                                                        <table id="tableUsuarioMesa" class="display table table-bordered " cellspacing="0" width="100%">
                                                          <thead class="text-center font-table">
                                                            <tr class="bg-primary">
                                                              <th class="text-center" width="10%">SOL. TEC.</th>
                                                              <th class="text-center" width="10%">DEPARTAMENTO</th>
                                                              <th class="text-center" width="14%">PROVINCIA</th>
                                                              <th class="text-center" width="14%">DISTRITO</th>
                                                              <th class="text-center" width="14%">MESA</th>
                                                              <th class="text-center" width="24%">USUARIO</th>
                                                              <th class="text-center" width="14%">FECHA y HORA</th>
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
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div role="tabpanel" class="tab-pane fade" id="tab-rendimiento">
                    <div class="row">
                      <div class="col-md-12 col-sm-12">
                        <div class="panel panel-default panel-table m-b-0">
                          <div class="panel-heading">
                            <h4 class="text-center text-primary font-12" id="titlePerfil"><strong>REPORTE RENDIMIENTO GR&Aacute;FICO</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="col-lg-12">
                              <form class="form" id="sign_registerColaborador" autocomplete="off">
                                <input class="form-control" type="hidden" id="txtIDColaborador" name="txtIDColaborador">
                                <input class="form-control" type="hidden" id="txtcontrolColaborador" name="txtcontrolColaborador" value="0">
                                <div class="panel panel-default">
                                  <!-- <div class="panel-heading">
                                    <h4 class="panel-title text-blue-grey font-12"><strong>DATOS DE LA INSTITUCI&Oacute;N</strong></h4>
                                  </div> -->
                                  <div class="panel-body">
                                    <!-- <h5 class="text-blue-grey m-b-15"><strong>DATOS LABORALES</strong></h5> -->
                                    <div class="row">
                                      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 z-8">
                                        <div class="form-group">
                                          <label>PROCESO</label>
                                          <select class="form-control" name="cboProcesoReporteRendimiento" id="cboProcesoReporteRendimiento" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboMaterialRendimiento()" required>
                                            <option value="">[ SELECCIONE UN PROCESO ]</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 z-7">
                                        <div class="form-group">
                                          <label>MATERIAL</label>
                                            <select class="form-control" name="cboMaterialReporteRendimiento" id="cboMaterialReporteRendimiento" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboEtapaRendimiento()" required>
                                              <option value="">[ SELECCIONE UN MATERIAL ]</option>
                                            </select>
                                        </div>
                                      </div>
                                      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 z-6">
                                        <div class="form-group">
                                          <label>ETAPA</label>
                                          <select class="form-control" name="cboEtapaReporteRendimiento" id="cboEtapaReporteRendimiento" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cargaRendimiento()" required>
                                              <option value="">[ SELECCIONE UNA ETAPA ]</option>
                                            </select>
                                        </div>
                                      </div>
                                    </div>
                                    
                                    <div class="row">
                                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="panel panel-default panel-table m-b-0">
                                          <div class="panel-body">                                        
                                            <div class="table-responsive">
                                              <h4 class="text-center text-danger" id="titleRendimiento"></h4><br><br>
                                              <div id="tbl_Rendimiento" class="dataTables_wrapper form-inline" role="grid">
                                                
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>

                                  </div>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div role="tabpanel" class="tab-pane fade" id="tab-grafico">
                    <div class="row">
                      <div class="col-md-12 col-sm-12">
                        <div class="panel panel-default panel-table m-b-0">
                          <div class="panel-heading">
                            <h4 class="text-center text-primary font-12" id="titlePerfil"><strong>REPORTE GR&Aacute;FICO - ODPE</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="col-lg-12">
                              <form class="form" id="sign_registerColaborador" autocomplete="off">
                                <input class="form-control" type="hidden" id="txtIDColaborador" name="txtIDColaborador">
                                <input class="form-control" type="hidden" id="txtcontrolColaborador" name="txtcontrolColaborador" value="0">
                                <div class="panel panel-default">
                                  <!-- <div class="panel-heading">
                                    <h4 class="panel-title text-blue-grey font-12"><strong>DATOS DE LA INSTITUCI&Oacute;N</strong></h4>
                                  </div> -->
                                  <div class="panel-body">
                                    <!-- <h5 class="text-blue-grey m-b-15"><strong>DATOS LABORALES</strong></h5> -->
                                    <div class="row">
                                      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 z-8">
                                        <div class="form-group">
                                          <label>PROCESO</label>
                                          <select class="form-control" name="cboProcesoReporteGrafico" id="cboProcesoReporteGrafico" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboMaterialGrafico()" required>
                                            <option value="">[ SELECCIONE UN PROCESO ]</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 z-7">
                                        <div class="form-group">
                                          <label>MATERIAL</label>
                                            <select class="form-control" name="cboMaterialReporteGrafico" id="cboMaterialReporteGrafico" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboEtapaGrafico()" required>
                                              <option value="">[ SELECCIONE UN MATERIAL ]</option>
                                            </select>
                                        </div>
                                      </div>
                                      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 z-6">
                                        <div class="form-group">
                                          <label>ETAPA</label>
                                          <select class="form-control" name="cboEtapaReporteGrafico" id="cboEtapaReporteGrafico" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboOdpeGrafico()" required>
                                              <option value="">[ SELECCIONE UNA ETAPA ]</option>
                                            </select>
                                        </div>
                                      </div>
                                      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 z-5">
                                        <div class="form-group">
                                          <label>ODPE</label>
                                          <select class="form-control" name="cboOdpeReporteGrafico" id="cboOdpeReporteGrafico" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cargaOdpeGrafico()" required>
                                              <option value="">[ SELECCIONE UNA ODPE ]</option>
                                            </select>
                                        </div>
                                      </div>
                                    </div>
                                    
                                    <div class="row">
                                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="panel panel-default panel-table m-b-0">
                                          <div class="panel-body">                                        
                                            <div class="table-responsive">
                                              <h4 class="text-center text-danger" id="titleOdpeGrafico"></h4><br><br>
                                              <div id="tbl_cargaGrafico" class="dataTables_wrapper form-inline" role="grid">
                                                  
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>

                                  </div>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div role="tabpanel" class="tab-pane fade" id="tab-estadistico">
                    <div class="row">
                      <div class="col-md-12 col-sm-12">
                        <div class="panel panel-default panel-table m-b-0">
                          <div class="panel-heading">
                            <h4 class="text-center text-primary font-12" id="titlePerfil"><strong>ESTAD&Iacute;STICO DE MESAS</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="col-lg-12">
                              <form class="form" id="sign_registerColaborador" autocomplete="off">
                                <input class="form-control" type="hidden" id="txtIDColaborador" name="txtIDColaborador">
                                <input class="form-control" type="hidden" id="txtcontrolColaborador" name="txtcontrolColaborador" value="0">
                                <div class="panel panel-default">
                                  <!-- <div class="panel-heading">
                                    <h4 class="panel-title text-blue-grey font-12"><strong>DATOS DE LA INSTITUCI&Oacute;N</strong></h4>
                                  </div> -->
                                  <div class="panel-body">
                                    <!-- <h5 class="text-blue-grey m-b-15"><strong>DATOS LABORALES</strong></h5> -->
                                    <div class="row">
                                      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 z-8">
                                        <div class="form-group">
                                          <label>PROCESO</label>
                                          <select class="form-control" name="cboProcesoReporteEstadistico" id="cboProcesoReporteEstadistico" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboSolTecEstadistico()" required>
                                            <option value="">[ SELECCIONE UN PROCESO ]</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 z-7">
                                        <div class="form-group">
                                          <label>SOLUCI&Oacute;N TECNOL&Oacute;GICA</label>
                                            <select class="form-control" name="cboSolTecReporteEstadistico" id="cboSolTecReporteEstadistico" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboOdpeEstadistico()" required>
                                              <option value="">[ SELECCIONE UNA SOL. TEC. ]</option>
                                            </select>
                                        </div>
                                      </div>
                                      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 z-6">
                                        <div class="form-group">
                                          <label>ODPE</label>
                                          <select class="form-control" name="cboOdpeReporteEstadistico" id="cboOdpeReporteEstadistico" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboDepartEstadistico()" required>
                                              <option value="">[ SELECCIONE UNA ODPE ]</option>
                                            </select>
                                        </div>
                                      </div>
                                    
                                      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 z-5">
                                        <div class="form-group">
                                          <label>DEPARTAMENTO</label>
                                          <select class="form-control" name="cboDepartReporteEstadistico" id="cboDepartReporteEstadistico" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboProvEstadistico()" required>
                                              <option value="">[ SELECCIONE UN DEPARTAMENTO ]</option>
                                            </select>
                                        </div>
                                      </div>
                                      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 z-4">
                                        <div class="form-group">
                                          <label>PROVINCIA</label>
                                          <select class="form-control" name="cboProvReporteEstadistico" id="cboProvReporteEstadistico" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboDistEstadistico()" required>
                                              <option value="">[ SELECCIONE UNA PROVINCIA ]</option>
                                            </select>
                                        </div>
                                      </div>
                                      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 z-3">
                                        <div class="form-group">
                                          <label>DISTRiTO</label>
                                          <select class="form-control" name="cboDistReporteEstadistico" id="cboDistReporteEstadistico" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="reporteEstadistico()" required>
                                              <option value="">[ SELECCIONE UN DISTRiTO ]</option>
                                            </select>
                                        </div>
                                      </div>
                                    </div>
                                    
                                    <div class="row">
                                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="panel panel-default panel-table m-b-0">
                                          <div class="panel-body"> <br>                                      
                                            <div class="table-responsive">
                                              <div id="tbl_cargaEstadistico" class="dataTables_wrapper form-inline" role="grid">
                                                     
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>

                                  </div>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div role="tabpanel" class="tab-pane fade" id="tab-estado_mesa"> 
                    <div class="row">
                      <div class="col-md-3 col-sm-3">
                        <div class="panel panel-default panel-table m-b-0">
                          <div class="panel-heading">
                            <h4 class="text-center text-primary font-12" id="titleUsuario"><strong>CONSULTA MESA</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="row">
                              <!-- <div class="col-lg-1"></div> -->
                              <div class="col-lg-12">
                                <form class="form" id="sign_registerUsuario" method="POST" autocomplete="off" action="javascript:void(0);">
                                  <input class="form-control" type="hidden" id="txtIDUsuario" name="txtIDUsuario">
                                  <input class="form-control" type="hidden" id="txtcontrolUsuario" name="txtcontrolUsuario" value="0">
                                  <div class="panel panel-default">
                                    <div class="panel-body">
                                      <!-- <h5 class="text-blue-grey m-b-15"><strong>DATOS PERSONALES</strong></h5> -->
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 z-8">
                                          <div class="form-group">
                                            <label>PROCESO</label>
                                            <select class="form-control" name="cboProcesoReporteConsulta" id="cboProcesoReporteConsulta" onChange="cboMesaConsulta()" data-size="6" data-live-search="true">
                                              <option value="">[ SELECCIONE UN PROCESO ]</option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="form-group">
                                            <label>NRo MESA</label>
                                            <input class="form-control vld" type="text" id="txtMesaReporteConsulta" name="txtMesaReporteConsulta" maxlength="6" onkeypress="SoloNum()" onkeyup="reporteConsultMesa()" placeholder="NRO DE MESA" disabled>
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
                            <h4 class="text-center text-primary font-12"><strong>ESTADO GENERAL DE MESA</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group text-center">
                                  <span class="font-24 text-blue-grey" id="txtMesa" style="font-size: 36px !important"></span>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="font-size: 18px !important">
                                <div class="form-group">
                                  <label>ODPE / ORC: </label>
                                  <span class="font-15" id="txtOdpe"></span>
                                </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="font-size: 18px !important">
                                <div class="form-group">
                                  <label>SOLUCI&Oacute;N TECNOL&Oacute;GICA: </label>
                                  <span class="font-15" id="txtSoltec"></span>
                                </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="font-size: 18px !important">
                                <div class="form-group">
                                  <label>NRO. DE ELECTORES: </label>
                                  <span class="font-15" id="txtNroElectores"></span>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="font-size: 18px !important">
                                <div class="form-group">
                                  <label>DEPARTAMENTO: </label>
                                  <span class="font-15" id="txtDepartamento"></span>
                                </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="font-size: 18px !important">
                                <div class="form-group">
                                  <label>PROVINCIA: </label>
                                  <span class="font-15" id="txtProvincia"></span>
                                </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="font-size: 18px !important">
                                <div class="form-group">
                                  <label>DISTRITO: </label>
                                  <span class="font-15" id="txtDistrito"></span>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="font-size: 18px !important">
                                <div class="form-group">
                                  <label>LOCAL: </label>
                                  <span class="font-15" id="txtLocal"></span>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="font-size: 18px !important">
                                <div class="form-group">
                                  <label>ARCHIVO DE CONTROL DE CALIDAD: </label>
                                  <span class="font-15" id="fileMesa"></span>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <!-- <div class="col-lg-1"></div> -->
                              <div class="col-lg-12">
                                <div class="table-responsive">
                                  <div id="tbl_ConsultaMesa" class="dataTables_wrapper form-inline" role="grid">
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

                  <div role="tabpanel" class="tab-pane fade" id="tab-otros-materiales">
                    <div class="row">
                      <div class="col-md-12 col-sm-12">
                        <div class="panel panel-default panel-table m-b-0">
                          <div class="panel-heading">
                            <h4 class="text-center text-primary font-12" id="titlePerfil"><strong>REPORTE OTROS MATERIALES</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="col-lg-12">
                              <form class="form" id="sign_registerColaborador" autocomplete="off">
                                <input class="form-control" type="hidden" id="txtIDColaborador" name="txtIDColaborador">
                                <input class="form-control" type="hidden" id="txtcontrolColaborador" name="txtcontrolColaborador" value="0">
                                <div class="panel panel-default">
                                  <!-- <div class="panel-heading">
                                    <h4 class="panel-title text-blue-grey font-12"><strong>DATOS DE LA INSTITUCI&Oacute;N</strong></h4>
                                  </div> -->
                                  <div class="panel-body">

                                    <ul class="nav nav-tabs nav-tabs-custom m-b-15">
                                      <li class="active">
                                        <a href="#tab-avance-general-otros" role="tab" data-toggle="tab" aria-expanded="true">
                                          <i class="zmdi zmdi-apps"></i> REPORTE AVANCE</a>
                                      </li>
                                      <li class="">
                                        <a href="#tab-avance-rendimiento-otros" role="tab" data-toggle="tab" aria-expanded="true">
                                          <i class="zmdi zmdi-apps"></i> REPORTE RENDIMIENTO</a>
                                      </li>

                                    </ul>
                                    <div class="tab-content">
                                      <div role="tabpanel" class="tab-pane fade active in" id="tab-avance-general-otros">
                                        <div class="row">
                                          <div class="col-md-12 col-sm-12">
                                            <div class="panel panel-default panel-table m-b-0">
                                              <div class="panel-heading">
                                                <h4 class="text-center text-danger font-12" id="titlePerfil"><strong>REPORTE AVANCE GENERAL</strong></h4>
                                              </div>
                                              <div class="panel-body">
                                                <div class="row">
                                                  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 z-8">
                                                    <div class="form-group">
                                                      <label>PROCESO</label>
                                                      <select class="form-control" name="cboProcesoReporteAvance_Otros" id="cboProcesoReporteAvance_Otros" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboCargaAvanceOtros()" required>
                                                        <option value="">[ SELECCIONE PROCESO ]</option>
                                                      </select>
                                                    </div>
                                                  </div>
                                                  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 z-7">
                                                  </div>
                                                  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 z-6">
                                                    <div class="clearfix m-t-30">
                                                        <div class="pull-right">
                                                           <a class="btn btn-blue btn-sm" data-dismiss="modal" id="updateOtros"  onclick="cboCargaAvanceOtros();"><i class="zmdi zmdi-refresh zmdi-hc-fw"></i><span></span></a>
                                                        </div>
                                                  </div>
                                                  </div>
                                                </div>

                                                <div class="row">
                                                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="panel panel-default panel-table m-b-0">
                                                      <div class="panel-body">                                        
                                                        <div class="table-responsive">
                                                          <div id="tbl_cargaAvance" class="dataTables_wrapper form-inline" role="grid">
                                                            <h4 class="text-center text-danger" id="titleProcesoOtros"></h4>
                                                            <br>
                                                            <div class="table-responsive">
                                                                <table id="tableAvanceGeneralOtros" class="display table table-bordered " cellspacing="0" width="100%">
                                                                  <thead class="text-center font-table">
                                                                    <tr class="bg-primary">
                                                                      <th class="text-center" width="20%" rowspan="2">NOMBRE ODPE</th>
                                                                      <th class="text-center" width="80%" colspan="3">CEDULAS DE RESERVA</th>
                                                                    </tr>
                                                                    <tr class="bg-primary">
                                                                      <th class="text-center" width="25%">CANTIDAD RESERVA</th>
                                                                      <th class="text-center" width="25%">CANTIDAD ENVIADA</th>
                                                                      <th class="text-center" width="30%">OBSERVACION</th>
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

                                      <div role="tabpanel" class="tab-pane fade" id="tab-avance-rendimiento-otros">
                                        <div class="row">
                                          <div class="col-md-12 col-sm-12">
                                            <div class="panel panel-default panel-table m-b-0">
                                              <div class="panel-heading">
                                                <h4 class="text-center text-danger font-12" id="titlePerfil"><strong>REPORTE RENDIMIENTO</strong></h4>
                                              </div>
                                              <div class="panel-body">

                                                <!-- <h5 class="text-blue-grey m-b-15"><strong>DATOS LABORALES</strong></h5> -->
                                                <div class="row">
                                                  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 z-8">
                                                    <div class="form-group">
                                                      <label>PROCESO</label>
                                                      <select class="form-control" name="cboProcesoReporteRendimiento_Otros" id="cboProcesoReporteRendimiento_Otros" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboMaterialRendimiento_Otros()" required>
                                                        <option value="">[ SELECCIONE UN PROCESO ]</option>
                                                      </select>
                                                    </div>
                                                  </div>
                                                  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 z-7">
                                                    <div class="form-group">
                                                      <label>MATERIAL</label>
                                                        <select class="form-control" name="cboMaterialReporteRendimiento_Otros" id="cboMaterialReporteRendimiento_Otros" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboEtapaRendimiento_Otros()" required>
                                                          <option value="">[ SELECCIONE UN MATERIAL ]</option>
                                                        </select>
                                                    </div>
                                                  </div>
                                                  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 z-6">
                                                    <div class="form-group">
                                                      <label>ETAPA</label>
                                                      <select class="form-control" name="cboEtapaReporteRendimiento_Otros" id="cboEtapaReporteRendimiento_Otros" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cargaRendimiento_Otros()" required>
                                                          <option value="">[ SELECCIONE UNA ETAPA ]</option>
                                                        </select>
                                                    </div>
                                                  </div>
                                                </div>
                                                
                                                <div class="row">
                                                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="panel panel-default panel-table m-b-0">
                                                      <div class="panel-body">                                        
                                                        <div class="table-responsive">
                                                          <h4 class="text-center text-danger" id="titleRendimiento_Otros"></h4><br><br>
                                                          <div id="tbl_Rendimiento_Otros" class="dataTables_wrapper form-inline" role="grid">
                                                            
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

                                  </div>
                                </div>
                              </form>
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
           
          

      <img src="" >
      </div>
      <div class="site-footer">
        2021 © Sistema
      </div>
    </div>
    
    <<!-- FOOTER -->
    <?php footerAdmin($data); ?>
    <script src="<?= media();?>/js/Highcharts/code/highcharts.js"></script>
    <script src="<?= media();?>/js/Highcharts/code/modules/exporting.js"></script>
    <script src="<?= media();?>/js/Highcharts/code/modules/export-data.js"></script>
    <script src="<?= media();?>/js/Highcharts/code/highcharts-more.js"></script>
    <script src="<?= media();?>/js/Highcharts/code/modules/solid-gauge.js"></script>
  </body>

<!-- Mirrored from big-bang-studio.com/cosmos/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 10 Jan 2019 12:53:30 GMT -->
</html>