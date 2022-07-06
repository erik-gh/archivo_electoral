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
              <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"></div>
              <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 z-1000">
                <div class="form-group">
                  <div class="input-group-prepend">
                    <select class="form-control" name="cboProceso" id="cboProceso" data-dropup-auto="false" data-live-search="true" data-size="6" onchange="cbomateriales()">
                      <option value="">[ SELECCIONE PROCESO ]</option>
                    </select>                                           
                    <!--<div class="help-block with-errors"></div>-->
                  </div>                                    
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                <div class="widget widget-tile-2 bg-info m-b-30" style="cursor: pointer;" id="acta" onclick="panelTabs('cedula')">
                  <div class="wt-content p-a-20 p-b-50">
                    <div class="wt-title">CEDULAS<br>ELECTORALES</div>
                    <div class="wt-number"></div>
                    <div class="wt-text"></div>
                  </div>
                  <div class="wt-icon">
                    <i class="zmdi zmdi-view-web"></i>
                  </div>
                </div>
              </div>
              <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                <div class="widget widget-tile-2 bg-warning m-b-30" style="cursor: pointer;" id="acta" onclick="panelTabs('acta')">
                  <div class="wt-content p-a-20 p-b-50">
                    <div class="wt-title">ACTA<br>PADRON</div>
                    <div class="wt-number"></div>
                    <div class="wt-text"></div>
                  </div>
                  <div class="wt-icon">
                    <i class="zmdi zmdi-assignment"></i>
                  </div>
                </div>
              </div>
              <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                <div class="widget widget-tile-2 bg-danger m-b-30" style="cursor: pointer;" id="dispositivo" onclick="panelTabs('dispositivo')">
                  <div class="wt-content p-a-20 p-b-50">
                    <div class="wt-title">DISPOSITIVOS<br>ELECTRONICOS</div>
                    <div class="wt-number"></div>
                    <div class="wt-text"></div>
                  </div>
                  <div class="wt-icon">
                    <i class="zmdi zmdi-tablet"></i>
                  </div>
                </div>
              </div>
              <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                <div class="widget widget-tile-2 bg-primary m-b-30" style="cursor: pointer;" id="reserva" onclick="panelTabs('reserva')">
                  <div class="wt-content p-a-20 p-b-50">
                    <div class="wt-title">CEDULAS<br>DE RESERVA</div>
                    <div class="wt-number"></div>
                    <div class="wt-text"></div>
                  </div>
                  <div class="wt-icon">
                    <i class="zmdi zmdi-view-web"></i>
                  </div>
                </div>
              </div>
              <!--<div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                <div class="widget widget-tile-2 bg-info m-b-30">
                  <div class="wt-content p-a-20 p-b-50">
                    <div class="wt-title">PLANTILLA <br>BRAILLE</div>
                    <div class="wt-number"></div>
                    <div class="wt-text"></div>
                  </div>
                  <div class="wt-icon">
                    <i class="zmdi zmdi-cloud-box account-box-phone"></i>
                  </div>
                </div>
              </div>
              <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                <div class="widget widget-tile-2 bg-success m-b-30">
                  <div class="wt-content p-a-20 p-b-50">
                    <div class="wt-title">PAQUETES DE <br>COORDINADOR</div>
                    <div class="wt-number"></div>
                    <div class="wt-text"></div>
                  </div>
                  <div class="wt-icon">
                    <i class="zmdi zmdi-folder-star"></i>
                  </div>
                </div>
              </div>-->
            </div>

            <div class=" row">
              <div class="panel panel-default m-b-0" id="carga_panel">
                <!-- <div class="panel-body" >
                </div> -->
              </div>
            </div>

            <!--<img id="barcode" src="Assets/images/barcodes.jpg"/>
            <br/>
            <button onclick="validar()">Scan</button>
            <input type="text" id="codes0">
            <input type="text" id="codes1">-->


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