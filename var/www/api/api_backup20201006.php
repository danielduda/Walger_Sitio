<?php 

@include_once("../api/connect.php");
@include_once("../api/errores.php");
@include_once("../api/funciones.php");
@include_once("../api/consultas.php");
@include_once("../inc/configuracion.php");
@include_once("../inc/sesion.php");

include_once dirname(__FILE__)."/todopago/vendor/autoload.php";
use TodoPago\Sdk;

sqlinjection();

$respuesta=array();
$respuesta["errores"]["coderror"]=array();
$respuesta["errores"]["mensajeerror"]=array();


switch ($_GET["accion"]) {

	case 'login':

	/********** LOGIN ***********/

	if (!isset($_GET["usuario"]) || $_GET["usuario"]=="") {
		$respuesta["error"]=TRUE;
		cargaError($_GET["accion"],0);
	}

	if (!isset($_GET["contrasena"]) || $_GET["contrasena"]=="") {
		$respuesta["error"]=TRUE;
		cargaError($_GET["accion"],1);			
	}

	if (!isset($respuesta["error"]) || $respuesta["error"]!=TRUE) {
		$sql="SELECT * FROM dbo_cliente
		INNER JOIN dbo_listaprecios on dbo_cliente.Regis_ListaPrec = dbo_listaprecios.Regis_ListaPrec
		INNER JOIN dbo_ivacondicion on dbo_cliente.Regis_IvaC = dbo_ivacondicion.Regis_IvaC
		INNER JOIN walger_clientes on dbo_cliente.CodigoCli = walger_clientes.CodigoCli
		LEFT JOIN dbo_moneda on dbo_moneda.Regis_Mda = walger_clientes.Regis_Mda
		WHERE emailCli='".$_GET["usuario"]."'
		AND contrasenia='".$_GET["contrasena"]."'
		AND Habilitado = 'S'
		LIMIT 1";

		$resultado = mysqli_query($mysqli, $sql);

		if ($resultado->num_rows===1) {
			$respuesta["error"]=FALSE;
			$registro=mysqli_fetch_assoc($resultado);
			if ($registro["Cotiz_Mda"]==0) {
				$registro["Cotiz_Mda"]=1;
			}
			$_SESSION["idUsuario"]=$registro["CodigoCli"];
			$_SESSION["VariacionListaPrec"]=$registro["VariacionListaPrec"];
			$_SESSION["Signo_Mda"]=$registro["Signo_Mda"];
			$_SESSION["Cotiz_Mda"]=$registro["Cotiz_Mda"];
			$_SESSION["CalculaIvaC"]=$registro["CalculaIvaC"];
			$_SESSION["DiscriminaIvaC"]=$registro["DiscriminaIvaC"];
			$_SESSION["Denominacion"]=$registro["RazonSocialCli"];
			$_SESSION["cuit"]=$registro["CuitCli"];			

			$sql="UPDATE walger_clientes
            SET IP = '".$_SERVER['REMOTE_ADDR']."',
            UltimoLogin = NOW()
            WHERE CodigoCli = '".$registro["CodigoCli"]."'";

			$resultado=mysqli_query($mysqli, $sql);

			if (compruebaUsuarioInvitado()) {

				$usuarioInvitado=usuarioInvitado();

				$idUsuario=$_SESSION["idUsuario"];

				$sql="UPDATE `trama_favoritos` SET `idUsuario` = '".$idUsuario."' WHERE `trama_favoritos`.`idUsuario` = '".$usuarioInvitado."'";
				$resultado=mysqli_query($mysqli, $sql);							

				$sql="SELECT idPedido
				FROM walger_pedidos
				WHERE estado = 'N'
				AND CodigoCli = '".$idUsuario."'";

				$resultado=mysqli_query($mysqli, $sql);

				if ($resultado->num_rows > 0){
					$registro=mysqli_fetch_assoc($resultado);
					$idPedido=$registro["idPedido"];

					$sql="SELECT `walger_items_pedidos`.idItemPedido,
					`walger_items_pedidos`.cantidad,
					`walger_items_pedidos`.CodInternoArti,
					`walger_pedidos`.idPedido
					FROM walger_items_pedidos
					INNER JOIN `walger_pedidos`
					ON `walger_items_pedidos`.idPedido = walger_pedidos.idPedido
					WHERE `walger_pedidos`.`CodigoCli` = '".$usuarioInvitado."'
					AND `walger_items_pedidos`.estado = 'P'
					AND walger_pedidos.estado = 'N'";

					$resultadoPedidoAnterior=mysqli_query($mysqli, $sql);

					if ($resultadoPedidoAnterior->num_rows > 0) {
						for ($i=0; $i < $resultadoPedidoAnterior->num_rows; $i++) {

							$registro=mysqli_fetch_assoc($resultadoPedidoAnterior);

							$codigo=$registro["CodInternoArti"];
							$cantidad=$registro["cantidad"];
							$idPedidoAnterior=$registro["idPedido"];

							$sql="SELECT *
							FROM dbo_articulo
							WHERE CodInternoArti='".$codigo."'";

							$resultado=mysqli_query($mysqli, $sql);

							$articulo=mysqli_fetch_assoc($resultado);								

							$sql="SELECT `walger_items_pedidos`.idItemPedido,
							`walger_items_pedidos`.cantidad
							FROM walger_items_pedidos
							INNER JOIN `walger_pedidos`
							ON `walger_items_pedidos`.idPedido = walger_pedidos.idPedido
							WHERE `walger_items_pedidos`.`CodInternoArti` = '".$codigo."'
							AND `walger_pedidos`.`CodigoCli` = '".$idUsuario."'
							AND `walger_items_pedidos`.estado = 'P'
							AND walger_pedidos.estado = 'N'";

							$resultado=mysqli_query($mysqli, $sql);

							if ($resultado->num_rows > 0) {
								$registro=mysqli_fetch_assoc($resultado);
								$nuevacantidad=$registro["cantidad"]+$cantidad;
								$sql="UPDATE `walger_items_pedidos`
								SET `cantidad` = '".$nuevacantidad."'
								WHERE `walger_items_pedidos`.`idItemPedido` = '".$registro["idItemPedido"]."'";

							}else{
								$sql="INSERT INTO walger_items_pedidos
								(
									idPedido,
									CodInternoArti,
									precio,
									cantidad,
									estado
									)VALUES (
									'".$idPedido."',
									'".$codigo."',
									'".$articulo["PrecioVta1_PreArti"]."',
									'".$cantidad."',
									'P'
									)";
							}			

						$resultado=mysqli_query($mysqli, $sql);

						}

						$sql="DELETE
						FROM walger_items_pedidos
						INNER JOIN `walger_pedidos`
						ON `walger_items_pedidos`.idPedido = walger_pedidos.idPedido
						WHERE walger_pedidos.idPedido = '".$idPedidoAnterior."'";

						$resultado=mysqli_query($mysqli, $sql);

						$sql="DELETE
						FROM walger_pedidos
						WHERE idPedido = '".$idPedidoAnterior."'";

						$resultado=mysqli_query($mysqli, $sql);							
					}

				}else{
					$sql="UPDATE `walger_pedidos`
					SET `CodigoCli` = '".$idUsuario."'
					WHERE `CodigoCli` = '".$usuarioInvitado."'";

					$resultado=mysqli_query($mysqli, $sql);
				}

			}

		}else{
			$respuesta["error"]=TRUE;
			cargaError($_GET["accion"],2);
		}

	}

	borraUsuarioInvitado();

	break;

	case 'logout':
		
		/********** LOGOUT ***********/
		unset($_SESSION["idUsuario"]);

		session_unset();

		break;

	case 'captcha':
		
		/********** CAPTCHA ***********/
	  
	  $captcha = "";
    if (isset($_GET["response"]))
        $captcha = $_GET["response"];

    if (!$captcha)
        $respuesta["mensaje"]="Debe marcar la casilla";

    $secret = $GLOBALS["configuracion"]["captchasecret"];
    $respuesta = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$captcha."&remoteip=".$_SERVER["REMOTE_ADDR"]), true);

		break;		

	case 'paginanovedades':
		
		/********** NOVEDADES ***********/

		$sql="SELECT *
		FROM trama_noticias
		ORDER BY id DESC
		LIMIT ".$GLOBALS["configuracion"]["paginanovedades"]["resultadosDevueltos"]."
		OFFSET ".$_GET["offset"];

		$resultado = mysqli_query($mysqli, $sql);

		if ($resultado->num_rows>0) {
			$respuesta["exito"]=array();
			$respuesta["error"]=FALSE;

			for ($i=0; $i < $resultado->num_rows; $i++) { 
				$registro=mysqli_fetch_assoc($resultado);
				$registro["contenidocorto"]=substr($registro["contenido"], 0, $GLOBALS["configuracion"]["paginanovedades"]["limiteCaracteresContenidoPrevio"])."...";
				$registro=map($registro);
				array_push($respuesta["exito"], $registro);
			}
		$respuesta["adicionales"]["carpetaupload"]=$GLOBALS["configuracion"]["carpetaupload"];
		}else{
			if ($_GET["offset"]==1) {
				$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],0);				
			}else{
				$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],1);
			}
		}

		break;

	case 'paginaportfolio':
		
		/********** PORTFOLIO ***********/

		$sql="SELECT * FROM `trama_portfolio`";

		$resultado = mysqli_query($mysqli, $sql);

		if ($resultado->num_rows>0) {
			$respuesta["exito"]=array();
			$respuesta["error"]=FALSE;

			for ($i=0; $i < $resultado->num_rows; $i++) { 
				$registro=mysqli_fetch_assoc($resultado);
				$registro=map($registro);
				array_push($respuesta["exito"], $registro);
			}
		$respuesta["adicionales"]["carpetaupload"]=$GLOBALS["configuracion"]["carpetaupload"];
		}

		break;		

	case 'formulario-contacto':
		
		/********** FORMULARIO CONTACTO ***********/


		$demail=$GLOBALS["configuracion"]["email"]["emailenvia"];
		$denombre=$GLOBALS["configuracion"]["email"]["nombreenvia"];
		$paramail=$GLOBALS["configuracion"]["email"]["emailadministracion"];
		$paranombre=$GLOBALS["configuracion"]["email"]["nombreadministracion"];
		$responderamail=$_GET["cabecera"]["email"];
		$responderanombre=$_GET["cabecera"]["nombre"];
		$concopia="";
		$concopiaoculta="";
		$asunto=$GLOBALS["configuracion"]["email"]["asuntos"]["contactoadministracion"];
		$mensajehtml= "Hemos recibido un mensaje desde nuestro formulario de contacto de ".$_GET["cabecera"]["nombre"].". Su teléfono es ".$_GET["cabecera"]["telefono"].". Para contactarse vía mail puede responder este correo <br> Mensaje: ".$_GET["cabecera"]["mensaje"];
		$mensajeplano="Hemos recibido un mensaje desde nuestro formulario de contacto de ".$_GET["cabecera"]["nombre"].". Su teléfono es ".$_GET["cabecera"]["telefono"].". Para contactarse vía mail puede responder este correo. Mensaje: ".$_GET["cabecera"]["mensaje"];
		$encabezado=$GLOBALS["configuracion"]["email"]["nombreadministracion"];	

		$resultado=enviarMail($demail, $denombre, $paramail, $paranombre, $responderamail, $responderanombre, $concopia, $concopiaoculta, $asunto, $mensajehtml, $mensajeplano, $encabezado );

		if ($resultado["enviado"]==TRUE) {
			$respuesta["error"]=FALSE;			
			$respuesta["exito"]="Mensaje Enviado";

			$demail=$GLOBALS["configuracion"]["email"]["emailenvia"];
			$denombre=$GLOBALS["configuracion"]["email"]["nombreenvia"];
			$paramail=$_GET["cabecera"]["email"];
			$paranombre=$_GET["cabecera"]["nombre"];
			$responderamail=$GLOBALS["configuracion"]["email"]["norespondermail"];
			$responderanombre=$GLOBALS["configuracion"]["email"]["norespondernombre"];
			$concopia="";
			$concopiaoculta="";
			$asunto=$GLOBALS["configuracion"]["email"]["asuntos"]["contactocliente"];
			$mensajehtml= "Hemos recibido su mensaje y en breve nos contactaremos con usted";
			$mensajeplano="Hemos recibido su mensaje y en breve nos contactaremos con usted";
			$encabezado=$_GET["cabecera"]["nombre"];		
	
			enviarMail($demail, $denombre, $paramail, $paranombre, $responderamail, $responderanombre, $concopia, $concopiaoculta, $asunto, $mensajehtml, $mensajeplano, $encabezado );


		}else{
			$respuesta["error"]=TRUE;
			cargaError($_GET["accion"],1);
		}

		break;

	case 'restaurarcontrasena':
		
		/********** RESTAURAR CONTASEÑA ***********/

		if (!isset($_GET["email"]) || $_GET["email"]=="") {
			$respuesta["error"]=TRUE;
			cargaError($_GET["accion"],0);
		}


		if (!isset($respuesta["error"]) || $respuesta["error"]!=TRUE) {

			$email = $_GET["email"];
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  			$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],1); 
			}
		}

		if (!isset($respuesta["error"]) || $respuesta["error"]!=TRUE) {		

			$sql="SELECT
				dc.CodigoCli,
				dc.RazonSocialCli,
				dc.emailCli
				FROM  `dbo_cliente` AS dc 
				WHERE dc.emailCli='".$_GET["email"]."'";
			$resultado = mysqli_query($mysqli, $sql);

			if ($resultado->num_rows===1) {
				$registro=mysqli_fetch_assoc($resultado);
				$nuevopass=randomPassword();

				$sql="UPDATE `walger_clientes`
				SET `Contrasenia` = '".$nuevopass."'
				WHERE `walger_clientes`.`CodigoCli` = '".$registro["CodigoCli"]."'";
				mysqli_query($mysqli, $sql);

				$demail=$GLOBALS["configuracion"]["email"]["emailenvia"];
				$denombre=$GLOBALS["configuracion"]["email"]["nombreenvia"];
				$paramail=$registro["emailCli"];
				$paranombre=ucwords(strtolower($registro["RazonSocialCli"]));
				$responderamail=$GLOBALS["configuracion"]["email"]["norespondermail"];
				$responderanombre=$GLOBALS["configuracion"]["email"]["norespondernombre"];
				$concopia="";
				$concopiaoculta="";
				$asunto=$GLOBALS["configuracion"]["email"]["asuntos"]["cambiodecontrasenacliente"];
				$mensajehtml= "Hemos recibido una solicitud para modificar su contraseña.<br>A partir de este momento, podrá iniciar sesión utilizando la siguiente contraseña: <strong>".$nuevopass."</strong>";
				$mensajeplano="Hemos recibido una solicitud para modificar su contraseña.A partir de este momento, podrá iniciar sesión utilizando la siguiente contraseña: ".$nuevopass;
				$encabezado=ucwords(strtolower($registro["RazonSocialCli"]));	

				$resultado=enviarMail($demail, $denombre, $paramail, $paranombre, $responderamail, $responderanombre, $concopia, $concopiaoculta, $asunto, $mensajehtml, $mensajeplano, $encabezado );

				if ($resultado["enviado"]==TRUE) {
					$respuesta["error"]=FALSE;			
					$respuesta["exito"]="Contraseña Restaurada. Revise su correo";

				}else{
					$respuesta["error"]=TRUE;
					cargaError($_GET["accion"],3);
				}

			}else{
				$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],2);
			}
		}

		break;

	case 'formulario-registro':
		
		/********** FORMULARIO REGISTRO ***********/

		$tiposClientes=retornarTiposClientes();		
		//compruebo contraseñas
		$respuesta=comprobarPassword($_GET["cabecera"]["contrasena"]);

		if ($_GET["cabecera"]["contrasena"]!=$_GET["cabecera"]["repetir-contrasena"]) {
			$respuesta["error"]=TRUE;
			cargaError($_GET["accion"],0);			
		}

		if ($respuesta["error"]==FALSE) {

			foreach ($GLOBALS["configuracion"]["camposregistro"] as $key => $value) {
				if (!isset($_GET["cabecera"][$key])) {
					$_GET["cabecera"][$key]=$value["valordefault"];
				}
			}

			if ($GLOBALS["configuracion"]["registroautomatico"]===TRUE || ($GLOBALS["configuracion"]["registroautomaticoconsumidorfinal"]===TRUE && $_GET["cabecera"]["tipo-cliente"]==3)) {
				
				if ($GLOBALS["configuracion"]["registroautomatico"]===TRUE) {

					$sql="SELECT MAX(`CodigoCli`) as 'id' FROM `dbo_cliente`";
					$resultado=mysqli_query($mysqli, $sql);
					$registro=mysqli_fetch_assoc($resultado);

					$proximoid=$registro["id"]+1;

					$habilitado='S';
				
				}else{

					$sql="SELECT CONCAT('CF', (CodigoCli + 1)) AS ProximoCodigoCli
					FROM (
					SELECT CONVERT(REPLACE(CodigoCli, 'CF', ''), UNSIGNED INTEGER) AS CodigoCli
					FROM walger_clientes 
					WHERE CodigoCli LIKE 'CF%'
					) AS CodigosCli
					ORDER BY CodigoCli DESC
					LIMIT 1";

					$resultado=mysqli_query($mysqli, $sql);
					$registro=mysqli_fetch_assoc($resultado);

					$proximoid=$registro["ProximoCodigoCli"];

					$habilitado='N';

				}

				$sql="INSERT INTO `dbo_cliente` (
					`CodigoCli`,
					`RazonSocialCli`,
					`CuitCli`,
					`IngBrutosCli`,
					`Regis_IvaC`,
					`Regis_ListaPrec`,
					`emailCli`,
					`RazonSocialFlete`,
					`Direccion`,
					`BarrioCli`,
					`LocalidadCli`,
					`DescrProvincia`,
					`CodigoPostalCli`,
					`DescrPais`,
					`Telefono`,
					`FaxCli`,
					`PaginaWebCli`
				) VALUES (
					'".$proximoid."',
					'".$_GET["cabecera"]["razon-social"]."',
					'".$_GET["cabecera"]["cuit"]."',
					'".$_GET["cabecera"]["ingresos-brutos"]."',
					'".$_GET["cabecera"]["condicion-iva"]."',
					'1',
					'".$_GET["cabecera"]["email"]."',
					'".$_GET["cabecera"]["flete"]."',
					'".$_GET["cabecera"]["direccion-postal"]."',
					'".$_GET["cabecera"]["barrio"]."',
					'".$_GET["cabecera"]["localidad"]."',
					'".$_GET["cabecera"]["provincia"]."',
					'".$_GET["cabecera"]["codigo-postal"]."',
					'".$_GET["cabecera"]["pais"]."',
					'".$_GET["cabecera"]["telefono"]."',
					'".$_GET["cabecera"]["fax"]."',
					'".$_GET["cabecera"]["pagina-web"]."'
				)";

				mysqli_query($mysqli, $sql);

				$sql="INSERT INTO `walger_clientes` (
					`CodigoCli`,
					`TipoCliente`,
					`ApellidoNombre`,
					`Cargo`,
					`Comentarios`,
					`Contrasenia`,
					`IP`,
					`UltimoLogin`,
					`Habilitado`,
					`Regis_Mda`
				) VALUES (
					'".$proximoid."',
					'".$_GET["cabecera"]["tipo-cliente"]."',
					'".$_GET["cabecera"]["apellido-nombre"]."',
					'".$_GET["cabecera"]["cargo"]."',
					'".$_GET["cabecera"]["comentarios"]."',
					'".$_GET["cabecera"]["contrasena"]."',
					'".gethostbyname(gethostname())."',
					'0000-00-00 00:00:00.000000',
					'".$habilitado."',
					'1'
				)";
				mysqli_query($mysqli, $sql);

			}

			$condicionesiva=retornarCondicionesIva();		

			$demail=$GLOBALS["configuracion"]["email"]["emailenvia"];
			$denombre=$GLOBALS["configuracion"]["email"]["nombreenvia"];
			$paramail=$GLOBALS["configuracion"]["email"]["emailadministracion"];
			$paranombre=$GLOBALS["configuracion"]["email"]["nombreadministracion"];
			$responderamail=$_GET["cabecera"]["email"];
			$responderanombre=$_GET["cabecera"]["razon-social"];
			$concopia="";
			$concopiaoculta="";
			$asunto=$GLOBALS["configuracion"]["email"]["asuntos"]["registroadministracion"];
									
      $tiposClientes=retornarTiposClientes();											 	

			$datos="Tipo de Cliente: ".$tiposClientes["exito"][$_GET["cabecera"]["tipo-cliente"]]."<br>";
			$datos.="Razón Social: ".$_GET["cabecera"]["razon-social"]."<br>";
			$datos.="CUIT: ".$_GET["cabecera"]["cuit"]."<br>";
			$datos.="Dirección Postal: ".$_GET["cabecera"]["direccion-postal"]."<br>";
			$datos.="Código Postal: ".$_GET["cabecera"]["codigo-postal"]."<br>";
			$datos.="Teléfono: ".$_GET["cabecera"]["telefono"]."<br>";
			$datos.="Página Web: ".$_GET["cabecera"]["pagina-web"]."<br>";
			$datos.="Contraseña: ".$_GET["cabecera"]["contrasena"]."<br>";
			$datos.="Ingresos Brutos: ".$_GET["cabecera"]["ingresos-brutos"]."<br>";
			$datos.="Condición Iva: ".$condicionesiva["exito"][$_GET["cabecera"]["condicion-iva"]]."<br>";
			$datos.="País: ".$_GET["cabecera"]["pais"]."<br>";
			$datos.="Provincia: ".$_GET["cabecera"]["provincia"]."<br>";
			$datos.="Localidad: ".$_GET["cabecera"]["localidad"]."<br>";
			$datos.="Barrio: ".$_GET["cabecera"]["barrio"]."<br>";
			$datos.="Fax: ".$_GET["cabecera"]["fax"]."<br>";
			$datos.="Email: ".$_GET["cabecera"]["email"]."<br>";
			$datos.="Flete: ".$_GET["cabecera"]["flete"]."<br>";
			$datos.="Nombre y Apellido: ".$_GET["cabecera"]["apellido-nombre"]."<br>";
			$datos.="Comentarios: ".$_GET["cabecera"]["comentarios"]."<br>";
			$datos.="Cargo: ".$_GET["cabecera"]["cargo"]."<br>";
			$mensajehtml= "Hemos recibido una solicitud de registro con los siguientes datos: <br>".$datos."Para contactarse con el usuario puede responder el presente email";
			$mensajeplano=str_replace("<br>", " - ", $mensajehtml);
			$encabezado=$GLOBALS["configuracion"]["email"]["nombreadministracion"];	

			$resultado=enviarMail($demail, $denombre, $paramail, $paranombre, $responderamail, $responderanombre, $concopia, $concopiaoculta, $asunto, $mensajehtml, $mensajeplano, $encabezado );

			if ($resultado["enviado"]==TRUE) {

				$demail=$GLOBALS["configuracion"]["email"]["emailenvia"];
				$denombre=$GLOBALS["configuracion"]["email"]["nombreenvia"];
				$paramail=$_GET["cabecera"]["email"];
				$paranombre=$_GET["cabecera"]["razon-social"];
				$responderamail=$GLOBALS["configuracion"]["email"]["norespondermail"];
				$responderanombre=$GLOBALS["configuracion"]["email"]["norespondernombre"];
				$concopia="";
				$concopiaoculta="";
				$asunto=$GLOBALS["configuracion"]["email"]["asuntos"]["registrocliente"];
				if ($GLOBALS["configuracion"]["registroautomatico"]===TRUE) {
					$mensajehtml= "Bienvenido a nuestra tienda virtual.<br>Ya podés ingresar con los siguientes datos:<br>Usuario: ".$_GET["cabecera"]["email"]."<br>Contraseña: ".$_GET["cabecera"]["contrasena"]."<br>Muchas gracias.";									
				}else{
					$mensajehtml= "Hemos recibido una solicitud de registro y en este momento se encuentra en proceso de revisión. En breve nos contactaremos.<br>Muchas gracias.";
				}				
				$mensajeplano=str_replace("<br>", " - ", $mensajehtml);
				$encabezado=$_GET["cabecera"]["razon-social"];	

				$resultado=enviarMail($demail, $denombre, $paramail, $paranombre, $responderamail, $responderanombre, $concopia, $concopiaoculta, $asunto, $mensajehtml, $mensajeplano, $encabezado );

				if ($resultado["enviado"]==TRUE) {
					$respuesta["error"]=FALSE;			
					$respuesta["exito"]="Registro Solicitado. Revise su correo";
				}else{
					$respuesta["error"]=TRUE;
					cargaError($_GET["accion"],2);
				}
			}else{
				$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],1);
			}				
											
		}						

		break;

	case 'formulario-editar-registro':
		
		/********** FORMULARIO REGISTRO ***********/

		$tiposClientes=retornarTiposClientes();
		$condicionesiva=retornarCondicionesIva();		

		$respuesta=comprobarPassword($_GET["cabecera"]["contrasena"]);

		if ($_GET["cabecera"]["contrasena"]!=$_GET["cabecera"]["repetir-contrasena"]) {
			$respuesta["error"]=TRUE;
			cargaError($_GET["accion"],0);			
		}

		if ($respuesta["error"]==FALSE) {
				$demail=$GLOBALS["configuracion"]["email"]["emailenvia"];
				$denombre=$GLOBALS["configuracion"]["email"]["nombreenvia"];
				$paramail=$GLOBALS["configuracion"]["email"]["emailadministracion"];
				$paranombre=$GLOBALS["configuracion"]["email"]["nombreadministracion"];
				$responderamail=$_GET["cabecera"]["email"];
				$responderanombre=$_GET["cabecera"]["razon-social"];
				$concopia="";
				$concopiaoculta="";
				$asunto=$GLOBALS["configuracion"]["email"]["asuntos"]["ediciondatosadministracion"];
										
	      $tiposClientes=retornarTiposClientes();											 	

				$datos="Tipo de Cliente: ".$tiposClientes["exito"][$_GET["cabecera"]["tipo-cliente"]]."<br>";
				$datos.="Razón Social: ".$_GET["cabecera"]["razon-social"]."<br>";
				$datos.="CUIT: ".$_GET["cabecera"]["cuit"]."<br>";
				$datos.="Dirección Postal: ".$_GET["cabecera"]["direccion-postal"]."<br>";
				$datos.="Código Postall: ".$_GET["cabecera"]["codigo-postal"]."<br>";
				$datos.="Teléfono: ".$_GET["cabecera"]["telefono"]."<br>";
				$datos.="Página Web: ".$_GET["cabecera"]["pagina-web"]."<br>";
				$datos.="Contraseña: ".$_GET["cabecera"]["contrasena"]."<br>";
				$datos.="Ingresos Brutos: ".$_GET["cabecera"]["ingresos-brutos"]."<br>";
				$datos.="Condición Iva: ".$condicionesiva["exito"][$_GET["cabecera"]["condicion-iva"]]."<br>";
				$datos.="País: ".$_GET["cabecera"]["pais"]."<br>";
				$datos.="Provincia: ".$_GET["cabecera"]["provincia"]."<br>";
				$datos.="Localidad: ".$_GET["cabecera"]["localidad"]."<br>";
				$datos.="Barrio: ".$_GET["cabecera"]["barrio"]."<br>";
				$datos.="Fax: ".$_GET["cabecera"]["fax"]."<br>";
				$datos.="Email: ".$_GET["cabecera"]["email"]."<br>";
				$datos.="Flete: ".$_GET["cabecera"]["flete"]."<br>";
				$datos.="Nombre y Apellido: ".$_GET["cabecera"]["apellido-nombre"]."<br>";
				$datos.="Comentarios: ".$_GET["cabecera"]["comentarios"]."<br>";
				$datos.="Cargo: ".$_GET["cabecera"]["cargo"]."<br>";
				$mensajehtml= "Hemos recibido una solicitud de edición de registro con los siguientes datos: <br>".$datos."Para contactarse con el usuario puede responder el presente email";
				$mensajeplano=str_replace("<br>", " - ", $mensajehtml);
				$encabezado=$GLOBALS["configuracion"]["email"]["nombreadministracion"];	

				$resultado=enviarMail($demail, $denombre, $paramail, $paranombre, $responderamail, $responderanombre, $concopia, $concopiaoculta, $asunto, $mensajehtml, $mensajeplano, $encabezado );

				if ($resultado["enviado"]==TRUE) {

					$demail=$GLOBALS["configuracion"]["email"]["emailenvia"];
					$denombre=$GLOBALS["configuracion"]["email"]["nombreenvia"];
					$paramail=$_GET["cabecera"]["email"];
					$paranombre=$_GET["cabecera"]["razon-social"];
					$responderamail=$GLOBALS["configuracion"]["email"]["norespondermail"];
					$responderanombre=$GLOBALS["configuracion"]["email"]["norespondernombre"];
					$concopia="";
					$concopiaoculta="";
					$asunto=$GLOBALS["configuracion"]["email"]["asuntos"]["ediciondatoscliente"];
					$mensajehtml= "Hemos recibido una solicitud de edición de registro y en este momento se encuentra en proceso de revisión. En breve nos contactaremos.<br>Muchas gracias.";
					$mensajeplano=str_replace("<br>", " - ", $mensajehtml);
					$encabezado=$_GET["cabecera"]["razon-social"];	

					$resultado=enviarMail($demail, $denombre, $paramail, $paranombre, $responderamail, $responderanombre, $concopia, $concopiaoculta, $asunto, $mensajehtml, $mensajeplano, $encabezado );

					if ($resultado["enviado"]==TRUE) {
						$respuesta["error"]=FALSE;			
						$respuesta["exito"]="Edición Solicitada. Revise su correo";
					}else{
						$respuesta["error"]=TRUE;
						cargaError($_GET["accion"],2);
					}
				}else{
					$respuesta["error"]=TRUE;
					cargaError($_GET["accion"],1);
				}				
											
		}						

		break;		


	case 'seguridad-password':
		
		/********** SEGURIDAD PASSWORD ***********/

	$pwd = $_GET['password'];

	$respuesta=comprobarPassword($pwd);						

	break;

	case 'configuracion':
		
		/********** CONFIGURACION ***********/

	$respuesta=$GLOBALS["configuracion"];						

	break;	

	case 'suscribirse-newsletter':
	
		/********** SUSCRIBIRSE NEWSLETTER ***********/
	
		$email = $_GET["email"];
		
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$respuesta["error"]=TRUE;
			cargaError($_GET["accion"],0); 
		}else{
			$respuesta["error"]=FALSE;
		}

		if ($respuesta["error"]==FALSE) {
				$sql="INSERT INTO `trama_newsletter`(
					`email`
				)VALUES(
					'".$_GET["email"]."'
				)";
				$resultado=mysqli_query($mysqli, $sql);
			if (mysqli_errno($mysqli)==1062) {
				$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],1);				
			}else{
				if(!$resultado){
					$respuesta["error"]=TRUE;
					cargaError($_GET["accion"],2);
				}else{

				$demail=$GLOBALS["configuracion"]["email"]["emailenvia"];
				$denombre=$GLOBALS["configuracion"]["email"]["nombreenvia"];
				$paramail=$GLOBALS["configuracion"]["email"]["emailadministracion"];
				$paranombre=$GLOBALS["configuracion"]["email"]["nombreadministracion"];
				$responderamail=$_GET["email"];
				$responderanombre=$_GET["email"];
				$concopia="";
				$concopiaoculta="";
				$asunto=$GLOBALS["configuracion"]["email"]["asuntos"]["newsletteradministracion"];
				$mensajehtml= "Hemos recibido una solicitud de Newsletter de: <br>".$_GET["email"].". Para contactarse con el usuario puede responder el presente email";
				$mensajeplano=str_replace("<br>", " - ", $mensajehtml);
				$encabezado=$GLOBALS["configuracion"]["email"]["nombreadministracion"];	

				$resultado=enviarMail($demail, $denombre, $paramail, $paranombre, $responderamail, $responderanombre, $concopia, $concopiaoculta, $asunto, $mensajehtml, $mensajeplano, $encabezado );

				if ($resultado["enviado"]==TRUE) {

					$demail=$GLOBALS["configuracion"]["email"]["emailenvia"];
					$denombre=$GLOBALS["configuracion"]["email"]["nombreenvia"];
					$paramail=$_GET["email"];
					$paranombre=$_GET["email"];
					$responderamail=$GLOBALS["configuracion"]["email"]["norespondermail"];
					$responderanombre=$GLOBALS["configuracion"]["email"]["norespondernombre"];
					$concopia="";
					$concopiaoculta="";
					$asunto=$GLOBALS["configuracion"]["email"]["asuntos"]["newslettercliente"];
					$mensajehtml= "A partir de este momento, se encuentra registrado a nuestro Newsletter. Muchas gracias.";
					$mensajeplano=str_replace("<br>", " - ", $mensajehtml);
					$encabezado="Bienvenido";	

					$resultado=enviarMail($demail, $denombre, $paramail, $paranombre, $responderamail, $responderanombre, $concopia, $concopiaoculta, $asunto, $mensajehtml, $mensajeplano, $encabezado );

					if ($resultado["enviado"]==TRUE) {
						$respuesta["error"]=FALSE;			
						$respuesta["exito"]="Se ha suscripto a nuestro Newsletter con éxito";
					}else{
						$respuesta["error"]=TRUE;
						cargaError($_GET["accion"],3);						
					}

				}				
			}
		}
	}		


	break;

	case 'productos':
		
		/********** PRODUCTOS ***********/

		$filtros=array();
		foreach ($GLOBALS["configuracion"]["productos"]["filtros"] as $key => $value) {
			if ($_GET["filtros"][$value["id"]]!="") {

				switch ($value["filtro"]) {
					
					case "like":
						$filtro=$value["campo"]." like '%".$_GET["filtros"][$value["id"]]."%'"; 					
					break;
					
					case "match":
						if (isset($_GET["filtros"][$value["id"]])) {
							$filtro=" MATCH ". $value["campo"]. " AGAINST ('".$_GET["filtros"][$value["id"]]."')";
						}
					break;

					case "buscador":

					$arraymezclado=array();

					$arr = explode(" ", $_GET["filtros"][$value["id"]]);

					mezclararray($arr);

					$filtro= $value["campo"]." LIKE '".implode("' OR ".$value["campo"]." LIKE '", $arraymezclado)."'";

					break;											
					
					default:
						$filtro=$value["campo"]." ".$value["filtro"]." '".$_GET["filtros"][$value["id"]]."'"; 
					break;
				}

				array_push($filtros, $filtro);				
			}
		}

		if ($GLOBALS["configuracion"]["productos"]["muestrasinexistencia"]==FALSE) {
			$filtro=$GLOBALS["configuracion"]["productos"]["campostock"]." > 0 ";
			array_push($filtros, $filtro);				
		}

		if (isset($_GET["favoritos"]) && $_GET["favoritos"]=="true") {
			if (isset($_SESSION["idUsuario"])) {
				$filtro="idUsuario='".$_SESSION["idUsuario"]."'";
				array_push($filtros, $filtro);							
			}else{
				if (compruebaUsuarioInvitado()) {
					$filtro="idUsuario='".usuarioInvitado()."'";
					array_push($filtros, $filtro);							
				}
			}
		}

		$filtros=implode(" AND ", $filtros);

		if (isset($_SESSION["idUsuario"])) {
			$favoritos="AND idUsuario='".$_SESSION["idUsuario"]."'";
		}else{
			if (compruebaUsuarioInvitado()) {
				$favoritos="AND idUsuario='".usuarioInvitado()."'";
			}else{
				$favoritos="AND idUsuario IS NULL";			
			}
		}


		if ($filtros != "") {
			$where=	"WHERE ".$filtros;
		}else{
			$where="";
		}

		$sql="SELECT
		dbo_articulo.*,
		trama_favoritos.*,
		`trama_articulos-imagenes-adicionales`.imagenes as 'imagenesadicionales',
		t1.`precio` as 'minimo',
    t2.`precio` as 'maximo'
    FROM dbo_articulo
    LEFT JOIN `trama_articulos-imagenes-adicionales`
    ON dbo_articulo.`CodInternoArti` = `trama_articulos-imagenes-adicionales`.idArticulo
		LEFT JOIN trama_favoritos
		ON dbo_articulo.`CodInternoArti` = trama_favoritos.`idArticulo`".$favoritos." 
		LEFT JOIN `trama_articulos-valores-stock-precio` as t1 on (
		    dbo_articulo.CodInternoArti = t1.`idArticulo` 
		    and t1.`precio`  = (
		        select min(precio)
		        from `trama_articulos-valores-stock-precio`
		        where idArticulo=dbo_articulo.CodInternoArti
		    ) 
		)
		LEFT JOIN `trama_articulos-valores-stock-precio` as t2 on (
		    dbo_articulo.CodInternoArti = t2.`idArticulo` 
		    and t2.`precio`  = (
		        select max(precio)
		        from `trama_articulos-valores-stock-precio`
		        where idArticulo=dbo_articulo.CodInternoArti
		    ) 
		)
		" .$where. "
		GROUP BY CodInternoArti		
		ORDER BY ".$GLOBALS["configuracion"]["productos"]["formasordenamiento"][$_GET["ordenamiento"]]["campo"]." ".$GLOBALS["configuracion"]["productos"]["formasordenamiento"][$_GET["ordenamiento"]]["tipo"].",
		DescripcionArti
		 LIMIT ".$GLOBALS["configuracion"]["productos"]["resultadosDevueltos"]."
		 OFFSET ".$_GET["offset"];

		$sql=utf8_decode($sql);

		$resultado = mysqli_query($mysqli, $sql);

		if ($resultado->num_rows>0) {
			$respuesta["exito"]=array();
			$respuesta["error"]=FALSE;

			if ($resultado->num_rows<$GLOBALS["configuracion"]["productos"]["resultadosDevueltos"]) {
				$respuesta["limit"]=TRUE;
			}else{
				$respuesta["limit"]=FALSE;
			}

			$tiposarticulos=array();

			for ($i=0; $i < $resultado->num_rows; $i++) { 
				$registro=mysqli_fetch_assoc($resultado);

				array_push($tiposarticulos, $registro["idTipoArticulo"]);

				$registro=map($registro);
				if ($registro["NombreFotoArti"]=="" || $registro["NombreFotoArti"]=="NULL") {
					$registro["NombreFotoArti"]=$GLOBALS["configuracion"]["productos"]["imagennodisponible"];		
				}

				$registro["NombreFotoArti"]=explode(",", $registro["NombreFotoArti"]);
				if ($registro["imagenesadicionales"]!=NULL) {
	
					$registro["imagenesadicionales"]=explode(",", $registro["imagenesadicionales"]);
	
					if (is_array($registro["imagenesadicionales"] )) {
						if (count($registro["imagenesadicionales"])>0) {
							foreach ($registro["imagenesadicionales"] as $key => $value) {
								array_push($registro["NombreFotoArti"], $value);
							}
						}
					}
					
				}


				$registro["atributos"]=array();

				$registro["PrecioVta1_PreArti"]=precioCliente($registro["PrecioVta1_PreArti"],$registro["TasaIva"]);			
				$registro["PrecioVta1_PreArti"]=formatearPrecio($registro["PrecioVta1_PreArti"]);

				if ($registro["minimo"]==$registro["maximo"]) {
					$registro["palabraminimo"]="";
				}else{
					$registro["palabraminimo"]="Desde ";
				}
				
				$registro["minimo"]=precioCliente($registro["minimo"],$registro["TasaIva"]);			
				$registro["minimo"]=formatearPrecio($registro["minimo"]);

				$registro["orden"]=$_GET["offset"]+$i;

        $registro["botonesfacebook"]=$GLOBALS["configuracion"]["redessociales"]["botonesfacebook"];
				$registro["link"]=$GLOBALS["configuracion"]["host"]."/producto.php?codigo=".$registro["CodInternoArti"];

				array_push($respuesta["exito"], $registro);

			}

			$tiposarticulosquery=implode("','", $tiposarticulos);

			$sql="SELECT
			`trama_tipos-articulos`.id as 'idtipoarticulo',
			`trama_atributos`.`denominacion` as 'nombreatributo',
      `trama_atributos`.`id` as 'idatributo',
			`trama_tipos-articulos`.atributo1,
      `trama_tipos-articulos`.atributo2,
      `trama_tipos-articulos`.atributo3,
      `trama_tipos-articulos`.atributo4,
      `trama_tipos-articulos`.atributo5,
      `trama_tipos-articulos`.atributo6,
      `trama_tipos-articulos`.atributo7,
      `trama_tipos-articulos`.atributo8,
      `trama_tipos-articulos`.atributo9,
			`trama_atributos-valores`.`id`,
			`trama_atributos-valores`.`valor`,
			`trama_atributos-valores`.`imagen`
			FROM `trama_atributos-valores`
		  INNER JOIN trama_atributos ON `trama_atributos-valores`.idAtributo =
		    trama_atributos.id
		  LEFT JOIN `trama_tipos-articulos` ON
		  		trama_atributos.id = `trama_tipos-articulos`.atributo1
		  	OR trama_atributos.id = `trama_tipos-articulos`.atributo2 
		    OR trama_atributos.id = `trama_tipos-articulos`.atributo3 
		    OR trama_atributos.id = `trama_tipos-articulos`.atributo4 
		    OR trama_atributos.id = `trama_tipos-articulos`.atributo5 
		    OR trama_atributos.id = `trama_tipos-articulos`.atributo6 
		    OR trama_atributos.id = `trama_tipos-articulos`.atributo7 
		    OR trama_atributos.id = `trama_tipos-articulos`.atributo8 
		    OR trama_atributos.id = `trama_tipos-articulos`.atributo9
			WHERE `trama_tipos-articulos`.id IN ('".$tiposarticulosquery."')
			ORDER BY idtipoarticulo, nombreatributo, id";

			$resultado = mysqli_query($mysqli, $sql);

			if ($resultado->num_rows>0) {

				$tipos=array();

				for ($i=0; $i < $resultado->num_rows; $i++) {

					$registro=mysqli_fetch_assoc($resultado);
					$registro=map($registro);

					$cantidadAtributos=9;

					for ($i2=1; $i2 < $cantidadAtributos+1; $i2++) { 
						if ($registro["idatributo"]==$registro["atributo".$i2]) {
							$registro["orden"]=$i2;
						}
					}


					if (!array_key_exists($registro["idtipoarticulo"], $tipos)) {
						$tipos[$registro["idtipoarticulo"]]=array(); 	
					}

					if (!array_key_exists($registro["nombreatributo"], $tipos[$registro["idtipoarticulo"]])) {
						$tipos[$registro["idtipoarticulo"]][$registro["nombreatributo"]]=array(); 	
					}					

					array_push($tipos[$registro["idtipoarticulo"]][$registro["nombreatributo"]], $registro);

				}

			}

			for ($i=0; $i < count($tiposarticulos); $i++) { 
				if ($tiposarticulos[$i]!='') {
					$respuesta["exito"][$i]["atributos"]=$tipos[$respuesta["exito"][$i]["idTipoArticulo"]];
				}
			}

			$respuesta["adicionales"]["carpetaupload"]=$GLOBALS["configuracion"]["carpetauploadremoto"];
			$respuesta["adicionales"]["detallemodal"]=$GLOBALS["configuracion"]["productos"]["detallemodal"];
			$respuesta["adicionales"]["textosinexistencia"]=$GLOBALS["configuracion"]["productos"]["textosinexistencia"];
			$respuesta["adicionales"]["mostrardefault"]=$GLOBALS["configuracion"]["productos"]["mostrardefault"];
			$respuesta["adicionales"]["detalleproducto"]=$GLOBALS["configuracion"]["productos"]["detalleproducto"];
			$respuesta["adicionales"]["comprarsinexistencia"]=$GLOBALS["configuracion"]["productos"]["comprarsinexistencia"];
			$respuesta["adicionales"]["avisoexistencia"]=$GLOBALS["configuracion"]["productos"]["avisoexistencia"];
			$respuesta["adicionales"]["textoexistencia"]=$GLOBALS["configuracion"]["productos"]["textoexistencia"];			
			$respuesta["adicionales"]["avisopocaexistencia"]=$GLOBALS["configuracion"]["productos"]["avisopocaexistencia"];
			$respuesta["adicionales"]["textopocaexistencia"]=$GLOBALS["configuracion"]["productos"]["textopocaexistencia"];
			$respuesta["adicionales"]["cantidadpocaexistencia"]=$GLOBALS["configuracion"]["productos"]["cantidadpocaexistencia"];


		}else{
			if ($_GET["offset"]==0) {
				$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],0);				
			}else{
				$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],1);
			}
		}
					

	break;

	case 'precio-por-atributo':

	$filtro="WHERE idArticulo='".$_GET["codigo"]."'";

	$cantidadAtributos=9;

	for ($i=1; $i < $cantidadAtributos+1; $i++) { 
		if (isset($_GET["atributos"][$i])) {
			$filtro.=" AND valor".$i."=".$_GET["atributos"][$i];	
		}else{
			$filtro.=" AND (valor".$i." IS NULL OR valor".$i." = 0)";								
		}
	}

	foreach ($_GET["atributos"] as $key => $value) {
		$filtro.=" AND valor".$key."=".$value;	
	}

	$sql="SELECT
	`trama_articulos-valores-stock-precio`.precio,
	`trama_articulos-valores-stock-precio`.stock,
	`trama_articulos-valores-stock-precio`.id,	
	dbo_articulo.TasaIva
	FROM `trama_articulos-valores-stock-precio`
	INNER JOIN dbo_articulo
	ON `trama_articulos-valores-stock-precio`.idArticulo=dbo_articulo.CodInternoArti
	".$filtro;

	$resultado = mysqli_query($mysqli, $sql);

	if ($resultado->num_rows==1) {
		$registro=mysqli_fetch_assoc($resultado);
		$registro=map($registro);

		$registro["precio"]=precioCliente($registro["precio"],$registro["TasaIva"]);			
		$registro["precio"]=formatearPrecio($registro["precio"]);

		$respuesta["exito"]=array();
		$respuesta["error"]=FALSE;
		$respuesta["adicionales"]["textosinexistencia"]=$GLOBALS["configuracion"]["productos"]["textosinexistencia"];

		array_push($respuesta["exito"], $registro);
	}else{
		$respuesta["error"]=TRUE;
	}

	break;

	case 'agregar-favoritos':
		
		/********** AGREGAR FAVORITOS ***********/

		$respuesta["error"]=FALSE;
		
		if (!isset($_SESSION["idUsuario"])) {
			if ($GLOBALS["configuracion"]["permiteinvitado"]===TRUE) {
				$idUsuario=usuarioInvitado();
			}else{
				$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],0);															
			}
		}else{
			$idUsuario=$_SESSION["idUsuario"];
		}

		if ($respuesta["error"]==FALSE) {
			$sql="INSERT INTO `trama_favoritos`(
				`idUsuario`,
				`idArticulo`
			)VALUES(
				'".$idUsuario."',
				'".$_GET["codigo"]."'
			)";

			$resultado=mysqli_query($mysqli, $sql);

			if (mysqli_errno($mysqli)==1062) {
				$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],1);				
			}else{
				if(!$resultado){
					$respuesta["error"]=TRUE;
					cargaError($_GET["accion"],2);
				}else{
					$sql="SELECT *
					FROM dbo_articulo
					WHERE CodInternoArti='".$_GET["codigo"]."'";

					$resultado = mysqli_query($mysqli, $sql);

					if ($resultado->num_rows>0) {
						$respuesta["exito"]=array();
						$respuesta["error"]=FALSE;

						for ($i=0; $i < $resultado->num_rows; $i++) { 
							$registro=mysqli_fetch_assoc($resultado);
							$registro=map($registro);
							array_push($respuesta["exito"], $registro);
						}

					}else{
						$respuesta["error"]=TRUE;
						cargaError($_GET["accion"],3);					
					}																									
				}			
			}
		}							

	break;

	case 'borrar-favoritos':
		
		/********** BORRAR FAVORITOS ***********/

		$respuesta["error"]=FALSE;
		
		if (!isset($_SESSION["idUsuario"])) {
			if ($GLOBALS["configuracion"]["permiteinvitado"]==TRUE) {
				$idUsuario=usuarioInvitado();
			}else{
				$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],0);															
			}
		}else{
			$idUsuario=$_SESSION["idUsuario"];
		}

		if ($respuesta["error"]==FALSE) {
			$sql="DELETE FROM `trama_favoritos`
			WHERE `idUsuario`='".$idUsuario."'
			AND `idArticulo`='".$_GET["codigo"]."'";

			$resultado=mysqli_query($mysqli, $sql);

			if(!$resultado){
				$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],1);
			}else{
				$respuesta["exito"]=array();
				$respuesta["error"]=FALSE;																				
			}			
		}							

	break;

	case 'favoritos-lateral':
		
		/********** FAVORITOS LATERAL***********/

		$respuesta["error"]=FALSE;
		
		if (!isset($_SESSION["idUsuario"])) {
			if ($GLOBALS["configuracion"]["permiteinvitado"]===TRUE) {
				$idUsuario=usuarioInvitado();
			}else{
				$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],0);															
			}
		}else{
			$idUsuario=$_SESSION["idUsuario"];
		}

		if ($respuesta["error"]==FALSE) {
			$sql="SELECT
			trama_favoritos.*,
			dbo_articulo.*
			FROM trama_favoritos
			INNER JOIN dbo_articulo
			ON trama_favoritos.idArticulo=dbo_articulo.CodInternoArti
			WHERE trama_favoritos.idUsuario='".$idUsuario."'
			ORDER BY trama_favoritos.id DESC
			LIMIT 3";

			$resultado=mysqli_query($mysqli, $sql);

			if ($resultado->num_rows>0) {
				$respuesta["exito"]=array();
				$respuesta["error"]=FALSE;

				for ($i=0; $i < $resultado->num_rows; $i++) { 
					$registro=mysqli_fetch_assoc($resultado);
					if ($registro["NombreFotoArti"]=="" || $registro["NombreFotoArti"]==NULL) {
						$registro["NombreFotoArti"]=$GLOBALS["configuracion"]["productos"]["imagennodisponible"];		
					}else{
						$registro["NombreFotoArti"]=retornarPrimeraImagen($registro["NombreFotoArti"]);
					}	
								
					$registro=map($registro);
					$registro["PrecioVta1_PreArti"]=precioCliente($registro["PrecioVta1_PreArti"],$registro["TasaIva"]);			
					$registro["PrecioVta1_PreArti"]=formatearPrecio($registro["PrecioVta1_PreArti"]);

					array_push($respuesta["exito"], $registro);
				}
				$respuesta["adicionales"]["carpetaupload"]=$GLOBALS["configuracion"]["carpetauploadremoto"];
			}else{
				$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],1);				
			}					
		}							

	break;

	case 'cesta-lateral':
		
		/********** CESTA LATERAL***********/

		$respuesta["error"]=FALSE;
		
		if (!isset($_SESSION["idUsuario"])) {
			if ($GLOBALS["configuracion"]["permiteinvitado"]===TRUE) {
				$idUsuario=usuarioInvitado();
			}else{
				$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],0);															
			}
		}else{
			$idUsuario=$_SESSION["idUsuario"];
		}
		
		if ($respuesta["error"]==FALSE) {
			$sql="SELECT walger_items_pedidos.*,
			dbo_articulo.*,
			`trama_atributos-valores`.valor AS valor1,
			`trama_atributos-valores1`.valor AS valor2,
			`trama_atributos-valores2`.valor AS valor3,
			`trama_atributos-valores3`.valor AS valor4,
			`trama_atributos-valores4`.valor AS valor5,
			`trama_atributos-valores5`.valor AS valor6,
			`trama_atributos-valores6`.valor AS valor7,
			`trama_atributos-valores7`.valor AS valor8,
			`trama_atributos-valores8`.valor AS valor9,
			`trama_articulos-valores-stock-precio`.precio AS precioatributo
			FROM walger_items_pedidos
			INNER JOIN dbo_articulo ON walger_items_pedidos.CodInternoArti =
			dbo_articulo.CodInternoArti
			INNER JOIN walger_pedidos ON walger_items_pedidos.idPedido =
			walger_pedidos.idPedido
			LEFT JOIN `trama_articulos-valores-stock-precio`
			ON walger_items_pedidos.idArticulosValores =
			`trama_articulos-valores-stock-precio`.id
			LEFT JOIN `trama_atributos-valores`
			ON `trama_articulos-valores-stock-precio`.valor1 =
			`trama_atributos-valores`.id
			LEFT JOIN `trama_atributos-valores` `trama_atributos-valores1`
			ON `trama_articulos-valores-stock-precio`.valor2 =
			`trama_atributos-valores1`.id
			LEFT JOIN `trama_atributos-valores` `trama_atributos-valores2`
			ON `trama_articulos-valores-stock-precio`.valor3 =
			`trama_atributos-valores2`.id
			LEFT JOIN `trama_atributos-valores` `trama_atributos-valores3`
			ON `trama_articulos-valores-stock-precio`.valor4 =
			`trama_atributos-valores3`.id
			LEFT JOIN `trama_atributos-valores` `trama_atributos-valores4`
			ON `trama_articulos-valores-stock-precio`.valor5 =
			`trama_atributos-valores4`.id
			LEFT JOIN `trama_atributos-valores` `trama_atributos-valores5`
			ON `trama_articulos-valores-stock-precio`.valor6 =
			`trama_atributos-valores5`.id
			LEFT JOIN `trama_atributos-valores` `trama_atributos-valores6`
			ON `trama_articulos-valores-stock-precio`.valor7 =
			`trama_atributos-valores6`.id
			LEFT JOIN `trama_atributos-valores` `trama_atributos-valores7`
			ON `trama_articulos-valores-stock-precio`.valor8 =
			`trama_atributos-valores7`.id
			LEFT JOIN `trama_atributos-valores` `trama_atributos-valores8`
			ON `trama_articulos-valores-stock-precio`.valor9 =
			`trama_atributos-valores8`.id
			WHERE walger_items_pedidos.estado = 'P' AND walger_pedidos.CodigoCli = '".$idUsuario."'
			AND walger_pedidos.estado = 'N'
			ORDER BY walger_items_pedidos.idItemPedido DESC
			LIMIT 3 ";

			$resultado=mysqli_query($mysqli, $sql);

			if ($resultado->num_rows>0) {
				$respuesta["exito"]=array();
				$respuesta["error"]=FALSE;

				for ($i=0; $i < $resultado->num_rows; $i++) { 
					$registro=mysqli_fetch_assoc($resultado);
					if ($registro["NombreFotoArti"]=="" || $registro["NombreFotoArti"]==NULL) {
						$registro["NombreFotoArti"]=$GLOBALS["configuracion"]["productos"]["imagennodisponible"];		
					}else{
						$registro["NombreFotoArti"]=retornarPrimeraImagen($registro["NombreFotoArti"]);
					}	

					$registro=map($registro);

					if ($registro["precioatributo"]==NULL) {
						$precio=$registro["PrecioVta1_PreArti"];
					}else{
						$precio=$registro["precioatributo"];
					}

					$registro["precio"]=formatearPrecio(precioCliente($precio,$registro["TasaIva"]));
					if ($registro["idArticulosValores"]==NULL) {
						$registro["idArticulosValores"]="";
					}
					array_push($respuesta["exito"], $registro);
				}
				$respuesta["adicionales"]["carpetaupload"]=$GLOBALS["configuracion"]["carpetauploadremoto"];
			}else{
				$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],1);				
			}					
		}							

	break;			

	case 'agregar-cesta':
		
		/********** AGREGAR CESTA ***********/
		$respuesta["error"]=FALSE;
		
		if (!isset($_SESSION["idUsuario"])) {
			if ($GLOBALS["configuracion"]["permiteinvitado"]===TRUE) {
				$idUsuario=usuarioInvitado();
			}else{
				$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],0);															
			}
		}else{
			$idUsuario=$_SESSION["idUsuario"];
		}
		

		if ($respuesta["error"]==FALSE) {

			$sql="SELECT *
			FROM dbo_articulo
      LEFT JOIN `trama_articulos-valores-stock-precio`
      ON dbo_articulo.CodInternoArti = `trama_articulos-valores-stock-precio`.`idArticulo`
      AND `trama_articulos-valores-stock-precio`.`id` = '".$_GET["codigoProductoAtributo"]."'
      WHERE CodInternoArti='".$_GET["codigo"]."'";

			$resultado=mysqli_query($mysqli, $sql);

			$articulo=mysqli_fetch_assoc($resultado);

			if ($articulo["precio"]==NULL) {
				$precio=$articulo["PrecioVta1_PreArti"];
			}else{
				$precio=$articulo["precio"];
			}

			$sql="SELECT idPedido
			FROM walger_pedidos
      WHERE estado = 'N'
			AND CodigoCli = '".$idUsuario."'";


			$resultado=mysqli_query($mysqli, $sql);

	    if ($resultado->num_rows > 0){
				$registro=mysqli_fetch_assoc($resultado);
				$idPedido=$registro["idPedido"];

	    }else{
	    	$sql="INSERT INTO walger_pedidos
	    	(
	    		CodigoCli,
	    		estado,
	    		fechaEstado
    		) VALUES (
    			'".$idUsuario."',
    			'N',
    			NOW()
  			)";


				$resultado=mysqli_query($mysqli, $sql);

				if(!$resultado){
					$respuesta["error"]=TRUE;
					cargaError($_GET["accion"],1);
				}else{
					$idPedido=mysqli_insert_id($mysqli);
				}
			}			

			if ($respuesta["error"]==FALSE) {

				$sql="SELECT `walger_items_pedidos`.idItemPedido,
				`walger_items_pedidos`.cantidad
				FROM walger_items_pedidos
				INNER JOIN `walger_pedidos`
				ON `walger_items_pedidos`.idPedido = walger_pedidos.idPedido
				WHERE `walger_items_pedidos`.`CodInternoArti` = '".$_GET["codigo"]."'
				AND `walger_items_pedidos`.`idArticulosValores` = '".$_GET["codigoProductoAtributo"]."'
				AND `walger_pedidos`.`CodigoCli` = '".$idUsuario."'
				AND `walger_items_pedidos`.estado = 'P'
				AND walger_pedidos.estado = 'N'";


				$resultado=mysqli_query($mysqli, $sql);

				if ($resultado->num_rows > 0) {
					$registro=mysqli_fetch_assoc($resultado);
					$nuevacantidad=$registro["cantidad"]+$_GET["cantidad"];
					$sql="UPDATE `walger_items_pedidos`
					SET `cantidad` = '".$nuevacantidad."'
					WHERE `walger_items_pedidos`.`idItemPedido` = '".$registro["idItemPedido"]."'";

				}else{
			    $sql="INSERT INTO walger_items_pedidos
			    (
			    	idPedido,
			    	CodInternoArti,
			    	idArticulosValores,
			    	precio,
			    	cantidad,
			    	estado
		    	)VALUES (
		    		'".$idPedido."',
		    		'".$_GET["codigo"]."',
		    		'".$_GET["codigoProductoAtributo"]."',
						'".$precio."',
						'".$_GET["cantidad"]."',
						'P'
					)";
				}

				$respuesta["adicionales"]["accionalcomprar"]="";

				if (isset($GLOBALS["configuracion"]["productos"]["accionalcomprar"])) {
					if ($GLOBALS["configuracion"]["productos"]["accionalcomprar"]!="") {
						$respuesta["adicionales"]["accionalcomprar"]=$GLOBALS["configuracion"]["productos"]["accionalcomprar"];
					}
				}		

				$resultado=mysqli_query($mysqli, $sql);

				if(!$resultado){
					$respuesta["error"]=TRUE;
					cargaError($_GET["accion"],1);
				}else{
					$respuesta["error"]=FALSE;
					$respuesta["exito"]="agregado";					
				}	
			}
		}					




	break;

	case 'actualizar-cesta':
		
		/********** ACTUALIZAR CESTA ***********/
		$respuesta["error"]=FALSE;
		
		if (!isset($_SESSION["idUsuario"])) {
			if ($GLOBALS["configuracion"]["permiteinvitado"]===TRUE) {
				$idUsuario=usuarioInvitado();
			}else{
				$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],0);															
			}
		}else{
			$idUsuario=$_SESSION["idUsuario"];
		}


		if ($respuesta["error"]==FALSE) {

				$sql="SELECT `walger_items_pedidos`.idItemPedido,
				`walger_items_pedidos`.cantidad
				FROM walger_items_pedidos
				INNER JOIN `walger_pedidos`
				ON `walger_items_pedidos`.idPedido = walger_pedidos.idPedido
				WHERE `walger_items_pedidos`.`CodInternoArti` = '".$_GET["codigo"]."'
				AND `walger_items_pedidos`.`idArticulosValores` = '".$_GET["codigoProductoAtributo"]."'				
				AND `walger_pedidos`.`CodigoCli` = '".$idUsuario."'
				AND `walger_items_pedidos`.estado = 'P'
				AND walger_pedidos.estado = 'N'";

				$resultado=mysqli_query($mysqli, $sql);

				if ($resultado->num_rows > 0) {
					$registro=mysqli_fetch_assoc($resultado);
					$sql="UPDATE `walger_items_pedidos`
					SET `cantidad` = '".$_GET["cantidad"]."'
					WHERE `walger_items_pedidos`.`idItemPedido` = '".$registro["idItemPedido"]."'";
				
					$resultado=mysqli_query($mysqli, $sql);
				}

			if(!$resultado){
				$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],1);
			}else{
				$respuesta["error"]=FALSE;
				$respuesta["exito"]="actualizado";						
			}	
		}

	break;	

	case 'borrar-cesta':
		
		/********** BORRAR CESTA ***********/
		$respuesta["error"]=FALSE;
		
		if (!isset($_SESSION["idUsuario"])) {
			if ($GLOBALS["configuracion"]["permiteinvitado"]===TRUE) {
				$idUsuario=usuarioInvitado();
			}else{
				$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],0);															
			}
		}else{
			$idUsuario=$_SESSION["idUsuario"];
		}

		if ($respuesta["error"]==FALSE) {

			$sql="DELETE `walger_items_pedidos`.*
			FROM `walger_items_pedidos`
			INNER JOIN `walger_pedidos`
			ON `walger_items_pedidos`.idPedido = walger_pedidos.idPedido
			WHERE `walger_items_pedidos`.`CodInternoArti` = '".$_GET["codigo"]."'
			AND `walger_items_pedidos`.`idArticulosValores` = '".$_GET["codigoProductoAtributo"]."'
			AND `walger_pedidos`.`CodigoCli` = '".$idUsuario."'
			AND `walger_items_pedidos`.estado = 'P'
			AND walger_pedidos.estado = 'N'";

			$resultado=mysqli_query($mysqli, $sql);

			if(!$resultado){
				$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],1);
			}else{
				$respuesta["error"]=FALSE;
				$respuesta["exito"]="Eliminado";						
			}	
		}
							
	break;

	case 'carrito':
		
		/********** CARRITO ***********/
		$respuesta["error"]=FALSE;
		
		if (!isset($_SESSION["idUsuario"])) {
			if ($GLOBALS["configuracion"]["permiteinvitado"]===TRUE) {
				$idUsuario=usuarioInvitado();
			}else{
				$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],0);															
			}
		}else{
			$idUsuario=$_SESSION["idUsuario"];
		}

		if ($respuesta["error"]==FALSE) {

			$sql="SELECT walger_items_pedidos.*,
			dbo_articulo.*,
			`trama_atributos-valores`.valor AS valor1,
			`trama_atributos-valores1`.valor AS valor2,
			`trama_atributos-valores2`.valor AS valor3,
			`trama_atributos-valores3`.valor AS valor4,
			`trama_atributos-valores4`.valor AS valor5,
			`trama_atributos-valores5`.valor AS valor6,
			`trama_atributos-valores6`.valor AS valor7,
			`trama_atributos-valores7`.valor AS valor8,
			`trama_atributos-valores8`.valor AS valor9,
			`trama_articulos-valores-stock-precio`.precio AS precioatributo
			FROM walger_items_pedidos
			INNER JOIN dbo_articulo ON walger_items_pedidos.CodInternoArti =
			dbo_articulo.CodInternoArti
			INNER JOIN walger_pedidos ON walger_items_pedidos.idPedido =
			walger_pedidos.idPedido
			LEFT JOIN `trama_articulos-valores-stock-precio`
			ON walger_items_pedidos.idArticulosValores =
			`trama_articulos-valores-stock-precio`.id
			LEFT JOIN `trama_atributos-valores`
			ON `trama_articulos-valores-stock-precio`.valor1 =
			`trama_atributos-valores`.id
			LEFT JOIN `trama_atributos-valores` `trama_atributos-valores1`
			ON `trama_articulos-valores-stock-precio`.valor2 =
			`trama_atributos-valores1`.id
			LEFT JOIN `trama_atributos-valores` `trama_atributos-valores2`
			ON `trama_articulos-valores-stock-precio`.valor3 =
			`trama_atributos-valores2`.id
			LEFT JOIN `trama_atributos-valores` `trama_atributos-valores3`
			ON `trama_articulos-valores-stock-precio`.valor4 =
			`trama_atributos-valores3`.id
			LEFT JOIN `trama_atributos-valores` `trama_atributos-valores4`
			ON `trama_articulos-valores-stock-precio`.valor5 =
			`trama_atributos-valores4`.id
			LEFT JOIN `trama_atributos-valores` `trama_atributos-valores5`
			ON `trama_articulos-valores-stock-precio`.valor6 =
			`trama_atributos-valores5`.id
			LEFT JOIN `trama_atributos-valores` `trama_atributos-valores6`
			ON `trama_articulos-valores-stock-precio`.valor7 =
			`trama_atributos-valores6`.id
			LEFT JOIN `trama_atributos-valores` `trama_atributos-valores7`
			ON `trama_articulos-valores-stock-precio`.valor8 =
			`trama_atributos-valores7`.id
			LEFT JOIN `trama_atributos-valores` `trama_atributos-valores8`
			ON `trama_articulos-valores-stock-precio`.valor9 =
			`trama_atributos-valores8`.id
			WHERE walger_items_pedidos.estado = 'P' AND walger_pedidos.CodigoCli = '".$idUsuario."'
			AND walger_pedidos.estado = 'N'
			ORDER BY walger_items_pedidos.idItemPedido DESC";

			$resultado=mysqli_query($mysqli, $sql);

			if(!$resultado){
				$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],1);
			}else{
				$respuesta["exito"]=array();
				$respuesta["error"]=FALSE;

				$acumulado=0;
				$ivaacumulado=0;

				for ($i=0; $i < $resultado->num_rows; $i++) { 
					$registro=mysqli_fetch_assoc($resultado);
					if ($registro["NombreFotoArti"]=="" || $registro["NombreFotoArti"]==NULL) {
						$registro["NombreFotoArti"]=$GLOBALS["configuracion"]["productos"]["imagennodisponible"];		
					}else{
						$registro["NombreFotoArti"]=retornarPrimeraImagen($registro["NombreFotoArti"]);
					}			
					$registro=map($registro);

					if ($registro["precioatributo"]==NULL) {
						$precio=$registro["PrecioVta1_PreArti"];
					}else{
						$precio=$registro["precioatributo"];
					}

					$registro["iva"]=precioCliente($precio,$registro["TasaIva"]) * $registro["cantidad"] * $registro["TasaIva"] / 100;
					$ivaacumulado += $registro["iva"];
					$registro["iva"]=formatearPrecio($registro["iva"]);					
					$registro["subtotal"]=precioCliente($precio,$registro["TasaIva"]) * $registro["cantidad"];
					$acumulado += $registro["subtotal"];
					$registro["subtotal"]=formatearPrecio($registro["subtotal"]);					
					$registro["PrecioVta1_PreArti"]=formatearPrecio(precioCliente($precio,$registro["TasaIva"]));
					array_push($respuesta["exito"], $registro);
				}
				$respuesta["adicionales"]["carpetaupload"]=$GLOBALS["configuracion"]["carpetauploadremoto"];						
				$_SESSION["acumuladosinformato"]=$acumulado;
				$_SESSION["ivasinformato"]=$ivaacumulado;
				$acumulado=formatearPrecio($acumulado);
				$ivaacumulado=formatearPrecio($ivaacumulado);
				$respuesta["adicionales"]["ivaacumulado"]=$ivaacumulado;								
				$respuesta["adicionales"]["acumulado"]=$acumulado;
				if (sesion()) {
					$respuesta["adicionales"]["CalculaIvaC"]=$_SESSION["CalculaIvaC"];
					$respuesta["adicionales"]["DiscriminaIvaC"]=$_SESSION["DiscriminaIvaC"];				
				}else{
					$respuesta["adicionales"]["CalculaIvaC"]=1;
					$respuesta["adicionales"]["DiscriminaIvaC"]=0;					
				}
			}	
		}
							
	break;


	case 'contador-cesta':
		
		/********** CONTADOR CESTA ***********/
		$respuesta["error"]=FALSE;
		
		if (!isset($_SESSION["idUsuario"])) {
			if ($GLOBALS["configuracion"]["permiteinvitado"]===TRUE) {
				$idUsuario=usuarioInvitado();
			}else{
				$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],0);															
			}
		}else{
			$idUsuario=$_SESSION["idUsuario"];
		}

		if ($respuesta["error"]==FALSE) {

			$sql="SELECT
			".$GLOBALS["configuracion"]["productos"]["tipocontador"]."(walger_items_pedidos.cantidad) as cantidad
			FROM walger_items_pedidos
			INNER JOIN walger_pedidos
			ON walger_items_pedidos.idPedido=walger_pedidos.idPedido
			WHERE walger_items_pedidos.`estado`='P'
			AND walger_pedidos.CodigoCli='".$idUsuario."'
			AND walger_pedidos.estado = 'N'";
			$resultado=mysqli_query($mysqli, $sql);

			if(!$resultado){
				$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],1);
			}else{
				$respuesta["exito"]=array();
				$respuesta["error"]=FALSE;

				$registro=mysqli_fetch_assoc($resultado);
				array_push($respuesta["exito"], $registro);

			}	
		}
							
	break;

	case 'confirmar-pedido':
		
		/********** CONFIRMAR PEDIDO ***********/
		$respuesta["error"]=FALSE;

		if (!isset($_SESSION["idUsuario"])) {
			$respuesta["error"]=TRUE;
			cargaError($_GET["accion"],0);															
		}else{
			$sql="SELECT *
      FROM walger_pedidos
      WHERE estado = 'N'
      AND CodigoCli = '".$_SESSION["idUsuario"]."'
      LIMIT 1";
			
			$resultado=mysqli_query($mysqli, $sql);

			if(!$resultado){
				$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],1);
			}else{

				if ($resultado->num_rows > 0) {

					$registro=mysqli_fetch_assoc($resultado);
					$idPedido=$registro["idPedido"];

					$sql="SELECT * FROM `walger_items_pedidos`
					INNER JOIN dbo_articulo
					ON `walger_items_pedidos`.`CodInternoArti`= dbo_articulo.CodInternoArti
					LEFT JOIN `trama_articulos-valores-stock-precio`
					ON `walger_items_pedidos`.`idArticulosValores` = `trama_articulos-valores-stock-precio`.`id`
          WHERE idPedido = '".$idPedido."'";

					$resultado=mysqli_query($mysqli, $sql);

					if(!$resultado){

						$respuesta["error"]=TRUE;
						cargaError($_GET["accion"],1);
					}else{
						if ($GLOBALS["configuracion"]["checkout"]==TRUE && $_SESSION["pasarelaPago"]==1) {

							if ($resultado->num_rows>0) {

								$CSITPRODUCTCODE = array();
								$CSITPRODUCTDESCRIPTION = array();    
								$CSITPRODUCTNAME = array(); 
								$CSITPRODUCTSKU = array();
								$CSITTOTALAMOUNT = array();
								$CSITQUANTITY = array();
								$CSITUNITPRICE = array();

								$AMOUNT=0;
							
								for ($i=0; $i < $resultado->num_rows; $i++) { 

									$registro=mysqli_fetch_assoc($resultado);
									$registro=map($registro);

									array_push($CSITPRODUCTCODE, "default");
									array_push($CSITPRODUCTDESCRIPTION, $registro["DescripcionArti"]);
									array_push($CSITPRODUCTNAME, $registro["DescripcionArti"]);
									array_push($CSITPRODUCTSKU, $registro["CodInternoArti"]);
									if ($registro["precio"]==NULL) {
										$precio=$registro["PrecioVta1_PreArti"];
									}else{
										$precio=$registro["precio"];
									}

									$precio=precioCliente($precio, $registro["TasaIva"]);

									array_push($CSITTOTALAMOUNT, formatoMonedaTodoPago($registro["cantidad"]*$precio));
									array_push($CSITQUANTITY, $registro["cantidad"]);
									array_push($CSITUNITPRICE, formatoMonedaTodoPago($precio));
									
								}

								$CSITPRODUCTCODE = formatoDetallesTodoPago($CSITPRODUCTCODE);
								$CSITPRODUCTDESCRIPTION = formatoDetallesTodoPago($CSITPRODUCTDESCRIPTION);    
								$CSITPRODUCTNAME = formatoDetallesTodoPago($CSITPRODUCTNAME); 
								$CSITPRODUCTSKU = formatoDetallesTodoPago($CSITPRODUCTSKU);
								$CSITTOTALAMOUNT = formatoDetallesTodoPago($CSITTOTALAMOUNT);
								$CSITQUANTITY = formatoDetallesTodoPago($CSITQUANTITY);
								$CSITUNITPRICE = formatoDetallesTodoPago($CSITUNITPRICE);

								$datosTodopago = obtieneDatosTodopago();

								$http_header = array('Authorization'=>$datosTodopago["Security"],
								 'user_agent' => 'PHPSoapClient');

								$connector = new Sdk($http_header, $datosTodopago["modo"]);

								$operationid = "Pedido Número ".$idPedido; 
								 
								$optionsSAR_comercio = array (
									'Security'=> $datosTodopago["Security"],
									'EncodingMethod'=>'XML',
									'Merchant'=>$datosTodopago["Merchant"],
									'URL_OK'=>"http://".$GLOBALS["configuracion"]["host"]."/exito.php?pedido=$idPedido",
									'URL_ERROR'=>"http://".$GLOBALS["configuracion"]["host"]."/error.php?pedido=$idPedido"
								);

								$optionsSAR_operacion = array (
									'MERCHANT'=> $datosTodopago["Merchant"],
									'OPERATIONID'=>$operationid,
									'CURRENCYCODE'=> 032,
									'AMOUNT'=>$_SESSION["totalfinal"],
									'MININSTALLMENTS' => $_SESSION["cuotas"],	
									'MAXINSTALLMENTS' => $_SESSION["cuotas"],
									'TIMEOUT' => 1800000,

									'CSBTCITY'=> $_GET["datostodopago"]["CSBTCITY"],
									'CSSTCITY'=> $_GET["datostodopago"]["CSSTCITY"],
									
									'CSBTCOUNTRY'=> "AR",
									'CSSTCOUNTRY'=> "AR",
									
									'CSBTEMAIL'=> $_GET["datostodopago"]["CSBTEMAIL"],
									'CSSTEMAIL'=> $_GET["datostodopago"]["CSSTEMAIL"],
									
									'CSBTFIRSTNAME'=> $_GET["datostodopago"]["CSBTFIRSTNAME"],
									'CSSTFIRSTNAME'=> $_GET["datostodopago"]["CSSTFIRSTNAME"],      
									
									'CSBTLASTNAME'=> $_GET["datostodopago"]["CSBTLASTNAME"],
									'CSSTLASTNAME'=> $_GET["datostodopago"]["CSSTLASTNAME"],
									
									'CSBTPHONENUMBER'=> $_GET["datostodopago"]["CSBTPHONENUMBER"],     
									'CSSTPHONENUMBER'=> $_GET["datostodopago"]["CSSTPHONENUMBER"],     
									
									'CSBTPOSTALCODE'=> $_GET["datostodopago"]["CSBTPOSTALCODE"],
									'CSSTPOSTALCODE'=> $_GET["datostodopago"]["CSSTPOSTALCODE"],
									
									'CSBTSTATE'=> $_GET["datostodopago"]["CSBTSTATE"],
									'CSSTSTATE'=> $_GET["datostodopago"]["CSSTSTATE"],
									
									'CSBTSTREET1'=> $_GET["datostodopago"]["CSBTSTREET1"],
									'CSSTSTREET1'=> $_GET["datostodopago"]["CSSTSTREET1"],
									
									'CSBTCUSTOMERID'=> $_SESSION["idUsuario"],
									'CSBTIPADDRESS'=> gethostbyname(gethostname()),       
									'CSPTCURRENCY'=> "ARS",
									'CSPTGRANDTOTALAMOUNT'=> formatoMonedaTodoPago($_SESSION["totalfinal"]),
									'CSMDD7'=> "",     
									'CSMDD8'=> "N",       
									'CSMDD9'=> "",       
									'CSMDD10'=> "",      
									'CSMDD11'=> "",
									'CSMDD12'=> "",     
									'CSMDD13'=> "",
									'CSMDD14'=> "",
									'CSMDD15'=> "",        
									'CSMDD16'=> "",
									'CSITPRODUCTCODE'=> $CSITPRODUCTCODE,
									'CSITPRODUCTDESCRIPTION'=> $CSITPRODUCTDESCRIPTION,     
									'CSITPRODUCTNAME'=> $CSITPRODUCTNAME,  
									'CSITPRODUCTSKU'=> $CSITPRODUCTSKU,
									'CSITTOTALAMOUNT'=> $CSITTOTALAMOUNT,
									'CSITQUANTITY'=> $CSITQUANTITY,
									'CSITUNITPRICE'=> $CSITUNITPRICE
								);

								$rta = $connector->sendAuthorizeRequest($optionsSAR_comercio, $optionsSAR_operacion);

								if ($rta["StatusCode"]==-1) {
									$respuesta["error"]=FALSE;
									$URL_Request=$rta["URL_Request"];
									$RequestKey=$rta["RequestKey"];
									$PublicRequestKey=$rta["PublicRequestKey"];
									$respuesta["adicionales"]["formulario"]=$URL_Request;
								}else{
									$respuesta["error"]=TRUE;
									cargaError("todopago",$rta["StatusCode"]);
								}

							}else{
								$respuesta["error"]=TRUE;
								cargaError($_GET["accion"],3);
							}
						}else{
							$URL_Request=0;
							$RequestKey=0;
							$PublicRequestKey=0;
							$respuesta["adicionales"]["formulario"]=$URL_Request;
						}
					}					

					if ($respuesta["error"]===FALSE) {
						
						$sql="UPDATE walger_pedidos
	          SET estado = 'X',
	          comentario = '".$_GET["comentario"]."',
	          fechaEstado = NOW(),
	          idMedioEnvio = '".$_GET["idEntrega"]."',
	          medioEnvio = '".$_GET["medioenvio"]."',	          
	          idMedioPago = '".$_GET["idPago"]."',
	          idCuotaRecargo = '".$_GET["idCuota"]."',
	          recargoEnvio = '".$_SESSION["subtotalrecargoentrega"]."',
	          recargoPago = '".$_SESSION["subtotalrecargopago"]."',
	          recargoEnvioIva = '".$_SESSION["subtotalrecargoentregaiva"]."',
	          recargoPagoIva = '".$_SESSION["subtotalrecargopagoiva"]."',
	          URL_Request= '".$URL_Request."',
						RequestKey='".$RequestKey."',
						PublicRequestKey='".$PublicRequestKey."'
	          WHERE CodigoCli = '".$_SESSION["idUsuario"]."'
	          AND idPedido = '".$idPedido."'";

						$resultado=mysqli_query($mysqli, $sql);

						if(!$resultado){
							$respuesta["error"]=TRUE;
							cargaError($_GET["accion"],1);
						}else{
							$sql="SELECT * FROM walger_items_pedidos
	            WHERE idPedido = '".$idPedido."'";

							$resultado=mysqli_query($mysqli, $sql);

							if(!$resultado){
								$respuesta["error"]=TRUE;
								cargaError($_GET["accion"],1);
							}else{
								if ($resultado->num_rows > 0) {

									$sql="UPDATE walger_items_pedidos
									inner join dbo_articulo
									on walger_items_pedidos.CodInternoArti = dbo_articulo.CodInternoArti
									SET estado = 'P',
									walger_items_pedidos.precio=dbo_articulo.PrecioVta1_PreArti
									WHERE idPedido = '".$idPedido."'";
									
									$resultado=mysqli_query($mysqli, $sql);

									if(!$resultado){
										$respuesta["error"]=TRUE;
										cargaError($_GET["accion"],1);
									}else{

										$sql="SELECT
										walger_items_pedidos.CodInternoArti,
										DescripcionArti,
										walger_items_pedidos.Precio,
										Cantidad,
										emailCli,
										walger_items_pedidos.Estado,
										walger_pedidos.idPedido,
										walger_pedidos.fechaEstado AS FECHAPED,
										walger_items_pedidos.idItemPedido,
										walger_clientes.CodigoCli AS CCLI,
										dbo_cliente.Telefono AS TELE,
										dbo_cliente.IngbrutosCLI AS INGBRUT,
										dbo_cliente.CuitCli AS CUIT,
										dbo_ivacondicion.DescrIvaC AS DESCRIVA,
										TasaIva,
										RazonSocialCli,
										Direccion, BarrioCli,
										LocalidadCli,
										DescrProvincia,
										CodigoPostalCli,
										DescrPais,
										RazonSocialFlete,
										walger_pedidos.Comentario,
										walger_pedidos.medioEnvio as 'medioenvio',
										dbo_moneda.Signo_Mda,
										`trama_medios-entrega`.denominacion as 'medioentrega',
										`trama_medios-pagos`.denominacion as 'mediopago',
										`trama_atributos-valores`.valor AS valor1,
										`trama_atributos-valores1`.valor AS valor2,
										`trama_atributos-valores2`.valor AS valor3,
										`trama_atributos-valores3`.valor AS valor4,
										`trama_atributos-valores4`.valor AS valor5,
										`trama_atributos-valores5`.valor AS valor6,
										`trama_atributos-valores6`.valor AS valor7,
										`trama_atributos-valores7`.valor AS valor8,
										`trama_atributos-valores8`.valor AS valor9,
										`trama_articulos-valores-stock-precio`.precio AS precioatributo										
										FROM dbo_articulo
										INNER JOIN walger_items_pedidos
										ON dbo_articulo.CodInternoArti = walger_items_pedidos.CodInternoArti
										INNER JOIN walger_pedidos
										ON walger_items_pedidos.idPedido = walger_pedidos.idPedido
										INNER JOIN dbo_cliente
										ON dbo_cliente.CodigoCli = walger_pedidos.CodigoCli
										INNER JOIN dbo_ivacondicion
										ON dbo_cliente.Regis_ivaC = dbo_ivacondicion.Regis_ivaC
										INNER JOIN walger_clientes
										ON dbo_cliente.CodigoCli = walger_clientes.CodigoCli
										LEFT JOIN dbo_moneda
										ON dbo_moneda.Regis_Mda = walger_clientes.Regis_Mda
										LEFT JOIN `trama_medios-entrega`
										ON walger_pedidos.idMedioEnvio = `trama_medios-entrega`.id
										LEFT JOIN `trama_medios-pagos`
										ON walger_pedidos.idMedioPago = `trama_medios-pagos`.id										
										LEFT JOIN `trama_articulos-valores-stock-precio`
										ON walger_items_pedidos.idArticulosValores =
										`trama_articulos-valores-stock-precio`.id
										LEFT JOIN `trama_atributos-valores`
										ON `trama_articulos-valores-stock-precio`.valor1 =
										`trama_atributos-valores`.id
										LEFT JOIN `trama_atributos-valores` `trama_atributos-valores1`
										ON `trama_articulos-valores-stock-precio`.valor2 =
										`trama_atributos-valores1`.id
										LEFT JOIN `trama_atributos-valores` `trama_atributos-valores2`
										ON `trama_articulos-valores-stock-precio`.valor3 =
										`trama_atributos-valores2`.id
										LEFT JOIN `trama_atributos-valores` `trama_atributos-valores3`
										ON `trama_articulos-valores-stock-precio`.valor4 =
										`trama_atributos-valores3`.id
										LEFT JOIN `trama_atributos-valores` `trama_atributos-valores4`
										ON `trama_articulos-valores-stock-precio`.valor5 =
										`trama_atributos-valores4`.id
										LEFT JOIN `trama_atributos-valores` `trama_atributos-valores5`
										ON `trama_articulos-valores-stock-precio`.valor6 =
										`trama_atributos-valores5`.id
										LEFT JOIN `trama_atributos-valores` `trama_atributos-valores6`
										ON `trama_articulos-valores-stock-precio`.valor7 =
										`trama_atributos-valores6`.id
										LEFT JOIN `trama_atributos-valores` `trama_atributos-valores7`
										ON `trama_articulos-valores-stock-precio`.valor8 =
										`trama_atributos-valores7`.id
										LEFT JOIN `trama_atributos-valores` `trama_atributos-valores8`
										ON `trama_articulos-valores-stock-precio`.valor9 =
										`trama_atributos-valores8`.id										
										WHERE walger_pedidos.idPedido = '".$idPedido."'
										ORDER BY walger_items_pedidos.CodInternoArti, DescripcionArti";
										
										$resultado=mysqli_query($mysqli, $sql);

										if ($resultado->num_rows>0) {
											$datospedido=array();
											for ($i=0; $i < $resultado->num_rows; $i++) { 
												$registro=mysqli_fetch_assoc($resultado);
												array_push($datospedido, $registro);											
											}
										}

										$demail=$GLOBALS["configuracion"]["email"]["emailenvia"];
										$denombre=$GLOBALS["configuracion"]["email"]["nombreenvia"];
										$paramail=$GLOBALS["configuracion"]["email"]["emailadministracion"];
										$paranombre=$GLOBALS["configuracion"]["email"]["nombreadministracion"];
										$responderamail=$datospedido[0]["emailCli"];
										$responderanombre=$datospedido[0]["RazonSocialCli"];
										$concopia="";
										$concopiaoculta="";
										$asunto=$GLOBALS["configuracion"]["email"]["asuntos"]["nuevopedidoadministracion"] . $idPedido;

										$mensaje="";
										$mensaje.='<table style="min-width:480px" border="1">';
										$mensaje.='<tr>';
										$mensaje.='<td><b>Pedido Número: </b>'.$datospedido[0]["idPedido"].'</td>';
										$mensaje.='<td><b>Fecha y Hora Pedido: </b>'.$datospedido[0]["FECHAPED"].'</td>';
										$mensaje.='<td><b>Codigo Cliente: </b>'.$datospedido[0]["CCLI"].'</td>';
										$mensaje.='<td><b>Cliente: </b>'.$datospedido[0]["RazonSocialCli"].'</td>';
										$mensaje.='</tr>';
										$mensaje.='</table>';
										$mensaje.='<br>';									
										$mensaje.='<table style="min-width:480px" border="1">';
										$mensaje.='<tr>';
										$mensaje.='<td><b>Dirección: </b>'.$datospedido[0]["Direccion"].' '.$datospedido[0]["BarrioCli"].' '.$datospedido[0]["LocalidadCli"].' ('.$datospedido[0]["CodigoPostalCli"].') '.$datospedido[0]["DescrProvincia"].' '.$datospedido[0]["DescrPais"].'</td>';
										$mensaje.='<td><b>Telefono: </b>'.$datospedido[0]["TELE"].'</td>';
										$mensaje.='</tr>';
										$mensaje.='</table>';
										$mensaje.='<br>';									
										$mensaje.='<table style="min-width:480px" border="1">';
										$mensaje.='<tr>';
										$mensaje.='<td><b>Ing. Brutos: </b>'.$datospedido[0]["INGBRUT"].'</td>';
										$mensaje.='<td><b>Nro. Cuit: </b>'.$datospedido[0]["CUIT"].'</td>';
										$mensaje.='<td><b>Tipo IVA: </b>'.$datospedido[0]["DESCRIVA"].'</td>';
										$mensaje.='<td><b>Transporte: </b>'.$datospedido[0]["RazonSocialFlete"].'</td>';
										$mensaje.='</tr>';
										$mensaje.='</table>';
										$mensaje.='<br>';									
										$mensaje.='<table style="min-width:480px" border="1">';
										$mensaje.='<thead>';
										$mensaje.='<tr>';
										$mensaje.='<th>Código</th>';
										$mensaje.='<th width="300px">Descripción</th>';
										$mensaje.='<th width="35px">Cant</th>';
										$mensaje.='<th>Precio '.$datospedido[0]["Signo_Mda"].'</th>';
										$mensaje.='<th>Total Línea</th>';
										$mensaje.='</tr>';
										$mensaje.='</thead>';
										$mensaje.='<tbody>';

										$SUBTOTAL=0;
										$IVA=0;

										for ($i=0; $i < count($datospedido) ; $i++) { 
											$mensaje.='<tr>';
											$mensaje.='<td>'.$datospedido[$i]["CodInternoArti"].'</td>';
											$mensaje.='<td>'.$datospedido[$i]["DescripcionArti"].'<strong>'.$datospedido[$i]["valor1"].' '.$datospedido[$i]["valor2"].' '.$datospedido[$i]["valor3"].' '.$datospedido[$i]["valor4"].' '.$datospedido[$i]["valor5"].' '.$datospedido[$i]["valor6"].' '.$datospedido[$i]["valor7"].' '.$datospedido[$i]["valor8"].' '.$datospedido[$i]["valor9"].' '.'</strong></td>';
											$mensaje.='<td align ="right">'.$datospedido[$i]["Cantidad"].'</td>';
											$mensaje.='<td align ="right">'.formatearPrecio(precioCliente($datospedido[$i]["Precio"],$datospedido[$i]["TasaIva"])).'</td>';
											$mensaje.='<td align ="right">'.formatearPrecio(precioCliente($datospedido[$i]["Cantidad"] * $datospedido[$i]["Precio"],$datospedido[$i]["TasaIva"])).'</td>';
											$mensaje.='</tr>';
											$SUBTOTAL += precioCliente($datospedido[$i]["Cantidad"] * $datospedido[$i]["Precio"],$datospedido[$i]["TasaIva"]);
											$IVA += precioCliente($datospedido[$i]["Cantidad"] * $datospedido[$i]["Precio"] * $datospedido[$i]['TasaIva'] / 100,$datospedido[$i]["TasaIva"]);
										}

										$TOTAL=$SUBTOTAL+$IVA;

										$mensaje.='</tbody>';
										$mensaje.='</table>';
										$mensaje.='<br>';									
										$mensaje.='<table style="min-width:480px" border="2">';

										if ($_SESSION["CalculaIvaC"]==1 && $_SESSION["DiscriminaIvaC"]==1) {
											$mensaje.='<tr>';
											$mensaje.='<td align ="right">Subtotal: '.formatearPrecio($SUBTOTAL).'</td>';
											$mensaje.='<td align ="right">IVA: '.formatearPrecio($IVA).'</td>';
											$mensaje.='</tr>';

											if ($GLOBALS["configuracion"]["checkout"]===TRUE) {

												$mensaje.='<tr>';
												$mensaje.='<td>Medio de envío: '.$datospedido[0]["medioentrega"].'</td>';												
												$mensaje.='<td align ="right">Recargo Entrega: '.formatearPrecio($_SESSION["subtotalrecargoentrega"]).'</td>';
												$mensaje.='<td align ="right">Recargo Entrega IVA: '.formatearPrecio($_SESSION["subtotalrecargoentregaiva"]).'</td>';
												$mensaje.='</tr>';

												$mensaje.='<tr>';
												$mensaje.='<td>Medio de Pago: '.$datospedido[0]["mediopago"].' ('.$_SESSION["cuotas"].' cuotas)'.'</td>';																								
												$mensaje.='<td align ="right">Recargo Entrega: '.formatearPrecio($_SESSION["subtotalrecargopago"]).'</td>';
												$mensaje.='<td align ="right">Recargo Entrega IVA: '.formatearPrecio($_SESSION["subtotalrecargopagoiva"]).'</td>';
												$mensaje.='</tr>';

												$mensaje.='<tr>';
												$mensaje.='<td></td>';																																																
												$mensaje.='<td align ="right">Total: '.formatearPrecio($_SESSION["total"]).'</td>';
												$mensaje.='<td align ="right">IVA: '.formatearPrecio($_SESSION["totaliva"]).'</td>';
												$mensaje.='</tr>';																																				
											
											}else{

												$mensaje.='<tr>';
												$mensaje.='<td></td>';																								
												$mensaje.='<td>Medio de envío: '.$datospedido[0]["medioenvio"].'</td>';												
												$mensaje.='</tr>';													

												$mensaje.='<tr>';
												$mensaje.='<td></td>';																																																
												$mensaje.='<td align ="right">TOTAL: '.formatearPrecio($TOTAL).'</td>';
												$mensaje.='</tr>';

											}

										}else{

											if ($GLOBALS["configuracion"]["checkout"]===TRUE) {

												$mensaje.='<tr>';
												$mensaje.='<td>Medio de envío: '.$datospedido[0]["medioentrega"].'</td>';												
												$mensaje.='<td align ="right">Recargo Entrega: '.formatearPrecio($_SESSION["subtotalrecargoentrega"]).'</td>';
												$mensaje.='</tr>';

												$mensaje.='<tr>';
												$mensaje.='<td>Medio de Pago: '.$datospedido[0]["mediopago"].' ('.$_SESSION["cuotas"].' cuotas)'.'</td>';																								
												$mensaje.='<td align ="right">Recargo Entrega: '.formatearPrecio($_SESSION["subtotalrecargopago"]).'</td>';
												$mensaje.='</tr>';

												$mensaje.='<tr>';
												$mensaje.='<td></td>';																																				
												$mensaje.='<td align ="right">Total: '.formatearPrecio($_SESSION["total"]).'</td>';
												$mensaje.='</tr>';																																				
											
											}else{

												$mensaje.='<tr>';
												$mensaje.='<td>Medio de envío: '.$datospedido[0]["medioenvio"].'</td>';												
												$mensaje.='</tr>';												

												$mensaje.='<tr>';
												$mensaje.='<td align ="right">TOTAL: '.formatearPrecio($TOTAL).'</td>';
												$mensaje.='</tr>';

											}
										}
										$mensaje.='</table>';
										$mensaje.='<br>';
										$mensaje.='<br>';
										$mensaje.='<b>Comentario:</b><p>'.$datospedido[0]["Comentario"].'</p>';
										$mensaje.='<br>';
										$mensaje.='<br>';        
										$mensaje.='Gracias por comprar en nuestra tienda virtual.<br>Le recordamos que los pedidos se procesarán en orden de llegada y que podrá verificar el estado de su pedido on line.';

										$mensajehtml= $mensaje;
										$mensajeplano= strip_tags($mensaje);
										$encabezado=$GLOBALS["configuracion"]["email"]["nombreadministracion"];

										$resultado=enviarMail($demail, $denombre, $paramail, $paranombre, $responderamail, $responderanombre, $concopia, $concopiaoculta, $asunto, $mensajehtml, $mensajeplano, $encabezado );
										
										if ($resultado["enviado"]==TRUE) {
											$respuesta["error"]=FALSE;			
											$respuesta["exito"]="Se ha enviado su pedido";
										}else{
											$respuesta["error"]=TRUE;
											cargaError($_GET["accion"],4);						
										}									
									}																
								}else{
									$respuesta["error"]=TRUE;
									cargaError($_GET["accion"],3);								
								}							
							}            
						}
					}
				}else{
					$respuesta["error"]=TRUE;
					cargaError($_GET["accion"],2);					
				}
			}	
		}				

		break;

	case 'pedidos':
		
		/********** PEDIDOS ***********/
		$respuesta["error"]=FALSE;
		
		if (!isset($_SESSION["idUsuario"])) {
			$respuesta["error"]=TRUE;
			cargaError($_GET["accion"],0);															
		}else{

			$sql="SELECT * FROM `walger_pedidos`
			WHERE CodigoCli='".$_SESSION["idUsuario"]."'
			AND `estado` != 'N'
			ORDER BY `walger_pedidos`.`idPedido` DESC";

			$resultado=mysqli_query($mysqli, $sql);

			if(!$resultado){
				$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],1);
			}else{
				$respuesta["exito"]=array();
				$respuesta["error"]=FALSE;

				$hoy=date_create(date("d-m-Y"));
				
				for ($i=0; $i < $resultado->num_rows; $i++) { 
					$registro=mysqli_fetch_assoc($resultado);
					$registro=map($registro);
					$registro["estado"]=$GLOBALS["configuracion"]["estadospedidos"][$registro["estado"]];
					if ($registro["fechaFacturacion"]==null) {
						$registro["fechaFacturacion"]="-";
						$registro["vencido"]=FALSE;
					}else{
						$registro["fechaFacturacion"]=date("d-m-Y",strtotime($registro["fechaFacturacion"]));					
						$fechaFacturacion=date_create($registro["fechaFacturacion"]);
						$intervalo = (date_diff($fechaFacturacion, $hoy)->days);
						if ($intervalo>$GLOBALS["configuracion"]["diasvencimientotransaccion"]) {
							$registro["vencido"]=TRUE;
						}						
					}

					$registro["fechaEstado"]=date("d-m-Y",strtotime($registro["fechaEstado"]));

					if ($GLOBALS["configuracion"]["pdffacturas"]===TRUE) {
						if (strlen($registro["factura"])>0) {
							$nrocomprobante=str_replace("-", "", substr($registro["factura"],3));
						}else{
							$nrocomprobante=0;
						}
						$idcliente=$_SESSION["idUsuario"];
						$cuitcliente=$_SESSION["cuit"];

						$rutapdf = "";
						$rutaprincipal = opendir($GLOBALS["configuracion"]["carpetapdffacturas"]);
						$carpeta = readdir($rutaprincipal);

						while ($carpeta = readdir($rutaprincipal)) {
							if ((strpos($carpeta, $idcliente) === 0) && (strpos($carpeta, $cuitcliente) > 0)){
								$rutacompleta = opendir($GLOBALS["configuracion"]["carpetapdffacturas"].$carpeta."/");
								while ($subcarpeta = readdir($rutacompleta)) {
									if ((strpos($subcarpeta, $nrocomprobante) > 0)&&(strpos($subcarpeta, ".pdf") > 0)) {
										$rutapdf = "fc.php?r=".$carpeta."/".$subcarpeta;
										break;
									}
								}
								break;
							}
						}

						$registro["linkpdf"]=$rutapdf;							
						
					}else{

						$registro["linkpdf"]="";

					}

					array_push($respuesta["exito"], $registro);
				}
			}	
		}
							
	break;

	case 'detalle-pedido':
		
		/********** DETALLE PEDIDO ***********/
		$respuesta["error"]=FALSE;
		
		if (!isset($_SESSION["idUsuario"])) {
			$respuesta["error"]=TRUE;
			cargaError($_GET["accion"],0);															
		}else{

			$sql="SELECT
			walger_items_pedidos.*,
			dbo_articulo.*
			FROM walger_items_pedidos
			INNER JOIN dbo_articulo
			ON walger_items_pedidos.CodInternoArti=dbo_articulo.CodInternoArti
			INNER JOIN walger_pedidos
			ON walger_items_pedidos.idPedido=walger_pedidos.idPedido
			WHERE walger_pedidos.CodigoCli='".$_SESSION["idUsuario"]."'
			AND walger_pedidos.idPedido = '".$_GET["idPedido"]."'
			ORDER BY walger_items_pedidos.idItemPedido DESC";

			$resultado=mysqli_query($mysqli, $sql);

			if(!$resultado){
				$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],1);
			}else{
				$respuesta["exito"]=array();
				$respuesta["error"]=FALSE;

				$acumulado=0;
				$ivaacumulado=0;

				for ($i=0; $i < $resultado->num_rows; $i++) { 
					$registro=mysqli_fetch_assoc($resultado);
					if ($registro["NombreFotoArti"]=="" || $registro["NombreFotoArti"]==NULL) {
						$registro["NombreFotoArti"]=$GLOBALS["configuracion"]["productos"]["imagennodisponible"];		
					}			
					$registro=map($registro);
					$registro["iva"]=precioCliente($registro["precio"],$registro["TasaIva"]) * $registro["cantidad"] * $registro["TasaIva"] / 100;
					$ivaacumulado += $registro["iva"];
					$registro["iva"]=formatearPrecio($registro["iva"]);					
					$registro["subtotal"]=precioCliente($registro["precio"],$registro["TasaIva"]) * $registro["cantidad"];
					$acumulado += $registro["subtotal"];
					$registro["subtotal"]=formatearPrecio($registro["subtotal"]);					
					$registro["precio"]=formatearPrecio(precioCliente($registro["precio"],$registro["TasaIva"]));
					array_push($respuesta["exito"], $registro);
				}
				$respuesta["adicionales"]["carpetaupload"]=$GLOBALS["configuracion"]["carpetauploadremoto"];						
				$acumulado=formatearPrecio($acumulado);
				$ivaacumulado=formatearPrecio($ivaacumulado);
				$respuesta["adicionales"]["ivaacumulado"]=$ivaacumulado;								
				$respuesta["adicionales"]["acumulado"]=$acumulado;
				$respuesta["adicionales"]["CalculaIvaC"]=$_SESSION["CalculaIvaC"];
				$respuesta["adicionales"]["DiscriminaIvaC"]=$_SESSION["DiscriminaIvaC"];				
			}	
		}
							
	break;

	case 'ultimos-comprados':
		
		/********** ULTIMOS COMPRADOS ***********/
		$respuesta["error"]=FALSE;
		
		if (!isset($_SESSION["idUsuario"])) {
			$respuesta["error"]=TRUE;
			cargaError($_GET["accion"],0);															
		}else{

			$sql="SELECT
			walger_items_pedidos.*,
			dbo_articulo.*,
      walger_pedidos.*
			FROM walger_items_pedidos
			INNER JOIN dbo_articulo
			ON walger_items_pedidos.CodInternoArti=dbo_articulo.CodInternoArti
			INNER JOIN walger_pedidos
			ON walger_items_pedidos.idPedido=walger_pedidos.idPedido
			WHERE walger_pedidos.CodigoCli='".$_SESSION["idUsuario"]."'
			GROUP BY dbo_articulo.CodInternoArti
			ORDER BY walger_items_pedidos.idItemPedido DESC
			LIMIT ".$GLOBALS["configuracion"]["limiteultimoscomprados"];

			$resultado=mysqli_query($mysqli, $sql);

			if(!$resultado){
				$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],1);
			}else{
				$respuesta["exito"]=array();
				$respuesta["error"]=FALSE;


				for ($i=0; $i < $resultado->num_rows; $i++) { 
					$registro=mysqli_fetch_assoc($resultado);
					if ($registro["NombreFotoArti"]=="" || $registro["NombreFotoArti"]==NULL) {
						$registro["NombreFotoArti"]=$GLOBALS["configuracion"]["productos"]["imagennodisponible"];		
					}			
					$registro=map($registro);					
					$registro["PrecioVta1_PreArti"]=formatearPrecio(precioCliente($registro["PrecioVta1_PreArti"],$registro["TasaIva"]));
					
					$fecha=substr($registro["fechaEstado"],0,10);

					$fecha = date_create_from_format('Y-m-d', $fecha);
					$registro["fechacompra"]= date_format($fecha, 'd/m/Y');
					
					array_push($respuesta["exito"], $registro);
				}
				$respuesta["adicionales"]["carpetaupload"]=$GLOBALS["configuracion"]["carpetauploadremoto"];						
				$respuesta["adicionales"]["CalculaIvaC"]=$_SESSION["CalculaIvaC"];
				$respuesta["adicionales"]["DiscriminaIvaC"]=$_SESSION["DiscriminaIvaC"];				
			}	
		}
							
	break;

	case 'retornar-lineas':
		
		/********** RETORNAR LINEAS ***********/
		$respuesta["error"]=FALSE;

		$sql="SELECT 
		distinct(DescrNivelInt3) as 'linea'
		FROM  `dbo_articulo`
		WHERE DescrNivelInt4 = '".$_GET["categoria"]."'";
		$resultado=mysqli_query($mysqli, $sql);

		if(!$resultado){
			$respuesta["error"]=TRUE;
			cargaError($_GET["accion"],0);
		}else{
			$respuesta["exito"]=array();
			$respuesta["error"]=FALSE;
			for ($i=0; $i < $resultado->num_rows; $i++) { 
				$registro=mysqli_fetch_assoc($resultado);
				$registro=map($registro);
				$registro["linea"]=ucwords(mb_strtolower($registro["linea"], 'UTF-8'));			
				array_push($respuesta["exito"], $registro);
			}
		}	

							
	break;

	case 'estado-cuenta':
		
		/********** ESTADO CUENTA ***********/
		$respuesta["error"]=FALSE;
		
		if (!isset($_SESSION["idUsuario"])) {
			$respuesta["error"]=TRUE;
			cargaError($_GET["accion"],0);															
		}else{

			$sql="SELECT * FROM `dbo_clientevtotransa`
			WHERE `CodigoCli` = '".$_SESSION["idUsuario"]."'";

			$resultado=mysqli_query($mysqli, $sql);

			if(!$resultado){
				$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],1);
			}else{
				$respuesta["exito"]=array();
				$respuesta["error"]=FALSE;

				$sql="SELECT * FROM `dbo_moneda`";
				$qmonedas=mysqli_query($mysqli, $sql);

				$monedas=array();

				for ($i=0; $i < $qmonedas->num_rows; $i++) { 
					$moneda=mysqli_fetch_assoc($qmonedas);	
					$moneda=map($moneda);
					$monedas[$moneda["Regis_Mda"]]=$moneda;
				}

				$acumulado=0;

				for ($i=0; $i < $resultado->num_rows; $i++) { 
					$registro=mysqli_fetch_assoc($resultado);	
					$registro=map($registro);
					if ($registro["MdaOper_CliTra"]==0) {
						$registro["MdaOper_CliTra"]=1;
					}
					$registro["FechaVto_CliVto"]=substr($registro["FechaVto_CliVto"],0, 10);
					$registro["Fecha_CliTra"]=substr($registro["Fecha_CliTra"],0, 10);
					$registro["moneda"]=$monedas[$registro["MdaOper_CliTra"]]["Signo_Mda"];

					if ($registro["SignoComp"] == "-") {
						$registro["ImportePes_CliVto"] = $registro["ImportePes_CliVto"] * -1;
					}

					$acumulado+=$registro["ImportePes_CliVto"];
					$registro["acumulado"]=formatearPrecio($acumulado);
					$registro["pendiente"]=formatearPrecio($registro["ImportePes_CliVto"]);

					$hoy=date_create(date("d-m-Y"));
					
					$fechaTra=date_create_from_format('d/m/Y', substr($registro["Fecha_CliTra"],0,10));			
					$fechaTra=date_format($fechaTra, 'Y-m-d');
					$fechaTra=date_create($fechaTra);

					$intervalo = (date_diff($fechaTra, $hoy)->days);

					$registro["dias"]=$intervalo;

					if ($GLOBALS["configuracion"]["pdffacturas"]===TRUE) {

						$nrocomprobante=$registro["NroComprob_CliTra"];
						$idcliente=$_SESSION["idUsuario"];
						$cuitcliente=$_SESSION["cuit"];

						$rutapdf = "";
						$rutaprincipal = opendir($GLOBALS["configuracion"]["carpetapdffacturas"]);
						$carpeta = readdir($rutaprincipal);

						while ($carpeta = readdir($rutaprincipal)) {
							if ((strpos($carpeta, $idcliente) === 0) && (strpos($carpeta, $cuitcliente) > 0)){
								$rutacompleta = opendir($GLOBALS["configuracion"]["carpetapdffacturas"].$carpeta."/");
								while ($subcarpeta = readdir($rutacompleta)) {
									if ((strpos($subcarpeta, $nrocomprobante) > 0)&&(strpos($subcarpeta, ".pdf") > 0)) {
										$rutapdf = "fc.php?r=".$carpeta."/".$subcarpeta;
										break;
									}
								}
								break;
							}
						}

						$registro["linkpdf"]=$rutapdf;							
						
					}else{

						$registro["linkpdf"]="";

					}
								
					array_push($respuesta["exito"], $registro);
				}
			}	
		}	

							
	break;

	case 'estado-cuenta-pago':
		
		/********** ESTADO CUENTA PAGO  ***********/

		$respuesta["error"]=FALSE;

		if ($_GET["cabecera"]["monto-abonar"]<=0) {
			$respuesta["error"]=TRUE;
			cargaError($_GET["accion"],0);			
		}

		if ($_GET["cabecera"]["medios-pagos"]==0) {
			$respuesta["error"]=TRUE;
			cargaError($_GET["accion"],1);			
		}		

		if ($respuesta["error"]==FALSE) {

				$sql="SELECT * FROM `dbo_cliente` where CodigoCli='".$_SESSION["idUsuario"]."'";
				$resultado=mysqli_query($mysqli, $sql);

				$registro=mysqli_fetch_assoc($resultado);

				$demail=$GLOBALS["configuracion"]["email"]["emailenvia"];
				$denombre=$GLOBALS["configuracion"]["email"]["nombreenvia"];
				$paramail=$GLOBALS["configuracion"]["email"]["emailadministracion"];
				$paranombre=$GLOBALS["configuracion"]["email"]["nombreadministracion"];
				$responderamail=$registro["emailCli"];
				$responderanombre=$registro["RazonSocialCli"];
				$concopia="";
				$concopiaoculta="";
				$asunto=$GLOBALS["configuracion"]["email"]["asuntos"]["nuevopagoadministracion"];
										
				$datos = "<strong>Monto total: </strong>".$_GET["cabecera"]["monto-seleccionado"]."<br>";
				$datos .= "<strong>Monto total abonado: </strong>".$_GET["cabecera"]["monto-abonar"]."<br>";				

				if ($_GET["cabecera"]["medios-pagos"] == "1")
				{

				$datos .= "<strong>Fecha y Hora de depósito: </strong>".$_GET["cabecera"]["fecha-hora-deposito"]."<br>";
				$datos .= "<strong>Banco: </strong>".$_GET["cabecera"]["banco"]."<br>";
				$datos .= "<strong>Número de comprobante: </strong>".$_GET["cabecera"]["numero-comprobante"]."<br>";

				if (isset($_GET["cabecera"]["archivo"])) {
					if ($_GET["cabecera"]["archivo"]!="") {
						$datos .=	"<strong>Comprobante: </strong><a href=".(isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://'.$GLOBALS["configuracion"]["host"]."/".$GLOBALS["configuracion"]["carpetaupload"].$_GET["cabecera"]["archivo"].">".$_GET["cabecera"]["archivo"]."</a><br>";					
					}
				}

				} else
				if ($_GET["cabecera"]["medios-pagos"] == "2")
				{

				$datos .= "<strong>Fecha del envío: </strong>".$_GET["cabecera"]["fecha-deposito"]."<br>";
				$datos .= "<strong>Empresa de correo: </strong>".$_GET["cabecera"]["empresa-correo"]."<br>";
				$datos .= "<strong>Número de oblea: </strong>".$_GET["cabecera"]["numero-oblea"]."<br>";

				} else
				if ($_GET["cabecera"]["medios-pagos"] == "3")
				{

				$datos .= "<strong>Importe: </strong>".$_GET["cabecera"]["fecha-deposito"]."<br>";
				$datos .= "<strong>Empresa de transporte: </strong>".$_GET["cabecera"]["nombre-transporte"]."<br>";
				$datos .= "<strong>Número de guia: </strong>".$_GET["cabecera"]["numero-guia"]."<br>";

				} else
				if ($_GET["cabecera"]["medios-pagos"] == "4")
				{

					$datos .= "<strong>Medio de Pago Seleccionado:</strong> MERCADO PAGO <br>";
					$datos .= "<strong>Importe a pagar:</strong> $".$_GET["cabecera"]["importe-final"]." <br>";
					$datos .= "<strong>Importe a descontar:</strong> $".$_GET["cabecera"]["monto-abonar"]." <br>";

					require_once ('mercadopago/mercadopago.php');

					$mp = new MP ($GLOBALS["configuracion"]["mercadopago"]["credenciales"]["CLIENT_ID"], $GLOBALS["configuracion"]["mercadopago"]["credenciales"]["CLIENT_SECRET"]);

					$preference_data = array (
					    "items" => array (
					        array (
					            "title" => 'Pago - '.$registro["RazonSocialCli"].'(Cód. '.$registro["CodigoCli"].')',
					            "quantity" => 1,
					            "currency_id" => "ARS",
					            "unit_price" => floatval($_GET["cabecera"]["importe-final"])
					        )
					    ),
					    "notification_url"=>(isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://'.$GLOBALS["configuracion"]["host"]."api/mercadopago/ipn.php",
					    "external_reference"=>$registro["CodigoCli"],
							"back_urls" => array(
								"success" => (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://'.$GLOBALS["configuracion"]["host"].'/exito.php',
								"failure" => (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://'.$GLOBALS["configuracion"]["host"].'/exito.php',
								"pending" => (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://'.$GLOBALS["configuracion"]["host"].'/exito.php'
							)
					);

					$preference = $mp->create_preference($preference_data);

					$respuesta["adicionales"]=array();
					if ($GLOBALS["configuracion"]["mercadopago"]["modo"]=="test") {
						$respuesta["adicionales"]["redirigir"]=$preference["response"]["init_point"];													
					}else{
						$respuesta["adicionales"]["redirigir"]=$preference["response"]["sandbox_init_point"];			
					}

				}else
				if ($_GET["cabecera"]["medios-pagos"] == "5")
				{

				$datos .= "<strong>Medio de Pago Seleccionado: </strong>QR MercadoPago<br>";

				}


				$datos .= "<strong>Código de cliente: </strong>".$registro["CodigoCli"]."<br>";
				$datos .= "<strong>Denominación de cliente: </strong>".$registro["RazonSocialCli"]."<br>";

				$datos .= "<strong>Comentarios: </strong>".$_GET["cabecera"]["comentarios"]."<br>";

				$mensajehtml= "Hemos recibido una solicitud de pago con los siguientes datos: <br>".$datos."Para contactarse con el usuario puede responder el presente email";
				$mensajeplano=str_replace("<br>", " - ", $mensajehtml);
				$encabezado=$GLOBALS["configuracion"]["email"]["nombreadministracion"];	

				$resultado=enviarMail($demail, $denombre, $paramail, $paranombre, $responderamail, $responderanombre, $concopia, $concopiaoculta, $asunto, $mensajehtml, $mensajeplano, $encabezado );

				if ($resultado["enviado"]==TRUE) {

					$demail=$GLOBALS["configuracion"]["email"]["emailenvia"];
					$denombre=$GLOBALS["configuracion"]["email"]["nombreenvia"];
					$paramail=$registro["emailCli"];
					$paranombre=$registro["RazonSocialCli"];
					$responderamail=$GLOBALS["configuracion"]["email"]["norespondermail"];
					$responderanombre=$GLOBALS["configuracion"]["email"]["norespondernombre"];
					$concopia="";
					$concopiaoculta="";
					$asunto=$GLOBALS["configuracion"]["email"]["asuntos"]["nuevopagocliente"];

					$datos = "<strong>Monto total: </strong>".$_GET["cabecera"]["monto-seleccionado"]."<br>";
					$datos .= "<strong>Monto total abonado: </strong>".$_GET["cabecera"]["monto-abonar"]."<br>";				

					if ($_GET["cabecera"]["medios-pagos"] == "1")
					{

					$datos .= "<strong>Fecha y Hora de depósito: </strong>".$_GET["cabecera"]["fecha-hora-deposito"]."<br>";
					$datos .= "<strong>Banco: </strong>".$_GET["cabecera"]["banco"]."<br>";
					$datos .= "<strong>Número de comprobante: </strong>".$_GET["cabecera"]["numero-comprobante"]."<br>";

					} else
					if ($_GET["cabecera"]["medios-pagos"] == "2")
					{

					$datos .= "<strong>Fecha del envío: </strong>".$_GET["cabecera"]["fecha-deposito"]."<br>";
					$datos .= "<strong>Empresa de correo: </strong>".$_GET["cabecera"]["empresa-correo"]."<br>";
					$datos .= "<strong>Número de oblea: </strong>".$_GET["cabecera"]["numero-oblea"]."<br>";

					} else
					if ($_GET["cabecera"]["medios-pagos"] == "3")
					{

					$datos .= "<strong>Fecha del envío: </strong>".$_GET["cabecera"]["fecha-deposito"]."<br>";
					$datos .= "<strong>Empresa de transporte: </strong>".$_GET["cabecera"]["nombre-transporte"]."<br>";
					$datos .= "<strong>Número de guia: </strong>".$_GET["cabecera"]["numero-guia"]."<br>";

					}else
					if ($_GET["cabecera"]["medios-pagos"] == "4")
					{

					$datos .= "<strong>Medio de Pago Seleccionado:</strong> MERCADO PAGO <br>";
					$datos .= "<strong>Importe a pagar:</strong> $".$_GET["cabecera"]["importe-final"]." <br>";
					$datos .= "<strong>Importe a descontar:</strong> $".$_GET["cabecera"]["monto-abonar"]." <br>";
					$datos .= 'Puede realizar el pago mediante el siguiente link <a href="'.$respuesta["adicionales"]["redirigir"].'">'.$respuesta["adicionales"]["redirigir"].'</a>';
					}else
					if ($_GET["cabecera"]["medios-pagos"] == "5")
					{

					$datos .= "<strong>Medio de Pago Seleccionado: </strong>QR MercadoPago<br>";

					}	
									
					$datos .= "<strong>Comentarios: </strong>".$_GET["cabecera"]["comentarios"]."<br>";

					$datos .= "<strong>Sr Cliente</strong>: Dependiendo del medio de seleccion que Ud. ha indicado, su operacion se vera reflejada, en aproximadamente 72 hs. habiles, en el caso de no mostrar modificacion, por favor contactarse con nuestra area administrativa.<br>";
					$datos .= "Esta informacion es de caracter virtual, y solo se incorporara al sistema una vez recibida en la empresa.<br>";
					$datos .= "Desde ya agradecemos vuestra compra y continuamos trabajando para brindarle cada dia un mejor servicio<br>";

					$mensajehtml= "Hemos recibido una solicitud de pago con los siguientes datos: <br>".$datos;
					$mensajeplano=str_replace("<br>", " - ", $mensajehtml);
					$encabezado=$registro["RazonSocialCli"];

					$resultado=enviarMail($demail, $denombre, $paramail, $paranombre, $responderamail, $responderanombre, $concopia, $concopiaoculta, $asunto, $mensajehtml, $mensajeplano, $encabezado);

					if ($resultado["enviado"]==TRUE) {
						$respuesta["error"]=FALSE;			
						$respuesta["exito"]="Solicitud de pago enviada. Muchas gracias";
					}else{
						$respuesta["error"]=TRUE;
						cargaError($_GET["accion"],2);
					}
				}else{
					$respuesta["error"]=TRUE;
					cargaError($_GET["accion"],2);
				}				
											
		}						

		break;

	case 'pagos-por-entregas':
		
		/********** PAGOS POR ENTREGAS ***********/
		$respuesta["error"]=FALSE;

		if ($_GET["idEntrega"]==0) {
			$_SESSION["recargoentrega"]=0;
			$_SESSION["recargoentregaiva"]=0;			
		}else{
			$sql="SELECT `trama_medios-pagos`.*,
			`trama_medios-entrega`.importe as recargoentrega,
			`trama_medios-entrega`.iva as recargoentregaiva
			FROM `trama_medios-pagos`
			INNER JOIN `trama_pagos-entregas`
			ON `trama_medios-pagos`.id = `trama_pagos-entregas`.`idMedioPago`
			AND `trama_medios-pagos`.`activo` = 1 
			INNER JOIN `trama_medios-entrega`
			ON `trama_pagos-entregas`.`idMedioEntrega` = `trama_medios-entrega`.id
			AND `trama_medios-entrega`.`activo` = 1
			WHERE `trama_medios-entrega`.`id` = '".$_GET["idEntrega"]."'";
			$resultado=mysqli_query($mysqli, $sql);

			if($resultado->num_rows>0){
				$respuesta["exito"]=array();
				$respuesta["error"]=FALSE;
				for ($i=0; $i < $resultado->num_rows; $i++) { 
					$registro=mysqli_fetch_assoc($resultado);
					$registro=map($registro);
					array_push($respuesta["exito"], $registro);
				}

				$_SESSION["recargoentrega"]=$respuesta["exito"][0]["recargoentrega"];
				$_SESSION["recargoentregaiva"]=$respuesta["exito"][0]["recargoentregaiva"];

			}else{
				$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],0);
			}	
		}


							
	break;

	case 'cuotas-por-pagos':
		
		/********** CUOTAS POR PAGOS ***********/
		$respuesta["error"]=FALSE;

		$sql="SELECT `trama_cuotas-recargos`.*,
		`trama_medios-pagos`.pasarelaPago
		FROM `trama_cuotas-recargos`
		INNER JOIN `trama_medios-pagos`
		ON `trama_cuotas-recargos`.idMedioPago = `trama_medios-pagos`.id
		WHERE idMedioPago = '".$_GET["idPago"]."'";
		$resultado=mysqli_query($mysqli, $sql);

		if($resultado->num_rows>0){
			$respuesta["exito"]=array();
			$respuesta["error"]=FALSE;
			for ($i=0; $i < $resultado->num_rows; $i++) { 
				$registro=mysqli_fetch_assoc($resultado);
				$registro=map($registro);
				$_SESSION["pasarelaPago"]=$registro["pasarelaPago"];
				array_push($respuesta["exito"], $registro);
			}
		}else{
			$respuesta["error"]=TRUE;
			cargaError($_GET["accion"],0);
			$_SESSION["pasarelaPago"]=0;
		}	

							
	break;

	case 'recargo-medio-pago':
		
		/********** RECARGO POR MEDIOS DE PAGO ***********/
		$respuesta["error"]=FALSE;

		$sql="SELECT * FROM `trama_medios-pagos`
		WHERE activo = 1
		AND id = '".$_GET["medioPago"]."'";
		$resultado=mysqli_query($mysqli, $sql);

		if($resultado->num_rows === 1){

			$respuesta["error"]=FALSE;
			$registro=mysqli_fetch_assoc($resultado);
			$registro=map($registro);
			$respuesta["exito"] = $registro["recargo"];

		}else{

			$respuesta["error"]=TRUE;

		}	

							
	break;	

	case 'importe-checkout':
		
		/********** IMPORTE CHECKOUT ***********/
		$respuesta["error"]=FALSE;

		if ($_GET["idCuota"]==0) {
			$_SESSION["recargoPago"]=0;
		}else{

			$sql="SELECT * FROM `trama_cuotas-recargos`
			WHERE id = '".$_GET["idCuota"]."'";
			$resultado=mysqli_query($mysqli, $sql);

			if($resultado->num_rows===1){
				$respuesta["exito"]=array();
				$respuesta["error"]=FALSE;
				for ($i=0; $i < $resultado->num_rows; $i++) { 
					$registro=mysqli_fetch_assoc($resultado);
					$registro=map($registro);
					
					$_SESSION["recargoPago"]=$registro["recargo"];
					$_SESSION["cuotas"]=$registro["cuotas"];					

				}

			}else{
				$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],0);
			}

		}

		$acumuladosinformato=$_SESSION["acumuladosinformato"];
		$ivasinformato=$_SESSION["ivasinformato"];

		if (!isset($_SESSION["recargoentrega"])) {
			$_SESSION["recargoentrega"]=0;
		}

		if (!isset($_SESSION["recargoentregaiva"]) || $_SESSION["recargoentregaiva"]=="") {
			$_SESSION["recargoentregaiva"]=0;
		}		
				
		if (sesion()) {
			$CalculaIva=$_SESSION["CalculaIvaC"];
			$DiscriminaIva=$_SESSION["DiscriminaIvaC"];				
		}else{
			$CalculaIva=1;
			$DiscriminaIva=0;					
		}

		if ($CalculaIva==1 && $DiscriminaIva==1){

			$_SESSION["subtotalrecargoentrega"]=$_SESSION["recargoentrega"];
			$_SESSION["subtotalrecargoentregaiva"]=$_SESSION["recargoentrega"] * $_SESSION["recargoentregaiva"] / 100;

			$respuesta["exito"]["recargoentrega"]= formatearPrecio($_SESSION["subtotalrecargoentrega"]);
			$respuesta["exito"]["recargoentregaiva"]= formatearPrecio($_SESSION["subtotalrecargoentregaiva"])." (% ".$_SESSION["recargoentregaiva"].")";

			$_SESSION["subtotalrecargopago"]=($acumuladosinformato * $_SESSION["recargoPago"] / 100) + ($_SESSION["subtotalrecargoentrega"] * $_SESSION["recargoPago"] / 100);
			$_SESSION["subtotalrecargopagoiva"]=($ivasinformato * $_SESSION["recargoPago"] / 100) + ($_SESSION["subtotalrecargoentregaiva"] * $_SESSION["recargoPago"] / 100);	

			$respuesta["exito"]["recargopago"]= formatearPrecio($_SESSION["subtotalrecargopago"])." (% ".$_SESSION["recargoPago"].")";
			$respuesta["exito"]["recargopagoiva"]= formatearPrecio($_SESSION["subtotalrecargopagoiva"])." (% ".$_SESSION["recargoPago"].")";

			$_SESSION["total"]=$acumuladosinformato+$_SESSION["subtotalrecargoentrega"]+$_SESSION["subtotalrecargopago"];
			$_SESSION["totaliva"]=$ivasinformato+$_SESSION["subtotalrecargoentregaiva"]+$_SESSION["subtotalrecargopagoiva"];

			$_SESSION["totalfinal"]=$_SESSION["total"]+$_SESSION["totaliva"];

			$respuesta["exito"]["total"]= formatearPrecio($_SESSION["total"]);
			$respuesta["exito"]["totaliva"]= formatearPrecio($_SESSION["totaliva"]);

		}else{

			$_SESSION["subtotalrecargoentrega"]=$_SESSION["recargoentrega"] + ($_SESSION["recargoentrega"] * $_SESSION["recargoentregaiva"] / 100);
			$_SESSION["subtotalrecargoentregaiva"]=0;						

			$respuesta["exito"]["recargoentrega"]= formatearPrecio($_SESSION["subtotalrecargoentrega"]);			
			$respuesta["exito"]["recargoentregaiva"]=formatearPrecio($_SESSION["subtotalrecargoentregaiva"]);

			$_SESSION["subtotalrecargopago"]=($acumuladosinformato * $_SESSION["recargoPago"] / 100) + ($_SESSION["subtotalrecargoentrega"] * $_SESSION["recargoPago"] / 100);
			$_SESSION["subtotalrecargopagoiva"]=($ivasinformato * $_SESSION["recargoPago"] / 100) + ($_SESSION["subtotalrecargoentregaiva"] * $_SESSION["recargoPago"] / 100);	

			$respuesta["exito"]["recargopago"]= formatearPrecio($_SESSION["subtotalrecargopago"])." (% ".$_SESSION["recargoPago"].")";
			$respuesta["exito"]["recargopagoiva"]= formatearPrecio($_SESSION["subtotalrecargopagoiva"])." (% ".$_SESSION["recargoPago"].")";

			$_SESSION["total"]=$acumuladosinformato+$_SESSION["subtotalrecargoentrega"]+$_SESSION["subtotalrecargopago"];
			$_SESSION["totaliva"]=$ivasinformato+$_SESSION["subtotalrecargoentregaiva"]+$_SESSION["subtotalrecargopagoiva"];

			$_SESSION["totalfinal"]=$_SESSION["total"];

			$respuesta["exito"]["total"]= formatearPrecio($_SESSION["total"]);
			$respuesta["exito"]["totaliva"]= formatearPrecio($_SESSION["totaliva"]);		
		}
							
	break;

	case 'feedinstagram':
		
		/********** FEED INSTAGRAM ***********/
							
		$registro=file_get_contents('https://api.instagram.com/v1/users/self/media/recent/?access_token='.$GLOBALS["configuracion"]["redessociales"]["instagramtoken"]);
		$respuesta["error"]=FALSE;
		$respuesta["exito"]=json_decode($registro);

	break;

	case 'remitos':
		
		/********** REMITOS ***********/
		$respuesta["error"]=FALSE;
		
		if (!isset($_SESSION["idUsuario"])) {
			$respuesta["error"]=TRUE;
			cargaError($_GET["accion"],0);															
		}else{

			$sql="SELECT * FROM remitos
			WHERE Cliente = '".$_SESSION["idUsuario"]."'
			ORDER BY id_Remito DESC";

			$resultado=mysqli_query($mysqliext0, $sql);

			if(!$resultado){
				$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],1);
			}else{
				$respuesta["exito"]=array();
				$respuesta["error"]=FALSE;
				
				for ($i=0; $i < $resultado->num_rows; $i++) {
					$registro=mysqli_fetch_assoc($resultado);
					$registro=map($registro);

					$registro["Fecha"]=date("d-m-Y",strtotime($registro["Fecha"]));
					$registro["Transporte"]=ucwords(mb_strtolower($registro["Transporte"], 'UTF-8'));			
					$registro["estado"]=$GLOBALS["configuracion"]["estadosremitos"][$registro["estado"]];

					array_push($respuesta["exito"], $registro);
				}
			}	
		}
							
	break;

	case 'detalle-remito':
		
		/********** DETALLE REMITO ***********/
		$respuesta["error"]=FALSE;
		
		if (!isset($_SESSION["idUsuario"])) {
			$respuesta["error"]=TRUE;
			cargaError($_GET["accion"],0);															
		}else{

			$sql="select `remitos_detalle`.*,
						`productos`.denominacion
						FROM `remitos_detalle`
						INNER JOIN productos
						ON productos.Id_Productos = remitos_detalle.descripcion
						WHERE remitos_detalle.remitoCabecera='".$_GET["idRemito"]."'";

			$resultado=mysqli_query($mysqliext0, $sql);

			if(!$resultado){
				$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],1);
			}else{
				$respuesta["exito"]=array();
				$respuesta["error"]=FALSE;

				for ($i=0; $i < $resultado->num_rows; $i++) { 
					$registro=mysqli_fetch_assoc($resultado);
					$registro=map($registro);
					array_push($respuesta["exito"], $registro);
				}
			}	
		}
							
	break;

	case 'lista-precios':
		
		/********** LISTA PRECIOS ***********/
		$respuesta["error"]=FALSE;
		
		if (!isset($_SESSION["idUsuario"])) {
			$respuesta["error"]=TRUE;
			cargaError($_GET["accion"],0);															
		}else{

			$sql="SELECT * FROM dbo_articulo
			ORDER BY
			DescrNivelInt4,
			DescrNivelInt3,
			DescrNivelInt2,
			DescripcionArti";

			$resultado=mysqli_query($mysqli, $sql);

			if(!$resultado){
				$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],1);
			}else{
				$respuesta["exito"]=array();
				$respuesta["error"]=FALSE;

				for ($i=0; $i < $resultado->num_rows; $i++) { 
					$registro=mysqli_fetch_assoc($resultado);
					$registro=map($registro);

					$registro["PrecioVta1_PreArti"]=precioCliente($registro["PrecioVta1_PreArti"],$registro["TasaIva"]);			
					
					if ($_SESSION["CalculaIvaC"]==1 && $_SESSION["DiscriminaIvaC"]==1) {
						$registro["importeIva"] = $registro["PrecioVta1_PreArti"] * $registro["TasaIva"] / 100;
					}

					$registro["PrecioVta1_PreArti"]=formatearPrecio($registro["PrecioVta1_PreArti"]);
					$registro["importeIva"]=formatearPrecio($registro["importeIva"]);

					array_push($respuesta["exito"], $registro);
				}

					$respuesta["adicionales"]["CalculaIvaC"]=$_SESSION["CalculaIvaC"];
					$respuesta["adicionales"]["DiscriminaIvaC"]=$_SESSION["DiscriminaIvaC"];
			}	
		}
							
	break;

	case 'listar-mensajes':
		
		/********** LISTAR MENSAJES ***********/
		$respuesta["error"]=FALSE;
		
		if (!isset($_SESSION["idUsuario"])) {
			$respuesta["error"]=TRUE;
			cargaError($_GET["accion"],0);															
		}else{

			$sql="(SELECT
			walger_ofertas.*,
			1 AS 'espublico',
			`trama_mensajes-publicos-leidos`.id
			FROM walger_ofertas
			LEFT JOIN `trama_mensajes-publicos-leidos`
			ON walger_ofertas.idOferta = `trama_mensajes-publicos-leidos`.idMensajePublico
			AND `trama_mensajes-publicos-leidos`.idCliente='".$_SESSION["idUsuario"]."'
			WHERE walger_ofertas.activo='S')
			UNION
			(SELECT
			`trama_mensajes-clientes`.id,
			`trama_mensajes-clientes`.mensaje,
			'S' AS 'activo',
			`trama_mensajes-clientes`.fecha,
			0 AS 'espublico',
			`trama_mensajes-clientes`.leido
			FROM `trama_mensajes-clientes`
			WHERE `trama_mensajes-clientes`.idCliente='".$_SESSION["idUsuario"]."')
			ORDER BY fecha desc";

			$resultado=mysqli_query($mysqli, $sql);

			if(!$resultado){
				$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],1);
			}else{
				$respuesta["exito"]=array();
				$respuesta["error"]=FALSE;

				for ($i=0; $i < $resultado->num_rows; $i++) { 
					$registro=mysqli_fetch_assoc($resultado);
					$registro=map($registro);
					$registro["fecha"]=date("d-m-Y", strtotime($registro["fecha"]));
					$registro["textoprevio"]=substr(strip_tags($registro["oferta"]),0,50)."...";
					array_push($respuesta["exito"], $registro);
				}
			}
		}
							
	break;

	case 'contador-mensajes':
		
		/********** LISTAR MENSAJES ***********/
		$respuesta["error"]=FALSE;
		
		if (!isset($_SESSION["idUsuario"])) {
			$respuesta["error"]=TRUE;
			cargaError($_GET["accion"],0);															
		}else{

			$sql="(SELECT
			walger_ofertas.*,
			1 AS 'espublico',
			`trama_mensajes-publicos-leidos`.id
			FROM walger_ofertas
			LEFT JOIN `trama_mensajes-publicos-leidos`
			ON walger_ofertas.idOferta = `trama_mensajes-publicos-leidos`.idMensajePublico
			AND `trama_mensajes-publicos-leidos`.idCliente='".$_SESSION["idUsuario"]."'			
			WHERE walger_ofertas.activo='S'
			AND (`trama_mensajes-publicos-leidos`.id=0 OR `trama_mensajes-publicos-leidos`.id IS NULL))
			UNION
			(SELECT
			`trama_mensajes-clientes`.id,
			`trama_mensajes-clientes`.mensaje,
			'S' AS 'activo',
			`trama_mensajes-clientes`.fecha,
			0 AS 'espublico',
			`trama_mensajes-clientes`.leido
			FROM `trama_mensajes-clientes`
			WHERE `trama_mensajes-clientes`.idCliente='R0043'
			AND (`trama_mensajes-clientes`.leido=0 OR `trama_mensajes-clientes`.leido IS NULL))
			ORDER BY fecha desc";

			$resultado=mysqli_query($mysqli, $sql);

			if(!$resultado){
				$respuesta["error"]=TRUE;
				cargaError($_GET["accion"],1);
			}else{
				$respuesta["exito"]=$resultado->num_rows;
				$respuesta["error"]=FALSE;
			}
		}
							
	break;	

	case 'cambiar-estado-mensaje':
		
		/********** CAMBIAR ESTADO MENSAJE ***********/		
		if (!isset($_SESSION["idUsuario"])) {
			$respuesta["error"]=TRUE;
			cargaError($_GET["accion"],0);	

		}else{

			if ($_GET["estadonuevo"]=="leido") {

				if ($_GET["tipo"]==1) {
					$sql="INSERT INTO
					`trama_mensajes-publicos-leidos`(
						`idMensajePublico`,
						`idCliente`
					) VALUES (
					'".$_GET["id"]."',
					'".$_SESSION["idUsuario"]."'
					)";

					mysqli_query($mysqli, $sql);

					if (mysqli_affected_rows($mysqli)>0) {
						$respuesta["error"]=FALSE;
					}else{
						$respuesta["error"]=TRUE;
						cargaError($_GET["accion"],1);						
					};
				}else{
					$sql="UPDATE
					`trama_mensajes-clientes`
					SET
					`leido`='1'
					WHERE  `id`='".$_GET["id"]."'";

					mysqli_query($mysqli, $sql);

					if (mysqli_affected_rows($mysqli)>0) {
						$respuesta["error"]=FALSE;
					}else{
						$respuesta["error"]=TRUE;
						cargaError($_GET["accion"],1);						
					};
				}
			}else{

				if ($_GET["tipo"]==1) {
					$sql="DELETE FROM
					`trama_mensajes-publicos-leidos` WHERE
					idMensajePublico='".$_GET["id"]."' AND
					idCliente='".$_SESSION["idUsuario"]."'";

					mysqli_query($mysqli, $sql);

					if (mysqli_affected_rows($mysqli)>0) {
						$respuesta["error"]=FALSE;
					}else{
						$respuesta["error"]=TRUE;
						cargaError($_GET["accion"],1);						
					};
				}else{
					$sql="UPDATE
					`trama_mensajes-clientes`
					SET
					`leido`='0'
					WHERE  `id`='".$_GET["id"]."'";

					mysqli_query($mysqli, $sql);

					if (mysqli_affected_rows($mysqli)>0) {
						$respuesta["error"]=FALSE;
					}else{
						$respuesta["error"]=TRUE;
						cargaError($_GET["accion"],1);						
					};
				}
			}
		}
							
	break;	

	default:

		break;
}
		echo (json_encode($respuesta, JSON_FORCE_OBJECT)) ;

 ?>