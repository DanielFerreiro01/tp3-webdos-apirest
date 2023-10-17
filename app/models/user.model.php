<?php

require_once './config/db.php';

class UserModel {
    private $db;
    private $con;

    function __construct() {
        $this->db = new Database();
        $this->con = $this->db->getConnection();
    }

    public function getByUsername($username) {
        $query = $this->con->prepare('SELECT * FROM usuario WHERE nombre = ?');
        $query->execute([$username]);
        $resultado = $query->fetch(PDO::FETCH_OBJ);
        return $resultado;
        
    }

    public function registro($email, $username, $password) {
        try{
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $query = $this->con->prepare('INSERT INTO pedido (nombre, email, contraseña) VALUES(?,?,?)');
            $query->execute([$email, $username, $hash]);
            return true;
        }catch(PDOException $exc){
            return false;
        }

    }

}
