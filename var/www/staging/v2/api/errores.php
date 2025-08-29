<?php 

@include_once("../inc/configuracion.php");

$errores=array(
	"login"=>array(
		"Debe ingresar usuario",
		"Debe ingresar contraseña",
		"Usuario y/o contraseña inválidos"
	),
	"categorias"=>array(
		"No se encontraron Categorías"
	),
	"productosDestacados"=>array(
		"No se encontraron Productos Destacados"
	),
	"novedades"=>array(
		"No se encontraron Novedades"
	),
	"descargas"=>array(
		"No se encontraron Descargas"
	),
	"paginanovedades"=>array(
		"No se encontraron Novedades",
		"No hay más Novedades"
	),
	"formulario-contacto"=>array(
		"No se pudo enviar el mensaje",
		"No pudimos procesar su solicitud",
		"No pudimos procesar su solicitud"		
	),
	"restaurarcontrasena"=>array(
		"Debe ingresar una dirección de Email",
		"Por favor ingrese un correo válido",
		"Su email no está registrado en nuestro sistema",
		"No pudimos enviarle la nueva contraseña a su Email"		
	),
	"seguridad-password"=>array(
		"Contraseña demasiado corta, se requieren ".$GLOBALS["configuracion"]["passwords"]["largominimo"]." carcteres por lo menos",
		"Contraseña demasiado larga, el máximo es de ".$GLOBALS["configuracion"]["passwords"]["largomaximo"]." caracteres",
		"Debe incluir al menos un número en la Contraseña",
		"Debe incluir al menos una letra en la Contraseña",
		"Debe incluir al menos una mayúscula en la Contraseña",
		"Debe incluir al menos un símbolo en la Contraseña"						
	),
	"formulario-registro"=>array(
		"Las contraseñas no coinciden",
		"No se pudo solicitar el registro",
		"Hemos recibido su solicitud, pero no pudimos verificar su correo"
	),
	"formulario-editar-registro"=>array(
		"Las contraseñas no coinciden",
		"No se pudo solicitar la edición",
		"Hemos recibido su solicitud, pero no pudimos verificar su correo"
	),	
	"tipos-clientes"=>array(
		"No se encontraron Tipos de Clientes"
	),
	"clientes"=>array(
		"No se encontró Cliente"
	),
	"condiciones-iva"=>array(
		"No se encontraron condiciones de IVA"
	),		
	"suscribirse-newsletter"=>array(
		"Por favor ingrese un correo válido",
		"Su correo ya está registrado en el newsletter",
		"No pudimos procesar su solicitud",
		"Hemos recibido su solicitud, pero no pudimos verificar su correo"							
	),
	"productos-ordenamiento"=>array(
		"No se encontraron formas de ordenamiento"
	),
	"marcas"=>array(
		"No se encontraron marcas"
	),
	"lineas"=>array(
		"No se encontraron lineas"
	),	
	"productos"=>array(
		"No se encontraron Productos",
		"No hay más Productos"
	),
	"agregar-favoritos"=>array(
		"Para agregar productos a su lista de favoritos debe estar logueado. Si no posee un usuario puede registrarse mediante nuestro formulario de registro",
		"Ese producto ya está incluído en su lista de favoritos",
		"No pudimos procesar su solicitud",
		"El producto que intenta agregar a favoritos ya no existe"
	),
	"borrar-favoritos"=>array(
		"Por favor vuelva a loguearse para modificar su lista de favoritos",
		"No pudimos procesar su solicitud"
	),
	"favoritos-lateral"=>array(
		"El usuario no se encuentra logueado",
		"No tiene artículos en favoritos"
	),
	"cesta-lateral"=>array(
		"El usuario no se encuentra logueado",
		"No tiene artículos en el Carrito"
	),		
	"agregar-cesta"=>array(
		"Para modificar su cesta debe estar logueado. Si no posee un usuario puede registrarse mediante nuestro formulario de registro",
		"No pudimos procesar su solicitud",
		"El producto que intenta agregar a la cesta ya no existe"
	),
	"actualizar-cesta"=>array(
		"Para modificar su cesta debe estar logueado",
		"No pudimos procesar su solicitud"
	),	
	"borrar-cesta"=>array(
		"Para borrar productos de su cesta debe estar logueado",
		"No pudimos procesar su solicitud",
		"El producto que intenta borrar de la cesta ya no existe"
	),
	"contador-cesta"=>array(
		"Para calcular los productos de su cesta debe estar logueado",
		"No pudimos procesar su solicitud"
	),
	"confirmar-pedido"=>array(
		"Para confirmar el pedido debe estar logueado",
		"No pudimos procesar su solicitud",
		"No posee pedidos activos",
		"El pedido no contiene ningún producto",
		"No se pudo enviar el correo"			
	),
	"pedidos"=>array(
		"Para ver sus pedidos debe estar logueado",
		"No pudimos procesar su solicitud"			
	),
	"detalle-pedidos"=>array(
		"Para ver sus pedidos debe estar logueado",
		"No pudimos procesar su solicitud"			
	),
	"ultimos-comprados"=>array(
		"Para ver sus últimos items debe estar logueado",
		"No pudimos procesar su solicitud"			
	),
	"estado-cuenta"=>array(
		"Para ver su estado de cuenta debe estar logueado",
		"No pudimos procesar su solicitud"			
	),	
	"retornar-lineas"=>array(
		"No se encontraron lineas"
	),
	"estado-cuenta-pago"=>array(
		"Indique un importe mayor a cero",
		"Indique un medio de pago",
		"No se pudo procesar su pedido"				
	),
	"detalle-usuario"=>array(
		"No hay ningún usuario logueado"			
	),
	"medios-entrega"=>array(
		"No hay medios de entrega cargados"			
	),
	"medios-pago"=>array(
		"No hay medios de pago cargados"			
	),	
	"pagos-por-entregas"=>array(
		"No hay medios de pago para este medio de entrega"			
	),
	"cuotas-por-pagos"=>array(
		"No hay cuotas para este medio de pago"			
	),
	"recargo-por-cuota"=>array(
		"No se encontró la cuota seleccionada"			
	),
	"todopago"=>array(
		"99977"=>"Transaccion denegada por validador de TP",
		"98001"=>"ERROR: El campo CSBTCITY es requerido",
		"98002"=>"ERROR: El campo CSBTCOUNTRY es requerido",
		"98003"=>"ERROR: El campo CSBTCUSTOMERID es requerido",
		"98004"=>"ERROR: El campo CSBTIPADDRESS es requerido",
		"98005"=>"ERROR: El campo CSBTEMAIL es requerido",
		"98006"=>"ERROR: El campo CSBTFIRSTNAME es requerido",
		"98007"=>"ERROR: El campo CSBTLASTNAME es requerido",
		"98008"=>"ERROR: El campo CSBTPHONENUMBER es requerido",
		"98009"=>"ERROR: El campo CSBTPOSTALCODE es requerido",
		"98010"=>"ERROR: El campo CSBTSTATE es requerido",
		"98011"=>"ERROR: El campo CSBTSTREET1 es requerido",
		"98012"=>"ERROR: El campo CSBTSTREET2 es requerido",
		"98013"=>"ERROR: El campo CSPTCURRENCY es requerido",
		"98014"=>"ERROR: El campo CSPTGRANDTOTALAMOUNT es requerido",
		"98015"=>"ERROR: El campo CSMDD7 es requerido",
		"98016"=>"ERROR: El campo CSMDD8 es requerido",
		"98017"=>"ERROR: El campo CSMDD9 es requerido",
		"98018"=>"ERROR: El campo CSMDD10 es requerido",
		"98019"=>"ERROR: El campo CSMDD11 es requerido",
		"98020"=>"ERROR: El campo CSSTCITY es requerido",
		"98021"=>"ERROR: El campo CSSTCOUNTRY es requerido",
		"98022"=>"ERROR: El campo CSSTEMAIL es requerido",
		"98023"=>"ERROR: El campo CSSTFIRSTNAME es requerido",
		"98024"=>"ERROR: El campo CSSTLASTNAME es requerido",
		"98025"=>"ERROR: El campo CSSTPHONENUMBER es requerido",
		"98026"=>"ERROR: El campo CSSTPOSTALCODE es requerido",
		"98027"=>"ERROR: El campo CSSTSTATE es requerido",
		"98028"=>"ERROR: El campo CSSTSTREET1 es requerido",
		"98029"=>"ERROR: El campo CSMDD12 es requerido",
		"98030"=>"ERROR: El campo CSMDD13 es requerido",
		"98031"=>"ERROR: El campo CSMDD14 es requerido",
		"98032"=>"ERROR: El campo CSMDD15 es requerido",
		"98033"=>"ERROR: El campo CSMDD16 es requerido",
		"98034"=>"ERROR: El campo CSITPRODUCTCODE es requerido",
		"98035"=>"ERROR: El campo CSITPRODUCTDESCRIPTION es requerido",
		"98036"=>"ERROR: El campo CSITPRODUCTNAME es requerido",
		"98037"=>"ERROR: El campo CSITPRODUCTSKU es requerido",
		"98038"=>"ERROR: El campo CSITTOTALAMOUNT es requerido",
		"98039"=>"ERROR: El campo CSITQUANTITY es requerido",
		"98040"=>"ERROR: El campo CSITUNITPRICE es requerido",
		"98101"=>"ERROR: El formato del campo CSBTCITY es incorrecto",
		"98102"=>"ERROR: El formato del campo CSBTCOUNTRY es incorrecto",
		"98103"=>"ERROR: El formato del campo CSBTCUSTOMERID es incorrecto",
		"98104"=>"ERROR: El formato del campo CSBTIPADDRESS es incorrecto",
		"98105"=>"ERROR: El formato del campo CSBTEMAIL es incorrecto",
		"98106"=>"ERROR: El formato del campo CSBTFIRSTNAME es incorrecto",
		"98107"=>"ERROR: El formato del campo CSBTLASTNAME es incorrecto",
		"98108"=>"ERROR: El formato del campo CSBTPHONENUMBER es incorrecto",
		"98109"=>"ERROR: El formato del campo CSBTPOSTALCODE es incorrecto",
		"98110"=>"ERROR: El formato del campo CSBTSTATE es incorrecto",
		"98111"=>"ERROR: El formato del campo CSBTSTREET1 es incorrecto",
		"98112"=>"ERROR: El formato del campo CSBTSTREET2 es incorrecto",
		"98113"=>"ERROR: El formato del campo CSPTCURRENCY es incorrecto",
		"98114"=>"ERROR: El formato del campo CSPTGRANDTOTALAMOUNT es incorrecto",
		"98115"=>"ERROR: El formato del campo CSMDD7 es incorrecto",
		"98116"=>"ERROR: El formato del campo CSMDD8 es incorrecto",
		"98117"=>"ERROR: El formato del campo CSMDD9 es incorrecto",
		"98118"=>"ERROR: El formato del campo CSMDD10 es incorrecto",
		"98119"=>"ERROR: El formato del campo CSMDD11 es incorrecto",
		"98120"=>"ERROR: El formato del campo CSSTCITY es incorrecto",
		"98121"=>"ERROR: El formato del campo CSSTCOUNTRY es incorrecto",
		"98122"=>"ERROR: El formato del campo CSSTEMAIL es incorrecto",
		"98123"=>"ERROR: El formato del campo CSSTFIRSTNAME es incorrecto",
		"98124"=>"ERROR: El formato del campo CSSTLASTNAME es incorrecto",
		"98125"=>"ERROR: El formato del campo CSSTPHONENUMBER es incorrecto",
		"98126"=>"ERROR: El formato del campo CSSTPOSTALCODE es incorrecto",
		"98127"=>"ERROR: El formato del campo CSSTSTATE es incorrecto",
		"98128"=>"ERROR: El formato del campo CSSTSTREET1 es incorrecto",
		"98129"=>"ERROR: El formato del campo CSMDD12 es incorrecto",
		"98130"=>"ERROR: El formato del campo CSMDD13 es incorrecto",
		"98131"=>"ERROR: El formato del campo CSMDD14 es incorrecto",
		"98132"=>"ERROR: El formato del campo CSMDD15 es incorrecto",
		"98133"=>"ERROR: El formato del campo CSMDD16 es incorrecto",
		"98134"=>"ERROR: El formato del campo CSITPRODUCTCODE es incorrecto",
		"98135"=>"ERROR: El formato del campo CSITPRODUCTDESCRIPTION es incorrecto",
		"98136"=>"ERROR: El formato del campo CSITPRODUCTNAME es incorrecto",
		"98137"=>"ERROR: El formato del campo CSITPRODUCTSKU es incorrecto",
		"98138"=>"ERROR: El formato del campo CSITTOTALAMOUNT es incorrecto",
		"98139"=>"ERROR: El formato del campo CSITQUANTITY es incorrecto",
		"98140"=>"ERROR: El formato del campo CSITUNITPRICE es incorrecto",
		"98201"=>"ERROR: Existen errores en la información de los productos",
		"98202"=>"ERROR: Existen errores en la información de CSITPRODUCTDESCRIPTION los productos",
		"98203"=>"ERROR: Existen errores en la información de CSITPRODUCTNAME los productos",
		"98204"=>"ERROR: Existen errores en la información de CSITPRODUCTSKU los productos",
		"98205"=>"ERROR: Existen errores en la información de CSITTOTALAMOUNT los productos",
		"98206"=>"ERROR: Existen errores en la información de CSITQUANTITY los productos",
		"98207"=>"ERROR: Existen errores en la información de CSITUNITPRICE de los productos"
	)
)

 ?>