<?php
require_once 'libs/Router.php';
require_once 'api/apiPackageController.php';

// CREO EL ROUTER
$router = new Router();

// DEFINO LA TABLA DE RUTEO
$router->addRoute('packages', 'GET', 'ApiPackageController', 'getAll');
$router->addRoute('packages/:ID', 'GET', 'ApiPackageController', 'getOnePackage');
$router->addRoute('packages/:ID', 'DELETE', 'ApiPackageController', 'removePackage');
$router->addRoute('packages', 'POST', 'ApiPackageController', 'insertPackage'); 
$router->addRoute('packages/:ID', 'PUT', 'ApiPackageController', 'updatePackage'); 
//(recurso o accion/:parametro/:otroParametro, verbo, a q controlador voy, a que metodo del controlador voy)

// EJECUTO LA RUTA(SEA CUAL SEA)
$resource= $_GET['resource'];
$method = $_SERVER['REQUEST_METHOD'];
$router->route ($resource, $method);

//esto es lo mimsmo: $router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);
// ($_get [con que recurso], $_server[con que metodo me llamaron->post,get,delete...])
