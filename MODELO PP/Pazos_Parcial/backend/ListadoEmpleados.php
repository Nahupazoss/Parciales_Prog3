<?php
require_once "../clases/empleado.php";
require_once "../clases/ICRUD.php";

$tabla = isset($_GET["tabla"]) ? $_GET["tabla"] : "sin tabla"; 
$empleados = Empleado::TraerTodos();


echo "<h1>Listado de Empleados<h1>
<table border='1'
<thead>
<tr>
<th>ID</th>
<th>NOMBRE</th>
<th>CORREO</th>
<th>ID_PERFIL</th>
<th>SUELDO</th>
<th>FOTO</th>
<tr>
</thead>
<tbody>";
    
foreach($empleados as $empleado):
echo "<tr>
        <td>{$empleado->id}</td>
        <td>{$empleado->nombre}</td>
        <td>{$empleado->correo}</td>
        <td>{$empleado->id_perfil}</td>
        <td>{$empleado->sueldo}</td>
        <td><img src = './empleados/fotos/{$empleado->foto}' width = '50' height = '50'></td>
        </tr>";               
endforeach;
echo "</tbody>
      </table>";
?>


<!DOCTYPE html>
<html lang = "en">
    <head>
        <meta charset="UTF-8">
        <meta name = "viewport" content="width=device-width, initial-scale=1.0">
        <title>Listado de Empleados</title>
    </head>
    <body>
    </body>
</html>