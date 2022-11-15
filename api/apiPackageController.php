<?php
require_once 'app/models/travelPackage.model.php';
require_once 'api/apiView.php';
require_once 'app/helpers/authApi.Helper.php';

class ApiPackageController{
    private $model;
    private $view;
    private $authHelper;
    private $data;

    function __construct(){
        $this->model= new TravelPackageModel();
        $this->view = new ApiView();
        $this->data =  file_get_contents("php://input"); 
        $this->authHelper = new AuthApiHelper();
        // file get content -> permite leer la entrada de texto crudo q se manda en formato RAW
    }
   private function getData() {
        return json_decode($this->data);
   // json_decode ->  convierte el string recibido a JSON y devuelve un objecto JSON
    }

//TRAE TODOS LOS PAQUETES
    public function getAll($params = null){
       
        $packages = $this->model->getAll();
        //var_dump($paquetes);
        $this->view->response($packages, 200); 
      
        if(isset($_GET['order']) && isset($_GET['sort'])){
            if (($_GET['sort']=="destino") || ($_GET['sort']=="DESTINO")){
                if(($_GET['order']=="ASC") || ($_GET['order']=="asc")){
                    $packages = $this->model->ordenAscendente();
                    }
                else if(($_GET['order']=="DESC") || ($_GET['order']=="desc")){
                    $packages = $this->model->ordenDescendente();
                    }  
            }
        }
    }

//TRAE UN PAQUETE 
    public function getOnePackage($params = null){
        $id = $params[':ID'];
        //var_dump($id);
        $package = $this->model->getOnePackage($id);
        if($package)
            $this->view->response($package, $id);
        else
        $this->view->response("Paquete con id=$id no encontrado ", 404);
    }
//ELIMINA UN PAQUETE
    public function removePackage ($params = null){
        $id = $params[':ID'];
        if(!$this->authHelper->isLoggedIn()){
            $this->view->response("No estas logueado", 401);
            return;
        }

        $package = $this->model->getOnePackage($id);

        if ($package) {
            $this->model->deleteTravelPackageModel($id);
            $this->view->response("Viaje con id=$id eliminado con éxito", 200);
        }
        else 
            $this->view->response("Viaje id=$id no encontrado", 404);

    }
//INSERTA UN PAQUETE
    public function insertPackage($params = null){
        if(!$this->authHelper->isLoggedIn()){
            $this->view->response("No estas logueado", 401);
            return;
        }
        $package = $this->getData();

        if (empty($package->destino) || empty($package->hotel) || empty($package->comida) || empty($package->fecha)) {
          $this->view->response("Complete todos los datos del paquete", 400);
        } else {
            $id = $this->model->insertTravelPackage($package->destino, $package->hotel, $package->comida, $package->fecha);
            $paquete = $this->model->getOnePackage($id);
            $this->view->response($paquete, 201);
       }
    }
  //MODIFICA UN PAQUETE
  public function updatePackage($params = []) {
    $id_paquete = $params[':ID'];
    if(!$this->authHelper->isLoggedIn()){
        $this->view->response("No estas logueado", 401);
        return;
    }
    $package = $this->model->getOnePackage($id_paquete);

    if ($package) {
        $body = $this->getData();
        $destino = $body->destino;
        $hotel = $body->hotel;
        $comida = $body->comida;
        $fecha = $body->fecha;
        $package = $this->model->editTravelPackageModel($id_paquete, $destino, $hotel, $comida, $fecha);
        $this->view->response("Paquete de viaje con id=$id_paquete actualizado con éxito", 200);
    }
    else 
        $this->view->response("Paquete de viaje con id=$id_paquete not found", 404);
}

}