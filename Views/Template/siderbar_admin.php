<?php //error_reporting(0);?>
        <?php 
          //session_start();
          require_once('./Models/TemplateModel.php');

          $menu = new TemplateModel();
          $arrData = $menu->loginMenu($_SESSION['idPerfil']) ;
          //print_r($arrData);
        ?>
        <div class="sidebar-backdrop"></div>
        <div class="custom-scrollbar">
          <ul class="sidebar-menu">
            <li class="menu-title">Menú Principal</li>

        <?php 
            
          foreach ($arrData as $rowMod ) {
              echo '  <li>
                        <a href="'.base_url().'/'.$rowMod['URL'].'">
                          <span class="menu-icon">
                            <i class="zmdi zmdi-'.$rowMod['ICONO'].'"></i>
                          </span>
                          <span class="menu-text">'.$rowMod['MODULO'].'</span>
                        </a>
                      </li>';
          }
        ?>
<!--         <div class="sidebar-backdrop"></div>
        <div class="custom-scrollbar">
          <ul class="sidebar-menu">
            <li class="menu-title">Menú Principal</li>
             <li> 
              <a href="<?= base_url(); ?>/dashboard">
                <span class="menu-icon">
                  <i class="zmdi zmdi-home"></i>
                </span>
                <span class="menu-text">Inicio</span>
              </a>
            </li>
            <li> 
              <a href="#">
                <span class="menu-icon">
                  <i class="zmdi zmdi-settings"></i>
                </span>
                <span class="menu-text">General</span>
              </a>
            </li> 
            <li> 
              <a href="#" >
                <span class="menu-icon">
                  <i class="zmdi zmdi-folder-person"></i>
                </span>
                <span class="menu-text">Personal</span>
              </a>
            </li>
            <li> 
              <a href="<?= base_url(); ?>/usuario" >
                <span class="menu-icon">
                  <i class="zmdi zmdi-accounts"></i>
                </span>
                <span class="menu-text">Usuarios</span>
              </a>
            </li>
            <li> 
              <a href="#" >
                <span class="menu-icon">
                  <i class="zmdi zmdi-apps"></i>
                </span>
                <span class="menu-text">Reportes</span>
              </a>
            </li>  -->
            <!-- <li class="menu-title">Sistema</li>
            <li>
              <a href="#">
                <span class="menu-icon">
                  <i class="zmdi zmdi-settings"></i>
                </span>
                <span class="menu-text">Configuracion</span>
              </a>
            </li>
            <li>
              <a href="#">
                <span class="menu-icon">
                  <i class="zmdi zmdi-account"></i>
                </span>
                <span class="menu-text">Perfiles y Usuarios</span>
              </a>
            </li> -->
            <!-- <li class="with-sub">
              <a href="#" aria-haspopup="true">
                <span class="menu-icon">
                  <i class="zmdi zmdi-widgets"></i>
                </span>
                <span class="menu-text">Usuarios y Perfiles</span>
              </a>
              <ul class="sidebar-submenu collapse">
                <li class="menu-subtitle">Usuarios y Perfiles</li>
                <li ><a href="usuario.php">Usuarios</a></li>
                <li ><a href="perfil.php">Perfiles</a></li>
              </ul>
            </li> -->
            <li class="menu-title">Cuenta</li>
            <li>
              <a href="#" data-toggle="tooltip" data-placement="bottom" title="">
                <span class="menu-icon">
                  <i class="zmdi zmdi-circle text-success"></i>
                </span>
                <span class="menu-text" >Guia del Sistema</span>
              </a>
            </li>
            <li>
              <a href="<?= base_url(); ?>/logout">
                <span class="menu-icon">
                  <i class="zmdi zmdi-circle text-danger"></i>
                </span>
                <span class="menu-text">Cerrar Sesi&oacute;n</span>
              </a>
            </li>
          </ul>
        </div>