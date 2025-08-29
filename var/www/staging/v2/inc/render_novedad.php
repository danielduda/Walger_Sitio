<?php 

function renderNovedad(){

  $novedad=retornarNovedad();

  ?>

  <section>

    <div class="container">
      <div class="row">          

        <!-- Encabezado Página -->

        <div class="col-xs-12">
          
          <!-- Breadcrumb -->

          <hr>
          <h5><a href="novedades.php">Novedades</a> / <?php echo $novedad["exito"][0]["titulo"] ?></h5>
          <hr>

          <!-- Fin Breadcrumb -->

        </div>

        <!-- Fin Encabezado Página -->

        <!-- Menú Lateral -->

        <?php renderMenuLateral() ?>

        <!-- Fin Menú Lateral -->

        <!-- Panel Central -->

        <!-- Novedad-->
        
        <div class="<?php echo $GLOBALS["configuracion"]["menulateral"]?"col-lg-9 col-md-9 col-sm-8":"" ?>col-xs-12">

          <h3 class="bold titulo">Novedades</h3>

            <div class="row novedad">
            <div class="col-md-12">
            <h3 class="bold mayuscula titulo2"><?php echo $novedad["exito"][0]["titulo"] ?></h3>
            <img src="<?php echo $GLOBALS["configuracion"]["carpetaupload"].$novedad["exito"][0]["imagen"] ?>" alt="">
            <p><?php echo $novedad["exito"][0]["contenido"] ?></p>
            </div>
            </div>         

          <!-- Fin Novedad-->

            <?php
              if ($GLOBALS["configuracion"]["redessociales"]["botonesfacebook"]===TRUE) {
                facebookMeGusta();                          
                facebookSeguir();
                facebookCompartir();
                facebookEnviar(); 
              }

            ?>           

        </div> 

        <!-- Panel Central -->

      </div> 
    </div>             

  </section>

  <?php
}

?>

