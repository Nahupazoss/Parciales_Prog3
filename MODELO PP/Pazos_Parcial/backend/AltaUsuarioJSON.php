<?php
require_once "../clases/usuario.php";

$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "sin nombre"; 
$correo = isset($_POST["correo"]) ? $_POST["correo"] : "sin correo"; 
$clave = isset($_POST["clave"]) ? $_POST["clave"] : "sin clave";

$new = new Usuario(0,$nombre,$correo,$clave);

if($new->nombre == $nombre && $new->correo == $correo && $new->clave == $clave)
{
    $retorno = $new->GuardarEnArchivoJSON("./backend/archivos/usuarios.json");
}
else
{
    $retorno = "hubo un error";
}


echo $retorno;
