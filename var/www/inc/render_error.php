<?php 

function renderError(){


  ?>

  <section>

    <div class="container">
      <div class="row">          

        <!-- Encabezado Página -->

        <div class="col-xs-12">
          
          <!-- Breadcrumb -->

          <hr>
          <h5>Error</h5>
          <hr>

          <!-- Fin Breadcrumb -->

        </div>

        <!-- Fin Encabezado Página -->

        <!-- Menú Lateral -->

        <?php renderMenuLateral() ?>

        <!-- Fin Menú Lateral -->

        <!-- Panel Central -->

        <!-- Mensaje-->
        
        <div class="<?php echo $GLOBALS["configuracion"]["menulateral"]?"col-lg-9 col-md-9 col-sm-8":"" ?> col-xs-12">

          <h3 class="bold titulo">Error</h3>

            <div class="row">
            <div class="col-md-12">
            <div>
              <p>
                No hemos podido procesar su pago <br>
                Igualmente, hemos recibido su pedido y, en breve, nos comunicaremos. <br>
                Muchas gracias!
              </p>
            </div>
            </div>
            </div>         

          <!-- Fin Mensaje-->

        </div> 

        <!-- Panel Central -->

      </div> 
    </div>             

  </section>

  <?php
}

?>

