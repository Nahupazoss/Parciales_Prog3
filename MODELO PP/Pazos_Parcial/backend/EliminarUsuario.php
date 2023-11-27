<?php
require_once "../clases/usuario.php";

$accion = isset($_POST["accion"]) ? $_POST["accion"] : "sin accion"; 
$id = isset($_POST["id"]) ? $_POST["id"] : 8; 

if($accion = "borrar")
{
    if($id > 0)
    {
        if(Usuario::EliminarBD($id))
        {
            echo "Usuario eliminado con exito";
        }
        else
        {
            echo "El id del usuario ingresado es incorrecto o se produjo un error";
        }
    }
    else
    {
        echo "error";
    }
}