function __numero (obj, evt) {

  var charCode = (evt.which) ? evt.which : event.keyCode
  if (charCode > 31 && (charCode < 48 || charCode > 57)) return (false);
  return (true);

}

function __numeroDecimal (obj, evt) {

  var charCode = (evt.which) ? evt.which : event.keyCode
  if ((charCode > 45 && charCode < 58) || charCode == 8) return true;  
  else return false;  

}

function buscar (termino) {

  if (termino != "") location.href = 'listado.php?termino=' + termino;

}

function validarEMail (str) {

  var at = "@"
  var dot = "."
  var lat = str.indexOf (at)
  var lstr = str.length
  var ldot = str.indexOf (dot)

  if (str.indexOf (at) == -1) return false;
  if (str.indexOf (at) == -1 || str.indexOf (at) == 0 || str.indexOf (at) == lstr) return false;
  if (str.indexOf (dot) == -1 || str.indexOf (dot) == 0 || str.indexOf (dot) == lstr) return false;
  if (str.indexOf (at, (lat+1)) != -1) return false;
  if (str.substring (lat-1, lat) == dot || str.substring (lat+1, lat+2) == dot) return false;
  if (str.indexOf (dot, (lat+2)) == -1) return false;
  if (str.indexOf (" ") != -1) return false;

  return true

}

function validarRegistro () {

  var mensaje = "";

//  if (document.getElementById ('RazonSocialCli').value.length < 2) mensaje += "- Debe completar el campo de razón social.\n";
  if (document.getElementById ('Direccion').value.length < 2) mensaje += "- Debe completar el campo de dirección postal.\n";
  if (document.getElementById ('CodigoPostalCli').value.length < 2) mensaje += "- Debe completar el campo de código postal.\n";
  if (document.getElementById ('LocalidadCli').value.length < 2) mensaje += "- Debe completar el campo de localidad.\n";
  if (document.getElementById ('DescrProvincia').value.length < 2) mensaje += "- Debe completar el campo de provincia.\n";
  if (document.getElementById ('DescrPais').value.length < 2) mensaje += "- Debe completar el campo de país.\n";
  if (document.getElementById ('Telefono').value.length < 2) mensaje += "- Debe completar el campo de teléfono.\n";
  if (! validarEMail (document.getElementById ('emailCli').value)) mensaje += "- Debe completar el campo de email.\n";
  if (document.getElementById ('Password').value.length < 5) mensaje += "- La contraseña debe tener al menos 5 caracteres de largo.\n";
  if (document.getElementById ('Password').value != document.getElementById ('rPassword').value) mensaje += "- Las contraseñas deben coincidir.\n";

  if (document.getElementById ('TipoCliente').value == "Consumidor Final")
  {
  
    if (document.getElementById ('ApellidoNombre').value.length < 2) mensaje += "- Debe completar el campo nombre y apellido.\n";

  }

  if (document.getElementById ('codigo').value != document.getElementById ('codigoUsuario').value) mensaje += "- El codigo de verificación no es correcto.\n";

  if (mensaje == "") document.forms [0].submit ();
  else alert ("Se detectaron los siguientes errores: \n\n" + mensaje);

}

function comprar (cantidad, codigo) {

  if ((cantidad == "") || (cantidad == 0)) 
  {
    alert("Debe ingresar una cantidad válida.");
  }
  else
  {
    location.href = 'insertar_pedido.php?cantidad='+cantidad+'&codigo='+codigo;
  }

}
