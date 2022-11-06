<?php
require_once 'app/models/trip.model.php';
require_once 'api/apiView.php';

class ApiTripController{
    private $model;
    private $view;

    function __construct(){
        $this->model= new TripModel();
        $this->view = new ApiView();
    }

    public function getAllTrips($params = null){
        $trips = $this->model->getAll();
        //var_dump($trips);
        $this->view->response($trips, 200);
    }

    public function getOneTrip($params = null){
        $id = $params[':ID'];
        //var_dump($id);
        $trip = $this->model->getOneTrip($id);
        if($trip)
            $this->view->response($trip, $id);
        else
        $this->view->response("Viaje con id=$id no encontrado ", 404);
    }

    public function removeTrip ($params = null){
        $id = $params[':ID'];
        $trip = $this->model->getOneTrip($id);

        if ($trip) {
            $this->model->delete($id);
            $this->view->response("Viaje con id=$id eliminado con éxito", 200);
        }
        else 
            $this->view->response("Viaje id=$id no encontrado", 404);

    }
}