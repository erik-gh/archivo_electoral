<?php 
      $url = explode('/', $_SERVER['REQUEST_URI']);
      if(!in_array($url[2], $_SESSION['module'])){
        if($url[2] != 'icons'){
          header('Location: '.base_url().'/dashboard');
        }
      }
?>
<head>
	<meta charset="utf-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
  	<meta name="description" content="">
    <title><?= $data['page_tag'] ?></title>
    <link rel="icon" type="image/png" href="<?= media(); ?>/images/favicon-32x32.png" sizes="32x32">
  	<link rel="icon" type="image/png" href="<?= media(); ?>/images/favicon-16x16.png" sizes="16x16">
    
    <!-- base:css -->
    <link rel="stylesheet" href="<?= media();?>/css/vendor.min.css">
  	<link rel="stylesheet" href="<?= media();?>/css/cosmos.min.css">
  	<link rel="stylesheet" href="<?= media();?>/css/application.min.css">

  	 <!-- plugin css for this page -->
  	 <!-- Sweetalert -->
  	<link rel="stylesheet" href="<?= media();?>/css/alert/css/sweetalert.css">
    <link rel="stylesheet" href="<?= media();?>/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="<?= media();?>/css/jquery.signature.css" >
    <link rel="stylesheet" type="text/css" href="<?= media();?>/css/style.css">
</head>