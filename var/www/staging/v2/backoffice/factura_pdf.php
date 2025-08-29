<?PHP

	$archivo_pdf = $_GET["pdf"];

	if (file_exists($archivo_pdf))
	{

		header('Content-type: application/pdf');
		header('Content-Disposition: inline; filename="factura.pdf"');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . filesize($archivo_pdf));
		header('Accept-Ranges: bytes');

		echo file_get_contents($archivo_pdf);

	}

?>


