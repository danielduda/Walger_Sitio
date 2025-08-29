<?php 

function renderServicios(){
  ?>

  <section>

    <div class="container">
      <div class="row">          

        <!-- Encabezado Página -->

        <div class="col-xs-12">
          
          <!-- Breadcrumb -->

          <hr>
          <h5><a href="">Servicios</a></h5>
          <hr>

          <!-- Fin Breadcrumb -->

        </div>

        <!-- Fin Encabezado Página -->

        <!-- Menú Lateral -->

        <?php renderMenuLateral() ?>

        <!-- Fin Menú Lateral -->

        <!-- Panel Central -->

        <div id="" class="<?php echo $GLOBALS["configuracion"]["menulateral"]?"col-lg-9 col-md-9 col-sm-8":"" ?> col-xs-12">

          <!-- Estado de Cuenta-->


          <div class="row">
            <div class="col-md-12">
              <h3 class="bold titulo">Servicios</h3>
              <dl>
                <?php 
                  for ($i=0; $i < count($GLOBALS["configuracion"]["textos"]["servicios"]); $i++) { 
                    ?>
                    <dt><?php echo $GLOBALS["configuracion"]["textos"]["servicios"][$i]["titulo"]; ?></dt>
                    <dd><?php echo $GLOBALS["configuracion"]["textos"]["servicios"][$i]["detalle"]; ?></dd>                      
                    <?php
                  }
                ?>
              </dl> 
            </div>
          </div>                                       

          <!-- Fin Estado de Cuenta-->

        </div> 

        <!-- Panel Central -->

      </div> 
    </div>             

  </section>

  <?php
}

?>

