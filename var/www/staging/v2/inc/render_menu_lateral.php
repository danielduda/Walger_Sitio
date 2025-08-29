<?php 

function renderMenuLateral(){
  if ($GLOBALS["configuracion"]["menulateral"]) {

    include_once("./api/consultas.php");
  	?>

    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
      <div id="productos-menu" class="col-xs-12 no-padding">

        <h3 class="bold titulo">Categorías</h3>

        <ul class="fa-ul" id="productos-categorias">
          <?php 
          $categorias=retornarCategorias();
          if ($categorias["error"]==false) {
            for ($i=0; $i < count($categorias["exito"]); $i++) { 
              if (isset($_GET["categoria"])) {
                if ($_GET["categoria"]== $categorias["exito"][$i]["denominacion"]) {
                  $lineas=retornarLineas($categorias["exito"][$i]["denominacion"]);
                  $linkseleccionado=isset($_GET["favoritos"]) ? "productos.php?categoria=".$categorias["exito"][$i]["denominacion"]."&favoritos=".$_GET["favoritos"] : "productos.php?categoria=".$categorias["exito"][$i]["denominacion"];
                  ?>
                  <li>
                    <i class="fa fa-check cl-color-1" aria-hidden="true"></i>
                    <a href="<?php echo $linkseleccionado ?>"><strong><?php echo $categorias["exito"][$i]["denominacion"] ?></strong>
                    </a>
                  </li>            
                  <?php
                    if ($GLOBALS["configuracion"]["productos"]["mostrarlineasencategorias"]===TRUE) {
                      foreach ($lineas["exito"] as $key => $value) {
                        ?>
                        <li class="menu-linea">
                          <i class="fa fa-minus cl-color-4" aria-hidden="true"></i>
                          <a href="<?php echo $linkseleccionado."&linea=".$value["linea"] ?>" value="<?php echo $value["linea"] ?>"><?php echo isset($_GET["linea"]) && $_GET["linea"]==$value["linea"] ? "<strong>".$value["linea"]."</strong>" : $value["linea"] ?></a>
                        </li>
                        <?php
                      }                
                    }
                }else{
                  $link=isset($_GET["favoritos"]) ? "productos.php?categoria=".$categorias["exito"][$i]["denominacion"]."&favoritos=".$_GET["favoritos"] : "productos.php?categoria=".$categorias["exito"][$i]["denominacion"];
                  ?>
                  <li><i class="fa fa-check cl-color-1" aria-hidden="true"></i> <a href="<?php echo $link ?>"><?php echo $categorias["exito"][$i]["denominacion"] ?></a></li>            
                  <?php
                }
              }else{
                $linkseleccionado=isset($_GET["favoritos"]) ? "productos.php?categoria=".$categorias["exito"][$i]["denominacion"]."&favoritos=".$_GET["favoritos"] : "productos.php?categoria=".$categorias["exito"][$i]["denominacion"];
                ?>
                <li><i class="fa fa-check cl-color-1" aria-hidden="true"></i> <a href="<?php echo $linkseleccionado ?>"><?php echo $categorias["exito"][$i]["denominacion"] ?></a></li>            
                <?php
              }
            }
          }
          ?>    
        </ul>

          <h3 class="bold titulo">Filtrar</h3>

          <?php
          if ($GLOBALS["configuracion"]["productos"]["mostrarlineasenfiltros"]===TRUE) {
            if (isset($_GET["categoria"]) && $_GET["categoria"] != "") {
              ?>
              <div class="form-group">
                <label class="control-label" for="lineas">Lineas</label>  
                <select onchange="seleccionaLinea()" id="lineas" class="form-control">
                  <option data-link="<?php echo $linkseleccionado ?>" value="">Seleccione</option>
                  <?php 
                    $lineas=retornarLineas($_GET["categoria"]);

                    foreach ($lineas["exito"] as $key => $value) {
                      ?>
                      <option data-link="<?php echo $linkseleccionado."&linea=".$value["linea"] ?>" <?php echo isset($_GET["linea"]) && $_GET["linea"]==$value["linea"] ? "selected" : "" ?> value="<?php echo $value["linea"] ?>"><?php echo $value["linea"] ?></option>
                      <?php
                    }
                  ?>
                </select>
              </div>
            <?php
            }
          }

          for ($i=0; $i < count($GLOBALS["configuracion"]["productos"]["filtros"]); $i++) { 
            ?>
            <div class="">
              <label class="control-label" for="<?php echo $GLOBALS["configuracion"]["productos"]["filtros"][$i]["id"]?>"><?php echo  $GLOBALS["configuracion"]["productos"]["filtros"][$i]["denominacion"] ?> <span class="label-valor"></span></label>  
              <?php
              if ($GLOBALS["configuracion"]["productos"]["filtros"][$i]["tipo"]=="input") {
                ?>
                <input class="form-control input-md" id="<?php echo $GLOBALS["configuracion"]["productos"]["filtros"][$i]["id"]?>"
                <?php 
                foreach ($GLOBALS["configuracion"]["productos"]["filtros"][$i]["atributos"] as $key => $value) {
                  echo $key.'="'.$value.'" ';
                }
                ?>
                >
                <?php
              }else if ($GLOBALS["configuracion"]["productos"]["filtros"][$i]["tipo"]=="select") {              
                ?>
                <select id="<?php echo $GLOBALS["configuracion"]["productos"]["filtros"][$i]["id"]?>" class="form-control"
                  <?php 
                  foreach ($GLOBALS["configuracion"]["productos"]["filtros"][$i]["atributos"] as $key => $value) {
                    echo $key.'="'.$value.'" ';
                  }
                  ?>                
                  >
                  <option value="">Seleccione</option>
                  <?php 
                    $opciones=$GLOBALS["configuracion"]["productos"]["filtros"][$i]["origendatos"]();
                    foreach ($opciones["exito"] as $key => $value) {
                      ?>
                      <option value="<?php echo $value[$GLOBALS["configuracion"]["productos"]["filtros"][$i]["valor"]] ?>"><?php echo $value[$GLOBALS["configuracion"]["productos"]["filtros"][$i]["texto"]] ?></option>
                      <?php
                    }
                  ?>
                </select>
                <?php
              }
              ?>
            </div>
            <?php
            }



          if (isset($_SESSION["idUsuario"])|| $GLOBALS["configuracion"]["permiteinvitado"]==TRUE) {

            ?>
              <h3 class="bold titulo hidden-xs">Favoritos</h3>
            
              <div id="panel-favoritos" class="hidden-xs">
                <div id="contenedor-panel-favoritos" class="container-fluid">

                </div>
                <div id="mensajes-panel-favoritos">
                  
                </div>
              </div>

              <h3 class="bold titulo hidden-xs">Carrito</h3>
            
              <div id="panel-cesta" class="hidden-xs">
                <div id="contenedor-panel-cesta" class="container-fluid">

                </div>
                <div id="mensajes-panel-cesta">
                  
                </div>                            
              </div>
              <?php            
          }

         ?>      
         <input id="favoritos" type="hidden" value="<?php echo isset($_GET["favoritos"]) ? $_GET["favoritos"] : "false" ?>">

      </div>
    </div>

  <?php
  }
}

?>