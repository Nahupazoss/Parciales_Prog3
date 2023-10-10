<?php
use PazosNahuel\autoBD;

require_once 'clases/autoBD.php';
$obj = json_decode($_POST['auto_json']);

$newauto = new autoBD( $obj->marca, $obj->patente, $obj->color, $obj->precio);

$result = $newauto->modificar();

if($result == true){

    echo "se modifico correctamente";

}else {

    echo "No se modifico correctamente";

}

?>
