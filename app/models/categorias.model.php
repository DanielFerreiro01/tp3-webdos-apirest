<?php 

require_once './config/db.php';

class categoriesModel {
    private $db;
    private $con;

    function __construct() {
        $this->db = new Database();
        $this->con = $this->db->getConnection();
    }
    
    public function getCategoriesEnvios(){
        $query = $this->con->prepare('SELECT * FROM tipodeenvio');
        $query->execute();

        // $tipoEnvios es un arreglo de tareas
        $tipoEnvios = $query->fetchAll(PDO::FETCH_OBJ);

        return $tipoEnvios;

    }

    public function getCategoria($envioId){
        $query = $this->con->prepare('SELECT * FROM tipodeenvio WHERE tipoEnvioId = ?');
        $query->execute([$envioId]);

        // $tipoEnvios es un arreglo de tareas
        $tipoEnvios = $query->fetch(PDO::FETCH_OBJ);

        return $tipoEnvios;

    }

    function insertCategory($tipoEnvio, $zonas, $premium, $paqueteAceptados) {
        $query = $this->con->prepare('INSERT INTO tipodeenvio (nombreEnvio, zonasDisponibles, premium, tipoPaquete) VALUES(?,?,?,?)');
        $query->execute([$tipoEnvio, $zonas, $premium, $paqueteAceptados]);

        return $this->con->lastInsertId();
    }

    function deleteCategory($id) {

        $query = $this->con->prepare('DELETE FROM tipodeenvio WHERE tipodeenvio . tipoEnvioId = ?');
        $query->execute([$id]);
    }
    
    function updateCategory($id, $tipoEnvio, $zonas, $premium, $paqueteAceptados) {    
        $query = $this->con->prepare('UPDATE tipodeenvio SET nombreEnvio=?, zonasDisponibles=?, premium=?, tipoPaquete=? WHERE tipoEnvioId=?');
        $query->execute([$tipoEnvio, $zonas, $premium, $paqueteAceptados, $id]);
}
    


}

?>