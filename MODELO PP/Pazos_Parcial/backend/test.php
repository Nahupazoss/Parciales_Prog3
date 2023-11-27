<?php

require_once("../clases/usuario.php");
$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "sin nombre"; 
$correo = isset($_POST["correo"]) ? $_POST["correo"] : "sin correo"; 
$clave = isset($_POST["clave"]) ? $_POST["clave"] : "sin clave";
$id_perfil = isset($_POST["id_perfil"]) ? $_POST["id_perfil"] : 0;


switch($opcion)
{
    case "login":
        
    break;

    case "mostar":
       
    break;

    case "alta":
    break;

    case "modificacion":
    break;

    case "baja":
    break;
}