<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="">
    <title><?= $data['page_tag'] ?></title>
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.html">
    <link rel="icon" type="image/png" href="<?= media();?>/images/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="<?= media();?>/images/favicon-16x16.png" sizes="16x16">
    <link rel="stylesheet" href="<?= media();?>/css/vendor.min.css">
    <link rel="stylesheet" href="<?= media();?>/css/cosmos.min.css">
    <link rel="stylesheet" href="<?= media();?>/css/application.min.css">
    <link rel="stylesheet" href="<?= media();?>/css/style.css">
  </head>
  <body class="authentication-body">
    <div class="container-fluid">
      <div class="authentication-header m-b-30">
        <div class="clearfix">
          <div class="text-center m-t-20">
            <a class="authentication-logo" href="#">
              <img src="<?= media();?>/images/logo.png" alt="" height="25">
              <span><b><?= $data['page_title'] ?></b></span>
            </a>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-4 col-sm-offset-4">
          <div class="authentication-content m-b-20">
            <h3 class="m-t-0 m-b-30 text-center text-info"><b><?= $data['page_tag'] ?></b></h3>
            <form id="form_login" method="POST" autocomplete="off">
              <div class="form-group">
                <label for="form-control-1">Usuario</label>
                <div class="input-group-prepend">
                  <input type="text" class="form-control" name="username" id="username" placeholder="Usuario"  onkeypress="" autofocus required>
                </div>
              </div>
              <div class="form-group">
                <label for="form-control-2">Contraseña</label>
                <div class="input-group-prepend">
                  <input type="password" class="form-control" name="password" id="password" placeholder="Contraseña" required>
                </div>
              </div>
              <button type="submit" class="btn btn-info btn-block" id="enviar"><i class="zmdi zmdi-lock zmdi-hc-fw m-r-5"></i><span> Iniciar Sesi&oacute;n</span></button>
              <div  class="text-center m-t-20">            
                  <div id="msj_sign_in"></div>
              </div>
              <div  class="text-center m-t-20" id="back">            
                  <a href="<?php $host= $_SERVER["HTTP_HOST"];?>/sistemas_gge" data-toggle="tooltip" data-placement="top" title="IR AL INICIO">
                    <img src="<?= media();?>/images/back.png" width="40" >   
                  </a>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="authentication-footer">
        <!-- <span class="text-muted">¿Nesecitas Auyda? Cont&aacute;ctenos a email@example.com</span> -->
      </div>
    </div>
    <script type="text/javascript">
      const base_url = "<?= base_url(); ?>";
      const media = "<?= media(); ?>";
    </script>
    <script src="<?= media();?>/js/vendor.min.js"></script>
    <script src="<?= media();?>/js/cosmos.min.js"></script>
    <script src="<?= media();?>/js/application.min.js"></script>
    <script src="<?= media();?>/js/jquery-validation/jquery.validate.js"></script>
    <script src="<?= media();?>/js/jquery-validation/localization/messages_es_PE.js"></script>
    <script src="<?= media();?>/js/sign-in.js"></script>
    <script src="<?= media();?>/functions/<?= $data['page_function_js'] ?>"></script>
  </body>
</html>