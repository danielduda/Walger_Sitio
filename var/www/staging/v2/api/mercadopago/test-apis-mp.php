<?php

function test_api($url){
    
    $cURL = curl_init($url);
    curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($cURL, CURLOPT_SSLVERSION, 3);
    curl_setopt($cURL, CURLOPT_CAINFO, dirname(__FILE__) . "/cacert.pem");
    $resultado = curl_exec($cURL);
    
        
            
    if(curl_exec($cURL) === false){
        echo 'Curl error: ' . curl_error($cURL);
    }
    else{
        curl_close($cURL);
        return json_decode($resultado, TRUE);
    }
    
}



$url = "https://api.mercadolibre.com/";
$category = test_api($url . "item_categories");
$sites = test_api($url . "sites");
$sites_mla = test_api($url . "sites/MLA");

if(is_array($category)):
    echo "<h1>Category: OK </h1><br/>";
else:
    echo '<h1 class="red-test">Category: NO OK </h1><br/>';
endif;


if(is_array($sites)):
    echo "<h1>Sites: OK </h1><br/>";
else:
    echo '<h1 class="red-test">Sites: NO OK </h1><br/>';
endif;


if(isset($sites_mla['id'])):
    echo "<h1>Sites MLA: OK </h1><br/>";
else:
    echo '<h1 class="red-test">Sites MLA: NO OK </h1><br/>';
endif;

echo '<style>.red-test{color:red;} h1{color:green;}</style>';

echo "<pre>";

print_r($category);
print_r($sites);
print_r($sites_mla);

