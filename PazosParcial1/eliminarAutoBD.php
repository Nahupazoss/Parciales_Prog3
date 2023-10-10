<?php

use PazosNahuel\autoBD;


require_once("./clases/autoBD.php");

$auto_json = isset($_POST["auto_json"]) ? $_POST["auto_json"] : null;

$lectura = json_decode($auto_json, true);

$auto = new autoBD($lectura["marca"], $lectura["patente"], $lectura["color"], $lectura["precio"]);

if(autoBD::eliminar($auto->patente))
{
    echo "Se pudo borrar.";
    $auto->guardar('./archivos/autos_eliminados.json'); // cambiar path
}
else
{
    echo "No se pudo borrar.";
}

?>