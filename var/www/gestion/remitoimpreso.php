<?php 
$link_aux = mysqli_connect("localhost", "root", "walger0000");
mysqli_select_db($link_aux, "gestion_walger");
$idremito=$_GET["Id_Remito"];
$qcabecera="select * from remitos where Id_Remito='".$idremito."'";
$qcabecera=mysqli_query($link_aux, $qcabecera);
$fcabecera=mysqli_fetch_assoc($qcabecera);

$qdetalle="SELECT remitos.*,
  remitos_detalle.*,
  productos.*
FROM remitos_detalle
  left JOIN remitos ON remitos.Id_Remito = remitos_detalle.remitoCabecera
  left JOIN productos ON remitos_detalle.descripcion = productos.Id_Productos
where Id_Remito='".$idremito."'";
//echo $qdetalle;
$qdetalle=mysqli_query($link_aux, $qdetalle);
//echo mysqli_num_rows($qdetalle);
$detalles=array();
for ($i=0; $i <mysqli_num_rows($qdetalle) ; $i++) {
	$fdetalle=mysqli_fetch_assoc($qdetalle);
	array_push($detalles, $fdetalle);	
}
//print_r($detalles);


$qfactura="SELECT 
`remitos` . * ,
`facturas` . *
FROM  `remitos` 
LEFT JOIN  `facturas` ON  `remitos`.Id_Remito =  `facturas`.RemitoCabecera
where Id_Remito='".$idremito."'";
$qfactura=mysqli_query($link_aux, $qfactura);



if ($fcabecera["tipoDestinatario"]==0) {
	$link_aux_2 = mysqli_connect("localhost", "root", "walger0000");
	mysqli_select_db($link_aux_2, "walger");
	$qcli="select `dbo_cliente`.* from `dbo_cliente` where CodigoCli= '".$fcabecera["Cliente"]."'";
	$qcli=mysqli_query($link_aux_2, $qcli);
	$fcli=mysqli_fetch_assoc($qcli);
	$nombre=$fcli['RazonSocialCli'];
	$domicilio=$fcli['Direccion'];
	$localidad="CP (".$fcli['CodigoPostalCli'].") ".$fcli['LocalidadCli']." - ".$fcli['DescrProvincia'];
	$condicion=$fcli['Regis_IvaC'];
	$cuitcli=$fcli['CuitCli'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Remito</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<link rel="stylesheet" href="remitoimpreso.css">
	<script src="sweetalert-master/dist/sweetalert.min.js"></script>
	<link rel="stylesheet" type="text/css" href="sweetalert-master/dist/sweetalert.css">
</head>
<body>
<page size="A4">
<input id="numero" disabled type="text" value="<?php echo "Referencia: 0001-". str_pad($fcabecera['numeroRemito'], 8,'0',STR_PAD_LEFT) ?>">	
<input id="dia" disabled type="text" value="<?php echo date('d', strtotime($fcabecera['Fecha'])) ?>">
<input id="mes" disabled type="text" value="<?php echo date('m', strtotime($fcabecera['Fecha'])) ?>">
<input id="ano" disabled type="text" value="<?php echo date('Y', strtotime($fcabecera['Fecha'])) ?>">
<input id="destinatario" disabled type="text" value="<?php echo htmlspecialchars(utf8_encode($nombre)) ?>">
<input id="domicilio" disabled type="text" value="<?php echo htmlspecialchars(utf8_encode($domicilio)) ?>">
<input id="localidad" disabled type="text" value="<?php echo htmlspecialchars(utf8_encode($localidad)) ?>">
<?php 
if ($condicion=$fcli['Regis_IvaC']==3) {
	?>
	<input id="consfinal" disabled type="text" value="X">
	<?php
}
?>
<?php
if ($condicion=$fcli['Regis_IvaC']==4) {
	?>
	<input id="excento" disabled type="text" value="X">
	<?php
}
?>
<?php
if ($condicion=$fcli['Regis_IvaC']==5) {
	?>
	<input id="monot" disabled type="text" value="X">
	<?php
}
?>
<?php
if ($condicion=$fcli['Regis_IvaC']==1) {
	?>
	<input id="resp" disabled type="text" value="X">
	<?php
}
?>


<input id="cuit" disabled type="text" value="<?php echo $cuitcli ?>">
<table id="detalle">
	<?php 
	for ($idet=0; $idet < count($detalles); $idet++) { 
	 ?>
	<tr class="renglon">
		<td class="cantidad"><?php echo ($detalles[$idet]["cantidad"]); ?></td>
		<td class="descripcion"><?php echo ($detalles[$idet]["denominacion"]); ?></td>
	</tr>
	<?php 

	}
	 ?>
</table>
<textarea id="facturas" style="color: black;" disabled >
	<?php 
		for ($i=0; $i < mysqli_num_rows($qfactura); $i++) {
			$ffactura=mysqli_fetch_assoc($qfactura);
			echo $ffactura["numFactura"];
		}
	 ?>
</textarea>
<input id="despachado" disabled type="text" value="<?php echo $fcabecera['Transporte'] ?>">

<input id="bultos" disabled type="text" value="<?php echo $fcabecera["NumeroDeBultos"] ?>">
<input id="valor" disabled type="text" value="<?php echo $fcabecera["Importe"] ?>">

</page>

</body>
<script>
	$(document).ready(function(){

		swal({
		   title: "Imprimir copias:",
		   type: "input",
		   inputType:"number",
		   showCancelButton: true,
		   closeOnConfirm: false,
		   animation: "slide-from-top",
		   inputPlaceholder: "Cantidad de impresiones",
		   inputValue:3,
		   },
		function(inputValue){
			if (inputValue === "") {
		   		swal.showInputError("Indique cantidad de impresiones");
		   		return false;
		   }else if (inputValue <1) {
		   		swal.showInputError("Indique cantidad de impresiones");
		   		return false;
		   	}else if (inputValue >=1) {
		   		for (var i = 0; i < inputValue; i++) {
		   			window.print();
		   		};
		   	};
		swal({
		   title: "Impresión finalizada",
		   text: '<a href="remitoslist.php">Volver</a>',
		   html: true
		});
		 });
	});
</script>
</html>