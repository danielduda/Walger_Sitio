<?php include_once("configuracion.php");

function sdkfacebook(){
?>

	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.10";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>

<?php
}

function facebookPluginPaginas(){
	?>
		<div
		  class="fb-page"
		  data-href="https://www.facebook.com/<?php echo $GLOBALS["configuracion"]["redessociales"]["nombrefacebook"] ?>"
		  data-tabs="timeline,messages"
		  data-small-header="true"
		  data-adapt-container-width="true"
		  data-hide-cover="true"
		  data-show-facepile="false">

		  <blockquote cite="https://www.facebook.com/<?php echo $GLOBALS["configuracion"]["redessociales"]["nombrefacebook"] ?>" class="fb-xfbml-parse-ignore">
		    <a href="https://www.facebook.com/<?php echo $GLOBALS["configuracion"]["redessociales"]["nombrefacebook"] ?>"><?php echo $GLOBALS["configuracion"]["redessociales"]["titulofacebook"] ?></a>
		  </blockquote>

		</div> 	
	<?php
}

function facebookMeGusta(){
	?>
		<div
			class="fb-like col-xs-12"
			data-href="<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"] ?>"
			data-layout="standard"
			data-action="like"
			data-size="small"
			data-show-faces="false"
			data-share="false"
    style="margin-bottom:5px;overflow: hidden;">
		</div>
		<br>	
	<?php
}

function facebookSeguir(){
	?>
		<div
			class="fb-follow col-xs-12"
			data-href="https://www.facebook.com/<?php echo $GLOBALS["configuracion"]["redessociales"]["nombrefacebook"] ?>"
			data-layout="standard"
			data-size="small"
			data-show-faces="false"
    style="margin-bottom:5px;overflow: hidden;">
		</div>
		<br>
	<?php
}

function facebookEnviar(){
	?>
  <div
  	class="fb-send col-xs-12" 
		data-href="<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"] ?>"
    style="margin-bottom:5px;overflow: hidden;">
  </div>
  <br>		
	<?php
}

function facebookCompartir(){
	?>
  <div
  	class="fb-share-button col-xs-12" 
		data-href="<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"] ?>"
		data-layout="button"    
    style="margin-bottom:5px;overflow: hidden;">
  </div>
  <br>		
	<?php
}

function facebookMetas(){
	?>
		<meta property="og:url"                content="<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"] ?>" />
		<meta property="og:type"               content="website" />
		<meta property="og:title"              content="<?php echo $GLOBALS["configuracion"]["metas"]["title"] ?>" />
		<meta property="og:description"        content="<?php echo $GLOBALS["configuracion"]["metas"]["description"] ?>" />
		<meta property="og:image"              content="<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://'.$GLOBALS["configuracion"]["host"].'/'.$GLOBALS["configuracion"]["carpetaimagenes"].$GLOBALS["configuracion"]["redessociales"]["imagenfacebook"] ?>" />
		<meta property="fb:app_id"             content="" />
	<?php
}

function facebookMetasArticle($title, $description, $image){
	?>
		<meta property="og:url"                content="<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"] ?>" />
		<meta property="og:type"               content="article" />
		<meta property="og:title"              content="<?php echo $title ?>" />
		<meta property="og:description"        content="<?php echo strip_tags($description) ?>" />
		<meta property="og:image"              content="<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://'.$GLOBALS["configuracion"]["host"].'/'.$GLOBALS["configuracion"]["carpetaimagenes"].$image ?>" />
		<meta property="fb:app_id"             content="" />
	<?php
}

function facebookMetasProduct($title, $image){
	?>
		<meta property="og:url"                content="<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"] ?>" />
		<meta property="og:type"               content="product" />
		<meta property="og:title"              content="<?php echo $title ?>" />
		<meta property="og:description"        content="<?php echo $GLOBALS["configuracion"]["redessociales"]["textoproducto"] ?>" />
		<meta property="og:image"              content="<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://'.$GLOBALS["configuracion"]["host"].'/'.$GLOBALS["configuracion"]["carpetauploadremoto"].$image ?>" />
		<meta property="fb:app_id"             content="" />
	<?php
}

?>

	
