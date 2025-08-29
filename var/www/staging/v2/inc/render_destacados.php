<?php 

function renderDestacados($tipo){

  //$tipo permite "ofertas" o "novedades"

	?>

        <section id="destacados" class="well3 center">
          <div class="">
            <h3 class="bold titulo"><?php echo $tipo=="ofertas"? "Ofertas" : "Novedades" ?></h3>
          </div>
          <div class="">
            <div class="row">

              <?php 

                $productosDestacados=retornarProductosDestacados($tipo);

                if($productosDestacados["error"]==true){
                  for ($i=0; $i < count($productosDestacados["errores"]["mensajeerror"]); $i++) { 
                    echo $productosDestacados["errores"]["mensajeerror"][$i]."<br>";
                  }
                }else{
                  for ($i=0; $i < count($productosDestacados["exito"]); $i++) {
                    ?>
                    <div class="destacados-contenedor producto col-md-3" data-codigo-producto="<?php echo $productosDestacados["exito"][$i]["CodInternoArti"] ?>">
                      <div class="destacados-inner">
                        <div class="col-md-12 col-sm-6">
                          <div class="destacados-imagen" >
                            <img src="<?php echo $GLOBALS["configuracion"]["carpetauploadremoto"].$productosDestacados["exito"][$i]["NombreFotoArti"] ?>" alt="">
                          </div>                      
                        </div>
                        <div class="col-md-12 col-sm-6 destacados-descripcion">
                    
                        <?php
                          if (isset($productosDestacados["exito"][$i]["atributos"])) {
                            ?>
                            <h3><span style="font-size:10pt"> <?php echo $productosDestacados["exito"][$i]["palabraminimo"] ?></span><span style="white-space: nowrap"> <?php echo $productosDestacados["exito"][$i]["minimo"] ?></span></h3>                    
                            <?php
                          }else{
                            ?>
                            <h3><?php echo $productosDestacados["exito"][$i]["PrecioVta1_PreArti"] ?></h3>
                            <?php
                          }                          
                        ?>
                          <a class="nombre-producto" href=""><h5><?php echo $productosDestacados["exito"][$i]["DescrNivelInt3"] ?></h5></a>
                          <p><?php echo $productosDestacados["exito"][$i]["DescripcionArti"] ?></p>
                          
                          <?php 

                          if (isset($productosDestacados["exito"][$i]["atributos"])) {
                            ?>
                              <div class="text-center input-group">
                              <a style="width:100%" class="btn btn-danger"  href="producto.php?codigo=<?php echo $productosDestacados["exito"][$i]["CodInternoArti"] ?>">
                              <h6 style="margin:4px"><i class="fa fa-filter" aria-hidden="true"></i> Seleccione</h6>
                              </a>
                              </div>
                            <?php
                          }else{
                            ?>

                          <div class="input-group">
                          <?php

                            if ($GLOBALS["configuracion"]["productos"]["comprarsinexistencia"]===FALSE) {
                                if ($productosDestacados["exito"][$i]["Stock1_StkArti"]>0) {
                                ?>
                                  <input onchange="valorCantidad(this)" id="cantidad-pedida" name="" class="form-control" placeholder="" type="number" min="1" max="<?php echo $productosDestacados["exito"][$i]["Stock1_StkArti"]+1 ?>" value="1">
                                  <span class="input-group-addon"><a onclick="agregarCesta(this)" class="btn btn-danger" href="javascript:void(0);"><i class="fa fa-cart-plus" aria-hidden="true"></i></a></span>
                                <?php
                                }else{
                                  ?>
                                    <h4><?php echo $GLOBALS["configuracion"]["productos"]["textosinexistencia"] ?></h4>                                  
                                  <?php
                                };
                            }else{
                                if ($GLOBALS["configuracion"]["productos"]["avisopocaexistencia"]===TRUE) {
                                    if ($productosDestacados["exito"][$i]["Stock1_StkArti"]<$GLOBALS["configuracion"]["productos"]["cantidadpocaexistencia"]) {
                                        ?>
                                        <input onchange="valorCantidad(this)" id="cantidad-pedida" name="" class="form-control" placeholder="" type="number" min="1" max="9999999" value="1">
                                        <span class="input-group-addon"><a onclick="agregarCesta(this)" class="btn btn-danger" href="javascript:void(0);"><i class="fa fa-cart-plus" aria-hidden="true"></i></a></span>
                                        </div>
                                        <div>
                                        <h6 class="cl-color-1"><?php echo $GLOBALS["configuracion"]["productos"]["textopocaexistencia"]?></h6>
                                        <?php
                                    }else{
                                        ?>
                                        <input onchange="valorCantidad(this)" id="cantidad-pedida" name="" class="form-control" placeholder="" type="number" min="1" max="999999" value="1">
                                        <span class="input-group-addon"><a onclick="agregarCesta(this)" class="btn btn-danger" href="javascript:void(0);"><i class="fa fa-cart-plus" aria-hidden="true"></i></a></span>
                                        <?php
                                    };                                    
                                }else{
                                  ?>
                                    <input onchange="valorCantidad(this)" id="cantidad-pedida" name="" class="form-control" placeholder="" type="number" min="1" max="999999" value="1">
                                    <span class="input-group-addon"><a onclick="agregarCesta(this)" class="btn btn-danger" href="javascript:void(0);"><i class="fa fa-cart-plus" aria-hidden="true"></i></a></span>
                                  <?php
                                };
                            };
                          ?>                            
                          </div>
                          <?php
                          }
                          ?>

                          <div class="contenedor-favoritos">
                            <?php 
                              if ($productosDestacados["exito"][$i]["id"]=="") {
                                ?>
                                <a class="favoritos" onclick="agregarFavoritos(this)" href="javascript:void(0);"><i class="fa fa-heart" aria-hidden="true"></i> Agregar a favoritos</a>
                                <?php
                              }else{
                                ?>
                                <a class="favoritos" onclick="borrarFavoritos(this)" href="javascript:void(0);"><i class="fa fa-trash-o fa-fw"></i> Eliminar de Favoritos</a>                          
                                <?php
                              };                            
                             ?>
                          </div>
                          <div class="col-xs-12 text-justify no-padding">
                            # <?php echo $productosDestacados["exito"][$i]["CodInternoArti"] ?>
                            <br>
                            Referencia: <?php echo $productosDestacados["exito"][$i]["CodBarraArti"] ?>
                          </div>                         
                        </div>
                      </div>
                    </div>
                    <?php
                  }

                  
                }

              ?>

            </div>
          </div>            
        </section>


	<?php
  
}

 ?>