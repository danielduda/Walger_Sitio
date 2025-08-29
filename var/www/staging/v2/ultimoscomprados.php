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

        <!-- Mi Cuenta -->

        <?php renderUltimosComprados() ?>

        <!-- Fin Mi Cuenta -->

        <!-- Footer--> 

        <?php renderFooter() ?>

        <!-- FinFooter-->

        <!-- Modal Producto-->

        <?php renderDetalleProducto() ?>

        <!-- Fin Modal Producto-->                 

      </main> 
    </div>
  </div>

  <!-- Fin Contenido Móvil-->


  <!-- Scripts-->

  <?php renderScripts() ?>

  <!-- Fin Scripts-->

  <script>

    ultimosComprados();
  
  </script> 
  


</body>

</html>
