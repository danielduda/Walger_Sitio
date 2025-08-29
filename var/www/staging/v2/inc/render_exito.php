<?php 

function renderExito(){


  confirmarPago($_GET["pedido"],$_GET["Answer"]);



  ?>

  <section>

    <div class="container">
      <div class="row">          

        <!-- Encabezado Página -->

        <div class="col-xs-12">
          
          <!-- Breadcrumb -->

          <hr>
          <h5>Éxito</h5>
          <hr>

          <!-- Fin Breadcrumb -->

        </div>

        <!-- Fin Encabezado Página -->

        <!-- Menú Lateral -->

        <?php renderMenuLateral() ?>

        <!-- Fin Menú Lateral -->

        <!-- Panel Central -->

        <!-- Mensaje-->
        
        <div class="<?php echo $GLOBALS["configuracion"]["menulateral"]?"col-lg-9 col-md-9 col-sm-8":"" ?>col-xs-12">

          <h3 class="bold titulo">Éxito</h3>

            <div class="row">
            <div class="col-md-12">
            <div>
              <p>
                Se ha procesado su compra exitosamente! <br>
                Por favor, revise su correo para confirmar la recepción del comprobante. <br>
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

