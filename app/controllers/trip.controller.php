<?php
//incluimos model view y auth
require_once './app/models/trip.model.php';
require_once './app/views/view.php';
require_once './app/helpers/auth.helper.php';

class TripController
{
    private $model;
    private $view;
    private $authHelper;

    public function __construct()
    {
        //instacio las clases
        $this->model = new TripModel();
        $this->view = new TripView();
        $this->authHelper = new AuthHelper();
    }

    public function showHome()
    {
        session_start();
        $this->view->showHome();
    }
    public function showTrips()
    {
        session_start();
        //obtiene las tareas del modelo
        $trips = $this->model->getAll(); // aca agrego $this->model-> nombre de la funcion del model
        //actualizo la vista
        $this->view->showTrips($trips);
        //var_dump($trips)
    }

    public function showTrip($id)
    {
        session_start();
        $oneTrip = $this->model->getOneTrip($id);
        $this->view->showTrip($oneTrip);
    }
    function addTrip()
    {
        session_start();
        //barrera para el que este logueado
        $this->authHelper->checkLoggedIn();
        //verificar si todo llego 
        if (
            !empty($_POST['destino']) && !empty($_POST['fecha']) && !empty($_POST['precio']) && !empty($_FILES['imagenViaje']) && !empty($_POST['descripcionDestino']) && !empty($_POST['id_aerolinea_fk'])
        ) {
            if ($_FILES['imagenViaje']['type'] == "image/jpg" || $_FILES['imagenViaje']['type'] == "image/jpeg" || $_FILES['imagenViaje']['type'] == "image/png") {

                //luego lo mandas al model para que haga un create 
                $destino = $_POST['destino'];
                $fecha = $_POST['fecha'];
                $precio = $_POST['precio'];
                $imagenViaje = $_FILES['imagenViaje']['tmp_name'];
                $descripcionDestino = $_POST['descripcionDestino'];
                $airline = $_POST['id_aerolinea_fk'];

                $this->model->insert($destino, $fecha, $precio, $imagenViaje, $descripcionDestino, $airline);
                // luego mostras el home o "se creo con exito"
                $this->view->showSuccessfully("Viaje agregado con éxito!");

            } else {
                $this->view->showError("Formato de imagen no permitido");
            }
        }
    }

    function showFormAdd($airlines)
    {
        session_start();
        //barrera para el que este logueado
        $this->authHelper->checkLoggedIn();
        $this->view->showFormAltaViaje($airlines); // aca la funcion q despues ponemos en db.php
    }

    function deleteTrip($id)
    {
        session_start();
        //barrera para el que este logueado
        $this->authHelper->checkLoggedIn();
        $this->model->delete($id);
        $this->view->showSuccessfully("Viaje eliminado con éxito!");
        header("Location: " . BASE_URL . 'trips');
    }
    function showOneTripForModify($id, $airlines)
    {
        session_start();
        //barrera para el que este logueado
        $this->authHelper->checkLoggedIn();
        $trip = $this->model->getOneTrip($id);
        $this->view->formModify($trip, $airlines);
    }

    function editTripController($id)
    {
        session_start();
        //barrera para el que este logueado
        $this->authHelper->checkLoggedIn();
        // echo $_POST['precio'];
        // var_dump($_POST);
        if (!empty($id)&&
            !empty($_POST['destino']) 
            && !empty($_POST['fecha']) 
            && !empty($_POST['precio']) 
            && !empty($_POST['descripcionDestino']) 
            && !empty($_POST['id_aerolinea_fk'])
        ) {
            if ($_FILES['imagenViaje']['type'] == "image/jpg" || $_FILES['imagenViaje']['type'] == "image/jpeg" 
            || $_FILES['imagenViaje']['type'] == "image/png") {

                $destino = $_POST['destino']; //lo que va despues del POSt adentro de [] tiene q ser igual a lo q hay en mi DB
                $fecha = $_POST['fecha'];
                $precio = $_POST['precio'];
                $imagenViaje = $_FILES['imagenViaje']['tmp_name'];
                $descripcionDestino = $_POST['descripcionDestino'];
                $airline = $_POST['id_aerolinea_fk'];

                $this->model->editTripModel($id, $destino, $fecha, $precio, $imagenViaje, $descripcionDestino, $airline);
                $this->view->showSuccessfully("Viaje editado con éxito!");
            } else {
                $this->view->showError("Formato de imagen no permitido");
            }
        }
    }
    public function showTripsByAirlineController($id)
    {
       session_start();
        if(!empty($id)){
             $trips = $this->model->getTripsByAirlinesModel($id);
            $this->view->showTrips($trips);
            return $trips;
        }else{
            $this->view->showError("Error, no se puede eliminar esta aerolinea");
        }
    }
}
