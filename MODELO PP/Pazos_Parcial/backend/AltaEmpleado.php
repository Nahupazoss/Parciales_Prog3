<?php
require_once "../clases/empleado.php";

$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "sin nombre"; 
$correo = isset($_POST["correo"]) ? $_POST["correo"] : "sin correo"; 
$clave = isset($_POST["clave"]) ? $_POST["clave"] : "sin clave";
$id_perfil = isset($_POST["id_perfil"]) ? $_POST["id_perfil"] : 0;
$sueldo = isset($_POST["sueldo"]) ? $_POST["sueldo"] : 0;
$hora = date('His');

$foto_name = $_FILES['foto']['name'];
$foto_tmp_name = $_FILES['foto']['tmp_name'];
$foto_extension = pathinfo($foto_name, PATHINFO_EXTENSION);
$hora = date('His');
$new_foto_name = $nombre.'.'.$hora . '.' . $foto_extension; 
$destinoFoto = "empleados/fotos/" . $new_foto_name;
move_uploaded_file($_FILES["foto"]["tmp_name"],$destinoFoto);
$uploadOk = TRUE;

if (file_exists($destinoFoto)) 
{
    $uploadOk = FALSE; //echo "El archivo ya existe. Verifique!!!";
}
if ($_FILES["foto"]["size"] > 5000000000000 ) 
{
    $uploadOk = FALSE;// echo "El archivo es demasiado grande. Verifique!!!";
}
$tipoArchivo = pathinfo($destinoFoto, PATHINFO_EXTENSION);
if($tipoArchivo != "jpg" && $tipoArchivo != "jpeg" && $tipoArchivo != "gif"&& $tipoArchivo != "png") 
{ 
    $uploadOk = FALSE;//   echo "Solo son permitidas imagenes con extension JPG, JPEG, PNG o GIF.";
}

$new = new Empleado(0,$nombre,$correo,$clave,$id_perfil,$new_foto_name,$sueldo);

if($new->nombre == $nombre && $new->correo == $correo && $new->clave == $clave && $new->id_perfil == $id_perfil && $new->foto == $new_foto_name && $new->sueldo == $sueldo)
{
    if($new->Agregar())
    {
        echo "empleado agregado con exito";
    }
    else
    {
        echo "error al agregar";
    }
}
else
{
    $retorno = "error faltan o ingresaste mal un campo";
}

