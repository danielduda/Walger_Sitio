<?PHP

	if (file_exists("/home/fcisis/" . $_GET["r"]))
	{

		$file = "/home/fcisis/" . $_GET["r"];
		$filename = "fc.pdf";
	
		header('Content-type: application/pdf');
		header('Content-Disposition: inline; filename="' . $filename . '"');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . filesize($file));
		header('Accept-Ranges: bytes');

		echo file_get_contents($file);

	}

?>
