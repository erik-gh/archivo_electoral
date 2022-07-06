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
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="text-center text-primary font-16"><b>LISTADO DE CONTRATOS</b></h4>
                  </div>
                  <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"></div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 z-5">
                      <div class="form-group">
                        <select class="form-control" name="cboProceso" id="cboProceso" data-dropup-auto="false" data-size="6" data-live-search="true" required>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="panel-body">
                    <div class="clearfix">
                      <div class="pull-left">
                        <a  data-toggle="modal" class="btn btn-primary" id="registerContrato" disabled><i class="zmdi zmdi-plus  zmdi-hc-fw m-r-5" ></i><span> Registrar Contrato</span></a>
                      </div>
                      <!--<div class="pull-right">
                        <a class="btn btn-primary" id="downloadPersonal" onclick="descargarPersonal()"><i class="zmdi zmdi-download  zmdi-hc-fw m-r-5"></i><span> Descargar Personal </span></a> 
                        <a class="btn btn-black" id="downloadPlantilla" onclick="descargarPlantilla()"><i class="zmdi zmdi-download zmdi-hc-fw m-r-5"></i><span> Descargar Plantilla</span></a>
                      </div>-->
                    </div><br>
                    <div class="table-responsive">
                      <div id="tbl_Contratos" class="dataTables_wrapper form-inline" role="grid">
                        <table id="tableContratos" class="display table table-bordered table-hover" cellspacing="0" width="100%">
                          <thead class="text-center font-table">
                            <tr class="bg-primary">
                              <th class="text-center" width="5%">Nº</th>
                              <th class="text-center" width="8%">NRO PEDIDO</th>
                              <th class="text-center" width="20%">APELLIDOS Y NOMBRE</th>
                              <th class="text-center" width="22%">OBJETO DE CONTRATO</th>
                              <th class="text-center" width="13%">NRO CONTRATO</th>
                              <th class="text-center" width="13%">FECHA INICIO CONTRATO</th>
                              <th class="text-center" width="11%">FECHA FIN CONTRATO</th>
                              <th class="text-center" width="8%">ACCI&Oacute;N</th>
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

         <!-- Modal  -->
        <div class="modal fade" id="modal_registro" role="dialog" data-keyboard="false" data-backdrop="static" tabindex="-1">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="zmdi zmdi-close"></i>
                  </span>
                </button>
                <h4 id="titleContrato" class="modal-title text-center text-primary"></h4>
              </div>
              <div class="modal-body">
                <div class="col-lg-12">
                  <div class="form-wizard">
                    <div class="fw-header">
                      <ul class="nav nav-pills">
                        <li class="active" id="step1"><a href="#tab1" data-toggle="tab">Paso 1 <span class="chevron"></span></a></li>
                        <!--<li><a href="#tab2" data-toggle="tab">Paso 2 <span class="chevron"></span></a></li>-->
                        <li id="step3"><a href="#tab3" data-toggle="tab" onclick="//listFormAcad();">Paso 2 <span class="chevron"></span></a></li>
                        <li id="step4"><a href="#tab4" data-toggle="tab" onclick="//listCursoEspec();">Paso 3 <span class="chevron"></span></a></li>
                        <li id="step5"><a href="#tab5" data-toggle="tab" onclick="//listExperiencia();">Paso 4 <span class="chevron"></span></a></li>
                      </ul>
                    </div>
                    <div class="tab-content p-x-15">
                      <div class="tab-pane active" id="tab1">
                        <!-- <h3 class="m-t-0 m-b-30">Crear Proceso</h3> -->
                        <div class="row">
                          <h4 class="text-center text-primary font-14"><strong>DATOS DE CONTRATO</strong></h4><br>
                          <div class="col-md-12 col-sm-12">
                            <div class="col-lg-12">
                              <form class="form" id="sign_registerContrato" method="POST" autocomplete="off" action="javascript:void(0);">
                                <input class="form-control" type="hidden" id="txtIDContrato" name="txtIDContrato">
                                <input class="form-control" type="hidden" id="txtcontrolContrato" name="txtcontrolContrato" value="0">
                                <!--<h5 class="text-blue-grey m-b-15"><strong>DATOS LABORALES</strong></h5>-->
                                <div class="row">
                                  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 z-8">
                                    <div class="form-group">
                                      <label>PEDIDO</label>
                                      <select class="form-control" name="cboPedido" id="cboPedido" data-dropup-auto="false" data-size="6" data-live-search="true" required>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                      <label>MEMORANDUM</label>
                                      <div class="input-group-prepend">
                                        <input class="form-control" type="text" id="txtMemorandum" name="txtMemorandum" disabled required>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                      <label>INFORME</label>
                                      <div class="input-group-prepend">
                                        <input class="form-control" type="text" id="txtInforme" name="txtInforme" disabled required>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-xs-10 col-sm-10 col-md-4 col-lg-4">
                                    <div class="form-group">
                                      <label>D.N.I.:</label>
                                      <div class="input-group-prepend">
                                        <input class="form-control vld" type="text" id="txtDNI" name="txtDNI" minlength="8" maxlength="8" onkeypress="SoloNum()" onkeyup="keyDNI();" disabled="" required>
                                      </div>
                                    </div>
                                  </div>
                                  <!--<div class="col-xs-2 col-sm-2 col-md-1 col-lg-1 ">
                                    <div class="form-group pull-right">
                                      <a data-toggle="modal" href="#modal_personal" class="btn btn-outline-primary" style="margin-top: 25px;">
                                        <i class="zmdi zmdi-account-add zmdi-hc-fw m-r-5" data-toggle="tooltip" title="Registrar"></i>
                                      </a>
                                    </div>
                                  </div>-->
                                  <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                                    <div class="form-group">
                                      <label>APELLIDOS Y NOMBRES</label>
                                      <input class="form-control" type="text" id="txtNombre" name="txtNombre" disabled required>
                                      <input class="form-control" type="hidden" id="txtIDPersonal" name="txtIDPersonal">
                                    </div>
                                  </div>
                                </div>
                                <!--<h5 class="text-blue-grey m-b-15"><strong>DATOS LABORALES</strong></h5>-->
                                <div class="row">
                                  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                      <label>OBJETO DE CONTRATO</label>
                                      <div class="input-group-prepend">
                                        <div class="input-group-prepend">
                                          <input class="form-control" type="text" id="txtCargo" name="txtCargo" disabled required>
                                          <input class="form-control" type="hidden" id="txtIDCargo" name="txtIDCargo" disabled required>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                      <label>Nº DE CONTRATO</label>
                                      <div class="input-group-prepend">
                                        <input class="form-control vld" type="text" id="txtNroContrato" name="txtNroContrato" required  onkeyup="keynroContrato()" maxlength="27">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                    <div class="form-group">
                                      <label>HORORARIOS (S/)</label>
                                      <div class="input-group-prepend">
                                        <input class="form-control" type="text" id="txtHonorarios" name="txtHonorarios" disabled required >
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                    <div class="form-group">
                                      <label>RUC:</label>
                                      <div class="input-group-prepend">
                                        <input class="form-control vld" type="text" id="txtRUC" name="txtRUC" minlength="11" maxlength="11" onkeypress="SoloNum()" required>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!--<h5 class="text-blue-grey m-b-15"><strong>DATOS PERONALES</strong></h5>-->
                                <div class="row">
                                  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                      <label>FECHA INICIO DE CONTRATO</label>
                                      <div class="input-group-prepend">
                                        <input class="form-control vld" type="date" id="txtFechaInicio" name="txtFechaInicio" required>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                      <label>FECHA FIN DE CONTRATO</label>
                                      <div class="input-group-prepend">
                                        <input class="form-control vld" type="date" id="txtFechaFin" name="txtFechaFin" required>
                                      </div>
                                    </div>
                                  </div>
                                  <input class="form-control" type="hidden" id="txtProcesoUpd" name="txtProcesoUpd" required>
                                  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 z-7">
                                    <div class="form-group">
                                      <label>LOCAL</label>
                                      <select class="form-control" name="cboLocal" id="cboLocal" data-dropup-auto="false" data-size="6" data-live-search="true" required>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                      <label>JEFE DIRECTO</label>
                                      <div class="input-group-prepend">
                                        <div class="input-group-prepend">
                                          <input class="form-control vld" type="text" id="txtJefe" name="txtJefe" required>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 z-6">
                                    <div class="form-group ">
                                      <label>VERIFICADO</label>
                                      <select class="form-control selectpicker" name="cboVerificacion" id="cboVerificacion" data-dropup-auto="false" data-size="10" required>
                                        <option value="">[ SELECCIONE VERFICACION ]</option>
                                        <option value="1">OK</option>
                                        <option value="2">NO</option>
                                      </select>
                                    </div>
                                  </div>
                                </div>

                                <h4 class="text-center text-primary font-14"><strong>DATOS PERSONALES</strong></h4><br>
                             
                            <!--</div>
                          </div>
                        </div>
                      </div>
                      
                      <div class="tab-pane" id="tab2">-->
                        <!-- <h3 class="m-t-0 m-b-30">Crear Proceso</h3> -->
                        <!--<div class="row">
                          <h4 class="text-center text-primary font-14"><strong>DATOS PERSONALES</strong></h4><br>
                          <div class="col-md-12 col-sm-12">
                            <div class="col-lg-12">-->
                              <!-- <form class="form" id="sign_registerColaborador" autocomplete="off"> -->
                                <!--<input class="form-control" type="hidden" id="txtIDColaborador" name="txtIDColaborador">
                                <input class="form-control" type="hidden" id="txtcontrolColaborador" name="txtcontrolColaborador" value="0">-->
                                <!--<h5 class="text-blue-grey m-b-15"><strong>DATOS LABORALES</strong></h5>-->
                                <div class="row">
                                  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                      <label>FECHA DE NACIMIENTO</label>
                                      <div class="input-group-prepend">
                                        <input class="form-control vld" type="date" id="txtFechaNac" name="txtFechaNac" required>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 z-5">
                                    <div class="form-group ">
                                      <label>SEXO</label>
                                      <select class="form-control selectpicker" name="cboSexo" id="cboSexo" data-dropup-auto="false" data-size="10" required>
                                        <option value="">[ SELECCIONE SEXO ]</option>
                                        <option value="1">MASCULINO</option>
                                        <option value="2">FEMENINO</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                      <label>DIRECCION ACTUAL</label>
                                      <div class="input-group-prepend">
                                        <input class="form-control vld" type="text" id="txtDireccion" name="txtDireccion" required>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                
                                <div class="row">
                                  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 z-4">
                                    <div class="form-group">
                                      <label>DEPARTAMENTO:</label>
                                      <select class="form-control" name="cboDepartamento" id="cboDepartamento" data-dropup-auto="false" data-size="6" data-live-search="true" onchange="listarCboProvincia()" required>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 z-3">
                                    <div class="form-group">
                                      <label>PROVINCIA:</label>
                                      <select class="form-control" name="cboProvincia" id="cboProvincia" data-dropup-auto="false" data-size="6" data-live-search="true" onchange="listarCboDistrito()" required>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 z-2">
                                    <div class="form-group">
                                      <label>DISTRITO:</label>
                                      <select class="form-control" name="cboDistrito" id="cboDistrito" data-dropup-auto="false" data-size="6" data-live-search="true" required>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                      <label>CELULAR:</label>
                                      <div class="input-group-prepend">
                                        <input class="form-control vld" type="text" id="txtCelular" name="txtCelular" minlength="9" maxlength="9" onkeypress="SoloNum()" required>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                      <label>TELEFONO FIJO:</label>
                                      <div class="input-group-prepend">
                                        <input class="form-control" type="text" id="txtTelefono" name="txtTelefono" minlength="9" maxlength="9" onkeypress="SoloNum()">
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <div class="pull-right">
                                    <button type="submit" class="btn btn-primary" id="agregarContrato"><i class="zmdi zmdi-check zmdi-hc-fw m-r-5"></i><span> Guardar</span></button>
                                  </div>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                      <div class="tab-pane" id="tab3">
                        <!-- <h3 class="m-t-0 m-b-30">Crear Proceso</h3> -->
                        <div class="row">
                          <h4 class="text-center text-primary font-14"><strong>FORMACION ACADEMICA</strong></h4><br>
                          <div class="col-md-12 col-sm-12">
                            <div class="col-lg-12">
                              <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                  <div class="pull-left">
                                    <a href="#modal_FormAcad" data-toggle="modal" class="btn btn-success" id="registerFormAcad"><i class="zmdi zmdi-plus  zmdi-hc-fw m-r-5"></i><span> Agregar</span></a>
                                  </div>
                                  <br><br>
                                  <div class="table-responsive">
                                    <div id="tbl_cargo" class="dataTables_wrapper form-inline" role="grid">
                                      <table id="tableFormAcad" class="display table table-bordered table-hover" cellspacing="0" width="100%">
                                        <thead class="text-center font-table">
                                          <tr class="bg-primary">
                                            <th class="text-center" width="5%">Nº</th>
                                            <th class="text-center" width="15%">TIPO DE ESTUDIOS</th>
                                            <th class="text-center" width="15%">NIVEL DE ESTUDIOS</th>
                                            <th class="text-center" width="20%">ESPECIALIDAD</th>
                                            <th class="text-center" width="25%">CENTRO DE ESTUDIOS</th>
                                            <th class="text-center" width="10%">FECHA</th>
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
                      
                      <div class="tab-pane" id="tab4">
                        <!-- <h3 class="m-t-0 m-b-30">Crear Proceso</h3> -->
                        <div class="row">
                          <h4 class="text-center text-primary font-14"><strong>CURSOS Y/O PROGRAMAS DE ESPECIALIZACION</strong></h4><br>
                          <div class="col-md-12 col-sm-12">
                            <div class="col-lg-12">
                              <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                  <div class="pull-left">
                                    <a href="#modal_CursoEspec" data-toggle="modal" class="btn btn-success" id="registerCursoEspec"><i class="zmdi zmdi-plus  zmdi-hc-fw m-r-5"></i><span> Agregar</span></a>
                                  </div>
                                  <br><br>
                                  <div class="table-responsive">
                                    <div id="tbl_cargo" class="dataTables_wrapper form-inline" role="grid">
                                      <table id="tableCursoEspec" class="display table table-bordered table-hover" cellspacing="0" width="100%">
                                        <thead class="text-center font-table">
                                          <tr class="bg-primary">
                                            <th class="text-center" width="5%">Nº</th>
                                            <th class="text-center" width="15%">TIPO DE ESTUDIOS</th>
                                            <th class="text-center" width="18%">DESCRIPCION</th>
                                            <th class="text-center" width="18%">CENTRO DE ESTUDIOS</th>
                                            <th class="text-center" width="11%">FECHA INICIO </th>
                                            <th class="text-center" width="11%">FECHA FIN</th>
                                            <th class="text-center" width="14%">HORAS LECTIVAS</th>
                                            <th class="text-center" width="8%">ACCI&Oacute;N</th>
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

                      <div class="tab-pane" id="tab5">
                        <!-- <h3 class="m-t-0 m-b-30">Crear Proceso</h3> -->
                        <div class="row">
                          <h4 class="text-center text-primary font-14"><strong>EXPERIENCIA LABORAL</strong></h4><br>
                          <div class="col-md-12 col-sm-12">
                            <div class="col-lg-12">
                              <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                  <div class="pull-left">
                                    <a href="#modal_Experiencia" data-toggle="modal" class="btn btn-success" id="registerExperiencia"><i class="zmdi zmdi-plus  zmdi-hc-fw m-r-5"></i><span> Agregar</span></a>
                                  </div>
                                  <br><br>
                                  <div class="table-responsive">
                                    <div id="tbl_cargo" class="dataTables_wrapper form-inline" role="grid">
                                      <table id="tableExperiencia" class="display table table-bordered table-hover" cellspacing="0" width="100%">
                                        <thead class="text-center font-table">
                                          <tr class="bg-primary">
                                            <th class="text-center" width="5%">Nº</th>
                                            <th class="text-center" width="8%">EXPERIENCIA</th>
                                            <th class="text-center" width="8%">ENTIDAD</th>
                                            <th class="text-center" width="15%">NOMBRE DE LA ENTIDAD</th>
                                            <th class="text-center" width="15%">AREA DE TRABAJO</th>
                                            <th class="text-center" width="15%">CARGO</th>
                                            <th class="text-center" width="8%">FECHA INICIO </th>
                                            <th class="text-center" width="8%">FECHA FIN</th>
                                            <th class="text-center" width="13%">TIEMPO</th>
                                            <th class="text-center" width="5%">ACCI&Oacute;N</th>
                                          </tr>
                                        </thead>
                                        <tbody class="text-center font-table">
                                          
                                        </tbody>
                                      </table>
                                    </div>
                                  </div><br><bR>
                                  <div class="pull-left">
                                    <b>EXPERIENCIA GENERAL: &nbsp;&nbsp;&nbsp;</b> <span id="countGeneral"></span> <br>
                                    <b>EXPERIENCIA EXPECIFICA: </b> <span id="countExpecifica"></span>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
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
                      <div id="barra" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                        
                      </div>
                    </div>
                  </div>
                  <div class="clearfix m-t-30">
                    <div class="pull-right">
                      <a class="btn btn-outline-danger" data-dismiss="modal" onclick="cancelContrato()"><i class="zmdi zmdi-close zmdi-hc-fw m-r-5"></i><span>Cerrar</span></a>
                    </div>
                  </div>
                </div>
                
              </div>
              <div class="modal-footer"></div>
            </div>
          </div>
        </div>
        <!-- #END# Modal Register -->


        <!-- #Modal FORMACION ACADEMICA -->
        <div id="modal_FormAcad" class="modal fade" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="zmdi zmdi-close"></i>
                  </span>
                </button>
                <h4 class="modal-title text-center text-primary" id="titleFormAcad"><b>REGISTRAR FORMACION ACADEMICA</b></h4>
              </div>
              <div class="modal-body">
                <div class="col-lg-12">
                  <form class="form" id="sign_registerFormAcad" method="POST" autocomplete="off" action="javascript:void(0);">
                    <input class="form-control" type="hidden" id="idContratoFormAcad" name="idContratoFormAcad" required>
                    <input class="form-control" type="hidden" id="txtIDFormAcad" name="txtIDFormAcad">
                    <input class="form-control" type="hidden" id="txtcontrolFormAcad" name="txtcontrolFormAcad" value="0">
                    <div class="panel panel-default panel-table m-b-0">
                      <div class="panel-body">      
                        <div class="row">
                          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 z-8">
                            <div class="form-group ">
                              <label>GRADO DE ESTUDIOS</label>
                              <select class="form-control" name="cboTipoEstudios" id="cboTipoEstudios" data-dropup-auto="false" data-size="6" data-live-search="true" onchange="listarCboNivelEstudio();" required>
                
                              </select>
                            </div>
                          </div>
                          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 z-7">
                            <div class="form-group ">
                              <label>NIVEL DE ESTUDIOS</label>
                              <select class="form-control" name="cboNivelEstudios" id="cboNivelEstudios" data-dropup-auto="false" data-size="10" data-live-search="true" required>
                                
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                              <label>ESPECIALIDAD</label>
                              <div class="input-group-prepend">
                                <input class="form-control vld" type="text" id="txtEspecialidad" name="txtEspecialidad" required>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                              <label>CENTRO DE ESTUDIOS</label>
                              <div class="input-group-prepend">
                                <input class="form-control vld" type="text" id="txtCentroEstudio" name="txtCentroEstudio" required>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                              <label>FECHA (Obtencion del Nivel de Estudios)</label>
                              <div class="input-group-prepend">
                                <input class="form-control vld" type="date" id="txtFechaEstudio" name="txtFechaEstudio" required>
                              </div>
                            </div>
                          </div>
                        </div>
                      
                        <div class="clearfix m-t-30">
                          <div class="pull-right">
                            <button type="submit" class="btn btn-primary" id="agregarFormAcad"><i class="zmdi zmdi-check zmdi-hc-fw m-r-5"></i><span> Guardar</span></button>
                            <button type="submit" class="btn btn-primary" id="updateFormAcad" style="display: none;i"><i class="zmdi zmdi-refresh zmdi-hc-fw m-r-5"></i><span> Actualizar</span></button>
                            <a class="btn btn-danger" data-dismiss="modal" id="cancelFormAcad" onclick="cancelFormAcad()"><i class="zmdi zmdi-close zmdi-hc-fw m-r-5"></i><span>Cerrar</span></a>
                          </div>
                        </div>
                      </div>
                    
                    </form>
                  </div>
                </div>
                <!-- <div class="col-lg-1"></div> -->
              </div>
              <div class="modal-footer"></div>
            </div>
          </div>
        </div>
        <!-- #END Modal FORMACION ACADEMICA --> 


        <!-- #Modal CURSOS Y/O PROGRAMAS -->
        <div id="modal_CursoEspec" class="modal fade" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="zmdi zmdi-close"></i>
                  </span>
                </button>
                <h4 class="modal-title text-center text-primary" id="titleCurso"><b>REGISTRAR CURSO Y/O ESPECIALIZACION</b></h4>
              </div>
              <div class="modal-body">
                <div class="col-lg-12">
                  <form class="form" id="sign_registerCursoEspec" method="POST" autocomplete="off" action="javascript:void(0);">
                    <input class="form-control" type="hidden" id="idContratoCursoEspec" name="idContratoCursoEspec" required>
                    <input class="form-control" type="hidden" id="txtIDCursoEspec" name="txtIDCursoEspec">
                    <input class="form-control" type="hidden" id="txtcontrolCursoEspec" name="txtcontrolCursoEspec" value="0">
                    <div class="panel panel-default panel-table m-b-0">
                      <div class="panel-body">      
                        <div class="row">
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 z-8">
                            <div class="form-group ">
                              <label>TIPO DE ESTUDIOS</label>
                              <select class="form-control selectpicker" name="cboTipoCurso" id="cboTipoCurso" data-dropup-auto="false" data-size="10" required>
                                <option value="">[ SELECCIONE TIPO ]</option>
                                <option value="1">PROGRAMA DE ESPECIALIZACION</option>
                                <option value="2">CURSO</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                              <label>DESCRIPCION</label>
                              <div class="input-group-prepend">
                                <input class="form-control vld" type="text" id="txtCursoDescrip" name="txtCursoDescrip" required>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                              <label>CENTRO DE ESTUDIOS</label>
                              <div class="input-group-prepend">
                                <input class="form-control vld" type="text" id="txtCursoCentroEstudio" name="txtCursoCentroEstudio" required>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                              <label>FECHA INICIO</label>
                              <div class="input-group-prepend">
                                <input class="form-control vld" type="date" id="txtFechaCursoInicio" name="txtFechaCursoInicio" required>
                              </div>
                            </div>
                          </div>
                          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                              <label>FECHA FIN</label>
                              <div class="input-group-prepend">
                                <input class="form-control vld" type="date" id="txtFechaCursoFin" name="txtFechaCursoFin" required>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                              <label>HORAS LECTIVAS</label>
                              <div class="input-group-prepend">
                                <input class="form-control vld" type="text" id="txtCursoHoras" name="txtCursoHoras" onkeypress="SoloNum()" required>
                              </div>
                            </div>
                          </div>
                        </div>
                      
                        <div class="clearfix m-t-30">
                          <div class="pull-right">
                            <button type="submit" class="btn btn-primary" id="agregarCursoEspec"><i class="zmdi zmdi-check zmdi-hc-fw m-r-5"></i><span> Guardar</span></button>
                            <button type="submit" class="btn btn-primary" id="updaterCursoEspec" style="display: none;i"><i class="zmdi zmdi-refresh zmdi-hc-fw m-r-5"></i><span> Actualizar</span></button>
                            <a class="btn btn-danger" data-dismiss="modal" id="cancelCursoEspec" onclick="cancelCursoEspec()"><i class="zmdi zmdi-close zmdi-hc-fw m-r-5"></i><span>Cerrar</span></a>
                          </div>
                        </div>
                      </div>
                    
                    </form>
                  </div>
                </div>
                <!-- <div class="col-lg-1"></div> -->
              </div>
              <div class="modal-footer"></div>
            </div>
          </div>
        </div>
        <!-- #END Modal CURSOS Y/O PROGRAMAS --> 


        <!-- #Modal EXPERIENCIA -->
        <div id="modal_Experiencia" class="modal fade" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="zmdi zmdi-close"></i>
                  </span>
                </button>
                <h4 class="modal-title text-center text-primary" id="titleExperiencia"><b>REGISTRAR EXPERIENCIA LABORAL</b></h4>
              </div>
              <div class="modal-body">
                <div class="col-lg-12">
                  <form class="form" id="sign_registerExperiencia" method="POST" autocomplete="off" action="javascript:void(0);">
                    <input class="form-control" type="hidden" id="idContratoExperiencia" name="idContratoExperiencia" required>
                    <input class="form-control" type="hidden" id="txtIDExperiencia" name="txtIDExperiencia">
                    <input class="form-control" type="hidden" id="txtcontrolExperiencia" name="txtcontrolExperiencia" value="0">
                    <input class="form-control" type="hidden" id="txtTiempoGeneral" name="txtTiempoGeneral">
                    <input class="form-control" type="hidden" id="txttiempoExpecifica" name="txttiempoExpecifica">

                    <div class="panel panel-default panel-table m-b-0">
                      <div class="panel-body">      
                        <div class="row">
                          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 z-8">
                            <div class="form-group ">
                              <label>TIPO DE EXPERIENCIA</label>
                              <select class="form-control selectpicker" name="cboTipoExperiencia" id="cboTipoExperiencia" data-dropup-auto="false" data-size="10" required>
                                <option value="">[ SELECCIONE TIPO ]</option>
                                <option value="1">GENERAL</option>
                                <option value="2">ESPECIFICA</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 z-7">
                            <div class="form-group ">
                              <label>TIPO DE ENTIDAD</label>
                              <select class="form-control selectpicker" name="cboTipoEntidad" id="cboTipoEntidad" data-dropup-auto="false" data-size="10" required>
                                <option value="">[ SELECCIONE TIPO ]</option>
                                <option value="1">PUBLICO</option>
                                <option value="2">PRIVADO</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                              <label>NOMBRE DE LA ENTIDAD</label>
                              <div class="input-group-prepend">
                                <input class="form-control vld" type="text" id="txtNombreEntidad" name="txtNombreEntidad" required>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                              <label>AREA DE TRABAJO</label>
                              <div class="input-group-prepend">
                                <input class="form-control vld" type="text" id="txtAreaEntidad" name="txtAreaEntidad" required>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                              <label>CARGO Y/O PUESTO</label>
                              <div class="input-group-prepend">
                                <input class="form-control vld" type="text" id="txtCargoEntidad" name="txtCargoEntidad" required>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                              <label>FECHA INICIO</label>
                              <div class="input-group-prepend">
                                <input class="form-control vld" type="date" id="txtFechaExperienInicio" name="txtFechaExperienInicio" onchange="resetFechaFinal();" required>
                              </div>
                            </div>
                          </div>
                          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                              <label>FECHA FIN</label>
                              <div class="input-group-prepend">
                                <input class="form-control vld" type="date" id="txtFechaExperienFin" name="txtFechaExperienFin" onchange="tiempoLaboral();" required>
                              </div>
                            </div>
                          </div>
                        </div> 
                        <div class="row">
                          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                              <label>TIEMPO LABORAL</label>
                              <div class="input-group-prepend">
                                <input class="form-control vld" type="text" id="txtTiempoLaboral" name="txtTiempoLaboral" required disabled>
                                <input class="form-control" type="hidden" id="txtTiempoDias" name="txtTiempoDias" >
                              </div>
                            </div>
                          </div>
                        </div>                      
                        <div class="clearfix m-t-30">
                          <div class="pull-right">
                            <button type="submit" class="btn btn-primary" id="agregarExperiencia"><i class="zmdi zmdi-check zmdi-hc-fw m-r-5"></i><span> Guardar</span></button>
                            <button type="submit" class="btn btn-primary" id="updateExperiencia" style="display: none;i"><i class="zmdi zmdi-refresh zmdi-hc-fw m-r-5"></i><span> Actualizar</span></button>
                            <a class="btn btn-danger" data-dismiss="modal" id="cancelExperiencia" onclick="cancelExperiencia()"><i class="zmdi zmdi-close zmdi-hc-fw m-r-5"></i><span>Cerrar</span></a>
                          </div>
                        </div>
                      </div>
                    
                    </form>
                  </div>
                </div>
                <!-- <div class="col-lg-1"></div> -->
              </div>
              <div class="modal-footer"></div>
            </div>
          </div>
        </div>
        <!-- #END Modal EXPERIENCIA -->  

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
