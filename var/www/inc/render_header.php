<?php 


function renderHeader(){
	?>

    <!-- Encabezado ocultable -->

    <?php renderEncabezadoOcultable(); ?>

    <!-- Fin Encabezado ocultable -->

    <!-- Encabezado Fijo -->  

    <?php renderEncabezadoFijo(); ?>

    <!-- Fin Encabezado Fijo -->

	<?php
}

//************************** ENCABEZADO OCULTABLE *****************************//

function renderEncabezadoOcultable(){

	?>

    <div id="encabezado-ocultable" class="container-fluid" >

      <!-- Panel login -->

      <div id="login" class="row">

      <?php renderPanelLogin(); ?>

      </div>

      <!-- Fin Panel login -->

      <!-- Panel Encabezado central -->

      <?php renderEncabezadoCentral(); ?>

      <!-- Fin Panel Encabezado central -->

    </div>

	<?php

}

//************************** PANEL LOGIN *****************************//

function renderPanelLogin(){
if (sesion()) {

  renderPanelLogueado();

}else{

  renderPanelSinLoguear();

};


}

function renderPanelLogueado(){
  ?>
        <div class="container">
          <div class="row">
            <div class="col-xs-6">
              <?php 
                if ($GLOBALS["configuracion"]["estadodecuenta"]===TRUE) {
                  ?>
                    <a href="estadocuenta.php"><h4 class="mayuscula cl-color-3"><i class="fa fa fa-dot-circle-o" style="color:<?php echo obtieneVencimiento() == TRUE ? "red" : "green" ?>" aria-hidden="true"></i> Estado de cuenta</h4></a>
                  <?php
                }
              ?>
            </div>

            <!-- Login Dropdown -->

            <div class="col-xs-6  text-right pull-right dropdown">
              <button class="btn btn-primary dropdown-toggle" type="button" id="micuenta" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <span title="Mensajes No Leídos" style="display:none; right: 4px;padding: 3px 9px;" class="badge" id="contador-mensajes"></span>
                <i class="fa fa-user" aria-hidden="true"></i>
                <?php echo $_SESSION["Denominacion"] ?>
                <span class="caret"></span>
              </button>
              <div class="dropdown-menu text-center padding-md bg-color-2" aria-labelledby="micuenta">                  
                <?php
                  $menu="menumicuenta";
                  foreach ($GLOBALS["configuracion"][$menu]["items"] as $key => $value) {
                    ?>
                      <div class="form-group mayuscula">
                        <a
                          <?php
                            if (array_key_exists("atributos", $value)) {
                              foreach ($value["atributos"] as $key2 => $value2) {
                                echo $key2.'="'.$value2.'"';
                              }
                            }
                          ?>
                        class="cl-color-3" href="<?php echo $value["link"] ?>"><?php echo $value["titulo"] ?></a>
                      </div>                      
                    <?php
                  }
                ?>                                                                  
              </div>
            </div>

            <!-- Fin Login Dropdown -->

          </div>
        </div>
  <?php
}

function renderPanelSinLoguear(){
  ?>
        <div class="container">
          <div class="row">
            <div class="col-xs-2 col-sm-2">
              <div class="btn-group" role="group">
                <a type="button" class="btn btn-primary" href="registro.php"><i class="fa fa-user-plus" aria-hidden="true"></i> Registro</a>
              </div>
            </div>

            <!-- Login Dropdown -->

            <div class="col-xs-8 col-sm-4 hidden-lg hidden-md text-right pull-right dropdown">
              <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <i class="fa fa-user" aria-hidden="true"></i>
                Usuarios Registrados
                <span class="caret"></span>
              </button>
              <div class="dropdown-menu text-center padding-md" aria-labelledby="dropdownMenu1">
                <form>
                  <div class="form-group">
                    <input type="text" class="form-control login-usuario" id="login-usuario-desktop" placeholder="Usuario">
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control login-contrasena" id="login-password-desktop" placeholder="Contraseña">
                  </div>               
                  <div class="btn-group-vertical" role="group">
                    <a onclick="login(this)" class="btn btn-primary"><i class="fa fa-fw fa-sign-in" aria-hidden="true"></i> Ingresar</a>
                    <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#olvide-contrasena"><i class="fa fa-key" aria-hidden="true"></i> Olvidé mi Contraseña</a>
                  </div>
                </form>                    
              </div>
            </div>

            <!-- Fin Login Dropdown -->

            <!-- Login inline -->

            <div class="text-right hidden-xs hidden-sm col-xs-10">
              <form class="form-inline">
                <div class="form-group">
                  <input type="text" class="form-control login-usuario" id="login-usuario-mobile" placeholder="Usuario">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control login-contrasena" id="login-password-mobile" placeholder="Contraseña">
                </div>
                <a onclick="login(this)" class="btn btn-primary"><i class="fa fa-fw fa-sign-in" aria-hidden="true"></i> Ingresar</a>
                <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#olvide-contrasena"><i class="fa fa-key" aria-hidden="true"></i> Olvidé mi Contraseña</a>
              </form>
            </div>

            <!-- Fin Login inline --> 

          </div>
        </div>
  <?php
}


//************************** ENCABEZADO CENTRAL *****************************//

function renderEncabezadoCentral(){

	?>

      <div id="encabezado-central" class="row padding-md">
        <div class="container">

          <!-- Logo -->  

          <div class="col-md-6 no-padding ">
            <a href="index.php">
              <div id="logo" style="background-image:url('<?php echo $GLOBALS["configuracion"]["carpetaimagenes"].$GLOBALS["configuracion"]["brand"]["logo"] ?>')">
              </div>
            </a>
          </div>

          <!-- Fin Logo -->

          <!-- Carrito --> 

          <div class="col-md-6 no-padding ">
            <div class="<?php echo $GLOBALS["configuracion"]["carrito"]?"col-md-9 col-lg-10":"col-md-12 col-lg-12" ?>  no-padding text-right">
              <ul class="fa-ul">
                <li><h3><?php echo $GLOBALS["configuracion"]["contactos"][0]["denominacion"] ?>:</h3></li>
                <li><a href="https://wa.me/5491160943285"><h2 class="bold cl-color-1"><i class="fa <?php echo $GLOBALS["configuracion"]["contactos"][0]["icono"] ?> cl-color-4"></i> <?php echo $GLOBALS["configuracion"]["contactos"][0]["valor"] ?></h2></a></li>
                <?php 
                  $diashorarios=array();
                  foreach ($GLOBALS["configuracion"]["dias"] as $key => $value) {
                    if ($GLOBALS["configuracion"]["dias"][$key]["abierto"]===TRUE) {
                      $dia=$GLOBALS["configuracion"]["dias"][$key];
                      $horario=array();
                      foreach ($dia["horario"] as $key2 => $value2) {
                        $hor=implode(" a ", $value2);
                        array_push($horario, $hor);
                      }
                      $horario=implode(" y de ", $horario);
                      $diacompleto=$key." De ".$horario;                      
                      array_push($diashorarios, $diacompleto);
                    }
                  }
                  $diashorarios=implode(" | ", $diashorarios);
                 ?>
                <li><h5 class="cl-gray-3"><?php echo $diashorarios ?></h5></li>
              </ul>
            </div>
            <?php 

            if ($GLOBALS["configuracion"]["carrito"]) {
              ?>
                <div class="col-md-3 col-lg-2 no-padding ">
                  <div class="dropdown pull-right">
                    <div id="btn-cart">
                      <button id="boton-cesta" class="btn cl-color-1 bg-color-3 dropdown-toggle" type="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <i class="fa fa-shopping-cart fa-3x" aria-hidden="true"></i>
                      </button>
                      <?php 

                      if ((sesion()) || $GLOBALS["configuracion"]["permiteinvitado"]===TRUE) {
                        ?>
                          <span id="contador-cesta" class="badge"></span>
                        <?php
                      }

                       ?>
                      <ul id="cesta" class="dropdown-menu padding-md  dropdown-menu-right" aria-labelledby="btn-cart">
                       
                      </ul>
                    </div>
                  </div>          
                </div>
              
              <?php
            }

            ?>
          </div>

          <!-- Fin Carrito -->

        </div>
      </div>


	<?php

}

//************************** ENCABEZADO FIJO *****************************//

function renderEncabezadoFijo(){
$dir=explode("/", $_SERVER["PHP_SELF"]);
  ?>  
    <div id="encabezado-fijo" class="bg-gray-1 padding-md">

      <nav class="navbar-default" >
        <div class="container-fluid">
          <div class=" navbar-header">

            <!-- Dropdown menú --> 

            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>

            <!-- Fin Dropdown menú -->

          </div>          
          <div class="row">
            <div class="container">
              <div class="no-padding <?php echo $GLOBALS["configuracion"]["buscador"]?"col-lg-9":"col-lg-12" ?> col-md-12" style="z-index:1">

                <!-- Menú -->    

                <div class="collapse pull-left no-padding navbar-collapse" id="menu">
                  <ul class="bold nav navbar-nav">
                    <?php
                    if (sesion()) {
                      $menu="menuconlogin";
                    }else{
                      $menu="menusinlogin";
                    }
                    foreach ($GLOBALS["configuracion"][$menu]["items"] as $key => $value) {
                      if ($value["subitems"]===FALSE) {
                        ?>
                          <li class="<?php echo ($dir[2] == $value["link"] ? 'active' : ''); ?>"><a href="<?php echo $value["link"] ?>"><?php echo $value["titulo"] ?><span class="sr-only"></span></a></li>
                        <?php
                      }else{
                        ?>
                          <li class="dropdown <?php echo ($dir[2] == $value["link"] ? 'active' : ''); ?>">
                            <a href="<?php echo $value["link"] ?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $value["titulo"] ?><span class="caret"></span></a>
                            <ul class="dropdown-menu">
                              <?php
                                foreach ($value["subitems"] as $key2 => $value2) {
                                  if ($value2["subitems"]===FALSE) {
                                    ?>
                                      <li class="<?php echo ($dir[2] == $value2["link"] ? 'active' : ''); ?>"><a href="<?php echo $value2["link"] ?>"><?php echo $value2["titulo"] ?><span class="sr-only"></span></a></li>
                                    <?php
                                  }else{
                                    ?>
                                      <li class="dropdown <?php echo ($dir[2] == $value2["link"] ? 'active' : ''); ?>">
                                        <a href="<?php echo $value2["link"] ?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $value2["titulo"] ?><span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                          <?php 

                                           ?>
                                        </ul>
                                      </li>
                                    <?php
                                  }
                                }
                               ?>
                            </ul>
                          </li>
                        <?php
                      }
                    }

                     ?>
                  </ul>
                </div>

                <!-- Fin Menú --> 

                <!-- Fin Buscador --> 

              </div>

              <!-- Buscador --> 
              <?php 

                if ($GLOBALS["configuracion"]["buscador"]) {
                  ?>
                    <div class="no-padding pull-right col-lg-3 ">
                      <div id="buscador" class="input-group">
                        <input id="search" name="search" class="form-control" placeholder="" type="text" value="<?php echo isset($_GET["descripcion"]) ? $_GET["descripcion"] : "" ?>">
                        <span onclick="buscador()" class="input-group-addon"><button class="btn btn-danger"><i class="fa fa-search" aria-hidden="true"></i></button></span>
                      </div> 
                    </div>
                  <?php
                }

              ?>
            </div>
          </div>
        </div>
      </nav>      
    </div>


	<?php

}



 ?>