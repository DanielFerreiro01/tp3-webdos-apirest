<?php 

class PedidosModel {
    private $db;

    function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=db_tpe_web;charset=utf8', 'root', '');
    }

    public function getPedidos(){
        $query = $this->db->prepare('SELECT * FROM pedido');
        $query->execute();

        // $tipoEnvios es un arreglo de tareas
        $pedidos = $query->fetchAll(PDO::FETCH_OBJ);

        return $pedidos;

    }

    function updateOrder($id) {    
        $query = $this->db->prepare('UPDATE pedido SET estadoPedido = ? WHERE numeroPedido = ?');
        $query->execute([$id]);
    }
    


}


?>