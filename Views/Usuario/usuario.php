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
                    <a href="#tab-profile" role="tab" data-toggle="tab" aria-expanded="true">
                      <i class="zmdi zmdi-accounts-list-alt"></i> PERFILES</a>
                  </li>
                  <li class="">
                    <a href="#tab-user" role="tab" data-toggle="tab" aria-expanded="false" onclick="cboPerfilUsuarios(); verlistadoUsuarios();">
                      <i class="zmdi zmdi-account-add"></i> USUARIOS</a>
                  </li>
                  <li class="">
                    <a href="#tab-module" role="tab" data-toggle="tab" aria-expanded="false">
                      <i class="zmdi zmdi-view-module"></i> M&Oacute;DULOS</a>
                  </li>
                  <li class="">
                    <a href="#tab-asignar" role="tab" data-toggle="tab" aria-expanded="false" onclick="cboPerfilModulo(); multicboModulos(); verlistadoAsignar();">
                      <i class="zmdi zmdi-assignment-check"></i> ASIGNAR M&Oacute;DULOS</a>
                  </li>
                </ul>

                <div class="tab-content">
                  <div role="tabpanel" class="tab-pane fade active in" id="tab-profile">
                    <div class="row">
                      <div class="col-md-4 col-sm-4">
                        <div class="panel panel-default panel-table m-b-0">
                          <div class="panel-heading">
                            <h4 class="text-center text-primary font-12" id="titlePerfil"><strong>REGISTRAR PERFIL</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="row">
                              <!-- <div class="col-lg-1"></div> -->
                              <div class="col-lg-12">
                                <form class="form" id="form_registerPerfil" method="POST" autocomplete="off" action="javascript:void(0);">
                                  <input class="form-control" type="hidden" id="txtIDPerfil" name="txtIDPerfil">
                                  <input class="form-control" type="hidden" id="txtcontrolPerfil" name="txtcontrolPerfil" value="0">
                                  <div class="panel panel-default">
                                    <div class="panel-body">
                                      <!-- <h5 class="text-blue-grey m-b-15"><strong>DATOS PERSONALES</strong></h5> -->
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="form-group">
                                            <label>Perfil</label>
                                            <div class="input-group-prepend">
                                              <input class="form-control vld" type="text" id="txtperfil" name="txtperfil" required>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="form-group">
                                            <label>Descricpci&oacute;n</label>
                                            <div class="input-group-prepend">
                                              <input class="form-control vld" type="text" id="txtdescripcion" name="txtdescripcion" required>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <!-- <h5 class="text-blue-grey m-b-15"><strong>DATOS DEL USUARIO</strong></h5> -->
                                      <div class="row" id="estado_perfil" style="display: none;">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="switches-stacked">
                                            <label>Activo</label>
                                            <label class="switch switch-primary">  
                                              <input type="checkbox" id="chkestadoPerfil" name="chkestadoPerfil" class="s-input">
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
                                          <button type="submit" class="btn btn-outline-primary" id="agregarPerfil"><i class="zmdi zmdi-check zmdi-hc-fw m-r-5"></i><span> Guardar</span></button>
                                          <button type="submit" class="btn btn-outline-primary" id="updatePerfil" style="display: none;"><i class="zmdi zmdi-refresh zmdi-hc-fw m-r-5"></i><span> Actualizar</span></button>
                                          <a class="btn btn-outline-danger" data-dismiss="modal" id="cancelPerfil" onclick="cancelPerfil();"><i class="zmdi zmdi-close zmdi-hc-fw m-r-5"></i><span>Cancelar</span></a>
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
                            <h4 class="text-center text-primary font-12"><strong>LISTA DE PERFILES</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="table-responsive">
                              <div id="tbl_perfil" class="dataTables_wrapper form-inline" role="grid">
                                <table id="tablePerfiles" class="display table table-bordered table-hover" cellspacing="0" width="100%">
                                  <thead class="text-center font-table">
                                      <tr class="bg-primary">
                                          <th class="text-center" width="10%">Nº</th>
                                          <th class="text-center" width="25%">PERFIL</th>
                                          <th class="text-center" width="25%">DESCRIPCI&Oacute;N</th>
                                          <th class="text-center" width="20%">ESTADO</th>
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
                 
                  <div role="tabpanel" class="tab-pane fade" id="tab-user"> 
                    <div class="row">
                      <div class="col-md-5 col-sm-5">
                        <div class="panel panel-default panel-table m-b-0">
                          <div class="panel-heading">
                            <h4 class="text-center text-primary font-12" id="titleUsuario"><strong>REGISTRAR USUARIO</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="row">
                              <!-- <div class="col-lg-1"></div> -->
                              <div class="col-lg-12">
                                <form class="form" id="form_registerUsuario" method="POST" autocomplete="off" action="javascript:void(0);">
                                  <input class="form-control" type="hidden" id="txtIDUsuario" name="txtIDUsuario">
                                  <input class="form-control" type="hidden" id="txtcontrolUsuario" name="txtcontrolUsuario" value="0">
                                  <div class="panel panel-default">
                                    <div class="panel-body">
                                      <h5 class="text-blue-grey m-b-15"><strong>DATOS PERSONALES</strong></h5>
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="form-group">
                                            <label>DNI</label>
                                            <div class="input-group-prepend">
                                              <input class="form-control vld" type="text" id="txtDNI" name="txtDNI" minlength="8" maxlength="8" onkeypress="SoloNum()" onkeyup="nickname()" required>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="form-group">
                                            <label>Apellidos</label>
                                            <div class="input-group-prepend">
                                              <input class="form-control vld" type="text" id="txtapellido" name="txtapellido" required>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="form-group">
                                            <label>Nombres</label>
                                            <div class="input-group-prepend">
                                              <input class="form-control vld" type="text" id="txtnombre" name="txtnombre" required>
                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                      <h5 class="text-blue-grey m-b-15"><strong>DATOS DEL USUARIO</strong></h5>
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="form-group">
                                            <label>Perfil</label>
                                            <select class="form-control" name="cboperfil" id="cboperfil" data-live-search="true" data-size="5" required>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="form-group">
                                            <label>Usuario</label>
                                            <div class="input-group-prepend">
                                              <input class="form-control vld" type="text" id="txtusuario" name="txtusuario" disabled="true" required>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <!--<div class="row" id="pass_user">
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                          <div class="form-group">
                                            <label>Contrase&ntilde;a</label>
                                            <div class="input-group-prepend">
                                              <input class="form-control vld" type="password" id="txtpassword" name="txtpassword" required>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                          <div class="form-group">
                                            <label>Repetir Contrase&ntilde;a</label>
                                            <div class="input-group-prepend">
                                              <input class="form-control vld" type="password" id="txtpassword2" name="txtpassword2" required>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <label class="custom-control custom-control-primary custom-checkbox active">
                                            <input id="view_checkbox_pass" class="custom-control-input" type="checkbox" name="custom" onclick="mostrarContrasena();">
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-label">Mostrar Contrase&ntilde;a</span>
                                          </label>
                                        </div>
                                      </div>-->
                                      <div class="row" id="estado_user" style="display: none;">
                                        <div class="col-xs-2 col-sm-2 col-md-4 col-lg-4">
                                          <div class="switches-stacked">
                                            <label>Activo</label>
                                            <label class="switch switch-primary">  
                                              <input type="checkbox" id="chkestadoUsuario" name="chkestadoUsuario" class="s-input">
                                              <span class="s-content">
                                                <span class="s-track"></span>
                                                <span class="s-handle"></span>
                                              </span>
                                            </label>
                                          </div>
                                        </div>
                                        <div class="col-xs-10 col-sm-10 col-md-8 col-lg-8 text-right">
                                          <a data-toggle="modal" href="#modal_newpass" class="btn btn-outline-primary"><i class="zmdi zmdi-lock zmdi-hc-fw m-r-5"></i><span class="font-12 font-bold">Cambiar Contrase&ntilde;a</span></a>
                                        </div>
                                      </div>
                                      <div class="clearfix m-t-30">
                                        <div class="pull-right">
                                          <button type="submit" class="btn btn-outline-primary" id="agregarUsuario"><i class="zmdi zmdi-check zmdi-hc-fw m-r-5"></i><span> Guardar</span></button>
                                          <button type="submit" class="btn btn-outline-primary" id="updateUsuario" style="display: none;"><i class="zmdi zmdi-refresh zmdi-hc-fw m-r-5"></i><span> Actualizar</span></button>
                                          <a class="btn btn-outline-danger" data-dismiss="modal" id="cancelUsuario" onclick="cancelUsuario();"><i class="zmdi zmdi-close zmdi-hc-fw m-r-5"></i><span>Cancelar</span></a>
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

                      <div class="col-md-7 col-sm-7">
                        <div class="panel panel-default panel-table m-b-0">
                          <div class="panel-heading">
                            <h4 class="text-center text-primary font-12"><strong>LISTA DE USUARIOS</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="table-responsive">
                              <div id="tbl_usuario" class="dataTables_wrapper form-inline" role="grid">
                                <table id="tableUsuarios" class="display table table-bordered table-hover" cellspacing="0" width="100%">
                                  <thead class="text-center font-table">
                                    <tr class="bg-primary">
                                      <th class="text-center" width="5%">Nº</th>
                                      <th class="text-center" width="10%">DNI</th>
                                      <th class="text-center" width="25%">APELLIDOS</th>
                                      <th class="text-center" width="20%">NOMBRES</th>
                                      <th class="text-center" width="10%">PERFIL</th>
                                      <th class="text-center" width="10%">USUARIO</th>
                                      <th class="text-center" width="10%">ESTADO</th>
                                      <th class="text-center" width="10%">&nbsp;&nbsp;ACCI&Oacute;N&nbsp;&nbsp;</th>
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

                  <div role="tabpanel" class="tab-pane fade" id="tab-module">
                    <div class="row">
                      <div class="col-md-12 col-sm-12">
                        <div class="panel panel-default panel-table m-b-0">
                          <div class="panel-heading">
                            <h4 class="text-center text-primary font-12"><strong>LISTA DE M&Oacute;DULOS</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="table-responsive">
                              <div id="tbl_modulo" class="dataTables_wrapper form-inline" role="grid">
                                <table id="tableModulo" class="display table table-bordered table-hover" cellspacing="0" width="100%">
                                  <thead class="text-center font-table">
                                    <tr class="bg-primary">
                                      <th class="text-center" width="5%">N</th>
                                      <th class="text-center" width="20%">M&Oacute;DULO</th>
                                      <th class="text-center" width="30%">DESCRIPCI&Oacute;N</th>
                                      <th class="text-center" width="10%">PÁGINA</th>
                                      <th class="text-center" width="10%">ICONO</th>
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
                  
                  <div role="tabpanel" class="tab-pane fade" id="tab-asignar">
                    <div class="row">

                      <div class="col-md-4 col-sm-4">
                        <div class="panel panel-default panel-table m-b-0">
                          <div class="panel-heading">
                            <h4 class="text-center text-primary font-12" id="titleAsignar"><strong>ASIGNAR M&Oacute;DULOS</strong></h4>
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
                                            <label>Perfil</label>
                                            <select class="form-control" name="cboperfilAsignar" id="cboperfilAsignar" data-live-search="true" required>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="form-group">
                                            <label>M&oacute;dulos</label>
                                            <select data-dropup-auto="false" title="[ Seleccione Módulos ]" data-size="6" name="multimodulo" id="multimodulo" class="form-control selectpicker" multiple data-selected-text-format="count > 3" data-live-search="true" noneSelectedText show-menu-arrow required>

                                            </select>
                                            <span id="errormultimodulo" class="font-error"></span>
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
                            <h4 class="text-center text-primary font-12"><strong>ASIGNAR M&Oacute;DULOS</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="table-responsive">
                              <div id="tbl_asignar" class="dataTables_wrapper form-inline" role="grid">
                                <table id="tableAsignar" class="display table table-bordered table-hover" cellspacing="0" width="100%">
                                  <thead class="text-center font-table">
                                    <tr class="bg-primary">
                                      <th class="text-center" width="5%">N</th>
                                      <th class="text-center" width="15%">PERFIL</th>
                                      <th class="text-center" width="25%">DESCRIPCI&Oacute;N DEL PERFIL</th>
                                      <th class="text-center" width="45%">M&Oacute;DULOS ASIGNADOS</th>
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
                              <label>Nueva Contrase&ntilde;a</label>
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
                            <button type="submit" class="btn btn-outline-primary" id="updatePass"><i class="zmdi zmdi-refresh zmdi-hc-fw m-r-5"></i><span>Reestablecer</span></button>
                            <a class="btn btn-outline-danger" data-dismiss="modal" id="cancelPpass" onclick="cancelPass();"><i class="zmdi zmdi-close zmdi-hc-fw m-r-5"></i><span>Cerrar</span></a>
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

        <!-- Modal MODULO -->
        <div class="modal fade" id="modal_modulo" role="dialog" data-keyboard="false" data-backdrop="static" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="zmdi zmdi-close"></i>
                  </span>
                </button> -->
                <h4 id="titleModule" class="modal-title text-center text-primary font-16"><b>EDITAR M&Oacute;DULO</b></h4>
              </div>
              <div class="modal-body">
                <div class="col-lg-1"></div>
                <div class="col-lg-10">
                  <form class="form-horizontal" id="form_registerModulo" method="POST" autocomplete="off" >
                    <input class="form-control" type="hidden" id="txtIDModulo" name="txtIDModulo">
                    <input class="form-control" type="hidden" id="txtcontrolModulo" name="txtcontrolModulo" value="0">
                    <div class="panel ">
                      <div class="panel-body">
                        <div class="row">
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                              <label>M&oacute;dulo</label>
                              <div class="input-group-prepend">
                                <input type="text" class="form-control vld" name="txtmodulo" id="txtmodulo" required/>
                              </div>
                            </div>
                          </div>                       
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                              <label>Descripci&oacute;n</label>
                              <div class="input-group-prepend">
                                <input type="text" class="form-control vld" name="txtdescripcionModulo" id="txtdescripcionModulo" required/>
                              </div>
                            </div>
                          </div>
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                              <label>Página</label>
                              <div class="input-group-prepend">
                                <input type="text" class="form-control vld" name="txtURL" id="txtURL" required disabled />
                              </div>
                            </div>
                          </div>                       
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                              <label>Icono</label>
                              <div class="input-group-prepend">
                                <input type="text" class="form-control vld" name="txticono" id="txticono" required/>
                              </div>
                              <span class="m-t-10 font-table"><a href="javascript:verIconos();" class="text-primary">VER ICONOS</a></span>
                            </div>
                          </div>
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                             <div class="switches-stacked">
                                <label>Activo</label>
                                <label class="switch switch-primary">  
                                  <input type="checkbox" id="chkestadoModulo" name="chkestadoModulo" class="s-input">
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
                            <button type="submit" class="btn btn-outline-primary" id="updateModulo"><i class="zmdi zmdi-refresh zmdi-hc-fw m-r-5"></i><span>Actualizar</span></button>
                            <a class="btn btn-outline-danger" data-dismiss="modal" id="cancelMOdulo" onclick="cancelModulo();"><i class="zmdi zmdi-close zmdi-hc-fw m-r-5"></i><span>Cerrar</span></a>
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
        <!-- #END# MODAL MODULO-->


      </div>
      <div class="site-footer">
        2021 © Sistema
      </div>
    </div>
    
    <!-- FOOTER -->
    <?php footerAdmin($data); ?>
  </body>

<!-- Mirrored from big-bang-studio.com/cosmos/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 10 Jan 2019 12:53:30 GMT -->
</html>