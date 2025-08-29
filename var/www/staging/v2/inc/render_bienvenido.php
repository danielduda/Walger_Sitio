<?php 

function renderBienvenido(){
  ?>

  <section>

    <div class="container">
      <div class="row">          

        <!-- Encabezado Página -->

        <div class="col-xs-12">
          
          <!-- Breadcrumb -->

          <hr>
          <h5><a href="">Bienvenido</a></h5>
          <hr>

          <!-- Fin Breadcrumb -->

        </div>

        <!-- Fin Encabezado Página -->

        <!-- Menú Lateral -->

        <?php renderMenuLateral() ?>

        <!-- Fin Menú Lateral -->

        <!-- Panel Central -->

        <div id="" class="<?php echo $GLOBALS["configuracion"]["menulateral"]?"col-lg-9 col-md-9 col-sm-8":"" ?>col-xs-12">

          <!-- Bienvenido-->

          <div class="row" style="margin-bottom: 15px;">
            <div class="col-md-12">
              <h3 class="bold titulo">Bienvenido</h3>
              <h4><?php echo $GLOBALS["configuracion"]["textos"]["bienvenido"] ?></4>
            </div>
          </div>                                       

          <!-- Fin Bienvenido-->
          <?php renderMensajes()?>    

          <!-- Productos Novedades-->
          
          <?php renderDestacados("novedades") ?>          

          <!-- Fin Productos Novedades-->


        </div> 

        <!-- Panel Central -->

      </div> 
    </div>             

  </section>

  <?php
}

?>

