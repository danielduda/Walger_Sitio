<?php

require_once ('mercadopago.php');
@include_once("../../inc/configuracion.php");
@include_once("../../inc/inc.php");
@include_once("../../api/connect.php");
@include_once("../../api/funciones.php");

$mp = new MP ($GLOBALS["configuracion"]["mercadopago"]["credenciales"]["CLIENT_ID"], $GLOBALS["configuracion"]["mercadopago"]["credenciales"]["CLIENT_SECRET"]);

$params = ["access_token" => $mp->get_access_token()];

// Check mandatory parameters
if (!isset($_GET["id"], $_GET["topic"]) || !ctype_digit($_GET["id"])) {
	http_response_code(400);
	return;
}

// Get the payment reported by the IPN. Glossary of attributes response in https://developers.mercadopago.com
if($_GET["topic"] == 'payment'){
	$payment_info = $mp->get("/collections/notifications/" . $_GET["id"], $params, false);
	$merchant_order_info = $mp->get("/merchant_orders/" . $payment_info["response"]["collection"]["merchant_order_id"], $params, false);

var_dump($payment_info);
var_dump($merchant_order_info);

// Get the merchant_order reported by the IPN. Glossary of attributes response in https://developers.mercadopago.com	
}else if($_GET["topic"] == 'merchant_order'){
	$merchant_order_info = $mp->get("/merchant_orders/" . $_GET["id"], $params, false);

var_dump($merchant_order_info);

}

//If the payment's transaction amount is equal (or bigger) than the merchant order's amount you can release your items 
if ($merchant_order_info["status"] == 200) {
	$transaction_amount_payments= 0;
	$transaction_amount_order = $merchant_order_info["response"]["total_amount"];
  $payments=$merchant_order_info["response"]["payments"];
  foreach ($payments as  $payment) {
  	if($payment['status'] == 'approved'){
    	$transaction_amount_payments += $payment['transaction_amount'];
    }	
  }
  if($transaction_amount_payments >= $transaction_amount_order){
			
		$sql="SELECT * FROM `dbo_cliente` where CodigoCli='".$merchant_order_info["response"]["external_reference"]."'";
		$resultado=mysqli_query($mysqli, $sql);

		$registro=mysqli_fetch_assoc($resultado);

		$demail=$GLOBALS["configuracion"]["email"]["emailenvia"];
		$denombre=$GLOBALS["configuracion"]["email"]["nombreenvia"];
		$paramail=$registro["emailCli"];
		$paranombre=$registro["RazonSocialCli"];
		$responderamail=$GLOBALS["configuracion"]["email"]["norespondermail"];
		$responderanombre=$GLOBALS["configuracion"]["email"]["norespondernombre"];
		$concopia=$GLOBALS["configuracion"]["email"]["emailadministracion"];
		$concopiaoculta="";
		$asunto=$GLOBALS["configuracion"]["email"]["asuntos"]["pagoacreditadoadministracion"];

		$datos = "<strong>Código de cliente: </strong>".$registro["CodigoCli"]."<br>";
		$datos .= "<strong>Denominación de cliente: </strong>".$registro["RazonSocialCli"]."<br>";
		$datos .= "<strong>Medio de Pago Seleccionado:</strong> MERCADO PAGO <br>";
		$datos .= "<strong>Importe:</strong> $".$transaction_amount_payments." <br>";
			
		$mensajehtml= "Se ha acreditado un pago por Mercado Pago con los siguientes datos: <br>".$datos;
		$mensajeplano=str_replace("<br>", " - ", $mensajehtml);
		$encabezado=$registro["RazonSocialCli"];

		$resultado=enviarMail($demail, $denombre, $paramail, $paranombre, $responderamail, $responderanombre, $concopia, $concopiaoculta, $asunto, $mensajehtml, $mensajeplano, $encabezado );

  }
  else{
		echo "No se acreditó el pago";
	}
}
?>