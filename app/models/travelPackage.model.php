<?php
class TravelPackageModel
{
    private $db; //es private xq nadie se va a conectar desde afuera

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;' . 'dbname=db_tpe;charset=utf8', 'root', '');
    }
    // Devuelve la lista de travelPackages completa.
    //podemos getAll solo ya que el redundante, los frameworks usan asi getall, insert y remove solo
    public function getAll()
    {
        // 1. abro conexión a la DB (ya esta abierta por el constructor de la clase)

        // 2. ejecuto la sentencia (2 subpasos)
        $query = $this->db->prepare("SELECT * FROM paquete");
        $query->execute();
        // 3. obtengo los resultados
        $travelPackage = $query->fetchAll(PDO::FETCH_OBJ); // devuelve un arreglo de objetos
        return $travelPackage;
    }

/*    TRAE UN PAQUETE SEGUN SU ID   */
    public function getOnePackage($id_paquete)
    {
        $query = $this->db->prepare('SELECT * FROM paquete WHERE id_paquete=?');
        $query->execute([$id_paquete]);
        $result =  $query->fetch(PDO::FETCH_OBJ);
        return $result;
    }

/*   INSERTA UN PAQUETE    */
    public function insertTravelPackage($destino, $hotel, $comida, $fecha)
    {
        $query = $this->db->prepare("INSERT INTO paquete (destino, hotel, comida, fecha) VALUES (?,?,?,?)");
        $query->execute([$destino, $hotel, $comida, $fecha]);
        return $this->db->lastInsertId(); //nos devuelve el id del último elemento insertado
    }

/*      ELIMINA UN PAQUETE SEGUN SU ID     */
    public function deleteTravelPackageModel($id)
    {
        $query = $this->db->prepare('DELETE FROM paquete WHERE id_paquete = ?');
        $query->execute([$id]);
    }
    
    /*   EDITA UNA PAQUETE   */
    public function editTravelPackageModel($id_paquete, $destino, $hotel, $comida, $fecha)
    {
        $query = $this->db->prepare("UPDATE paquete SET destino=?, hotel=?, comida=?, fecha=? WHERE id_paquete=?");
        $query->execute([$destino, $hotel, $comida, $fecha, $id_paquete]);
        return $this->db->lastInsertId();
    }

    public function ordenAscDescSort($order, $sort){
        $query = $this->db->prepare("SELECT * FROM paquete ORDER BY $sort $order");
        $query->execute();
        // 3. obtengo los resultados
        $travelPackage = $query->fetchAll(PDO::FETCH_OBJ); // devuelve un arreglo de objetos
        return $travelPackage;
    }
}
