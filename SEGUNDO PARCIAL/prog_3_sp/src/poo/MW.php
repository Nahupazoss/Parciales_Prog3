<?php

use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as ResponseMW;

require_once "autentificadora.php";
require_once "Usuario.php"; 
require_once "Juguete.php";
class MW
{
    public function verificarjwt(Request $request, RequestHandler $handler) : ResponseMW{
        $token = $request->getHeaderLine('token');
        $obj_rta = Autentificadora::verificarJWT($token);

        if (!$obj_rta->verificado) 
        {
            $std = new stdClass();
            $std->éxito = false;
            $std->mensaje = 'Token inválido';

            $response = new ResponseMW();
            $response->withStatus(403);
            $response->getBody()->write(json_encode($std));
    
            return $response->withHeader('Content-Type', 'application/json');
        }

        return $handler->handle($request);
    }
    
    public static function ValidarParametrosVacios(Request $request, RequestHandler $handler): ResponseMW
    {
        $contenidoAPI = "";
        $arrayDeParametros = $request->getParsedBody();
        $obj_respuesta = new stdClass();
        $obj_respuesta->status = 409;
        $obj = null;

        if (isset($arrayDeParametros["user"])) {
            $obj = json_decode(($arrayDeParametros["user"]));
        } else if (isset($arrayDeParametros["usuario"])) {
            $obj = json_decode(($arrayDeParametros["usuario"]));
        }

        if ($obj->correo != "" && $obj->clave != "") {
            $response = $handler->handle($request);
            $contenidoAPI = (string) $response->getBody();
            $api_respuesta = json_decode($contenidoAPI);
            $obj_respuesta->status = $api_respuesta->status;
        } else {
            $mensaje_error = "Parametros vacios: \n";
            if ($obj->correo == "") {
                $mensaje_error .= "- correo \n";
            }
            if ($obj->clave == "") {
                $mensaje_error .= "- clave \n";
            }
            $obj_respuesta->mensaje = $mensaje_error;
            $contenidoAPI = json_encode($obj_respuesta);
        }

        $response = new ResponseMW();
        $response = $response->withStatus($obj_respuesta->status);
        $response->getBody()->write($contenidoAPI);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function VerificarSiExisteUsuario(Request $request, RequestHandler $handler): ResponseMW
    {
        $arrayDeParametros = $request->getParsedBody();
        $obj_respuesta = new stdClass();
        $obj_respuesta->mensaje = "El usuario no existe!";
        $obj_respuesta->status = 403;
        $obj = null;

        if (isset($arrayDeParametros["user"])) {
            $obj = json_decode(($arrayDeParametros["user"]));
        } else if (isset($arrayDeParametros["usuario"])) {
            $obj = json_decode(($arrayDeParametros["usuario"]));
        }

        if ($obj) { 
            if (Usuario::TraerUsuario($obj)) {
                $response = $handler->handle($request);
                $contenidoAPI = (string) $response->getBody();
                $api_respuesta = json_decode($contenidoAPI);
                $obj_respuesta->status = $api_respuesta->status;
            } else {
                $contenidoAPI = json_encode($obj_respuesta);
            }
        }

        $response = new ResponseMW();
        $response = $response->withStatus($obj_respuesta->status);
        $response->getBody()->write($contenidoAPI);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function ChequearJWT(Request $request, RequestHandler $handler): ResponseMW
    {
        $contenidoAPI = "";
        $obj_respuesta = new stdClass();
        $obj_respuesta->mensaje = "Token Invalido!";
        $obj_respuesta->status = 403;

        if (isset($request->getHeader("token")[0])) {
            $token = $request->getHeader("token")[0];

            if ($obj = Autentificadora::verificarJWT($token)) {
                if ($obj->verificado) {
                    $response = $handler->handle($request);
                    $contenidoAPI = (string) $response->getBody();
                    $api_respuesta = json_decode($contenidoAPI);
                    $obj_respuesta->status = $response->getStatusCode();
                } else {
                    $obj_respuesta->mensaje = $obj->mensaje;
                    $contenidoAPI = json_encode($obj_respuesta);
                }
            }
        }

        $response = new ResponseMW();
        $response = $response->withStatus($obj_respuesta->status);
        $response->getBody()->write($contenidoAPI);
        return $response->withHeader('Content-Type', 'application/json');
    }


    public static function ListarUsuarioPropietario(Request $request, RequestHandler $handler): ResponseMW
    {
        $contenidoAPI = "";
        $api_respuesta = new stdClass();
        $api_respuesta->exito = false;
        $api_respuesta->mensaje = "El usuario no es propietario!";
        $api_respuesta->status = 403;

        if (isset($request->getHeader("token")[0])) 
        {
            $token = $request->getHeader("token")[0];

            $datos_token = Autentificadora::obtenerPayLoad($token);
            $usuario_token = $datos_token->payload->usuario;
            $perfil_usuario = $usuario_token->perfil;

            if ($perfil_usuario == "propietario") 
            {
                $response = $handler->handle($request);
                $contenidoAPI = (string) $response->getBody();
                $api_respuesta = json_decode($contenidoAPI);
                $array_usuarios = json_decode($api_respuesta->dato);

                foreach ($array_usuarios as $usuario) 
                {
                    unset($usuario->clave);
                }
                
                $api_respuesta = MW::ArmarTablaPropietario($array_usuarios);
            }
            else
            {
                $api_respuesta = json_encode($api_respuesta);
            }
        }
        $response = new ResponseMW();
        $response = $response->withStatus(200);
        $response->getBody()->write($api_respuesta);
        return $response;
    }

    public static function ListarTablaSinClavePropietario(Request $request, RequestHandler $handler): ResponseMW
    {
        $contenidoAPI = "";
        $contenidoAPI = "";
        $obj_respuesta = new stdClass();
        $obj_respuesta->exito = false;
        $obj_respuesta->mensaje = "El usuario no es propietario!";
        $obj_respuesta->status = 403;

        if (isset($request->getHeader("token")[0])) 
        {
            $token = $request->getHeader("token")[0];

            $datos_token = Autentificadora::obtenerPayLoad($token);
            $usuario_token = $datos_token->payload->usuario;
            $perfil_usuario = $usuario_token->perfil;

            if ($perfil_usuario == "propietario") 
            {
                $response = $handler->handle($request);
                $contenidoAPI = (string) $response->getBody();

                $api_respuesta = json_decode($contenidoAPI);
                $array_usuarios = json_decode($api_respuesta->dato);
    
                foreach ($array_usuarios as $usuario) 
                {
                    unset($usuario->clave);
                }
                $contenidoAPI = MW::ArmarTablaPropietario($array_usuarios);
            }
        }
        $contenidoAPI = json_encode($obj_respuesta);
        $response = new ResponseMW();
        $response = $response->withStatus($obj_respuesta->status);
        $response->getBody()->write($contenidoAPI);
        return $response->withHeader('Content-Type', 'application/json');
    }

    private static function ArmarTablaPropietario($listado): string
    {
    $camposExcluidos = ['id', 'clave', 'foto', 'perfil'];

    $tabla = "<table><thead><tr>";
    foreach ($listado[0] as $key => $value) {
        if (!in_array($key, $camposExcluidos)) {
            $tabla .= "<th>{$key}</th>";
        }
    }
    $tabla .= "</tr></thead><tbody>";

    foreach ($listado as $item) {
        $tabla .= "<tr>";
        foreach ($item as $key => $value) {
            if ($key == "foto") {
                $tabla .= "<td><img src='{$value}' width=25px></td>";
            } else {
                if (!in_array($key, $camposExcluidos)) {
                    $tabla .= "<td>{$value}</td>";
                }
            }
        }
        $tabla .= "</tr>";
    }
    $tabla .= "</tbody></table> <br>";
    return $tabla;
}

public static function ListarTablaSinClave(Request $request, RequestHandler $handler): ResponseMW
    {
        $contenidoAPI = "";

            $response = $handler->handle($request);
            $contenidoAPI = (string) $response->getBody();

            $api_respuesta = json_decode($contenidoAPI);
            $array_usuarios = json_decode($api_respuesta->dato);

            foreach ($array_usuarios as $usuario) {
                unset($usuario->clave);
            }
            $contenidoAPI = MW::ArmarTablaSinClave($array_usuarios);
        

        $response = new ResponseMW();
        $response = $response->withStatus(200);
        $response->getBody()->write($contenidoAPI);
        return $response;
    }

    private static function ArmarTablaSinClave($listado): string
    {
        $tabla = "<table><thead><tr>";
        foreach ($listado[0] as $key => $value) {
            if ($key != "clave") {
                $tabla .= "<th>{$key}</th>";
            }
        }
        $tabla .= "</tr></thead><tbody>";

        foreach ($listado as $item) {
            $tabla .= "<tr>";
            foreach ($item as $key => $value) {
                if ($key == "foto") {
                    $tabla .= "<td><img src='{$value}' width=25px></td>";
                } else {
                    if ($key != "clave") {
                        $tabla .= "<td>{$value}</td>";
                    }
                }
            }
            $tabla .= "</tr>";
        }
        $tabla .= "</tbody></table> <br>";
        return $tabla;
    }

    public function ListarTablaJuguetes(Request $request, RequestHandler $handler): ResponseMW
    {
        $contenidoAPI = "";

            $response = $handler->handle($request);
            $contenidoAPI = (string) $response->getBody();

            $api_respuesta = json_decode($contenidoAPI);
            $array_juguetes = json_decode($api_respuesta->dato);

            $contenidoAPI = MW::ArmarTablaJuguetes($array_juguetes);
        

        $response = new ResponseMW();
        $response = $response->withStatus(200);
        $response->getBody()->write($contenidoAPI);
        return $response;
    }

    private static function ArmarTablaJuguetes($listado): string
    {
        $tabla = "<table><thead><tr>";
        foreach ($listado[0] as $key => $value) {
            $tabla .= "<th>{$key}</th>";
        }
        $tabla .= "</tr></thead><tbody>";

        foreach ($listado as $item) {
            $tabla .= "<tr>";
            foreach ($item as $key => $value) {
                if ($key == "path_foto") {
                    $tabla .= "<td><img src='{$value}' width=25px></td>";
                } else {
                    $tabla .= "<td>{$value}</td>";
                }
            }
            $tabla .= "</tr>";
        }
        $tabla .= "</tbody></table> <br>";
        return $tabla;
    }

    public static function VerificarCorreo(Request $request, RequestHandler $handler): ResponseMW
    {
        $arrayDeParametros = $request->getParsedBody();
        $obj_respuesta = new stdClass();
        $obj_respuesta->mensaje = "El correo existe!";
        $obj_respuesta->status = 403;
        $obj = null;

        if (isset($arrayDeParametros["user"])) {
            $obj = json_decode(($arrayDeParametros["user"]));
        } else if (isset($arrayDeParametros["usuario"])) {
            $obj = json_decode(($arrayDeParametros["usuario"]));
        }

        if ($obj) {
            if (!Usuario::TraerUsuarioPorCorreo($obj->correo)) {
                $response = $handler->handle($request);
                $contenidoAPI = (string) $response->getBody();
                $api_respuesta = json_decode($contenidoAPI);
                $obj_respuesta->status = $api_respuesta->status;
            } else {
                $contenidoAPI = json_encode($obj_respuesta);
            }
        }

        $response = new ResponseMW();
        $response = $response->withStatus($obj_respuesta->status);
        $response->getBody()->write($contenidoAPI);
        return $response->withHeader('Content-Type', 'application/json');
    }
}

