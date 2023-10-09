<?php
require_once "../clases/usuario.php";

$accion = isset($_GET["accion"]) ? $_GET["accion"] : "sin accion";

if ($accion == "listar") {
    $retorno = Usuario::TraerTodosJSON();

    if ($retorno !== false) {
        echo $retorno;
    } else {
        echo '{"exito": false, "mensaje": "Error al obtener la lista de usuarios."}';
    }
}
?>