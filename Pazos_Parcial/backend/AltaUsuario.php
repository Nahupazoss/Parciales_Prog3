<?php
require_once "../clases/usuario.php";

$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "sin nombre"; 
$correo = isset($_POST["correo"]) ? $_POST["correo"] : "sin correo"; 
$clave = isset($_POST["clave"]) ? $_POST["clave"] : "sin clave";
$id_perfil = isset($_POST["id_perfil"]) ? $_POST["id_perfil"] : 0;

$new = new Usuario(0,$nombre,$correo,$clave,$id_perfil);

if($new->nombre == $nombre && $new->correo == $correo && $new->clave == $clave && $new->id_perfil == $id_perfil)
{
    if(Usuario::AgregarUsuario($new))
    {
        echo "agregado con exito";
    }
    else
    {
        echo "error";
    }
}
else
{
    $retorno = "hubo un error";
}

