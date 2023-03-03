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

// TRAE TODOS LOS PAQUETES
public function getAll(){
    if (isset($_GET['order']) && isset($_GET['sort'])&& isset($_GET['limit']) && isset($_GET['page'])&&
    isset($_GET['destino'])){
        $packages = $this->getAllSortOrder2();
        $packages = $this->filter($packages,$_GET['destino']);
        $result = $this->paginate($packages,$_GET['limit'],$_GET['page']);
        $this->view->response($result, 200);  
        return;
    }  
    else if(isset($_GET['order']) && isset($_GET['sort'])&&isset($_GET['destino'])){
        $packages = $this->getAllSortOrder2();
        $packages = $this->filter($packages,$_GET['destino']);
        if($packages){
            $this->view->response($packages, 200);  
        }
        else{
            $this->view->response("no hay paquetes con ese destino", 404);  
            return;
        }
        }
        if(isset($_GET['order']) && isset($_GET['sort'])&& isset($_GET['limit']) && isset($_GET['page'])){
            $packages = $this->getAllSortOrder2();
            $result = $this->paginate(   $packages    ,$_GET['limit'],$_GET['page']);
            $this->view->response($result, 200);  
        }
        if(isset($_GET['limit']) && isset($_GET['page'])&&isset($_GET['destino'])){
            $packages = $this->getAllPackages();
            $packages = $this->filter($packages,$_GET['destino']);
            $result = $this->paginate($packages,$_GET['limit'],$_GET['page']);
            $this->view->response($result, 200);  
            return;
        }        
        else if(isset($_GET['destino'])){
            $packages = $this->getAllPackages();
            $packages = $this->filter($packages,$_GET['destino']);
            $this->view->response($packages, 200);  
        }
        else if (isset($_GET['limit']) && isset($_GET['page'])){
            $packages = $this->getAllPackages();
            $result = $this->paginate($packages,$_GET['limit'],$_GET['page']);
            $this->view->response($result, 200);  
        }
        else if(isset($_GET['order']) && isset($_GET['sort'])){
            $packages = $this->getAllSortOrder();
        }
        else{
            $packages = $this->getAllPackages();
            $this->view->response($packages, 200); 
        }
    }
    
    function getAllPackages(){
        $packages = $this->model->getAll();
        return $packages;
    }
    
    
    public function paginate($packages,$limit,$page){
        $paginacion = $this->verifyPagination2($limit,$page);
        if($paginacion){
            $from = ($page - 1) * $limit;
            $result = array_slice($packages, $from, $limit);
            return $result;
        }
        else{
            $this->view->response("Error en los parametros de paginacion", 400); 
            return;
        }
             
}
//PAGINACION
function verifyPagination2($limit,$page){
        if ( is_numeric($limit) && is_numeric($page) && ($limit > 0) && ($page > 0) ) {
            return true;
        } else {
            $this->view->response("Error en los parametros de paginacion", 400); 
            die();
}
}

// public function verifyPagination(){
//         if (isset($_GET['limit']) && isset($_GET['page'])) {
//             if ( is_numeric($_GET['limit']) && is_numeric($_GET['page']) && ($_GET['limit'] > 0) && ($_GET['page'] > 0) ) {
//                 return true;
//             } else {
//                 $this->view->response("No hay paquetes en esta página", 404); 
//                 return false;
//             }
//     }
// }

// SORT Y ORDER
    public function getAllSortOrder(){
            if(isset($_GET['order']) && isset($_GET['sort'])){
                if (($_GET['sort']=="destino") || ($_GET['sort']=="hotel") || ($_GET['sort']=="comida") || ($_GET['sort']=="fecha")){
                    if(($_GET['order']=="asc") || ($_GET['order']=="desc")){
                        $order = $_GET['order'];
                        $sort = $_GET['sort'];
                        $packages = $this->model->ordenAscDescSort($order, $sort);
                        $this->view->response($packages, 200); 
                    }  
                }
            }
    }

    public function getAllSortOrder2(){
        if(isset($_GET['order']) && isset($_GET['sort'])){
            if (($_GET['sort']=="destino") || ($_GET['sort']=="hotel") || ($_GET['sort']=="comida") || ($_GET['sort']=="fecha")){
                if(($_GET['order']=="asc") || ($_GET['order']=="desc")){
                    $order = $_GET['order'];
                    $sort = $_GET['sort'];
                    $packages = $this->model->ordenAscDescSort($order, $sort);
                    return $packages;
                    }  
                }
            }
    }


//OBTENER UN PAQUETE 
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
            $this->view->response( "Paquete con id=$id eliminado con éxito", 200);
        }
        else 
            $this->view->response("Paquete id=$id no encontrado", 404);
    }

//INSERTA UN PAQUETE
    public function insertPackage(){
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
public function filter($packages,$destino){
    $aux = [];
    foreach ($packages as $package) {
        if ($package->destino == $destino) {
            array_push($aux, $package);
        }
    }
    if($aux){
        return $aux;
    }
    else{
        return null;
    }
}
}