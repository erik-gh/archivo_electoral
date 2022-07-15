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
                                <select class="form-control" name="cboProceso" id="cboProceso" data-dropup-auto="false"
                                        data-live-search="true" data-size="6" onchange="">
                                    <option value="">[ SELECCIONE PROCESO ]</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                        <div class="widget widget-tile-2 bg-info m-b-30" style="cursor: pointer;" id="acta"
                             onclick="panelTabs('cedula')">
                            <div class="wt-content p-a-20 p-b-50">
                                <div class="wt-title">REGISTRO <br> DOCUMENTOS ELECTORALES</div>
                                <div class="wt-number"></div>
                                <div class="wt-text"></div>
                            </div>
                            <div class="wt-icon">
                                <i class="zmdi zmdi-view-web"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" row">
                    <div class="panel panel-default m-b-0" id="carga_panel">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="site-footer">
        2022 © Sistema
    </div>
</div>

<!-- FOOTER -->
<?php footerAdmin($data); ?>
</body>

</html>