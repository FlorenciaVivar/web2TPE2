<?php
require_once 'libs/Router.php';
require_once 'api/apiTripController.php';

// CREO EL ROUTER
$router = new Router();

// DEFINO LA TABLA DE RUTEO
$router->addRoute('trips', 'GET', 'ApiTripController', 'getAllTrips');
$router->addRoute('trips/:ID', 'GET', 'ApiTripController', 'getOneTrip');
$router->addRoute('trips/:ID', 'DELETE', 'ApiTripController', 'removeTrip');
$router->addRoute('trips', 'POST', 'ApiTripController', 'insertTrip'); 
//(recurso o accion/:parametro/:otroParametro, verbo, a q controlador voy, a que metodo del controlador voy)

// EJECUTO LA RUTA(SEA CUAL SEA)
$resource= $_GET['resource'];
$method = $_SERVER['REQUEST_METHOD'];
$router->route ($resource, $method);

//esto es lo mimsmo: $router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);
// ($_get [con que recurso], $_server[con que metodo me llamaron->post,get,delete...])
