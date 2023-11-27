<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as ResponseMW;

require_once __DIR__ . "/autentificadora.php";
require_once __DIR__ . "/accesoDatos.php";
require_once __DIR__ . "/juguete.php";
require_once __DIR__ . "/usuario.php";

class Manejadora
{
    //###################################################################################################
    //###################################################################################################
    public function mostrarUsuarios(Request $request, Response $response, array $args) : Response 
    {
        $users = Usuario::TraerTodosUsuarios();
        $std = new stdclass();

        if($users)
        {
            $std->exito = true;
            $std->mensaje = "Usuarios obtenidos!";
            $std->tabla = json_encode($users);
            $newResponse = $response->withStatus(200);
            $newResponse->getBody()->write(json_encode($std));

            return $newResponse->withHeader('Content-Type', 'application/json');
        }
        else
        {
            $std->exito = true;
            $std->mensaje = "Usuarios NO obtenidos!";
            $std->tabla = '{"tabla":"no obtenida"}';
            $newResponse = $response->withStatus(424);
            $newResponse->getBody()->write(json_encode($std)); 

            return $newResponse->withHeader('Content-Type', 'application/json');
        }
    }
    //###################################################################################################
    //###################################################################################################
    public function crearJuguete(Request $request, Response $response, array $args):Response
    {
        $array = $request->getParsedBody();
        $Recibido = json_decode($array["juguete_json"]);        
        
        $juguete = new Juguete();
        $juguete->marca = $Recibido->marca;
        $juguete->precio = $Recibido->precio;    

        $archivos = $request->getUploadedFiles(); 
        $destino = "../src/fotos/";
        $extension = explode(".", $archivos['foto']->getClientFilename()); //nombre de la ext
        $path =  $juguete->marca . "." . $extension[1];

        $juguete->path_foto = $path;    
        
        $juguete->id = -1;     
        $std = new stdclass();
        
        if($juguete->Agregar())
        {            
            $archivos['foto']->moveTo($destino . $path);
            $std->exito = true;
            $std->mensaje = "juguete  agregado!";
            $newResponse = $response->withStatus(200);
            $newResponse->getBody()->write(json_encode($std)); 

            return $newResponse->withHeader('Content-Type', 'application/json');
        }
        else
        {
            $std->exito = false;
            $std->mensaje = "ERROR! juguete no agregado"; 
            $newResponse = $response->withStatus(418);
            $newResponse->getBody()->write(json_encode($std));   

            return $newResponse->withHeader('Content-Type', 'application/json');
        }
    }
    //###################################################################################################
    //###################################################################################################
    public function loginCorreoYclave(Request $request, Response $response, array $args): Response
    {
        $arrayDeParametros = $request->getParsedBody();
        $obj_respuesta = new stdClass();
        $obj_respuesta->exito = false;
        $obj_respuesta->jwt = null;
        $obj_respuesta->status = 403;

        if (isset($arrayDeParametros["user"])) {
            $obj = json_decode($arrayDeParametros["user"]);
            if ($usuario = Usuario::TraerUsuario($obj)) {
                $data = array();
                unset($usuario->clave);
                $alumno = array("nombre"=>"Nahuel", "apellido"=>"Pazos ");
                $dni_alumno = array("dni_alumno"=>"45583107");
                array_push($data, $usuario);
                array_push($data, $alumno);
                array_push($data, $dni_alumno);

                $obj_respuesta->exito = true;
                $obj_respuesta->jwt =  Autentificadora::crearJWT($data, 120);
                $obj_respuesta->status = 200;
            }
        }

        $contenidoAPI = json_encode($obj_respuesta);
        $response = $response->withStatus($obj_respuesta->status);
        $response->getBody()->write($contenidoAPI);

        return $response->withHeader('Content-Type', 'application/json');
    }
    //###################################################################################################
    //###################################################################################################
    public function loginToken(Request $request, Response $response, array $args) : Response 
    {

        $token = $request->getHeader("token")[0];

        $obj_rta = Autentificadora::verificarJWT($token);

        $status = $obj_rta->verificado ? 200 : 403;

        $newResponse = $response->withStatus($status);

        $newResponse->getBody()->write(json_encode($obj_rta));
    
        return $newResponse->withHeader('Content-Type', 'application/json');
    }
    //###################################################################################################
    //###################################################################################################
    public function borrarJuguete(Request $request, Response $response, array $args) : Response 
    {       
        $id = $args['id_juguete'];
        $token = $request->getHeaderLine('token');
        $obj_rta = Autentificadora::verificarJWT($token);

        if(!$obj_rta->verificado)
        {
            $std = new stdClass();
            $std->éxito = false;
            $std->mensaje = 'Token inválido';
            $newResponse = new ResponseMW();
            $newResponse->withStatus(418);
            $newResponse->getBody()->write(json_encode($std));        
        }
        else
        {
            $juguete  = Juguete::TraerUno($id);

            if(Juguete::Eliminar($id))
            {
                $rutaFoto = '../src/fotos/' . $juguete->path_foto;

                if (file_exists($rutaFoto)) 
                {
                    unlink($rutaFoto);
                }
                $std = new stdClass();
                $std->éxito = true;
                $std->mensaje = 'Juguete borrado exitosamente';
                $newResponse = new ResponseMW();
                $newResponse->withStatus(200);
                $newResponse->getBody()->write(json_encode($std));
            }
            else
            {
                $std = new stdClass();
                $std->éxito = false;
                $std->mensaje = 'Juguete NO existe ';
                $newResponse = new ResponseMW();
                $newResponse->withStatus(418);
                $newResponse->getBody()->write(json_encode($std));
            }           
        }
        return $newResponse->withHeader('Content-Type', 'application/json');
    }
    //###################################################################################################
    //###################################################################################################
    public function ModificarUno(Request $request, Response $response, array $args): Response
    {
        $parametros = $request->getParsedBody();

        $obj_respuesta = new stdclass();
        $obj_respuesta->exito = false;
        $obj_respuesta->mensaje = "No se pudo modificar el juguete";
        $obj_respuesta->status = 418;

        if (isset($request->getHeader("token")[0]) && isset($parametros["juguete"])) 
        {
            $token = $request->getHeader("token")[0];
            $obj_json = json_decode($parametros["juguete"]);

            $datos_token = Autentificadora::obtenerPayLoad($token);
            $usuario_token = $datos_token->payload->usuario;
            $perfil_usuario = $usuario_token->perfil;// 1- propietario, 2- supervisor, 3- empleado

            if ($perfil_usuario == "supervisor" ||  $perfil_usuario == "propietario" ) 
            {
                if ($juguete = Juguete::TraerUno($obj_json->id_juguete)) 
                {
                    $juguete->marca = $obj_json->marca;
                    $juguete->precio = $obj_json->precio;

                    $foto = "";
                    //#####################################################
                    // Guardado de foto/archivo
                    if (count($request->getUploadedFiles())) {
                        $archivos = $request->getUploadedFiles();
                        $destino = "./src/fotos/";

                        $nombreAnterior = $archivos['foto']->getClientFilename();
                        $extension = explode(".", $nombreAnterior);
                        $extension = array_reverse($extension);

                        $foto = $destino . $juguete->marca . "_modificacion" . "." . $extension[0];
                        $archivos['foto']->moveTo("." . $foto); // OjO agregue un punto .
                        $juguete->path_foto = $foto;
                    }
                    //#####################################################

                    if ($juguete->ModificarJuguete()) 
                    {
                        $obj_respuesta->exito = true;
                        $obj_respuesta->mensaje = "Juguete Modificado!";
                        $obj_respuesta->status = 200;
                    }
                } 
                else 
                {
                    $obj_respuesta->mensaje = "El Juguete no existe en el listado!";
                }
            }
            else 
            {
                $obj_respuesta->mensaje = "Usuario no autorizado para realizar la accion, debe ser supervisor. {$usuario_token->nombre} - {$usuario_token->apellido} - {$usuario_token->perfil}";
            }
        }

        $newResponse = $response->withStatus($obj_respuesta->status);
        $newResponse->getBody()->write(json_encode($obj_respuesta));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }
    //###################################################################################################
    //###################################################################################################
    public function mostrarJuguetes(Request $request, Response $response, array $args) : Response 
    {
        $Juguete = Juguete::TraerJuguetes();
        $std= new stdclass();

        if($Juguete)
        {
            $std->exito = true;
            $std->mensaje = "Juguete obtenidos!";
            $std->tabla = json_encode($Juguete);
            $newResponse = $response->withStatus(200);
            $newResponse->getBody()->write(json_encode($std));            
            return $newResponse->withHeader('Content-Type', 'application/json');
        }
        else
        {
            $std->exito = false;
            $std->mensaje = "Juguete NO obtenidos!";
            $std->tabla = '{"tabla":"no obtenida"}';
            $newResponse = $response->withStatus(424);
            $newResponse->getBody()->write(json_encode($std));            
            return $newResponse->withHeader('Content-Type', 'application/json');
        }
    }
    //###################################################################################################
    //###################################################################################################
    public function crearUsuario(Request $request, Response $response, array $args):Response
    {
        $parametros = $request->getParsedBody();

        $obj_respuesta = new stdclass();
        $obj_respuesta->exito = false;
        $obj_respuesta->mensaje = "No se pudo agregar el usuario";
        $obj_respuesta->status = 418;

        if (isset($parametros["usuario"])) {
            $obj = json_decode($parametros["usuario"]);

            $usuario = new Usuario();
            $usuario->correo = $obj->correo;
            $usuario->clave = $obj->clave;
            $usuario->nombre = $obj->nombre;
            $usuario->apellido = $obj->apellido;
            $usuario->perfil = $obj->perfil;

            //#####################################################
            // Guardado de foto/archivo
            if (count($request->getUploadedFiles())) {
                $archivos = $request->getUploadedFiles();
                $destino = "./src/fotos/";

                $nombreAnterior = $archivos['foto']->getClientFilename();
                $extension = explode(".", $nombreAnterior);
                $extension = array_reverse($extension);

                $foto = $destino . $usuario->correo . "." . $extension[0];
                $archivos['foto']->moveTo("." . $foto); // OjO agregue un punto .
                $usuario->foto = $foto;
            }
            //#####################################################
            
            $id_agregado = $usuario->Agregar();

            if ($id_agregado) {
                $obj_respuesta->exito = true;
                $obj_respuesta->mensaje = "Usuario Agregado";
                $obj_respuesta->status = 200;
            }
        }

        $newResponse = $response->withStatus($obj_respuesta->status);
        $newResponse->getBody()->write(json_encode($obj_respuesta));

        return $newResponse->withHeader('Content-Type', 'application/json');
    }
    //###################################################################################################
    //###################################################################################################
}