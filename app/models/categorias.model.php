<?php 

class categoriesModel {
    private $db;

    function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=db_tpe_web;charset=utf8', 'root', '');
    }
    
    public function getCategoriesEnvios(){
        $query = $this->db->prepare('SELECT * FROM tipodeenvio');
        $query->execute();

        // $tipoEnvios es un arreglo de tareas
        $tipoEnvios = $query->fetchAll(PDO::FETCH_OBJ);

        return $tipoEnvios;

    }

    function insertCategory($tipoEnvio, $zonas, $premium, $paqueteAceptados) {
        $query = $this->db->prepare('INSERT INTO tipodeenvio (nombreEnvio, zonasDisponibles, premium, tipoPaquete) VALUES(?,?,?,?)');
        $query->execute([$tipoEnvio, $zonas, $premium, $paqueteAceptados]);

        return $this->db->lastInsertId();
    }

    function deleteCategory($id) {
        $query = $this->db->prepare('DELETE FROM tipodeenvio WHERE tipodeenvio . tipoEnvioId = ?');
        $query->execute([$id]);
    }
    
    function updateCategory($id, $tipoEnvio, $zonas, $premium, $paqueteAceptados) {    
         $query = $this->db->prepare('UPDATE tipodeenvio SET nombreEnvio=?, zonasDisponibles=?, premium=?, tipoPaquete=? WHERE tipoEnvioId=?');
         $query->execute([$tipoEnvio, $zonas, $premium, $paqueteAceptados, $id]);
    }
    


}

?>