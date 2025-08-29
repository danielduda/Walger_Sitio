<?php 

include_once("inc.php");

@$GLOBALS["configuracion"]=
array(		
	"metas"=>array(
		"title"=>"WALGER TIENDA VIRTUAL",
		"description"=>"ecommerce",
		"author"=>"Trama Solutions",
		"favicon"=>"favicon.ico",
	),
/*------------------------------------------------------*/
	"analytics"=>"UA-7680832-2",
/*------------------------------------------------------*/
	"mysql"=>array(
		"servidor"=>"localhost",
		"usuario"=>"root",
		"contrasena"=>"walger0000",
		"base"=>"walger_stg"	
	),
	"conexionesexternas"=>
		array(
			array(
				"servidor"=>"localhost",
				"usuario"=>"root",
				"contrasena"=>"walger0000",
				"base"=>"gestion_walger"				
			)
		),
/*------------------------------------------------------*/
	"todopago"=>array(
		"test"=>array(
			"Merchant"=>"",
			"Security"=>""
		),
		"prod"=>array(
			"Merchant"=>"",
			"Security"=>""			
		),
		"modo"=>"",
	),
/*------------------------------------------------------*/
	"mercadopago"=>array(
		"credenciales"=>array(
			"CLIENT_ID"=>"2681156277615969",
			"CLIENT_SECRET"=>"RjlRb6MFBTyGd0ASfQ0AP8OEIvRns3Rd"
		),
		"modo"=>"test",
	),
/*------------------------------------------------------*/	
	"redessociales"=>array(
		"instagramtoken"=>"",
		"nombrefacebook"=>"",
		"titulofacebook"=>"",
		"imagenfacebook"=>"",
		"textoproducto"=>"",
		"botonesfacebook"=>FALSE
	),	
/*------------------------------------------------------*/
	"brand"=>
	array(
		"colores"=>
		array(
			"#c9302c",
			"#286090",
			"#323232"
		),
		"logo"=>"Logo_Walger.png",
		"fuentes"=>
		array(
			"Verdana",
		)
	),
/*------------------------------------------------------*/	
	"captchasecret"=>"6LfJsBIUAAAAANd6BNwhvgNKSKKoRAIvk3lBRVQ3",
	"captchasitekey"=>"6LfJsBIUAAAAABGnV8OxyKxeP0eY20kxZjptq51g",
/*------------------------------------------------------*/	
	"limitelogmails"=>100,
/*------------------------------------------------------*/	
	"carpetaimagenes"=>"img/",
	"carpetaupload"=>"img/",
	"carpetadescargas"=>"descargas/",
	"carpetauploadremoto"=>"http://servidor.walger.com.ar/articulos/",
	"carpetapdffacturas"=>"/home/fcisis/",
/*------------------------------------------------------*/
	"pdffacturas"=>TRUE,
/*------------------------------------------------------*/
	"descargarlistadeprecios"=>TRUE,
/*------------------------------------------------------*/
	"host"=>"servidor.walger.com.ar/staging/v2",
/*------------------------------------------------------*/
	"checkout"=>FALSE,
/*------------------------------------------------------*/
	"registroautomatico"=>FALSE,
	"registroautomaticoconsumidorfinal"=>TRUE,	
/*------------------------------------------------------*/			
	"passwords"=>
	array(
		"largominimo"=>8,
		"largomaximo"=>10,
		"requiereletras"=>TRUE,
		"requierenumeros"=>TRUE,
		"requieremayusculas"=>TRUE,
		"requieresimbolos"=>TRUE
	),
/*------------------------------------------------------*/	
	"precios"=>
	array(
		"cantidaddecimales"=>2,
		"separadordecimales"=>".",
		"separadormiles"=>""
	),
/*------------------------------------------------------*/		
	"contactos"=>
	array(
		array(
			"denominacion"=>"Teléfono",
			"icono"=>"fa-phone",
			"valor"=>"5411-4854-0360",
			"etiqueta"=>"h4",
			"clases"=>"mayuscula bold"

		),
		array(
			"denominacion"=>"Whatsapp",
			"icono"=>"fa-whatsapp",
			"valor"=>"+54 9 11-6094-3285",
			"etiqueta"=>"h4",
			"clases"=>"mayuscula bold"

		),
		array(
			"denominacion"=>"Email",
			"icono"=>"fa-envelope-o",
			"valor"=>"ventas@walger.com.ar",
			"etiqueta"=>"h6",
			"clases"=>"mayuscula bold",
			"link"=>"mailto:ventas@walger.com.ar"
		),
		array(
			"denominacion"=>"Domicilio",
			"icono"=>"fa-map-marker",
			"valor"=>"HIDALGO 1736 (C1414CAP) - CABA ARGENTINA",
			"etiqueta"=>"h6",
			"clases"=>"mayuscula"

		)
	),
/*------------------------------------------------------*/		
	"dias"=>
	array(
		"De Lunes a Viernes"=>
		array(
			"abierto"=>TRUE,
			"horario"=>
			array(
				array(8,18)
			)
		),
		"Sábados"=>
		array(
			"abierto"=>FALSE,
		),
		"Domingos"=>
		array(
			"abierto"=>FALSE
		)		
	),
/*------------------------------------------------------*/
	"carrito"=>TRUE,
	"buscador"=>TRUE,
	"menulateral"=>TRUE,
/*------------------------------------------------------*/			
	"menusinlogin"=>
	array(
		"items"=>
		array(
			array(
				"subitems"=>FALSE,
				"titulo"=>'<i class="fa fa-home" aria-hidden="true"></i>',
				"link"=>"index.php"
			),
			array(
				"subitems"=>FALSE,
				"titulo"=>"Catálogo",
				"link"=>"productos.php?categoria="
			),			
			array(
				"subitems"=>FALSE,
				"titulo"=>"Servicios",
				"link"=>"servicios.php"
			),
			array(
				"subitems"=>FALSE,
				"titulo"=>"Portfolio",
				"link"=>"portfolio.php"
			),
			array(
				"subitems"=>FALSE,
				"titulo"=>"Novedades",
				"link"=>"novedades.php"
			),
			array(
				"subitems"=>FALSE,
				"titulo"=>"Formas de Pago",
				"link"=>"formaspago.php"
			),
			array(
				"subitems"=>FALSE,
				"titulo"=>"Contacto",
				"link"=>"contacto.php"
			)															
		)
	),
	"menuconlogin"=>
	array(
		"items"=>
		array(
			array(
				"subitems"=>FALSE,
				"titulo"=>'<i class="fa fa-home" aria-hidden="true"></i>',
				"link"=>"index.php"
			),
			array(
				"subitems"=>array(
					array(
						"subitems"=>FALSE,
						"titulo"=>"Catálogo Completo",
						"link"=>"productos.php?categoria="						
					),
					array(
						"subitems"=>FALSE,
						"titulo"=>"Favoritos",
						"link"=>"productos.php?categoria=&favoritos=true"						
					),					
				),
				"titulo"=>"Catálogo",
				"link"=>"productos.php?categoria="
			),			
			array(
				"subitems"=>FALSE,
				"titulo"=>"Servicios",
				"link"=>"servicios.php"
			),
			array(
				"subitems"=>FALSE,
				"titulo"=>"Descargas",
				"link"=>"descargas.php"
			),
			array(
				"subitems"=>FALSE,
				"titulo"=>"Novedades",
				"link"=>"novedades.php"
			),
			array(
				"subitems"=>FALSE,
				"titulo"=>"Contacto",
				"link"=>"contacto.php"
			),
			array(
				"subitems"=>array(
					array(
						"subitems"=>FALSE,
						"titulo"=>"Pedidos",
						"link"=>"pedidos.php"						
					),
					array(
						"subitems"=>FALSE,
						"titulo"=>"Últimos Items Comprados",
						"link"=>"ultimoscomprados.php"						
					),
					array(
						"subitems"=>FALSE,
						"titulo"=>"Remitos",
						"link"=>"remitos.php"						
					),
					array(
						"subitems"=>FALSE,
						"titulo"=>"Estado de Cuenta",
						"link"=>"estadocuenta.php"
					),															
				),
				"titulo"=>"Mi Cuenta",
				"link"=>"#"
			),																		
		)
	),
	"menumicuenta"=>
	array(
		"items"=>
		array(
			array(
				"titulo"=>'Editar Mi Cuenta',
				"link"=>"editarcuenta.php"
			),
			array(
				"titulo"=>"Favoritos",
				"link"=>"productos.php?categoria=&favoritos=true"
			),			
			array(
				"titulo"=>"Carrito",
				"link"=>"carrito.php"
			),
			array(
				"titulo"=>"Estado de Cuenta",
				"link"=>"estadocuenta.php"
			),
			array(
				"titulo"=>"Remitos",
				"link"=>"remitos.php"
			),
			array(
				"titulo"=>'Mensajes <span style="display:none" id="alerta-mensajes"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></span>',
				"link"=>"mensajes.php"
			),								
			array(
				"titulo"=>"Salir",
				"link"=>"javascript:void(0)",
				"atributos"=>array(
					"onclick"=>"logout()"
				)
			)														
		)
	),
/*------------------------------------------------------*/		
	"estadodecuenta"=>TRUE,
/*------------------------------------------------------*/		
	"slider"=>
	array(
		"activo"=>TRUE,
		"altura"=>"500px"								
	),
/*------------------------------------------------------*/		
	"categorias"=>TRUE,
	"productosnovedades"=>TRUE,	
	"destacados"=>TRUE,
	"novedades"=>TRUE,
	"newsletter"=>TRUE,
	"mapa"=>
	array(
		"activo"=>TRUE,
		"altura"=>"366px",
		"src"=>"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3284.0950792328713!2d-58.44819158469418!3d-34.60175718045997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95bcca0ea8db2c39%3A0x63ee69ee1037457!2sHidalgo+1736%2C+C1414CAR+CABA!5e0!3m2!1ses!2sar!4v1482466509282"
	),
/*------------------------------------------------------*/		
	"paginanovedades"=>
	array(
		"resultadosDevueltos"=>3,
		"limiteCaracteresContenidoPrevio"=>50
	),
/*------------------------------------------------------*/		
	"portfolio"=>1,	
	"estilocategorias"=>1,	
/*------------------------------------------------------*/		
	"email"=>
	array(
		"asuntos"=>array(
			"contactoadministracion"=>"Mensaje desde Formulario de Contacto",
			"contactocliente"=>"Gracias por su contacto",
			"cambiodecontrasenacliente"=>"Cambio de Contraseña",
			"registroadministracion"=>"Usuario Registrado",
			"registrocliente"=>"Solicitud de Registro generada",
			"ediciondatosadministracion"=>"Edición de datos de Registro",
			"ediciondatoscliente"=>"Solicitud de Edición de Registro generada",
			"newsletteradministracion"=>"Nuevo usuario para Newsletter",
			"newslettercliente"=>"Bienvenido a nuestro Newsletter",
			"nuevopedidoadministracion"=>"Nuevo Pedido Web - Nro. ",
			"nuevopagoadministracion"=>"Mi Cuenta - Pago",
			"nuevopagocliente"=>"Walger - Mi Cuenta - Pago",
			"pagoacreditadoadministracion"=>"Pago Acreditado",
			"pagoacreditadocliente"=>"Pago Acreditado"
		),
		"emailadministracion"=>"administracionventas@walger.com.ar",
		"nombreadministracion"=>"Administración",
		"emailenvia"=>"administracionventas@walger.com.ar",
		"nombreenvia"=>"Walger - Tienda Virtual",
		"norespondermail"=>"noresponder@walger.com.ar",
		"norespondernombre"=>"noresponder",
		"host"=>"smtp.gmail.com",
		"usuario"=>"walgersrl",
		"password"=>"c8697400",
		"seguridad"=>"tls",
		"puerto"=>587
	),
/*------------------------------------------------------*/		
	"productos"=>
	array(
		"altoimagen"=>"auto",
		"selectorenbreadcrumb"=>TRUE,
		"muestratitulo"=>FALSE,
		"selectorenpanel"=>FALSE,
		"mostrarlineasencategorias"=>TRUE,		
		"mostrarlineasenfiltros"=>FALSE,		
		"detallemodal"=>FALSE,
		"listadepreciosdefault"=>2,
		"monedadefault"=>1,
		"mostrardefault"=>"grilla",
		"tipocontador"=>"COUNT",
		"detalleproducto"=>array(
			"mostrardetalle"=>FALSE,
			"descripcion"=>FALSE
		),		
		"formasordenamiento"=>
			array(
				array(
					"denominacion"=>"Nombre A-Z",
					"campo"=>"DescripcionArti",
					"tipo"=>"ASC"
				)						
			),
		"resultadosDevueltos"=>20,
		"muestrasinexistencia"=>TRUE,
		"textosinexistencia"=>"Consultar",
		"comprarsinexistencia"=>TRUE,
		"avisopocaexistencia"=>TRUE,
		"textopocaexistencia"=>"Consultar disponibilidad de este Producto",
		"cantidadpocaexistencia"=>1,		
		"campostock"=>"Stock1_StkArti",
		"imagennodisponible"=>"imagen no disponible.jpg",
		"filtros"=>
		array(												
			array(
				"denominacion"=>"Marca",
				"id"=>"marca",
				"campo"=>"DescrNivelInt2",
				"filtro"=>"=",
				"tipo"=>"select",
				"origendatos"=>"retornarMarcas",
				"valor"=>"DescrNivelInt2",
				"texto"=>"DescrNivelInt2",
				"atributos"=>
				array(
					"onchange"=>"seleccionamarca(this)"
				)
			),
			array(
				"denominacion"=>"",
				"id"=>"linea",
				"campo"=>"DescrNivelInt3",
				"filtro"=>"=",
				"tipo"=>"input",
				"atributos"=>
				array(
					"type"=>"hidden",
					"value"=>$_GET["linea"]
				)
			),
			array(
				"denominacion"=>"",
				"id"=>"descripcion",
				"campo"=>"CONCAT (`CodInternoArti`,`CodBarraArti`,`DescrNivelInt4`,`DescrNivelInt3`,`DescrNivelInt2`,`DescripcionArti`,`NombreFotoArti`)",
				"filtro"=>"buscador",
				"tipo"=>"input",
				"atributos"=>
				array(
					"type"=>"hidden",
					"value"=>$_GET["descripcion"]
				)
			),
			array(
				"denominacion"=>"",
				"id"=>"codigo",
				"campo"=>"CodInternoArti",
				"filtro"=>"=",
				"tipo"=>"input",
				"atributos"=>
				array(
					"type"=>"hidden",
					"value"=>$_GET["codigo"]
				)
			),										
			array(
				"denominacion"=>"",
				"id"=>"categoria",
				"campo"=>"DescrNivelInt4",
				"filtro"=>"=",
				"tipo"=>"input",
				"atributos"=>
				array(
					"type"=>"hidden",
					"value"=>$_GET["categoria"]
				)
			)					
		)
	),
/*------------------------------------------------------*/		
	"permiteinvitado"=>FALSE,
/*------------------------------------------------------*/			
	"categoriasinicio"=>array(
		"accionboton"=>"modal"
	),
/*------------------------------------------------------*/			
	"estadospedidos"=>
	array(
		"N"=>"No Confirmado",
		"P"=>"Pendiente",
		"F"=>"Facturado",
		"C"=>"Cancelado",
		"X"=>"Confirmado sin entregar",
		"E"=>"En preparación"
	),
	"estadosremitos"=>
	array(
		"En Trámite",
		"Finalizado",
		"Anulado",
		"Editable"
	),
/*------------------------------------------------------*/			
	"limiteultimoscomprados"=>50,
/*------------------------------------------------------*/			
	"diasvencimientotransaccion"=>30,
/*------------------------------------------------------*/			
	"textos"=>
	array(
		"tituloportfolio"=>"Portfolio",
		"bienvenido"=>"¡ Bienvenido a nuestro Ecommerce !",
		"formasdepago"=>
		array(
			0=>
			array(
				"titulo"=>'',				
				"detalle"=>'Para evitar demoras y riesgos de envió en los pagos, solicitamos tengan la amabilidad de hacer efectivo el pago de las facturas en nuestras cuentas corrientes de los siguientes bancos.'
			),
			1=>
			array(
				"titulo"=>'BANCO CREDICOOP COOPERATIVO LTDO',
				"detalle"=>'Sucursal Nº 031 Cuenta Corriente 27873/5 a la orden de WALGER SRL <br>CBU 19100315-55003102787350<br>ALIAS WALGERCREDICOOP'
			),
			2=>
			array(
				"titulo"=>'BANCO NACIÓN ARGENTINA',
				"detalle"=>'Sucursal Villa Crespo Cuenta Corriente 2300053/95 a la orden de WALGER SRL <br>CBU 01100235-20002300053951<br>ALIAS WALGERSRLBNA'
			),
			3=>
			array(
				"titulo"=>'NUESTRO NÚMERO DE CUIT',
				"detalle"=>'CUIT 30-66109877-1'
			),
			4=>
			array(
				"titulo"=>'',
				"detalle"=>'Desde ya agradecemos su valiosa colaboración y el envío por fax del cupón de depósito.'
			),												
		),
		"servicios"=>
		array(
			0=>
			array(
				"titulo"=>'Atención Telfónica',				
				"detalle"=>'Le brindamos atención personalizada, con personal capacitado, que lo asesorará para lograr la efectividad en vuestras consultas'
			),
			1=>
			array(
				"titulo"=>'Amplio Stock',
				"detalle"=>'Contamos con más de 7000 items, gran Varuedad de líneas de productos tanto nacionales como importados, todas de alta calidad y prestigio'
			),
			2=>
			array(
				"titulo"=>'Servicio de Entrega',
				"detalle"=>'Ponemos a vuestra disposición, una estructura logística que le permitirá disponer de nuestro stock dentro de las 24 hs en el ámbito nacional',
			),
			3=>
			array(
				"titulo"=>'Exportación',
				"detalle"=>'Servicio de consolidación, siendo nexo con más de 25 fábricas Nacionales con calidad y prestigio internacional'
			),
			4=>
			array(
				"titulo"=>'Información Online',
				"detalle"=>'Ponemos a vuestra disposición nuestra Tienda Online, la que le brinda actualización de precios y stock, acceso a vuestra Cuenta Corriente, estados de envío, en desarrollo permanente para poder darle un servicio cada día mejor, acorde al avance de la tecnología.'
			),												
		),
	),
/*------------------------------------------------------*/
	"mododebug"=>TRUE,
	"emaildebug"=>"proveedores@walger.com.ar",
/*------------------------------------------------------*/
/*------------------------------------------------------*/
);

 ?>