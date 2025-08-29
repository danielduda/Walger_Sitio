<?PHP

  session_start();

  $_GET ["c"] = $_SESSION ["cliente"]["CodigoCli"];
  include ("vto.php");

?>

