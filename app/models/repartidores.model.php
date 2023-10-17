<?php

require_once './config/db.php';

class repartidoresModel {
    private $db;
    private $con;

    function __construct() {
        $this->db = new Database();
        $this->con = $this->db->getConnection();
    }
    
    public function getRepartidores(){
        $query = $this->con->prepare('SELECT * FROM repartidor');
        $query->execute();

        // $tipoEnvios es un arreglo de tareas
        $repartidor = $query->fetchAll(PDO::FETCH_OBJ);

        return $repartidor;

    }
    }

    ?>