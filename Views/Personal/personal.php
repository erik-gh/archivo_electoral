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
                    <a href="#tab-personal" role="tab" data-toggle="tab" aria-expanded="true">
                      <i class="zmdi zmdi-labels"></i> PERSONAL</a>
                  </li>
                  
                </ul>

                <div class="tab-content">
                  <div role="tabpanel" class="tab-pane fade active in" id="tab-personal">
                    <div class="row">
                      <div class="col-md-4 col-sm-4">
                        <div class="panel panel-default panel-table m-b-0">
                          <div class="panel-heading">
                            <h4 class="text-center text-primary font-12" id="titlePersonal"><strong>REGISTRAR PERSONAL</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="row">
                              <!-- <div class="col-lg-1"></div> -->
                              <div class="col-lg-12">
                                <form class="form" id="form_registerPersonal" method="POST" autocomplete="off" action="javascript:void(0);">
                                  <input class="form-control" type="hidden" id="txtIDPersonal" name="txtIDPersonal">
                                  <input class="form-control" type="hidden" id="txtcontrolPersonal" name="txtcontrolPersonal" value="0">
                                  <div class="panel panel-default">
                                    <div class="panel-body">
                                      <!-- <h5 class="text-blue-grey m-b-15"><strong>DATOS PERSONALES</strong></h5> -->
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="form-group">
                                            <label>D.N.I.:</label>
                                            <div class="input-group-prepend">
                                              <input class="form-control vld" type="text" id="txtdni" name="txtdni" minlength="8" maxlength="8" onkeypress="SoloNum()" required>
                                            </div>
                                          </div>
                                        </div>
                                        <div id="personal_nombre">
                                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                              <label>Apellidos</label>
                                              <div class="input-group-prepend">
                                                <input class="form-control vld" type="text" id="txtapellidos" name="txtapellidos" required>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                              <label>Nombres</label>
                                              <div class="input-group-prepend">
                                                <input class="form-control vld" type="text" id="txtnombre" name="txtnombre" required>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div id="personal_nombreCompleto" style="display: none;">
                                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                              <label>Nombre Completo</label>
                                              <div class="input-group-prepend">
                                                <input class="form-control" type="text" id="txtnombreCompleto" name="txtnombreCompleto" required>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 z-9">
                                          <div class="form-group">
                                            <label>Cargo</label>
                                            <select class="form-control" name="cbocargo" id="cbocargo" data-dropup-auto="false" data-size="10" data-live-search="true" required>
                                            </select>
                                          </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 z-8">
                                          <div class="form-group">
                                            <label>Gerencia</label>
                                            <select class="form-control" name="cbogerencia" id="cbogerencia" data-dropup-auto="false" data-size="10" data-live-search="true" required>
                                              <!-- <option value="">[ Seleccione Gerencia ]</option>
                                              <option value="1">GGE</option>
                                              <option value="2">GITE</option>
                                              <option value="3">GAD</option> -->

                                            </select>
                                          </div>
                                        </div>

                                        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
                                          <div class="form-group">
                                            <!-- <label>Archivo</label> -->
                                            <div class="input-group-prepend">
                                              <div class="input-container m-b-5">
                                                <input class="form-control" type="file" id="archivo1" name="archivo1" accept="image/png, image/jpeg">
                                                <button type="button" class="browse-btn1 btn btn-primary">Seleccionar Imagen</button>
                                                <span id="txtnameuploadImg" class="file-info1" >Imagen a subir</span>
                                              </div>
                                            </div>
                                            <span id="errorfileimg" class="text-danger font-table "></span>
                                          </div>
                                        </div>
                                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="margin-left: -40px">
                                          <button type="button" class="btn btn-danger" id="deletimg" data-toggle="tooltip" title="Eliminar" onclick="limpiarImg();">
                                            <i class="zmdi zmdi-close zmdi-hc-fw"></i>
                                          </button>

                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <span class="col-pink font-12"><b>(Tama&ntilde;o máx: 1MB - Dimensiones entre 500px y 60px)</b></span>
                                        </div>
                                        <input type="hidden" class="form-control input-sm" id="file_temp">
                                        <input type="hidden" class="form-control input-sm" id="file_delete">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="form-group">
                                            <div class="col-xs-5 col-sm-12 col-md-12 col-lg-5">
                                              <div class="panel panel-default">
                                                <div  id="img_personal" style="height: 165px; padding: 15px 5px;">
                                                
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="estado_personal" style="display: none;">
                                          <div class="pull-left">
                                            <div class="switches-stacked">
                                              <label>Activo</label>
                                              <label class="switch switch-primary">  
                                                <input type="checkbox" id="chkestadoPersonal" name="chkestadoPersonal" class="s-input">
                                                <span class="s-content">
                                                  <span class="s-track"></span>
                                                  <span class="s-handle"></span>
                                                </span>
                                              </label>
                                            </div>
                                          </div>

                                          <div class="pull-right">
                                            <label class="custom-control custom-control-default custom-checkbox active">
                                              <input id="view_checkbox_black" name="view_checkbox_black" class="custom-control-input" type="checkbox" name="custom" onclick="mostrarEstado();">
                                              <span class="custom-control-indicator"></span>
                                              <span class="custom-control-label">Lista Negra</span>
                                            </label>
                                          </div>

                                        </div>
                                      </div>

                                      <div class="clearfix m-t-30">
                                        <div class="pull-right">
                                          <button type="submit" class="btn btn-outline-primary" id="agregarPersonal"><i class="zmdi zmdi-check zmdi-hc-fw m-r-5"></i><span> Guardar</span></button>
                                          <button type="submit" class="btn btn-outline-primary" id="updatePersonal" style="display: none;i"><i class="zmdi zmdi-refresh zmdi-hc-fw m-r-5"></i><span> Actualizar</span></button>
                                          <a class="btn btn-outline-danger" data-dismiss="modal" id="cancelPersonal" onclick="cancelPersonal()"><i class="zmdi zmdi-close zmdi-hc-fw m-r-5"></i><span>Cancelar</span></a>
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
                            <h4 class="text-center text-primary font-12"><strong>LISTA DE PERSONAL</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="clearfix">
                                <div class="pull-left">
                                    <a href="#modal_importar" data-toggle="modal" class="btn btn-purple" id="importPlantilla"><i class="zmdi zmdi-upload  zmdi-hc-fw m-r-5"></i><span> Importar Personal</span></a>
                                </div>
                                <div class="pull-right">
                                    <a class="btn btn-primary" id="downloadPersonal" onclick="descargarPersonal()"><i class="zmdi zmdi-download  zmdi-hc-fw m-r-5"></i><span> Descargar Personal </span></a> 
                                    <a class="btn btn-black" id="downloadPlantilla" onclick="descargarPlantilla()"><i class="zmdi zmdi-download zmdi-hc-fw m-r-5" ></i><span> Descargar Plantilla</span></a>
                                </div>
                            </div><br>
                            <div class="table-responsive">
                              <div id="tbl_personal" class="dataTables_wrapper form-inline" role="grid">
                                <table id="tablePersonal" class="display table table-bordered table-hover" cellspacing="0" width="100%">
                                  <thead class="text-center font-table">
                                      <tr class="bg-primary">
                                          <th class="text-center" width="5%">Nº</th>
                                          <th class="text-center" width="10%">DNI</th>
                                          <th class="text-center" width="25%">APELLIDOS Y NOMBRES</th>
                                          <th class="text-center" width="25%">CARGO</th>
                                          <th class="text-center" width="10%">GERENCIA</th>
                                          <th class="text-center" width="10%">ESTADO</th>
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

      </div>
      <div class="site-footer">
        2021 © Sistema
      </div>
    </div>

    <!-- #Modal-import -->
    <div class="modal fade" id="modal_importar" class="modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">
                <i class="zmdi zmdi-close"></i>
              </span>
            </button>
            <h4 class="modal-title text-center text-primary" id="title-import"><b>IMPORTAR PERSONAL</b></h4>
          </div>
          <div class="modal-body">
            <div class="text-center">
              <div class="text-primary">
                <i class="zmdi zmdi-cloud-upload zmdi-hc-4x"></i>
              </div>
            </div>
            <div class="col-lg-1"></div>
            <div class="col-lg-10">
              <form class="form" id="file_upload" method="POST" autocomplete="off" action="javascript:void(0);">
                <input type="hidden" name="txtControlImportar" id="txtControlImportar">
                <div class="panel panel-default panel-table m-b-0">
                      <!-- <div class="panel-heading">
                        <h4 class="text-center text-primary font-12"><strong></strong></h4>
                      </div> -->
                      <div class="panel-body">
                       <div class="alert alert-outline-success alert-dismissable font-table" role="alert">
                        <span class="alert-icon">
                          <i class="zmdi zmdi-primary-outline"></i>
                        </span>
                        <strong>Importante!</strong> Solo se permite archivos con extensi&oacute;n <strong>.XLSX</strong>.
                      </div>
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                          <div class="form-group">
                            <!-- <label>Archivo</label> -->
                            <div class="input-group-prepend">
                              <div class="input-container m-b-5">
                                <input class="form-control vld" type="file" id="archivo" name="archivo" accept=".xlsx" required>
                                <button type="button" class="browse-btn btn btn-primary">Seleccionar Archivo</button>
                                <span id="txtnameupload" class="file-info" >Archivo a subir</span>
                              </div>
                            </div>
                            <span id="errorfile" class="text-danger font-table "></span>
                          </div>
                          <div class="progress">
                            <div id="barraProgreso" class="progress-bar progress-bar-primary progress-bar-striped active" role="progressbar" aria-valuenow="32" aria-valuemin="0" aria-valuemax="100">
                              <span class="sr-only"></span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="clearfix m-t-30">
                        <div class="pull-right">
                          <button type="submit" class="btn btn-outline-primary" id="agregarImportar"><i class="zmdi zmdi-cloud-upload zmdi-hc-fw m-r-5"></i><span> Importar</span></button>
                          <a class="btn btn-outline-danger" data-dismiss="modal" id="cancelImportar" onclick="cancelImportar();"><i class="zmdi zmdi-close zmdi-hc-fw m-r-5" ></i><span>Cerrar</span></a>
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
      <!-- #END Modal-import -->
    
    
    <!-- #Modal-Imnformacion -->
    <div class="modal fade" id="modal_informacion" class="modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">
                <i class="zmdi zmdi-close"></i>
              </span>
            </button>
            <h4 class="modal-title text-center text-primary" id="title-import"><b>INFORMACI&Oacute;N DE LA IMPORTACI&Oacute;N</b></h4>
          </div>
          <div class="modal-body">
            <div class="text-center">
              <div class="text-primary">
                <i class="zmdi zmdi-info zmdi-hc-4x"></i>
              </div>
            </div>
            <div class="col-lg-12">
              <form class="form" id="file_upload" method="POST" autocomplete="off" action="javascript:void(0);">
                <input type="hidden" name="txtControlImportar" id="txtControlImportar">
                <div class="panel panel-default panel-table m-b-0">
                      <!-- <div class="panel-heading">
                        <h4 class="text-center text-primary font-12"><strong></strong></h4>
                      </div> -->
                    <div class="panel-body">
                      <div class="table-responsive">
                        <div id="tbl_cargaInfo" class="dataTables_wrapper form-inline" role="grid">

                        </div>
                      </div>
                      <div class="clearfix m-t-30">
                        <div class="pull-right">
                          <a class="btn btn-outline-danger" data-dismiss="modal" id="cancelImportar" onclick="cancelImportar();"><i class="zmdi zmdi-close zmdi-hc-fw m-r-5" ></i><span>Cerrar</span></a>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="modal-footer"></div>
          </div>
        </div>
      </div>
      <!-- #END Modal-import -->
    <!-- FOOTER -->
    
    <?php footerAdmin($data); ?>
  </body>

<!-- Mirrored from big-bang-studio.com/cosmos/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 10 Jan 2019 12:53:30 GMT -->
</html>