<?php
require_once "../clases/empleado.php";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $empleado_json = isset($_POST["empleado_json"]) ? $_POST["empleado_json"] : null;
    $foto = isset($_FILES["foto"]) ? $_FILES["foto"] : null;

    $empleado_data = json_decode($empleado_json);

    if($empleado_data && $foto)
    {
        $empleado = new Empleado($empleado_data->id,$empleado_data->nombre,$empleado_data->correo,$empleado_data->clave,$empleado_data->id_perfil,$foto["name"],$empleado_data->sueldo);
        $resultado = $empleado->Modificar($empleado->id);

        $obj = new stdClass();
        $obj->exito = $resultado;
        $obj->mensaje = "Error al modificar al empleado.";

        if($resultado)
        {
            $obj->mensaje = "Empleado modificado correctamente.";
        }

        echo json_encode($obj);
    } 
    else 
    {
        $obj = new stdClass();
        $obj->exito = false;
        $obj->mensaje = "Error en los datos recibidos.";

        echo json_encode($obj);
    }
}
