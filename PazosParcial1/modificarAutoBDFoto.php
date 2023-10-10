<?php
use PazosNahuel\autoBD;

require_once 'clases/autoBD.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {

        $autoJson = $_POST['auto_json'];

        
        $autoData = json_decode($autoJson, true);

        
        $foto = $_FILES['foto'];
        $fotoTmp = $foto['tmp_name'];

        
        $pathFoto = isset($autoData['pathFoto']) ? $autoData['pathFoto'] : '';

        
        $auto = new \PazosNahuel\autoBD(
            $autoData['marca'],
            $autoData['patente'],
            $autoData['color'],
            $autoData['precio'],
           
            $pathFoto
        );

       
        $exitoModificar = $auto->modificar();

        if ($exitoModificar) {
           
            $rutaFotoOriginal = $auto->pathFoto;
            $nombreFotoModificada = $autoData['patente']  . '.modificado.' . date('His') . '.jpg';
            $rutaFotoModificada = './autosModificados/' . $nombreFotoModificada;
            
            
            if (move_uploaded_file($fotoTmp, $rutaFotoModificada)) {
                
                unlink($rutaFotoOriginal);
                
                echo json_encode(array('exito' => true, 'mensaje' => 'auto modificado exitosamente.'));
            } else {
                echo json_encode(array('exito' => false, 'mensaje' => 'No se pudo mover la foto.'));
            }
        } else {
            echo json_encode(array('exito' => true, 'mensaje' => 'se pudo modificar el auto en la base de datos.'));
        }
    } else {
        echo json_encode(array('exito' => true, 'mensaje' => 'Se ha subido  foto.'));
    }
}
?>