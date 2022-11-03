<?php
require_once 'app/controllers/trip.controller.php';
require_once 'app/controllers/airline.controller.php';
require_once 'app/controllers/auth.controller.php';

define('BASE_URL', '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/');
define('LOGIN', '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/login');

$action = 'home'; // acción por defecto para mostrar home
if (!empty($_GET['action'])) {
    $action = $_GET['action'];
}

// parsea la accion
$params = explode('/', $action);

// tabla de ruteo
switch ($params[0]) {
    case 'home':
        //ok
        $controller = new TripController();
        $controller->showHome();
        break;
    case 'login':
        $authController = new AuthController();
        $authController->showFormLogin();
        break;
    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;
    case 'validate':
        $controller = new AuthController();
        $controller->validateUser();
        break;
    case 'trips':
        //ok
        $controller = new TripController();
        $controller->showTrips();
        break;
    case 'aerolineas':
        //ok
        $controller = new AirlineController();
        $controller->showAllAirlines();
        break;
    case 'add':
        //ok
        $airlineController = new AirlineController();
        $airlines = $airlineController->getAll();
        // var_dump($airlines);
        $controller = new TripController();
        $controller->showFormAdd($airlines);
        break;
    case 'addNew':
        //ok
        $controller = new TripController();
        $controller->addTrip();
        break;
    case 'delete':
        // OK obtengo el parametro de la acción
        $controller = new TripController();
        $id = $params[1];
        $controller->deleteTrip($id);
        break;
    case 'modify':
        //ok  obtengo el parametro de la acción
        $controller = new TripController();
        $airlineController = new AirlineController;
        $id = $params[1];
        $airlines = $airlineController->getAll();
        $controller->showOneTripForModify($id, $airlines);
        break;
    case 'modified':
        //ok
        $controller = new TripController;
        $id = $params[1];
        $controller->editTripController($id);
        break;
    case 'showTrip':
        //ok
        $controller = new TripController();
        $id = $params[1];
        $controller->showTrip($id);
        break;
    case 'showTripsByAirline':
        //ok
        $controller = new TripController();
        $id = $params[1];
        $controller->showTripsByAirlineController($id);
        //echo $id;
        break;
    case 'deleteAirline':
        //ok
        $controller = new TripController;
        $id = $params[1];
        $trips = $controller->showTripsByAirlineController($id);
        $controller = new AirlineController();
        $id = $params[1];
        $controller->deleteAirline($id, $trips);
        break;
    case 'modifyAirline':
        $airlineController = new AirlineController;
        $id = $params[1];
        $airlineController->showOneAirlineForModify($id);
        break;
    case 'modifiedAirline':
        $controller = new AirlineController;
        $id_aerolinea = $params[1];
        $controller->editAirlineController($id_aerolinea);
        break;
    case 'addNewAirline':
        $controller = new AirlineController(); 
        $controller->showFormAddAirline();
        $controller->addAirline();
        break;    
    default:
        header("HTTP/1.0 404 Not Found");
        echo ('404 Page not found');
        break;

}
