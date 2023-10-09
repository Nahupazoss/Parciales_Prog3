<?php
require_once "../clases/usuario.php";

$mostar = isset($_GET["tabla"]) ? $_GET["tabla"] : "sin tabla"; 
$retorno = Usuario::traer();
if($mostar == "mostrar"){
    echo "<style>
    table {
      border-collapse: collapse; 
      width: 80%; 
      padding: 10px;
      margin: 50px auto;
      text-align: center;
    }
    td, th {
      border: 1px solid black;
      padding: 8px; 
      text-align: center;
    }
    </style>";
    echo "
    <table >
        <thead>
            <tr>
                <th>ID</th>
                <th>NOMBRE</th>
                <th>CORREO</th>
                <th>ID_PERFIL</th>
            </tr>
        </thead>"; 
    foreach($retorno as $usuario)
    {
        echo "<tr>";
            echo "<td>" . $usuario->id . "</td>";
            echo "<td>" . $usuario->nombre . "</td>";
            echo "<td>" . $usuario->correo . "</td>";
            echo "<td>" . $usuario->id_perfil . "</td>";
            echo "<td>";
    }
    echo "</table>";
}else{
var_dump($retorno);
}