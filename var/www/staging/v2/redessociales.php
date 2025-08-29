<?php include_once("inc/inc.php") ?>

<!DOCTYPE html>
<html lang="es">

<head>
  <?php renderHead() ?>
  <?php facebookMetas() ?>
</head>

<body>
  <?php include_once("inc/analyticstracking.php") ?>

  <?php sdkfacebook(); ?>
  
  <header>

  <?php renderHeader() ?>

  </header>

  <!-- Contenido Móvil -->

  <div class="container-fluid">
    <div class="row">
      <main>

        <!-- Servicios -->

        <?php renderRedesSociales() ?>

        <!-- Fin Servicios -->

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



  $(document).ready(function(){
    feedinstagram();    
  })

  </script>

</body>

</html>
