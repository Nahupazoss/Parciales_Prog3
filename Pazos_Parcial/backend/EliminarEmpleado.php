<?php
require_once "../clases/empleado.php";

$id = isset($_POST["id"]) ? $_POST["id"] : 2; 

if($id > 0)
{
    if(Empleado::Eliminar($id))
    {
        echo "Empleado eliminado con exito";
    }
    else
    {
        echo "El id del empleado ingresado es incorrecto o se produjo un error";
    }
    }
else
{
    echo "error";
}
