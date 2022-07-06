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
        <form class="form" id="form_reportAsistencia" autocomplete="off">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="m-y-0 text-danger text-center font-18"><b><?= $data['page_title'] ?></b></h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                  <div class="form-group">
                    <label>D.N.i.</label>
                    <input class="form-control" type="text" id="txtDNI" name="txtDNI" maxlength="8" onkeypress="SoloNum()">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                  <div class="form-group">
                    <label>DESDE FECHA</label>
                    <input class="form-control" type="date" id="txtFechaInicio" name="txtFechaInicio">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                  <div class="form-group">
                    <label>HASTA FECHA</label>
                    <input class="form-control" type="date" id="txtFechaFin" name="txtFechaFin">
                  </div>
                </div> 
              </div>
              <div class="clearfix m-t-30">
                <div class="pull-left">
                  <button type="button" class="btn btn-outline-success" id="VER_register" onclick="viewAsistencia()"><i class="zmdi zmdi-eye zmdi-hc-fw m-r-5"></i><span> Visualizar</span></button>
                  <button type="button" class="btn btn-outline-primary" id="download_register" onclick="exportarAsistencia()"><i class="zmdi zmdi-download zmdi-hc-fw m-r-5"></i><span> Descargar</span></button>
                  <a class="btn btn-outline-danger" data-dismiss="modal" id="cancel_register" onclick="cancelreportAsistencia()"><i class="zmdi zmdi-close zmdi-hc-fw m-r-5"></i><span>Cancelar</span></a>
                </div>
              </div><br>
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="table-responsive">
                    <div id="tbl_reportAsistencia" class="dataTables_wrapper form-inline" role="grid">
                      <!-- <table id="lista_reporte" class="display table table-bordered table-hover" cellspacing="0" width="100%">

                      </table> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
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