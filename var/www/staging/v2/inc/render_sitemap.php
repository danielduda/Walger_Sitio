<?php 

function renderSitemap(){
  ?>

  <section>

    <div class="container">
      <div class="row">          

        <!-- Encabezado Página -->

        <div class="col-xs-12">
          
          <!-- Breadcrumb -->

          <hr>
          <h5><a href="">Mapa del Sitio</a></h5>
          <hr>

          <!-- Fin Breadcrumb -->

        </div>

        <!-- Fin Encabezado Página -->

        <!-- Menú Lateral -->

        <?php renderMenuLateral() ?>

        <!-- Fin Menú Lateral -->

        <!-- Panel Central -->

        <div id="" class="<?php echo $GLOBALS["configuracion"]["menulateral"]?"col-lg-9 col-md-9 col-sm-8":"" ?>col-xs-12">

          <!-- Estado de Cuenta-->


          <div class="row">
            <div class="col-md-12">
              <h3 class="bold titulo">Mapa del Sitio</h3>
              <?php
                generarsitemapsitio();
              ?>
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

