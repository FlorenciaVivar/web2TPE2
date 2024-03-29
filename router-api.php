<?php
require_once 'libs/Router.php';
require_once 'api/apiPackageController.php';
require_once 'api/apiAuthController.php';
// CREO EL ROUTER
$router = new Router();

// DEFINO LA TABLA DE RUTEO
//$router->addRoute(recurso o accion/:parametro/:otroParametro,httpMethod ,controler,metodo del controlador)
$router->addRoute('packages', 'GET', 'ApiPackageController', 'getAll');
$router->addRoute('packages/:ID', 'GET', 'ApiPackageController', 'getOnePackage');
$router->addRoute('packages/:ID', 'DELETE', 'ApiPackageController', 'removePackage');
$router->addRoute('packages', 'POST', 'ApiPackageController', 'insertPackage'); 
$router->addRoute('packages/:ID', 'PUT', 'ApiPackageController', 'updatePackage'); 
$router->addRoute('auth/token', 'GET', 'ApiAuthController', 'getToken'); 
// hago un get de auth/token -> authorization->basic Auth ->me da un token-> copio y pego en la funcion delete 
//y en authorization->barear Token pego eso y send
// EJECUTO LA RUTA(SEA CUAL SEA)
$resource= $_GET['resource'];
$method = $_SERVER['REQUEST_METHOD'];
$router->route ($resource, $method);
//linea 24 es lo mimsmo que: $router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);
// ($_get [con que recurso], $_server[con que metodo me llamaron->post,get,delete...])
