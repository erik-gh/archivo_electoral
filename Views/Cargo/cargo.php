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
                    <a href="#tab-cargo" role="tab" data-toggle="tab" aria-expanded="true">
                      <i class="zmdi zmdi-labels"></i> CARGOS</a>
                  </li>

                  <li class="">
                    <a href="#tab-pedido" role="tab" data-toggle="tab" aria-expanded="true" onclick="listCargoPedido();">
                      <i class="zmdi zmdi-tablet"></i> PEDIDO</a>
                  </li>
                  
                </ul>

                <div class="tab-content">
                  <div role="tabpanel" class="tab-pane fade active in" id="tab-cargo">
                    <div class="row">
                      <div class="col-md-4 col-sm-4">
                        <div class="panel panel-default panel-table m-b-0">
                          <div class="panel-heading">
                            <h4 class="text-center text-primary font-12" id="titleCargo"><strong>REGISTRAR CARGO</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="row">
                              <!-- <div class="col-lg-1"></div> -->
                              <div class="col-lg-12">
                                <form class="form" id="form_registerCargo" method="POST" autocomplete="off" action="javascript:void(0);">
                                  <input class="form-control" type="hidden" id="txtIDCargo" name="txtIDCargo">
                                  <input class="form-control" type="hidden" id="txtcontrolCargo" name="txtcontrolCargo" value="0">
                                  <div class="panel panel-default">
                                    <div class="panel-body">
                                      <!-- <h5 class="text-blue-grey m-b-15"><strong>DATOS PERSONALES</strong></h5> -->
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="form-group">
                                            <label>Cargo</label>
                                            <div class="input-group-prepend">
                                              <input class="form-control vld" type="text" id="txtcargo" name="txtcargo" required>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="form-group">
                                            <label>Remuneraci&oacute;n</label>
                                            <div class="input-group-prepend">
                                              <input class="form-control vld" type="text" id="txtremuneracion" name="txtremuneracion" onkeypress="SoloNum()" required>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <!-- <h5 class="text-blue-grey m-b-15"><strong>DATOS DEL USUARIO</strong></h5> -->
                                      <div class="row" id="estado_cargo" style="display: none;">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="switches-stacked">
                                            <label>Activo</label>
                                            <label class="switch switch-primary">  
                                              <input type="checkbox" id="chkestadoCargo" name="chkestadoCargo" class="s-input">
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
                                          <button type="submit" class="btn btn-outline-primary" id="agregarCargo"><i class="zmdi zmdi-check zmdi-hc-fw m-r-5"></i><span> Guardar</span></button>
                                          <button type="submit" class="btn btn-outline-primary" id="updateCargo" style="display: none;"><i class="zmdi zmdi-refresh zmdi-hc-fw m-r-5"></i><span> Actualizar</span></button>
                                          <a class="btn btn-outline-danger" data-dismiss="modal" id="cancelCargo" onclick="cancelCargo();"><i class="zmdi zmdi-close zmdi-hc-fw m-r-5"></i><span>Cancelar</span></a>
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
                            <h4 class="text-center text-primary font-12"><strong>LISTA DE CARGOS</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="clearfix">
                                <div class="pull-right">
                                    <a  class="btn btn-black" id="descargarCargo" onclick="descargarCargo()"><i class="zmdi zmdi-download  zmdi-hc-fw m-r-5"></i><span> Descargar Cargos</span></a>
                                </div>
                            </div><br>
                            <div class="table-responsive">
                              <div id="tbl_cargo" class="dataTables_wrapper form-inline" role="grid">
                                <table id="tableCargos" class="display table table-bordered table-hover" cellspacing="0" width="100%">
                                  <thead class="text-center font-table">
                                      <tr class="bg-primary">
                                          <th class="text-center" width="10%">Nº</th>
                                          <th class="text-center" width="35%">CARGO</th>
                                          <th class="text-center" width="10%">REMUNERACI&Oacute;N</th>
                                          <th class="text-center" width="20%">ESTADO</th>
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

                  <div role="tabpanel" class="tab-pane fade" id="tab-pedido">
                    <div class="row">
                      <div class="col-md-5 col-sm-5">
                        <div class="panel panel-default panel-table m-b-0">
                          <div class="panel-heading">
                            <h4 class="text-center text-primary font-12" id="titlePedido"><strong>REGISTRAR PEDIDO</strong></h4>
                          </div>
                          <div class="panel-body">
                            <div class="row">
                              <!-- <div class="col-lg-1"></div> -->
                              <div class="col-lg-12">
                                <form class="form" id="sign_registerPedido" method="POST" autocomplete="off" action="javascript:void(0);">
                                  <input class="form-control" type="hidden" id="txtIDPedido" name="txtIDPedido">
                                  <input class="form-control" type="hidden" id="txtcontrolPedido" name="txtcontrolPedido" value="0">
                                  <div class="panel panel-default">
                                    <div class="panel-body">
                                      <!-- <h5 class="text-blue-grey m-b-15"><strong>DATOS PERSONALES</strong></h5> -->
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                          <div class="form-group">
                                            <label>N° PEDIDO</label>
                                            <div class="input-group-prepend">
                                              <input class="form-control vld" type="text" id="txtpedido" name="txtpedido" onkeypress="SoloNum()" maxlength="4" required>
                                            </div>
                                          </div>
                                        </div>                                      
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                          <div class="form-group">
                                            <label>N° MEMORANDUM</label>
                                            <div class="input-group-prepend">
                                              <input class="form-control vld" type="text" id="txtmemorandum" name="txtmemorandum" onkeypress="SoloNum()" maxlength="4" required>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                          <div class="form-group">
                                            <label>N° INFORME</label>
                                            <div class="input-group-prepend">
                                              <input class="form-control vld" type="text" id="txtinforme" name="txtinforme" onkeypress="SoloNum()" maxlength="4" required>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                          <div class="form-group">
                                            <label>FECHA DE PEDIDO</label>
                                            <div class="input-group-prepend">
                                              <input class="form-control vld" type="date" id="txtFechaPedido" name="txtFechaPedido" required>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <br>
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                                          <label>LISTA DE CARGOS</label>
                                          <div class="table-responsive" style="height: 350px !important;">
                                            <div id="tbl_pedidoCargo" class="dataTables_wrapper form-inline" role="grid">
                                              <table id="tablePedidoCargos" class="display table table-bordered table-hover" cellspacing="0" width="100%">
                                                <thead class="text-center font-table">
                                                    <tr class="bg-primary">
                                                        <th class="text-center" width="15%">ITEM</th>
                                                        <th class="text-center" width="60%">CARGOS</th>
                                                        <th class="text-center" width="25%">CANTIDAD</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="font-table">
                                                </tbody>
                                              </table>
                                            </div>
                                          </div>
                                        </div>
                                      </div><br>
                                      <!-- <button onclick="agruparCargo()" type="button">vale!</button> -->
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="addComentario" style="display: none;">
                                          <label class="custom-control custom-control-primary custom-checkbox active">
                                            <input id="view_checkbox_obsv" class="custom-control-input" type="checkbox" name="custom" onclick="mostrarObservacion();">
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-label">Agregar Observacion</span>
                                          </label>
                                        </div>
                                      </div><br>
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="obsv" style="display: none;">
                                          <div class="form-group">
                                            <label>Observaci&oacute;n</label>
                                            <textarea class="form-control rounded-0 vld" id="txtobservacionPedido" name="txtobservacionPedido" rows="4" required style="text-align: justify;"></textarea>
                                          </div>
                                        </div>
                                      </div>
                                      

                                      <!-- <h5 class="text-blue-grey m-b-15"><strong>DATOS DEL USUARIO</strong></h5> 
                                      <div class="row" id="estado_Cargo" style="display: none;">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="switches-stacked">
                                            <label>ACTIVO</label>
                                            <label class="switch switch-primary">  
                                              <input type="checkbox" id="chkestadoPedido" name="chkestadoPedido" class="s-input">
                                              <span class="s-content">
                                                <span class="s-track"></span>
                                                <span class="s-handle"></span>
                                              </span>
                                            </label>
                                          </div>
                                        </div>
                                      </div>-->
                                      <div class="clearfix m-t-30">
                                        <div class="pull-right">
                                          <button type="submit" class="btn btn-outline-primary" id="agregarPedido"><i class="zmdi zmdi-check zmdi-hc-fw m-r-5"></i><span> Guardar</span></button>
                                          <button type="submit" class="btn btn-outline-primary" id="updatePedido" style="display: none;"><i class="zmdi zmdi-refresh zmdi-hc-fw m-r-5"></i><span> Actualizar</span></button>
                                          <a class="btn btn-outline-danger" data-dismiss="modal" id="cancelPedido" onclick="cancelPedido();"><i class="zmdi zmdi-close zmdi-hc-fw m-r-5"></i><span>Cancelar</span></a>
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
                            <h4 class="text-center text-primary font-12"><strong>LISTA DE PEDIDOS</strong></h4>
                          </div>
                          <div class="panel-body" >
                            <div class="table-responsive">
                              <div id="tbl_pedido" class="dataTables_wrapper form-inline" role="grid" >
                                <table id="tablePedidos" class="display table table-bordered table-hover" cellspacing="0" width="100%">
                                  <thead class="text-center font-table">
                                      <tr class="bg-primary">
                                          <th class="text-center" width="10%">Nº</th>
                                          <th class="text-center" width="15%">NRO. PEDIDO</th>
                                          <th class="text-center" width="20%">NRO. MEMORANDUM</th>
                                          <th class="text-center" width="15%">NRO. INFORME</th>
                                          <th class="text-center" width="20%">FECHA PEDIDO</th>
                                          <th class="text-center" width="20%">ACCI&Oacute;N</th>
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

         <!-- Modal  -->
        <div class="modal fade" id="modal_cargoPedido" role="dialog" data-keyboard="false" data-backdrop="static" tabindex="-1">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="zmdi zmdi-close"></i>
                  </span>
                </button>
                <h4 id="title" class="modal-title text-center text-primary"><b>CARGOS POR PEDIDO</b></h4>
              </div>
              <div class="modal-body">
                
                <div class="col-lg-12">
                  <div class="table-responsive">
                    <div id="tbl_pedidoCargolst" class="dataTables_wrapper form-inline" role="grid">
                      <table id="tableCargosPedido" class="display table table-bordered table-hover" cellspacing="0" width="100%">
                        <thead class="text-center font-table">
                          <tr class="bg-primary">
                            <th class="text-center" width="15%">N° PEDIDO</th>
                            <th class="text-center" width="70%">CARGO</th>
                            <th class="text-center" width="15%">CANTIDAD</th>
                          </tr>
                        </thead>
                        <tbody class="font-table">
                        </tbody>
                      </table>
                    </div>
                    
                    <div class="accordion" id="accordionExample">
                      <div class="card">
                        <div class="card-header" id="headingOne">
                          <h2 class="mb-0">
                            <a class="btn btn-link" id="historial" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                              HISTORIAL DE CAMBIOS
                            </a>
                          </h2>
                        </div>
                        <div class="col-lg-12">
                          <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body">
                              <table id="tableHistorial" class="display table table-bordered table-hover" cellspacing="0" width="100%">
                                <thead class="text-center font-table">
                                  <tr class="">
                                    <th class="text-center" width="15%">FECHA</th>
                                    <th class="text-center" width="50%">OBSERVACION</th>
                                    <th class="text-center" width="35%">DETALLE CARGO / CANTIDAD</th>
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
                  <div class="clearfix m-t-30">
                    <div class="pull-right">
                      <a class="btn btn-outline-danger" data-dismiss="modal" onclick="closeModal()"><i class="zmdi zmdi-close zmdi-hc-fw m-r-5"></i><span>Cerrar</span></a>
                    </div>
                  </div>
                </div>
                
              </div>
              <div class="modal-footer"></div>
            </div>
          </div>
        </div>
        <!-- #END# Modal Register -->  

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