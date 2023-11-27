<?php
require_once "../clases/usuario.php";

$usuario_json = isset($_POST["usuario_json"]) ? $_POST["usuario_json"] : null;
$usuario_decode = json_decode($usuario_json);
var_dump($usuario_decode);
if($usuario_decode)
{
    $usuario  = new Usuario($usuario_decode->id,$usuario_decode->nombre,$usuario_decode->correo,$usuario_decode->clave,$usuario_decode->id_perfil);

    if($usuario->ModificarBD())
    {
        echo '{"exito" : true,"mensaje": "modificado"}';
    }
    else
    {
        echo '{"exito" : false,"mensaje": "NO modificado"}'; 
    }
}
else
{ 
    echo "error";
}
    

