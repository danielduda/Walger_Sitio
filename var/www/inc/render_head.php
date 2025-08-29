<?php

function renderHead(){

	sqlinjection();
	
	?>
	  <meta charset="utf-8">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <meta name="author" content="<?php echo $GLOBALS["configuracion"]["metas"]["author"] ?>">

	  <!-- Descripción del sitio -->    
	  <meta name="description" content="<?php echo $GLOBALS["configuracion"]["metas"]["description"] ?>">
	  <!-- Tags sociales -->

	  <!-- Título Sitio -->
	  <title><?php echo $GLOBALS["configuracion"]["metas"]["title"] ?></title>

	  <!-- Favicon -->
	  <link rel="shortcut icon" href="<?php echo $GLOBALS["configuracion"]["carpetaimagenes"].$GLOBALS["configuracion"]["metas"]["favicon"] ?>" type="image/x-icon">
	  <link rel="icon" href="<?php echo $GLOBALS["configuracion"]["carpetaimagenes"].$GLOBALS["configuracion"]["metas"]["favicon"] ?>" type="image/x-icon">    

	  <!-- Bootstrap 3.3.7 Core CSS -->
	  <link href="css/bootstrap-3.3.7/bootstrap.min.css" rel="stylesheet">

	  <!-- Bootstrap 3.3.7 Core CSS -->
	  <link href="css/font-awesome-4.7.0/font-awesome.min.css" rel="stylesheet">

	  <!-- Camera -->
	  <link href="css/camera/camera.css" rel="stylesheet">

	  <!-- Owl Carousel -->
	  <link href="css/owlcarousel-2.2.0/owl.carousel.min.css" rel="stylesheet">
	  <link href="css/owlcarousel-2.2.0/owl.theme.default.min.css" rel="stylesheet">           

	  <!-- File Upload -->
	  <link href="css/fileupload/jquery.fileupload.css" rel="stylesheet">
	  <link href="css/fileupload/jquery.fileupload-ui.css" rel="stylesheet">           

	  <!-- Custom -->
	  <link href="css/misc/custom.php" rel="stylesheet">

		<script src="https://www.google.com/recaptcha/api.js"></script>	  

	  <!-- Fuentes -->
	  <?php 
	  	$fuentes=implode("|", $GLOBALS["configuracion"]["brand"]["fuentes"])
	   ?>
	  <link href="https://fonts.googleapis.com/css?family=<?php echo $fuentes ?>" rel="stylesheet">


	<?php

}

 ?>