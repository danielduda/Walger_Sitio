<?PHP 

  function escaparComillas () {

    foreach ($_POST as $key => $value) $_POST [$key] = str_replace ("'", "\'", $value);
    foreach ($_GET as $key => $value) $_GET [$key] = str_replace ("'", "\'", $value);

  }

  function conectar () {
  
    mysql_connect ("localhost","technext_walger_user", "*Walger000#25");
    mysql_select_db ("technext_walger");
  
  }

  function diasFechas ($f1)
  {
    $f1_ = substr($f1, 6, 4) . "-" . substr($f1, 3, 2) . "-" . substr ($f1, 0, 2);
    return floor((strtotime($f1_)-strtotime("now"))/-86400);
  }

  function actualizacionEnCurso () {
  
    $q = mysql_query ("SELECT pendiente 
                       FROM walger_actualizaciones 
                       ORDER BY fecha DESC
                       LIMIT 1");
  
    $f = mysql_fetch_array ($q);

    $currentFile = $_SERVER["PHP_SELF"];
    $parts = Explode('/', $currentFile);
    if ($parts[count($parts) - 1] == "actualizando.php") return;

    if ($f ["pendiente"] == "S") header ("location: actualizando.php");
  
  }
  
  function obtenerUltimaActualizacion () {
  
    $q = mysql_query ("SELECT MAX(fecha) AS fecha
                       FROM walger_actualizaciones");
    
    $f = mysql_fetch_array ($q);
    
    echo ($f ["fecha"]);
  
  }
  
  function obtenerCombo ($nombre, $campo) {
  
    $WHERE = " WHERE ($campo <> '') ";

    if (($_GET ["catalogo"] == "") || ($_GET ["catalogo"] == "Seleccione ...")) {
      $_GET ["linea"] = "";
      $_GET ["marca"] = "";
    }

    if (($_GET ["linea"] == "") || ($_GET ["linea"] == "Seleccione ...")) {
      $_GET ["marca"] = "";
    }

    if ($_GET ["catalogo"] != "") {

      if (($nombre == "linea") || ($nombre == "marca")) {

        $WHERE .= "AND (DescrNivelInt4 = '" . $_GET ["catalogo"] . "')";

      }

    }

    if ($_GET ["linea"] != "") {

      if ($nombre == "marca") {

        $WHERE .= "AND (DescrNivelInt3 = '" . $_GET ["linea"] . "')";

      }

    }

    $q = mysql_query ("SELECT DISTINCT ".$campo." AS 'a'
                       FROM dbo_articulo
                       $WHERE
                       ORDER BY ".$campo);
    
    echo ('<select id="'.$nombre.'" onchange="location.href = \'listado.php?catalogo=\'+document.getElementById (\'catalogo\').value+\'&linea=\'+document.getElementById (\'linea\').value+\'&marca=\'+document.getElementById (\'marca\').value;">');
    
    echo ('<option>Seleccione ...</option>');

    while ($f = mysql_fetch_array ($q)) {
    
        if ($_GET [$nombre] == $f ["a"]) $SELECTED = "selected";
        else $SELECTED = "";

        echo ('<option '.$SELECTED.' value="'.$f ["a"].'">'.$f ["a"].'</option>');
    
    }                  
  
    echo ('</select>');
    
  }
  
  function obtenerOfertas () {

    $offset_result = mysql_query("SELECT FLOOR(RAND() * COUNT(*)) AS offset FROM dbo_articulo
                                  INNER JOIN walger_articulos ON walger_articulos.CodInternoArti = dbo_articulo.CodInternoArti
                                  WHERE oferta = 'S'");
    $offset_row = mysql_fetch_object( $offset_result ); 
    $offset = $offset_row->offset;

    $q = mysql_query ("SELECT DescripcionArti, walger_articulos.CodInternoArti, NombreFotoArti
                       FROM dbo_articulo
                       INNER JOIN walger_articulos ON walger_articulos.CodInternoArti = dbo_articulo.CodInternoArti
                       WHERE oferta = 'S'
                       LIMIT $offset, 1");

    $f = mysql_fetch_array ($q);

    $imagen_aux = explode ("/", $f ["NombreFotoArti"]);
    $imagen_aux = $imagen_aux [count ($imagen_aux) - 1];
    if (($imagen_aux != "") && (file_exists ("articulos/$imagen_aux"))) $imagen = $imagen_aux;

    echo ('

        <span style="cursor: pointer;" onclick="location.href = \'articulo.php?id='.$f ["CodInternoArti"].'\';">'. substr ($f ["DescripcionArti"], 0, 40).' ...</span>
        <br />

        ');

    if ($imagen != "") echo ('<img style="cursor: pointer;" onclick="location.href = \'articulo.php?id='.$f ["CodInternoArti"].'\';" src="articulos/'.$imagen.'" alt="" width="77" height="58" />');
  
    if (mysql_num_rows ($q) == 0) echo ('<br /><span>No existen ofertas actualmente.</span>');

  }

  function obtenerOfertaHome () {

    $offset_result = mysql_query("SELECT FLOOR(RAND() * COUNT(*)) AS offset FROM walger_ofertas WHERE activo = 'S'");
    $offset_row = mysql_fetch_object( $offset_result ); 
    $offset = $offset_row->offset;

    $q = mysql_query ("SELECT * FROM walger_ofertas WHERE activo = 'S' LIMIT $offset, 1");

    $f = mysql_fetch_array ($q);

    echo ($f["oferta"]);

  }

  function obtenerNovedad () {

    $offset_result = mysql_query("SELECT FLOOR(RAND() * COUNT(*)) AS offset
                                  FROM dbo_articulo
                                  INNER JOIN walger_articulos ON walger_articulos.CodInternoArti = dbo_articulo.CodInternoArti
                                  WHERE novedad = 'S'");

    $offset_row = mysql_fetch_object( $offset_result ); 
    $offset = $offset_row->offset;

    $q = mysql_query ("SELECT DescripcionArti, walger_articulos.CodInternoArti, NombreFotoArti, DescrNivelInt4, DescrNivelInt3, DescrNivelInt2
                       FROM dbo_articulo
                       INNER JOIN walger_articulos ON walger_articulos.CodInternoArti = dbo_articulo.CodInternoArti
                       WHERE novedad = 'S'
                       LIMIT $offset, 1");

    $f = mysql_fetch_array ($q);

    $imagen_aux = explode ("/", $f ["NombreFotoArti"]);
    $imagen_aux = $imagen_aux [count ($imagen_aux) - 1];
    if (($imagen_aux != "") && (file_exists ("articulos/$imagen_aux"))) $imagen = $imagen_aux;

    if ($imagen != "") $imagen = '<img src="articulos/'.$imagen.'" alt="" width="77" height="58" />';

    if (mysql_num_rows ($q) != 0) echo ('

          <span style="cursor: pointer;" onclick="location.href = \'articulo.php?id='.$f ["CodInternoArti"].'\';"><strong>Producto:</strong>'.substr ($f ["DescripcionArti"], 0, 40).' ...</span>

          '.$imagen.'

          <div class="datos">
            <strong onclick="location.href = \'articulo.php?id='.$f ["CodInternoArti"].'\';">Código:</strong> '.$f ["CodInternoArti"].'<br />
            <strong onclick="location.href = \'articulo.php?id='.$f ["CodInternoArti"].'\';">Marca: </strong> '.$f ["DescrNivelInt2"].'<br />
            <strong onclick="location.href = \'articulo.php?id='.$f ["CodInternoArti"].'\';">Línea:</strong> '.$f ["DescrNivelInt3"].'<br />
            <strong onclick="location.href = \'articulo.php?id='.$f ["CodInternoArti"].'\';">Catálogo:</strong> '.$f ["DescrNivelInt1"].'
          </div>

    ');

    else echo ('<br /><br /><br /><span>No existen novedades actualmente.</span>');

  }

  function curPageURL() {

    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
      $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
      $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $pageURL;

  }

  function enviarEmail ($destinatario, $titulo, $mensaje) {

    @include_once ("./mailer/class.phpmailer.php");

    @include_once ("../mailer/class.phpmailer.php");
    

    $mail = new PHPMailer();
    $mail->SetLanguage = "es";
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "tls";
    $mail->Host = "smtp.gmail.com";
    $mail->Username = "walgersrl";
    $mail->Password = "c8697400";
    $mail->Port = 587;
    //$mail->From = "walgersrl@gmail.com";
    $mail->From = "administracionventas@walger.com.ar";
    $mail->FromName = "Walger - Tienda Virtual";
    $mail->Subject = $titulo;
    $mail->AddAddress ($destinatario, "");
    $mail->WordWrap = 50;
    $mail->Body = $mensaje;
    $mail->IsHTML(true);

    if(!$mail->Send()){
       return false; 
    } else {
       return true;
    }


  }

  function convertLatin1ToHtml ($str) {
	
    $html_entities = array (
        "á" =>  "&aacute;",     #latin small letter a
        "Á" =>  "&Aacute;",     #latin small letter a
        "À" =>  "&Agrave;",     #latin capital letter A
        "à" =>  "&agrave;",     #latin small letter a
        "É" =>  "&Eacute;",     #latin capital letter E
        "é" =>  "&eacute;",     #latin small letter e
        "È" =>  "&Egrave;",     #latin capital letter E
        "è" =>  "&Egrave;",     #latin capital letter E
        "í" =>  "&iacute;",     #latin capital letter E
        "Í" =>  "&Iacute;",     #latin small letter e
        "ì" =>  "&igrave;",     #latin capital letter E
        "Ì" =>  "&Igrave;",     #latin capital letter E
        "ó" =>  "&oacute;",     #latin capital letter E
        "Ó" =>  "&Oacute;",     #latin small letter e
        "ò" =>  "&ograve;",     #latin capital letter E
        "Ò" =>  "&Ograve;",     #latin capital letter E
        "ú" =>  "&uacute;",     #latin capital letter E
        "Ú" =>  "&Uacute;",     #latin small letter e
        "ù" =>  "&ugrave;",     #latin capital letter E
        "Ù" =>  "&Ugrave;",     #latin capital letter E
        "Ñ" =>  "&Ntilde;",
        "ñ" =>  "&ntilde;",
        "Ç" =>  "&Ccedil;",     #latin capital letter C
        "ç" =>  "&ccedil;"     #latin small letter c
    );

    foreach ($html_entities as $key => $value) {
        $str = str_replace($key, $value, $str);
    }
    
    return $str;
    
	} 

?>
