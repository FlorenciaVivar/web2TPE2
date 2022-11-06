<?php

class ApiView{

    public function response($data, $code) {

        header("Content-Type: application/json");
        header("HTTP/1.1 " . $code . " " . $this->requestStatus($code));

        echo json_encode($data);
        //json_encode->function generica que lo que le mandes te lo imprime en formato json, aunq este vacio
    }

    /*
    *Devuelve el texto asociado a un codigo de respuesta
     */
    private function requestStatus($code){
        $status = array(
            200 => "OK",
            404 => "Not found",
            500 => "Internal Server Error"
          );
          return (isset($status[$code]))? $status[$code] : $status[500];
        
    
    }
}