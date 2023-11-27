<?php

use PazosNahuel\autoBD;
use PazosNahuel\auto;
require_once("./clases/autoBD.php");

$auto_json = isset($_POST['auto_json']) ? $_POST['auto_json'] : null;

$lectura = json_decode($auto_json, true);

$auto =  new autoBD($lectura['marca'], $lectura['patente'], $lectura['color'],$lectura['precio']);

if($auto->agregar())
{
    echo "Se agregó.";
}
else
{
    echo "No se agregó.";
}


?>