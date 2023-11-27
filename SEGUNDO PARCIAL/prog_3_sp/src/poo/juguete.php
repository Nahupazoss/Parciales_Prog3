<?php

use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as ResponseMW;

require_once "accesoDatos.php";

class Juguete
{
    public int $id;
    public string $marca;
    public float $precio;
    public string $path_foto;

    public function Agregar()
    {
        $retorno = false;

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();    
        $consulta =$objetoAccesoDato->RetornarConsulta ("INSERT INTO `juguetes`( `marca`, `precio`, `path_foto`)
        VALUES (:marca, :precio, :path_foto)");                  
        $consulta->bindValue(':marca', $this->marca, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
        $consulta->bindValue(':path_foto', $this->path_foto, PDO::PARAM_STR);
        $consulta->execute();  

        if ($consulta->rowCount()>0) 
        {
            $retorno = true;
        }  
        return $retorno;
    }
    //###################################################################################################
    //###################################################################################################
    public static function obtenerId($marca, $precio,$path_foto)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();    
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT id FROM juguetes WHERE marca = :marca AND precio = :precio AND path_foto = :path_foto");
        $consulta->bindValue(':marca', $marca, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $precio, PDO::PARAM_INT);
        $consulta->bindValue(':path_foto', $path_foto, PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);  

        if ($resultado && isset($resultado['id'])) 
        {
          return $resultado['id'];
        }
        else
        {
          return null;
        }
    } 
    //###################################################################################################
    //###################################################################################################
    public static function TraerJuguetes()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("SELECT * FROM juguetes");
        $consulta->execute();
        $Juguete = $consulta->fetchAll(PDO::FETCH_CLASS, "Juguete");  

        return $Juguete;
    }
    //###################################################################################################
    public function TraerTodos(Request $request, Response $response, array $args): Response
    {
        $obj_respuesta = new stdClass();
        $obj_respuesta->exito = false;
        $obj_respuesta->mensaje = "No se encontraron juguetes!";
        $obj_respuesta->dato = "{}";
        $obj_respuesta->status = 424;

        $juguetes = Juguete::TraerJuguetes();

        if (count($juguetes)) {
            $obj_respuesta->exito = true;
            $obj_respuesta->mensaje = "Juguetes encontrados!";
            $obj_respuesta->dato = json_encode($juguetes);
            $obj_respuesta->status = 200;
        }

        $newResponse = $response->withStatus($obj_respuesta->status);
        $newResponse->getBody()->write(json_encode($obj_respuesta));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }
    //###################################################################################################
    //###################################################################################################
    public static function Eliminar($id)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM juguetes WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();      
        $retorno = false;

        if ($consulta->rowCount() > 0) 
        {
            $retorno = true;
        }

        return $retorno;
    }
    //###################################################################################################
    //###################################################################################################
    public static function TraerUno($id)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("SELECT * FROM juguetes WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        $juguete = $consulta->fetchObject('Juguete');

        return $juguete;
    }
    //###################################################################################################
    //###################################################################################################
    public function ModificarJuguete()
    {
        $retorno = false;

        $accesoDatos = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $accesoDatos->retornarConsulta(
            "UPDATE juguetes
             SET marca = :marca, precio = :precio, path_foto = :path_foto
             WHERE id = :id"
        );

        $consulta->bindValue(":id", $this->id, PDO::PARAM_INT);
        $consulta->bindValue(":marca", $this->marca, PDO::PARAM_STR);
        $consulta->bindValue(":precio", $this->precio, PDO::PARAM_INT);
        $consulta->bindValue(":path_foto", $this->path_foto, PDO::PARAM_STR);
        $consulta->execute();

        $total_modificado = $consulta->rowCount(); // verifico las filas afectadas por la consulta
        if ($total_modificado == 1) {
            $retorno = true;
        }

        return $retorno;
    }

    

}