<?php 

 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>Recaptcha</title>
 	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
 	<script src='https://www.google.com/recaptcha/api.js'></script>

 </head>
 <body>

 		<div class="g-recaptcha" data-sitekey="6LfJsBIUAAAAABGnV8OxyKxeP0eY20kxZjptq51g"></div>
		<button onclick="probar()">Probar</button>

 	
 <script>
 	function probar(){
 		var secret="6LfJsBIUAAAAANd6BNwhvgNKSKKoRAIvk3lBRVQ3";
 		var response=grecaptcha.getResponse();

    $.ajax({
        url: "https://www.google.com/recaptcha/api/siteverify",
        type: "post",
        crossDomain: true,
        data: {secret:secret, response:response},
        dataType: "json",
        success: function (response) {                            	
           console.log(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    }); 		

 	}
 </script>
 </body>
 </html>