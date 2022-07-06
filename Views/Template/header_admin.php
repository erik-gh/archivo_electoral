    <nav class="navbar navbar-default">
        <div class="navbar-header">
            <a class="navbar-brand" href="./">
                <img src="<?= media();?>/images/logo.png" alt="" height="25">
                <span class="font-18"><b>GGE</b></span>
            </a>
            <button class="navbar-toggler left-sidebar-toggle pull-left visible-xs" type="button">
                <span class="hamburger"></span>
            </button>
            <!-- <button class="navbar-toggler right-sidebar-toggle pull-right visible-xs-block" type="button">
                <i class="zmdi zmdi-long-arrow-left"></i>
                <div class="dot bg-success" data-toggle="tooltip" data-placement="bottom" title="Sesi&oacute;n Iniciada"></div>
            </button> -->
            <button class="navbar-toggler pull-right visible-xs-block" type="button" data-toggle="collapse" data-target="#navbar">
                <span class="more"></span>
            </button>
        </div>
        <div class="navbar-collapsible">
            <div id="navbar" class="navbar-collapse collapse">
                <button class="navbar-toggler left-sidebar-collapse pull-left hidden-xs" type="button">
                    <span class="hamburger"></span>
                </button>
                <ul class="nav navbar-nav">
                    <li class="visible-xs-block">
                        <div class="nav-avatar">
                            <img class="img-circle" src="<?= media();?>/images/user.png" alt="" width="48" height="48">
                        </div>
                        <h4 class="navbar-text text-center">BIenvenido!<br><br> <?= $_SESSION['nameUser']; ?></h4>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="nav-table dropdown hidden-sm-down">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <span class="nav-cell p-r-10">
                                <img class="img-circle" src="<?= media();?>/images/user.png" alt="" width="32" height="32">
                            </span>
                            <span class="nav-cell text-info">BIenvenido(a): <?= $_SESSION['nameUser']; ?>
                                <span class="caret"></span>
                            </span>
                        </a>
                        <ul class="dropdown-menu ">
                            <!-- <li>
                                <a href="#">
                                    <i class="zmdi zmdi-account-o m-r-10"></i> Mi Perfil</a>
                            </li>
                            <li>
                                <a href="#">
                                <i class="zmdi zmdi-settings m-r-10"></i> Configuraci&oacute;n</a>
                            </li> -->
                            <li>
                                <a href="#">
                                    <i class="zmdi zmdi-help-outline m-r-10"></i> Ayuda!
                                </a>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <a href="<?= base_url();?>/logout">
                                    <i class="zmdi zmdi-power m-r-10"></i> Cerrar Sesi&oacute;n
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>