<?php

use PazosNahuel\autoBD;
use PazosNahuel\auto;
require_once("./clases/autoBD.php");


$marca = isset($_POST['marca']) ? $_POST['marca'] : null;
$patente = isset($_POST['patente']) ? $_POST['patente'] : null;
$color = isset($_POST['color']) ? $_POST['color'] : null;
$precio = isset($_POST['precio']) ? $_POST['precio'] : null;
$foto = isset($_FILES['foto']) ? $_FILES['foto'] : null;

date_default_timezone_set('America/Argentina/Buenos_Aires');
$tipo = explode("/",$foto["type"]);
$tipo = $tipo[1];
$path = './autos/imagenes/'; // cambiar path
$destino = trim($path) . "." . $marca . "." . date("His") . "." . $tipo; // puede cambiar
move_uploaded_file($foto["tmp_name"], $destino);

echo $foto["tmp_name"];

if (file_exists($destino)) 
{
    $uploadOk = FALSE; //echo "El archivo ya existe. Verifique!!!";
}
if ($_FILES["foto"]["size"] > 5000000000000 ) 
{
    $uploadOk = FALSE;// echo "El archivo es demasiado grande. Verifique!!!";
}
$tipoArchivo = pathinfo($destino, PATHINFO_EXTENSION);
if($tipoArchivo != "jpg" && $tipoArchivo != "jpeg" && $tipoArchivo != "gif"&& $tipoArchivo != "png") 
{ 
    $uploadOk = FALSE;//   echo "Solo son permitidas imagenes con extension JPG, JPEG, PNG o GIF.";
}

$auto = new autoBD($marca, $patente, $color, $precio, $destino);

if($auto->existe(autoBD::traer()))
{
    echo "El auto ya existia.";
}
else
{
    echo "el auto se añadio";
  $auto->agregar();
}


?> 