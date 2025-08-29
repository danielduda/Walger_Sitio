<?php
include_once("inc/inc.php");
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <?php renderHead() ?>
  <?php
  
    $producto = retornarProductoParaMeta($_GET["codigo"]);

    facebookMetasProduct($producto["exito"][0]["DescripcionArti"], $producto["exito"][0]["NombreFotoArti"]);    

  ?>
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

        <!-- Productos -->

        <?php renderProducto() ?>

        <!-- Fin Productos -->

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
    
    mostrarProducto('<?php echo $_GET["codigo"] ?>');

  </script>

  <!-- Fin Scripts-->  


</body>

</html>
