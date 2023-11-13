<?php 

require_once './config/db.php';

class PedidosModel {
    private $db;
    private $con;

    function __construct() {
        $this->db = new Database();
        $this->con = $this->db->getConnection();
    }

    public function getPedidos($parametros){
        $sql = 'SELECT * FROM pedido';

        if(isset($parametros['order'])){
            $sql .= ' ORDER BY ' .$parametros['order'];

            if(isset($parametros['sort'])){
                $sql .= ' ' .$parametros['sort'];
            }
        }elseif (isset($parametros['campo']) && isset($parametros['valor'])) {
            $sql .= ' WHERE ' . $parametros['campo'] . ' = \'' . $parametros['valor'] . '\'';
        } else {
            $sql = 'SELECT pedido.*, repartidor.nombreCompleto AS nombre_repartidor, tipodeenvio.nombreEnvio FROM pedido JOIN repartidor ON pedido.repartidorId = repartidor.repartidorId JOIN tipodeenvio ON pedido.tipoEnvioId = tipodeenvio.tipoEnvioId';
        }

        // echo($sql);
        // echo(PHP_EOL);
        // die(__FILE__);

        $query = $this->con->prepare($sql);
        $query->execute();
        
        // $query = $this->con->prepare('SELECT pedido.*, repartidor.nombreCompleto AS nombre_repartidor, tipodeenvio.nombreEnvio FROM pedido JOIN repartidor ON pedido.repartidorId = repartidor.repartidorId JOIN tipodeenvio ON pedido.tipoEnvioId = tipodeenvio.tipoEnvioId');
        // $query->execute();

        // $tipoEnvios es un arreglo de tareas
        $pedidos = $query->fetchAll(PDO::FETCH_OBJ);

        return $pedidos;

    }

    function getPedido($pedidoId){
        $query = $this->con->prepare('SELECT pedido.*, repartidor.nombreCompleto AS nombre_repartidor, tipodeenvio.nombreEnvio FROM pedido JOIN repartidor ON pedido.repartidorId = repartidor.repartidorId JOIN tipodeenvio ON pedido.tipoEnvioId = tipodeenvio.tipoEnvioId WHERE pedido.numeroPedido = ?');
        $query->execute([$pedidoId]);
    
        // Obtiene un solo pedido en base a su ID
        $pedido = $query->fetch(PDO::FETCH_OBJ);
    
        return $pedido;
    }

    function insertOrder($nombreCliente, $ciudadCliente, $direccionCliente, $codigoPostal, $fechaEnvio, $producto, $cantidad, $totalPagar, $tipoEnvio, $repartidorAsignado) {
        try {
        $query = $this->con->prepare('INSERT INTO pedido (nombreCliente, ciudad, calle, cp, fechaEnvio, producto, cantidad, total, tipoEnvioId, repartidorId, estadoPedido) VALUES(?,?,?,?,?,?,?,?,?,?,?)');
        $query->execute([$nombreCliente, $ciudadCliente, $direccionCliente, $codigoPostal, $fechaEnvio, $producto, $cantidad, $totalPagar, $tipoEnvio, $repartidorAsignado, 0]);

        return $this->con->lastInsertId();
        } catch (PDOException $e) {
            echo 'Error en la inserción: ' . $e->getMessage();
        }
    }

    function deleteOrder($id) {
        $query = $this->con->prepare('DELETE FROM pedido WHERE pedido . numeroPedido = ?');
        $query->execute([$id]);
    }

    function updateOrder($id) {    
        $pedidoFinalizado = 1;
        $query = $this->con->prepare('UPDATE pedido SET estadoPedido = ? WHERE numeroPedido = ?');
        $query->execute([$pedidoFinalizado, $id]);
    }
    


}


?>