<?php
//incluimos model y view
require_once './app/views/view.php';
require_once './app/models/airline.model.php';
require_once './app/helpers/auth.helper.php';

class AirlineController
{
    private $model;
    private $view;
    private $authHelper;

    public function __construct()
    {
        $this->model = new AirlineModel();
        $this->view = new TripView();
        $this->authHelper = new AuthHelper();
    }

    public function getAll()
    {
        $airlines = $this->model->getAll();
        return $airlines;
    }

    public function showAllAirlines()
    {
        session_start();
        $airlines = $this->getAll();
        // //actualizo la vista
        $this->view->showAirlines($airlines);
    }

    public function deleteAirline($id, $trips)
    {
        $this->authHelper->getLoggedUserName();
        $this->authHelper->checkLoggedIn();
        if (empty($trips)) {
            if (isset($id)) {
                //barrera para el que este logueado
                $this->model->deleteAirlineModel($id);
            } else {
                $this->view->showError("Error al intentar eliminar");
            } 
        }
        else{
            $this->view->showError("No se puede eliminar la aerolinea, ya que tiene viajes por realizar");
        }
    }
    function showOneAirlineForModify($id)
    {
        session_start();
        //barrera para el que este logueado
        $this->authHelper->checkLoggedIn();
        $airline = $this->model->getOneAirline($id);
        //var_dump($airline);
        $this->view->formModifyAirline($airline);
    }
    function editAirlineController($id)
    {
        session_start();
        //barrera para el que este logueado
        $this->authHelper->checkLoggedIn();
        if (!empty($_POST['nombre'])) {
            if ($_FILES['imagenAerolinea']['type'] == "image/jpg" || $_FILES['imagenAerolinea']['type'] == "image/jpeg" || $_FILES['imagenAerolinea']['type'] == "image/png") {

                $nombre = $_POST['nombre']; //lo que va despues del POSt adentro de [] tiene q ser igual a lo q hay en mi DB
                $imagenAerolinea = $_FILES['imagenAerolinea']['tmp_name'];
                $this->model->editAirlineModel($id, $nombre, $imagenAerolinea);
                $this->view->showSuccessfully('Aerolinea editada con éxito!');
            } else {
                $this->view->showError("Formato de imagen no permitido");
            }
        }
    }
    function showFormAddAirline()
    {
        session_start();
        //barrera para el que este logueado
        $this->authHelper->checkLoggedIn();
        $this->view->showFormAltaAirline();
    }
    function addAirline()
    {
        //barrera para el que este logueado
        $this->authHelper->checkLoggedIn();
        //verificar si todo llego $_post

        if (!empty($_POST['nombre'])&& !empty($_FILES['imagenAerolinea']['tmp_name'])) {
            if ($_FILES['imagenAerolinea']['type'] == "image/jpg" || $_FILES['imagenAerolinea']['type'] == "image/jpeg" || $_FILES['imagenAerolinea']['type'] == "image/png") {

                //despues lo mandas al model para que haga un create 
                $nombre = $_POST['nombre'];
                $imagenAerolinea = $_FILES['imagenAerolinea']['tmp_name'];
                $this->model->insertAirline($nombre, $imagenAerolinea);
                $this->view->showSuccessfully("Aerolinea agregada con éxito!");
            } else {
                $this->view->showError("Formato de imagen no permitido");
            }
        }
    }
}
