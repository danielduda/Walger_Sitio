<?php

include_once("inc/inc.php");

if (sesion()!=true) {
  header("Location: ./index.php");
  exit(); 
} 

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <?php renderHead() ?>
</head>

<body>
  <?php include_once("inc/analyticstracking.php") ?>
  
  <header>

  <?php renderHeader() ?>

  </header>

  <!-- Contenido Móvil -->

  <div class="container-fluid">
    <div class="row">
      <main>

  <section>

    <div class="container">
      
      <div class="row">

        <!-- Encabezado Página -->

        <div class="col-xs-12">
          
          <!-- Breadcrumb -->

          <hr>
          <h5><a href="">Mensajes</a></h5>
          <hr>

          <!-- Fin Breadcrumb -->

        </div>

        <!-- Fin Encabezado Página -->

        <!-- Menú Lateral -->

        <?php renderMenuLateral() ?>

        <!-- Fin Menú Lateral -->

        <!-- Panel Central -->

        <div class="<?php echo $GLOBALS["configuracion"]["menulateral"]?"col-lg-9 col-md-9 col-sm-8":"" ?>col-xs-12" >

          <!-- Mensajes-->

        <?php renderMensajes() ?>
                          

          <!-- Fin Mensajes-->

        </div> 

        <!-- Panel Central -->   

      </div>
    </div>         

  </section>        




        <!-- Footer--> 

        <?php renderFooter() ?>

        <!-- FinFooter-->         

      </main> 
    </div>
  </div>

  <!-- Fin Contenido Móvil-->


  <!-- Scripts-->

  <?php renderScripts() ?>

  <!-- Fin Scripts-->

  <script>
  
    listarMensajes();

  </script> 
  


</body>

</html>
