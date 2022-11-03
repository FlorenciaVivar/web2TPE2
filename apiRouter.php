<?php
require_once './libs/Router.php';
require_once './app/controllers/tripApi.controller.php';

// crea el router
$router = new Router();

// defina la tabla de ruteo
$router->addRoute('trips', 'GET', 'TripApiController', 'getTrips');
$router->addRoute('trips/:ID', 'GET', 'TripApiController', 'getTrip');
$router->addRoute('trips/:ID', 'DELETE', 'TripApiController', 'deleteTrip');
$router->addRoute('trips', 'POST', 'TripApiController', 'insertTrip'); 

// ejecuta la ruta (sea cual sea)
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);
