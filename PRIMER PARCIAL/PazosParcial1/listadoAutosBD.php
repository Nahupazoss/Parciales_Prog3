<?php

use PazosNahuel\autoBD;

require_once 'clases/autoBD.php';


?>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>MARCA</th>
            <th>PATENTE</th>
            <th>COLOR</th>
            <th>PRECIO</th>
            <th>FOTO</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
     
            $autos = autoBD::traer();

            foreach ($autos as $auto) {
                echo "<tr>";
                echo "<td>" . $auto->marca . "</td>";
                echo "<td>" . $auto->patente . "</td>";
                echo "<td>" . $auto->color. "</td>";
                echo "<td>" . $auto->precio . "</td>";
                echo "<td><img src='" . $auto->pathFoto . "' alt='Foto del neumático'></td>";
                echo "</tr>";
            }
     
        ?>
    </tbody>
</table>