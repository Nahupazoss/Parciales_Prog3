<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use \Slim\Routing\RouteCollectorProxy;

require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . "/../poo/manejadora.php";
require_once __DIR__ . "/../poo/autentificadora.php";
require_once __DIR__ . "/../poo/MW.php";

$app = AppFactory::create();

$app->get('/', \Manejadora::class . ':mostrarUsuarios');

$app->post('/', \Manejadora::class . ':crearJuguete')
->add(\MW::class . ':verificarjwt');

$app->get('/juguetes', \Manejadora::class . ':mostrarJuguetes');

$app->post('/login', \Manejadora::class . ':loginCorreoYclave');

$app->get('/login', \Manejadora::class . ':loginToken');

$app->group('/toys',  function (RouteCollectorProxy $grupo)
{
    $grupo->delete("/{id_juguete}",\Manejadora::class . ':borrarJuguete');
    $grupo->post('/', \Manejadora::class . ':ModificarUno');
})->add(\MW::class . ':verificarjwt');

$app->group('/tablas', function (RouteCollectorProxy $grupo) {
    $grupo->get('/usuarios', \Usuario::class . ':TraerTodos')
    ->add(\MW::class . '::ListarTablaSinClave');
    $grupo->post('/usuarios', \Usuario::class . ':TraerTodos')
    ->add(\MW::class . '::ListarUsuarioPropietario')
    ->add(\MW::class . ':verificarjwt');
    $grupo->get('/juguetes', \Juguete::class . ':TraerTodos')
    ->add(\MW::class . ':ListarTablaJuguetes');
});

$app->post('/usuarios', \Manejadora::class . ':crearUsuario')
->add(\MW::class . '::VerificarCorreo')
->add(\MW::class . '::ValidarParametrosVacios');


try 
{
    //CORRE LA APLICACIÓN.
    $app->run();
} 
catch (Exception $e) 
{
    // Muestro mensaje de error
    die(json_encode(array("status" => "failed", "message" => "This action is not allowed")));
}
  