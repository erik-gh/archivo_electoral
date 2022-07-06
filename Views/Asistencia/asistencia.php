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
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 m-b-4">
                    <div class="form-group">
                      <label class="control-label font-18">Registrar:</label><br><br>
                      <div class="custom-controls-stacked">
                        <label class="custom-control custom-control-primary custom-radio">
                          <input class="custom-control-input vld" type="radio" name="radioIngreso" id="radioIngreso1" value="1" checked="checked" required>
                          <span class="custom-control-indicator"></span>
                          <span class="custom-control-label font-16">Control de Acceso</span>
                        </label><br>
                        <label class="custom-control custom-control-primary custom-radio">
                          <input class="custom-control-input vld" type="radio" name="radioIngreso" id="radioIngreso2" value="2" required>
                          <span class="custom-control-indicator"></span>
                          <span class="custom-control-label font-16">Control de Salida</span>
                        </label>
                      </div>
                    </div>
                    <div class="form-group form-group-lg"><br>
                      <label class="font-14">D.N.I.:</label>
                      <input class="form-control vld" type="text" id="txtDNI" name="txtDNI" minlength="8" maxlength="8" onkeypress="SoloNum(),inpDNI()" required>
                    </div>
                    <div class="panel panel-default panel-table m-b-0">
                      <div class="panel-heading">
                        <h4 class="text-center text-primary font-14"><strong>PERSONAL PRESENTE  - <span id="fechaActual"></span></strong></h4>
                      </div>
                      <div class="panel-body">
                        <!-- <div class="table-responsive"> -->
                          <div id="tbl_cantPersonal" class="dataTables_wrapper form-inline" role="grid">
                            <table id="tbl_cantidadPersonal" class="display table table-bordered table-hover" cellspacing="0" width="100%">
                              <thead>
                                <tr class="bg-primary">
                                  <th class="text-center" width="10%">Nª</th>
                                  <th class="text-center" width="45%">GERENCIA</th>
                                  <th class="text-center" width="45%">CANTIDAD</th>      
                                </tr>
                              </thead>
                              <tbody class="text-center font-14">
                              </tbody>                                       
                            </table>
                          </div>
                        <!-- </div> -->
                      </div>
                    </div>

                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <div class="panel panel-default">
                      <div class="panel-body">
                        <div class="row">
                          <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">

                            <div class="form-group">
                              <label class="text-blue-grey font-16">Control:</label>
                              <div class="input-group">                                             
                                <span id="controlAsistencia"></span>
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="text-blue-grey font-16">D.N.I.:</label>
                              <div class="input-group">                                             
                                <span id="dniAsistencia"></span>
                              </div>
                            </div>
                         
                            <div class="form-group">
                              <label class="text-blue-grey font-16">Nombre Completo:</label>
                              <div class="input-group">                                             
                                <span id="nombreAsistencia"></span>
                              </div>
                            </div>
                          
                            <div class="form-group">
                              <label class="text-blue-grey font-16">Cargo:</label>
                              <div class="input-group">                                             
                                <span id="cargoAsistencia"></span>
                              </div>
                            </div>
                          
                            <div class="form-group">
                              <label class="text-blue-grey font-16">Fecha y Hora:</label>
                              <div class="input-group">                                             
                                <span id="fechaAsistencia"></span>
                              </div>
                            </div>
                          </div>
                          <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="form-group">
                              <label class="text-blue-grey font-16 text-center"></label>
                              <div class="input-group">                                             
                                <span id="gerenciaAsistencia"></span>
                              </div>
                            </div>
                          <div class="col-xs-6 col-sm-12 col-md-12 col-lg-8">
                            <div class="form-group">
                              
                                <div class="panel panel-default">
                                  <div  id="img_personal" style="height: 210px; padding: 5px 5px;">

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
        2019 © Sistema
      </div>
    </div>

    <!-- FOOTER -->
    <?php footerAdmin($data); ?>
  </body>

<!-- Mirrored from big-bang-studio.com/cosmos/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 10 Jan 2019 12:53:30 GMT -->
</html>