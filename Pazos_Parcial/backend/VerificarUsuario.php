<?php 
require_once "../clases/usuario.php";

$usuario_json = isset($_POST["usuario_json"]) ? $_POST["usuario_json"] : null;
$usuario_decode = json_decode($usuario_json);

$correo = $usuario_decode->correo;
$clave = $usuario_decode->clave;
echo $correo . "-" . $clave;
$resultado = Usuario::traerUno($correo,$clave);

if($resultado == null)
{
    echo "error";
}
else
{
    echo "usuario verificado" ;
}