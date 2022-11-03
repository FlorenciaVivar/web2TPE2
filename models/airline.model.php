<?php
class AirlineModel
{
    private $db; //es private xq nadie se va a conectar desde afuera

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;' . 'dbname=db_tpe;charset=utf8', 'root', '');
    }
    public function getAll()
    {
        // 1. abro conexión a la DB (ya esta abierta por el constructor de la clase)

        // 2. ejecuto la sentencia (2 subpasos)
        $query = $this->db->prepare("SELECT * FROM aerolinea");
        $query->execute();
        // 3. obtengo los resultados
        $airlines = $query->fetchAll(PDO::FETCH_OBJ); // devuelve un arreglo de objetos
        return $airlines;
    }

    /*    TRAE UNA AEROLINEA SEGUN SU ID   */
    public function getOneAirline($id_aerolinea)
    {
        $query = $this->db->prepare('SELECT * FROM aerolinea WHERE id_aerolinea=?');
        // echo $id;
        $query->execute([$id_aerolinea]);
        $result =  $query->fetch(PDO::FETCH_OBJ);
        // var_dump($result); 
        return $result;
    }

     /*   INSERTA UNA AEROLINEA    */
    public function insertAirline($nombre, $imagenAerolinea)
    {
        $pathImg = $this->uploadImage($imagenAerolinea);
        //var_dump($imagenAerolinea);
        $query = $this->db->prepare("INSERT INTO aerolinea (nombre, imagenAerolinea) VALUES (?,?)");
        $query->execute([$nombre, $pathImg]);
        return $this->db->lastInsertId(); //nos devuelve el id del último elemento insertado
    }

    /*      ELIMINA UNA AEROLINEA SEGUN SU ID     */
    public function deleteAirlineModel($id)
    {
        $query = $this->db->prepare('DELETE FROM aerolinea WHERE id_aerolinea = ?');
        $query->execute([$id]);
    }
    
    /*   EDITA UNA AEROLINEA   */
    public function editAirlineModel($id_aerolinea, $nombre, $imagenAerolinea)
    {
        // echo 'holaaa';
        $pathImg = $this->uploadImage($imagenAerolinea);
        $query = $this->db->prepare("UPDATE aerolinea SET nombre=?, imagenAerolinea=? WHERE id_aerolinea=?");
        $query->execute([$nombre, $pathImg, $id_aerolinea]);
        return $this->db->lastInsertId();
    }
   
    private function uploadImage($imagenAerolinea)
    {
        $target = 'imgs/aerolineas/' . uniqid() . '.jpg';
        move_uploaded_file($imagenAerolinea, $target);
        return $target;
    }
 
}
