<?php

use PazosNahuel\auto;
require_once("./clases/auto.php");

$marca = isset($_POST["marca"]) ? $_POST["marca"] : null;
$patente = isset($_POST["patente"]) ? $_POST["patente"] : null;
$color = isset($_POST["color"]) ? $_POST["color"] : null;
$precio = isset($_POST["precio"]) ? $_POST["precio"] : null;

echo auto::verificarautoJSON($patente, "./archivos/autos.json");

?>