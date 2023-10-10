<?php
use PazosNahuel\auto;
require_once '.\clases\auto.php';

$marca = isset($_POST["marca"]) ? $_POST["marca"] : null;
$patente = isset($_POST["patente"]) ? $_POST["patente"] : null;
$color = isset($_POST["color"]) ? $_POST["color"] : null;
$precio = isset($_POST["precio"]) ? $_POST["precio"] : null;

$auto = new PazosNahuel\auto($marca, $patente, $color, $precio);
$path = './archivos/autos.json';
if($auto->marca == $marca && $auto->patente == $patente && $auto->color == $color && $auto->precio == $precio)
{
    $retorno = $auto->guardarJSON($path);
}
else
{
    $retorno = "hubo un error";
}

echo $retorno;
