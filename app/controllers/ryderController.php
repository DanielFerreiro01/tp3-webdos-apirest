<?php

require_once './app/views/homeRyderView.php';
require_once './app/models/pedidos.model.php';

class RyderController{
    private $view;
    private $model;

    public function __construct() {
        $this->view = new RyderHomeView();
        $this->model = new PedidosModel();
    }

    public function showHomeR(){
        $pedidos = $this->model->getPedidos();
        $this->view->showHomeR($pedidos);
    }

    function finishOrder($id) {
        $this->model->updateOrder($id);
        header('Location: http://localhost/tpe-web-dos/acceso-publico');
    }




}


?>