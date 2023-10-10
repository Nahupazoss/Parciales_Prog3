<?php

use PazosNahuel\autoBD;

require_once("clases/autoBD.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    
    $autoJson = $_POST['auto_json'];

    
    $autoData = json_decode($autoJson, true);

    // Crear una instancia de autoBD
    $auto = new \PazosNahuel\autoBD(
        $autoData['marca'],
        $autoData['patente'],
        $autoData['color'],
        $autoData['precio'],      
        $autoData['pathFoto']
    );

   
    $exitoEliminar = $auto->eliminar($autoData['patente']);


    if ($exitoEliminar) 
    {
        $resultado = $auto->guardarEnArchivo();
        echo $resultado;
    } 
    else 
    {
        echo json_encode(array('exito' => false, 'mensaje' => 'No se pudo eliminar el auto de la base de datos.'));
    }
} 
else 
{
   
    \PazosNahuel\autoBD::mostrarBorradosJSON();
}
?>
