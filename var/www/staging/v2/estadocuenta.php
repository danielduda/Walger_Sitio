<?php include_once("inc/inc.php") ?>

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

        <?php renderMiCuenta() ?>

        <!-- Fin Mi Cuenta -->

        <!-- Footer--> 

        <?php renderFooter() ?>

        <!-- FinFooter-->         

      </main> 
    </div>
  </div>

  <!-- Fin Contenido Móvil-->


  <!-- Scripts-->

  <?php renderScripts() ?>

  <script>
    estadoCuenta();
  </script>

  <!-- Fin Scripts--> 



</body>

</html>
