<?php

require_once './app/views/homeRyderView.php';
require_once './app/models/pedidos.model.php';
require_once './app/models/categorias.model.php';

class RyderController{
    private $view;
    private $model;
    private $modelCategory;

    public function __construct() {
        $this->view = new RyderHomeView();
        $this->model = new PedidosModel();
        $this->modelCategory = new categoriesModel();
    }

    public function showHomeR(){
        $pedidos = $this->model->getPedidos(null);
        $tipoEnvios = $this->modelCategory->getCategoriesEnvios();
        $filtro = isset($_POST['tipo-envio']) ? $_POST['tipo-envio'] : null;
        $this->view->showHomeR($pedidos, $filtro, $tipoEnvios);
    }

    function finishOrder($id) {
        $this->model->updateOrder($id);
        header('Location: http://localhost/tpe-web-dos/acceso-publico');
    }

    // public function filterOrder() {
    //      $filtro = $_POST['tipo-envio'];
    //      $this->view->showFilterR($filtro);
    // }


}


?>