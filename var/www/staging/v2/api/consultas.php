<?php 

include_once("api/connect.php");
include_once("api/errores.php");
include_once("api/funciones.php");
include_once("inc/inc.php");
include_once("inc/sesion.php");


		
/********** CATEGORIAS ***********/

function retornarCategorias(){

	global $mysqli;
	global $errores;

	$respuesta =array();
	$respuesta["exito"] =array();
	$respuesta["errores"]["coderror"] =array();
	$respuesta["errores"]["mensajeerror"] =array();

	$sql = "SELECT *
		FROM  `trama_categorias-productos`";
	$resultado = mysqli_query($mysqli, $sql);

	if ($resultado->num_rows>0) {
		$respuesta["error"] = FALSE;
		for ($i = 0; $i < $resultado->num_rows; $i++) { 

			$registro = mysqli_fetch_assoc($resultado);
			$registro = map($registro);			
			array_push($respuesta["exito"], $registro);
		}
	}else{
		$respuesta["error"] = TRUE;
		$tipo = "categorias";
		$codigo = 0;
		array_push($respuesta["errores"]["coderror"], $tipo.$codigo);
		array_push($respuesta["errores"]["mensajeerror"], $errores[$tipo][$codigo]);		
	}		

	return $respuesta ;
}

/********** LINEAS ***********/

function retornarLineas($categoria){

	global $mysqli;
	global $errores;

	$respuesta =array();
	$respuesta["exito"] =array();
	$respuesta["errores"]["coderror"] =array();
	$respuesta["errores"]["mensajeerror"] =array();

	if ($categoria != "") {
		$where="WHERE DescrNivelInt4='".$categoria."'";
	}else{
		$where="";
	}

	$sql = "SELECT 
		distinct(DescrNivelInt3) as 'linea'
		FROM  `dbo_articulo`
		".$where;
	$resultado = mysqli_query($mysqli, $sql);

	if ($resultado->num_rows>0) {
		$respuesta["error"] = FALSE;
		for ($i = 0; $i < $resultado->num_rows; $i++) { 

			$registro = mysqli_fetch_assoc($resultado);
			$registro = map($registro);
			$registro["linea"]=ucwords(mb_strtolower($registro["linea"], 'UTF-8'));			
			array_push($respuesta["exito"], $registro);
		}
	}else{
		$respuesta["error"] = TRUE;
		$tipo = "lineas";
		$codigo = 0;
		array_push($respuesta["errores"]["coderror"], $tipo.$codigo);
		array_push($respuesta["errores"]["mensajeerror"], $errores[$tipo][$codigo]);		
	}		

	return $respuesta ;
}

/********** PRODUCTOS DESTACADOS ***********/

function retornarProductosDestacados($tipo){

	global $mysqli;
	global $errores;

	$respuesta =array();
	$respuesta["exito"] =array();
	$respuesta["errores"]["coderror"] =array();
	$respuesta["errores"]["mensajeerror"] =array();

	if (isset($_SESSION["idUsuario"])) {
		$favoritos="AND idUsuario='".$_SESSION["idUsuario"]."'";
	}else{
		$favoritos="AND idUsuario IS NULL";			
	}


	$where=$tipo=="ofertas"? "wa.Oferta = 'S'": "wa.Novedad = 'S'";			

	$sql = "SELECT wa.*,
		da.*,
		t1.`precio` as 'minimo',
    t2.`precio` as 'maximo',		
		trama_favoritos.*
		FROM `walger_articulos` as wa
		INNER JOIN dbo_articulo as da
		ON wa.CodInternoArti = da.CodInternoArti
		LEFT JOIN trama_favoritos
		ON da.`CodInternoArti` = trama_favoritos.`idArticulo`".$favoritos."
		LEFT JOIN `trama_articulos-valores-stock-precio` as t1 on (
		    da.CodInternoArti = t1.`idArticulo` 
		    and t1.`precio`  = (
		        select min(precio)
		        from `trama_articulos-valores-stock-precio`
		        where idArticulo=da.CodInternoArti
		    ) 
		)
		LEFT JOIN `trama_articulos-valores-stock-precio` as t2 on (
		    da.CodInternoArti = t2.`idArticulo` 
		    and t2.`precio`  = (
		        select max(precio)
		        from `trama_articulos-valores-stock-precio`
		        where idArticulo=da.CodInternoArti
		    ) 
		)		 
		WHERE ".$where."
		GROUP BY da.CodInternoArti
		LIMIT 4";

	$resultado = mysqli_query($mysqli, $sql);

	if ($resultado->num_rows > 0) {
		$respuesta["error"] = FALSE;

		$tiposarticulos=array();
		
		for ($i = 0; $i < $resultado->num_rows; $i++) {

			$registro = mysqli_fetch_assoc($resultado);
			$registro = map($registro);

			array_push($tiposarticulos, $registro["idTipoArticulo"]);

			$registro["PrecioVta1_PreArti"]=precioCliente($registro["PrecioVta1_PreArti"],$registro["TasaIva"]);			
			$registro["PrecioVta1_PreArti"]=formatearPrecio($registro["PrecioVta1_PreArti"]);
			
			if ($registro["minimo"]==$registro["maximo"]) {
				$registro["palabraminimo"]="";
			}else{
				$registro["palabraminimo"]="Desde ";
			}
			
			$registro["minimo"]=precioCliente($registro["minimo"],$registro["TasaIva"]);			
			$registro["minimo"]=formatearPrecio($registro["minimo"]);

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

	}else{
		$respuesta["error"] = TRUE;
		$tipo = "productosDestacados";
		$codigo = 0;
		array_push($respuesta["errores"]["coderror"], $tipo.$codigo);
		array_push($respuesta["errores"]["mensajeerror"], $errores[$tipo][$codigo]);		
		
	}		

	return $respuesta ;
}

/********** NOTICIAS ***********/

function retornarUltimasNovedades(){

	global $mysqli;
	global $errores;

	$respuesta =array();
	$respuesta["exito"] =array();
	$respuesta["errores"]["coderror"] =array();
	$respuesta["errores"]["mensajeerror"] =array();		

	$sql = "SELECT * FROM `trama_noticias`
	ORDER BY fecha desc
	LIMIT 2";
	$resultado = mysqli_query($mysqli, $sql);

	if ($resultado->num_rows > 0) {
		$respuesta["error"] = FALSE;
		for ($i = 0; $i < $resultado->num_rows; $i++) { 

			$registro = mysqli_fetch_assoc($resultado);
			$registro = map($registro);
			array_push($respuesta["exito"], $registro);
		}
	}else{
		$respuesta["error"] = TRUE;
		$tipo = "novedades";
		$codigo = 0;
		array_push($respuesta["errores"]["coderror"], $tipo.$codigo);
		array_push($respuesta["errores"]["mensajeerror"], $errores[$tipo][$codigo]);		
		
	}		

	return $respuesta ;
}


/********** DESCARGAS ***********/

function retornarDescargas(){

	global $mysqli;
	global $errores;

	$respuesta =array();
	$respuesta["exito"] =array();
	$respuesta["errores"]["coderror"] =array();
	$respuesta["errores"]["mensajeerror"] =array();		
	

	$sql = "SELECT * FROM `trama_descargas`
	WHERE activo =1";
	$resultado = mysqli_query($mysqli, $sql);

	if ($resultado->num_rows > 0) {
		$respuesta["error"] = FALSE;
		for ($i = 0; $i < $resultado->num_rows; $i++) { 

			$registro = mysqli_fetch_assoc($resultado);
			$registro = map($registro);
			array_push($respuesta["exito"], $registro);
		}
	}else{
		$respuesta["error"] = TRUE;
		$tipo = "descargas";
		$codigo = 0;
		array_push($respuesta["errores"]["coderror"], $tipo.$codigo);
		array_push($respuesta["errores"]["mensajeerror"], $errores[$tipo][$codigo]);
	}		

	return $respuesta ;
}


/********** NOVEDAD ***********/

function retornarNovedad(){

	global $mysqli;
	global $errores;

	$respuesta =array();
	$respuesta["exito"] =array();
	$respuesta["errores"]["coderror"] =array();
	$respuesta["errores"]["mensajeerror"] =array();		

	$sql = "SELECT * FROM `trama_noticias`
	where id = '".$_GET["novedad"]."'";
	$resultado = mysqli_query($mysqli, $sql);

	if ($resultado->num_rows > 0) {
		$respuesta["error"]=FALSE;
		for ($i = 0; $i < $resultado->num_rows; $i++) { 

			$registro = mysqli_fetch_assoc($resultado);
			$registro = map($registro);
			array_push($respuesta["exito"], $registro);
		}
	}else{
		$respuesta["error"] = TRUE;
		$tipo = "novedades";
		$codigo = 0;
		array_push($respuesta["errores"]["coderror"], $tipo.$codigo);
		array_push($respuesta["errores"]["mensajeerror"], $errores[$tipo][$codigo]);		
		
	}		

	return $respuesta ;
}

/********** OBRA ***********/

function retornarObra(){

	global $mysqli;
	global $errores;

	$respuesta =array();
	$respuesta["exito"] =array();
	$respuesta["errores"]["coderror"] =array();
	$respuesta["errores"]["mensajeerror"] =array();		

	$sql = "SELECT * FROM `trama_portfolio`
	where id = '".$_GET["obra"]."'";
	$resultado = mysqli_query($mysqli, $sql);

	if ($resultado->num_rows > 0) {
		$respuesta["error"]=FALSE;
		for ($i = 0; $i < $resultado->num_rows; $i++) { 

			$registro = mysqli_fetch_assoc($resultado);
			$registro = map($registro);
			array_push($respuesta["exito"], $registro);
		}
	}	

	return $respuesta ;
}

/********** TIPOS CLIENTES ***********/

function retornarTiposClientes(){

	global $mysqli;
	global $errores;

	$respuesta =array();
	$respuesta["exito"] =array();
	$respuesta["errores"]["coderror"] =array();
	$respuesta["errores"]["mensajeerror"] =array();		

	$sql = "SELECT * FROM `trama_tipos_clientes`";
	$resultado = mysqli_query($mysqli, $sql);

	if ($resultado->num_rows > 0) {
		$respuesta["error"]=FALSE;
		for ($i = 0; $i < $resultado->num_rows; $i++) { 

			$registro = mysqli_fetch_assoc($resultado);
			$registro = map($registro);
			$respuesta["exito"][$registro["id"]]=$registro["denominacion"];
		}
	}else{
		$respuesta["error"] = TRUE;
		$tipo = "tipos-clientes";
		$codigo = 0;
		array_push($respuesta["errores"]["coderror"], $tipo.$codigo);
		array_push($respuesta["errores"]["mensajeerror"], $errores[$tipo][$codigo]);		
		
	}		

	return $respuesta ;
}

/********** CLIENTE ***********/

function retornarCliente(){
	global $mysqli;
	global $errores;

	$respuesta =array();
	$respuesta["exito"] =array();
	$respuesta["errores"]["coderror"] =array();
	$respuesta["errores"]["mensajeerror"] =array();		

	$sql="SELECT dbo_cliente.*,
	walger_clientes.*
	FROM dbo_cliente
	INNER JOIN walger_clientes
	ON dbo_cliente.CodigoCli=walger_clientes.CodigoCli
	WHERE dbo_cliente.CodigoCli='".$_SESSION["idUsuario"]."'";
	$resultado=mysqli_query($mysqli, $sql);

	if ($resultado->num_rows > 0) {
		$respuesta["error"]=FALSE;
		for ($i = 0; $i < $resultado->num_rows; $i++) { 

			$registro = mysqli_fetch_assoc($resultado);
			$registro = map($registro);
			array_push($respuesta["exito"], $registro);
		}
	}else{
		$respuesta["error"] = TRUE;
		$tipo = "clientes";
		$codigo = 0;
		array_push($respuesta["errores"]["coderror"], $tipo.$codigo);
		array_push($respuesta["errores"]["mensajeerror"], $errores[$tipo][$codigo]);		
		
	}		

	return $respuesta ;	
}

/********** CONDICIONES IVA ***********/

function retornarCondicionesIva(){

	global $mysqli;
	global $errores;

	$respuesta =array();
	$respuesta["exito"] =array();
	$respuesta["errores"]["coderror"] =array();
	$respuesta["errores"]["mensajeerror"] =array();		

	$sql = "SELECT * FROM `dbo_ivacondicion`";
	$resultado = mysqli_query($mysqli, $sql);

	if ($resultado->num_rows > 0) {
		$respuesta["error"]=FALSE;
		for ($i = 0; $i < $resultado->num_rows; $i++) { 

			$registro = mysqli_fetch_assoc($resultado);
			$registro = map($registro);
			$respuesta["exito"][$registro["Regis_IvaC"]]=$registro["DescrIvaC"];
		}
	}else{
		$respuesta["error"] = TRUE;
		$tipo = "condiciones-iva";
		$codigo = 0;
		array_push($respuesta["errores"]["coderror"], $tipo.$codigo);
		array_push($respuesta["errores"]["mensajeerror"], $errores[$tipo][$codigo]);		
		
	}		

	return $respuesta ;
}


/********** PRODUCTOS ORDENAMIENTO ***********/

function retornarProductosOrdenamiento(){

	global $errores;

	$respuesta =array();
	$respuesta["exito"] =array();
	$respuesta["errores"]["coderror"] =array();
	$respuesta["errores"]["mensajeerror"] =array();		

	if (count($GLOBALS["configuracion"]["productos"]["formasordenamiento"])>0) {
		$respuesta["error"]=FALSE;
		for ($i = 0; $i < count($GLOBALS["configuracion"]["productos"]["formasordenamiento"]); $i++) { 

			$registro = $GLOBALS["configuracion"]["productos"]["formasordenamiento"][$i];
			array_push($respuesta["exito"], $registro);
		}
	}else{
		$respuesta["error"] = TRUE;
		$tipo = "productos-ordenamiento";
		$codigo = 0;
		array_push($respuesta["errores"]["coderror"], $tipo.$codigo);
		array_push($respuesta["errores"]["mensajeerror"], $errores[$tipo][$codigo]);		
		
	}		

	return $respuesta ;
}


/********** PRODUCTOS MARCAS ***********/

function retornarMarcas(){
	global $mysqli;
	global $errores;

	$respuesta =array();
	$respuesta["exito"] =array();
	$respuesta["errores"]["coderror"] =array();
	$respuesta["errores"]["mensajeerror"] =array();

	if ($_GET["categoria"]!="" && isset($_GET["linea"])) {
		$where="WHERE DescrNivelInt4='".$_GET["categoria"]."' AND DescrNivelInt3='".$_GET["linea"]."'";
	}else if ($_GET["categoria"]!="" && !isset($_GET["linea"])){
		$where="WHERE DescrNivelInt4='".$_GET["categoria"]."'";
	}else{
		$where="";
	}		

	$sql="SELECT `DescrNivelInt2`
	FROM`dbo_articulo`
	".$where."
	GROUP BY `DescrNivelInt2`"; 
	$resultado=mysqli_query($mysqli, $sql);

	if ($resultado->num_rows > 0) {
		$respuesta["error"]=FALSE;
		for ($i = 0; $i < $resultado->num_rows; $i++) { 
			$registro = mysqli_fetch_assoc($resultado);
			$registro = map($registro);
			array_push($respuesta["exito"], $registro);
		}
	}else{
		$respuesta["error"] = TRUE;
		$tipo = "marcas";
		$codigo = 0;
		array_push($respuesta["errores"]["coderror"], $tipo.$codigo);
		array_push($respuesta["errores"]["mensajeerror"], $errores[$tipo][$codigo]);		
	}		

	return $respuesta ;	
}

/********** DETALLE USUARIO ***********/

function retornarDetalleUsuario(){
	global $mysqli;
	global $errores;

	$respuesta =array();
	$respuesta["exito"] =array();
	$respuesta["errores"]["coderror"] =array();
	$respuesta["errores"]["mensajeerror"] =array();

	if (isset($_SESSION["idUsuario"])) {
		
		$sql="SELECT
		dbo_cliente.*,
		walger_clientes.*
		FROM dbo_cliente
		INNER JOIN walger_clientes
		ON dbo_cliente.CodigoCli = walger_clientes.CodigoCli
		WHERE dbo_cliente.CodigoCli='".$_SESSION["idUsuario"]."'";

		$resultado=mysqli_query($mysqli, $sql);

		if ($resultado->num_rows == 1) {
			$respuesta["error"]=FALSE;
			$registro = mysqli_fetch_assoc($resultado);
			$registro = map($registro);
			array_push($respuesta["exito"], $registro);			
		}

	}else{
		$respuesta["error"] = TRUE;
		$tipo = "detalle-usuario";
		$codigo = 0;
		array_push($respuesta["errores"]["coderror"], $tipo.$codigo);
		array_push($respuesta["errores"]["mensajeerror"], $errores[$tipo][$codigo]);		
	}

	return $respuesta ;	
}

/********** CATEGORIAS PORTFOLIO ***********/

function retornarCategoriasPortfolio(){
	global $mysqli;
	global $errores;

	$respuesta =array();
	$respuesta["exito"] =array();
	$respuesta["errores"]["coderror"] =array();
	$respuesta["errores"]["mensajeerror"] =array();
		
	$sql="SELECT * FROM `trama_categorias-portfolio`";

	$resultado=mysqli_query($mysqli, $sql);

	if ($resultado->num_rows > 0) {
		$respuesta["error"]=FALSE;
		for ($i=0; $i < $resultado->num_rows ; $i++) { 
			$registro = mysqli_fetch_assoc($resultado);
			$registro = map($registro);
			array_push($respuesta["exito"], $registro);			
		}
	}

	return $respuesta ;	
}

/********** MEDIOS ENTREGA ***********/

function retornarMediosEntrega(){
	global $mysqli;
	global $errores;

	$respuesta =array();
	$respuesta["exito"] =array();
	$respuesta["errores"]["coderror"] =array();
	$respuesta["errores"]["mensajeerror"] =array();
		
	$sql="SELECT * FROM `trama_medios-entrega` WHERE activo = 1";

	$resultado=mysqli_query($mysqli, $sql);

	if ($resultado->num_rows > 0) {
		$respuesta["error"]=FALSE;
		for ($i=0; $i < $resultado->num_rows ; $i++) { 
			$registro = mysqli_fetch_assoc($resultado);
			$registro = map($registro);
			array_push($respuesta["exito"], $registro);			
		}
	}else{
		$respuesta["error"] = TRUE;
		$tipo = "medios-entrega";
		$codigo = 0;
		array_push($respuesta["errores"]["coderror"], $tipo.$codigo);
		array_push($respuesta["errores"]["mensajeerror"], $errores[$tipo][$codigo]);		
	}

	return $respuesta ;	
}

/********** MEDIOS DEFAULT (SIN CHECKOUT) ***********/

function retornarMedioEntregaDefault(){
	global $mysqli;
	global $errores;

	$respuesta =array();
	$respuesta["exito"] =array();
	$respuesta["errores"]["coderror"] =array();
	$respuesta["errores"]["mensajeerror"] =array();
		
	$sql="SELECT `RazonSocialFlete` FROM `dbo_cliente` WHERE CodigoCli = '".$_SESSION["idUsuario"]."'";

	$resultado=mysqli_query($mysqli, $sql);

	if ($resultado->num_rows === 1) {
		$respuesta["error"]=FALSE;
		$registro = mysqli_fetch_assoc($resultado);
		$registro = map($registro);
		$respuesta["exito"]=$registro;
	}else{
		$respuesta["error"]=FALSE;
		$respuesta["exito"]["RazonSocialFlete"]="";
	}

	return $respuesta ;	
}

/********** MEDIOS PAGO (Cuenta Corriente) ***********/

function retornarMediosPagoCC(){
	global $mysqli;
	global $errores;

	$respuesta =array();
	$respuesta["exito"] =array();
	$respuesta["errores"]["coderror"] =array();
	$respuesta["errores"]["mensajeerror"] =array();
		
	$sql="SELECT * FROM `trama_medios-pagos` WHERE activo = 1";

	$resultado=mysqli_query($mysqli, $sql);

	if ($resultado->num_rows > 0) {
		$respuesta["error"]=FALSE;
		for ($i=0; $i < $resultado->num_rows ; $i++) { 
			$registro = mysqli_fetch_assoc($resultado);
			$registro = map($registro);
			array_push($respuesta["exito"], $registro);			
		}
	}else{
		$respuesta["error"] = TRUE;
		$tipo = "medios-pago";
		$codigo = 0;
		array_push($respuesta["errores"]["coderror"], $tipo.$codigo);
		array_push($respuesta["errores"]["mensajeerror"], $errores[$tipo][$codigo]);		
	}

	return $respuesta ;	
}

/********** PROVINCIAS TODOPAGO ***********/

function retornarProvinciasTodopago(){
	global $mysqli;
	global $errores;

	$respuesta =array();
	$respuesta["exito"] =array();
	$respuesta["errores"]["coderror"] =array();
	$respuesta["errores"]["mensajeerror"] =array();
		
	$sql="SELECT * FROM `todopago_provincias`
	ORDER BY `denominacion`";

	$resultado=mysqli_query($mysqli, $sql);

	if ($resultado->num_rows > 0) {
		$respuesta["error"]=FALSE;
		for ($i=0; $i < $resultado->num_rows ; $i++) { 
			$registro = mysqli_fetch_assoc($resultado);
			$registro = map($registro);
			array_push($respuesta["exito"], $registro);			
		}
	}

	return $respuesta ;	
}

/********** SLIDER ***********/

function retornarSlider(){
	global $mysqli;
	global $errores;

	$respuesta =array();
	$respuesta["exito"] =array();
	$respuesta["errores"]["coderror"] =array();
	$respuesta["errores"]["mensajeerror"] =array();
		
	$sql="SELECT * FROM `trama_slider`
	WHERE activo = 1";

	$resultado=mysqli_query($mysqli, $sql);

	if ($resultado->num_rows > 0) {
		$respuesta["error"]=FALSE;
		for ($i=0; $i < $resultado->num_rows ; $i++) { 
			$registro = mysqli_fetch_assoc($resultado);
			$registro = map($registro);
			array_push($respuesta["exito"], $registro);			
		}
	}

	return $respuesta ;	
}

/********** PORTFOLIO COMPLETO ***********/

function retornarPorfolioCompleto(){
	global $mysqli;
	global $errores;

	$respuesta =array();
	$respuesta["exito"] =array();
	$respuesta["errores"]["coderror"] =array();
	$respuesta["errores"]["mensajeerror"] =array();
		
	$sql="SELECT `trama_portfolio`.*,
				`trama_categorias-portfolio`.`denominacion` as 'categoria'
				FROM `trama_portfolio`
				INNER JOIN `trama_categorias-portfolio`
				ON `trama_portfolio`.`fkCategoriaPortfolio`= `trama_categorias-portfolio`.`id`";

	$resultado=mysqli_query($mysqli, $sql);

	if ($resultado->num_rows > 0) {
		$respuesta["error"]=FALSE;
		for ($i=0; $i < $resultado->num_rows ; $i++) { 
			$registro = mysqli_fetch_assoc($resultado);
			$registro = map($registro);
			if (!array_key_exists($registro["fkCategoriaPortfolio"], $respuesta["exito"])) {
				$respuesta["exito"][$registro["fkCategoriaPortfolio"]]=array(); 	
			}		
			array_push($respuesta["exito"][$registro["fkCategoriaPortfolio"]], $registro);			
		}
	}

	return $respuesta ;	
}

/********** PORTFOLIO COMPLETO ***********/

function retornarProductoParaMeta($codigo){
	global $mysqli;
	global $errores;

	$respuesta =array();
	$respuesta["exito"] =array();
	$respuesta["errores"]["coderror"] =array();
	$respuesta["errores"]["mensajeerror"] =array();
		
	$sql="SELECT DescripcionArti,
				NombreFotoArti
				FROM dbo_articulo
				WHERE CodInternoArti = '".$codigo."'";

	$resultado=mysqli_query($mysqli, $sql);

	if ($resultado->num_rows === 1) {
		$respuesta["error"]=FALSE;
		$registro = mysqli_fetch_assoc($resultado);
		$registro = map($registro);
		array_push($respuesta["exito"], $registro);			
	}

	return $respuesta ;	
}

/********** LISTA PRECIOS ***********/

function retornarListaPrecios(){
	global $mysqli;
	global $errores;

	$respuesta =array();
	$respuesta["exito"] =array();
	$respuesta["errores"]["coderror"] =array();
	$respuesta["errores"]["mensajeerror"] =array();
		
	$sql="SELECT * FROM dbo_articulo
	ORDER BY DescrNivelInt4, DescrNivelInt3, DescrNivelInt2, DescripcionArti";

	$resultado=mysqli_query($mysqli, $sql);

	if ($resultado->num_rows > 0) {
		$respuesta["error"]=FALSE;
		for ($i=0; $i < $resultado->num_rows ; $i++) { 
			$registro = mysqli_fetch_assoc($resultado);
			$registro = map($registro);
			
			$registro["PrecioVta1_PreArti"]=precioCliente($registro["PrecioVta1_PreArti"],$registro["TasaIva"]);			
			
			if ($_SESSION["CalculaIvaC"]==1 && $_SESSION["DiscriminaIvaC"]==1) {
				$registro["importeIva"] = $registro["PrecioVta1_PreArti"] * $registro["TasaIva"] / 100;
			}

			$registro["PrecioVta1_PreArti"]=formatearPrecio($registro["PrecioVta1_PreArti"]);
			$registro["importeIva"]=formatearPrecio($registro["importeIva"]);
	
			array_push($respuesta["exito"], $registro);			
		}
	}

	return $respuesta ;	
}

/********** SITEMAP PRODUCTOS ***********/

function retornarSitemapProductos(){
	global $mysqli;
	global $errores;

	$respuesta =array();
	$respuesta["exito"] =array();
	$respuesta["errores"]["coderror"] =array();
	$respuesta["errores"]["mensajeerror"] =array();
		
	$sql="SELECT
	CodInternoArti,
	DescrNivelInt4,
	DescrNivelInt3,
	DescrNivelInt2,
	DescripcionArti	
	FROM dbo_articulo
	ORDER BY DescrNivelInt4, DescrNivelInt3, DescrNivelInt2, DescripcionArti";

	$resultado=mysqli_query($mysqli, $sql);

	if ($resultado->num_rows > 0) {
		$respuesta["error"]=FALSE;
		for ($i=0; $i < $resultado->num_rows ; $i++) { 
			$registro = mysqli_fetch_assoc($resultado);
			$registro = map($registro);
	
			array_push($respuesta["exito"], $registro);			
		}
	}

	return $respuesta ;	
}

/********** SITEMAP NOVEDADES ***********/

function retornarSitemapNovedades(){
	global $mysqli;
	global $errores;

	$respuesta =array();
	$respuesta["exito"] =array();
	$respuesta["errores"]["coderror"] =array();
	$respuesta["errores"]["mensajeerror"] =array();
		
	$sql="SELECT
	id,
	titulo,
	fecha	
	FROM trama_noticias
	ORDER BY id DESC";

	$resultado=mysqli_query($mysqli, $sql);

	if ($resultado->num_rows > 0) {
		$respuesta["error"]=FALSE;
		for ($i=0; $i < $resultado->num_rows ; $i++) { 
			$registro = mysqli_fetch_assoc($resultado);
			$registro = map($registro);
	
			array_push($respuesta["exito"], $registro);			
		}
	}

	return $respuesta ;	
}

/********** SITEMAP PORTFOLIO ***********/

function retornarSitemapPortfolio(){
	global $mysqli;
	global $errores;

	$respuesta =array();
	$respuesta["exito"] =array();
	$respuesta["errores"]["coderror"] =array();
	$respuesta["errores"]["mensajeerror"] =array();
		
	$sql="SELECT
	trama_portfolio.id,
	trama_portfolio.denominacion,
	`trama_categorias-portfolio`.denominacion as 'denominacioncategoria'
	FROM trama_portfolio
	INNER JOIN `trama_categorias-portfolio`
	ON trama_portfolio.fkCategoriaPortfolio = `trama_categorias-portfolio`.id
	ORDER BY `trama_categorias-portfolio`.denominacion ASC, trama_portfolio.id DESC";

	$resultado=mysqli_query($mysqli, $sql);

	if ($resultado->num_rows > 0) {
		$respuesta["error"]=FALSE;
		for ($i=0; $i < $resultado->num_rows ; $i++) { 
			$registro = mysqli_fetch_assoc($resultado);
			$registro = map($registro);
	
			array_push($respuesta["exito"], $registro);			
		}
	}

	return $respuesta ;	
}


 ?>