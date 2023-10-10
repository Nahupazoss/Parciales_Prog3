<?php

use PazosNahuel\autoBD;

require_once("./clases/autoBD.php");

$auto_JSON = isset($_POST['obj_auto']) ? $_POST['obj_auto'] : null;

$lectura = json_decode($auto_JSON, true);

$patente = isset($lectura['patente']) ? $lectura['patente'] : '';


if (autoBD::existe($patente)) 
{
    echo "Existe.";
} 
else 
{
    echo "No existe.";
}

?>
