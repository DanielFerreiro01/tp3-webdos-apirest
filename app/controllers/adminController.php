<?php 

require_once './app/views/homeAdminView.php';
require_once './app/models/categorias.model.php';
require_once './app/models/pedidos.model.php';
require_once './app/models/repartidores.model.php';
require_once './app/helpers/auth.helper.php';

class AdminController {
    private $view;
    private $model;
    private $modelPedidos;
    private $modelRepartidores;

    public function __construct(){
        $this->view = new AdminHomeView();
        $this->model = new categoriesModel();
        $this->modelPedidos = new PedidosModel();
        $this->modelRepartidores = new repartidoresModel();
    }

    // Mostrar secciones home y categorias del Admin
    
    public function showHomeA() {
        AuthHelper::verify();
        $pedidos = $this->modelPedidos->getPedidos();
        $repartidores = $this->modelRepartidores->getRepartidores();
        $tipoEnvios = $this->model->getCategoriesEnvios();
        $this->view->showHomeA($tipoEnvios, $pedidos, $repartidores);
    }

    public function showCategoriesA() {
        $tipoEnvios = $this->model->getCategoriesEnvios();
        $this->view-> showCategoriesA($tipoEnvios);
    }

    //ITEMS

    public function addOrder() {

        // obtengo los datos del usuario
        $nombreCliente = $_POST['nombre-cliente'];
        $ciudadCliente = $_POST['ciudad-cliente'];
        $direccionCliente = $_POST['direccion-cliente'];
        $codigoPostal = $_POST['codigo-postal'];
        $fechaEnvio = $_POST['fecha-envio'];
        $producto = $_POST['producto'];
        $cantidad = $_POST['cantidad'];
        $totalPagar = $_POST['total-pagar'];
        $tipoEnvio = $_POST['tipo-envio'];
        $repartidorAsignado = $_POST['repartidor-asignado'];

        // validaciones
        if (empty($nombreCliente) || empty($ciudadCliente) || empty($direccionCliente) || empty($codigoPostal) || empty($fechaEnvio) || empty($producto) || empty($cantidad) || empty($totalPagar) || empty($tipoEnvio) || empty($repartidorAsignado)) {
            $this->view->showError("Debe completar todos los campos");
            return;
        }

        $id = $this->modelPedidos->insertOrder($nombreCliente, $ciudadCliente, $direccionCliente, $codigoPostal, $fechaEnvio, $producto, $cantidad, $totalPagar, $tipoEnvio, $repartidorAsignado);

        if ($id) {
            header('Location: http://localhost/tpe-web-dos/home-admin');
        } else {
            $this->view->showError("Error al insertar la categoria");
        }
    }

    function removeOrder($id) {
        $this->modelPedidos->deleteOrder($id);
        header('Location: http://localhost/tpe-web-dos/home-admin');
    }


    // CATEGORIAS

    public function addCategory() {

        // obtengo los datos del usuario
        $tipoEnvio = $_POST['tipo-envio'];
        $zonas = $_POST['zonas-disponibles'];
        $premium = isset($_POST['premium']) ? 1 : 0;
        $paqueteAceptados = $_POST['paquete-aceptado'];

        // validaciones
        if (empty($tipoEnvio) || empty($zonas) || empty($paqueteAceptados)) {
            $this->view->showError("Debe completar todos los campos");
            return;
        }

        $id = $this->model->insertCategory($tipoEnvio, $zonas, $premium, $paqueteAceptados);
        if ($id) {
            header('Location: http://localhost/tpe-web-dos/categorias-admin');
        } else {
            $this->view->showError("Error al insertar la categoria");
        }
    }

    function deleteCategory($id) {
        $this->model->deleteCategory($id);
        header('Location: http://localhost/tpe-web-dos/categorias-admin');
    }

    function updateCategory($id) {
        $tipoEnvio = $_POST['tipo-envio'];
        $zonas = $_POST['zonas-disponibles'];
        $premium = isset($_POST['premium']) ? 1 : 0;
        $paqueteAceptados = $_POST['paquete-aceptado'];

        if (empty($tipoEnvio) || empty($zonas) || empty($paqueteAceptados)) {
            $this->view->showError("Debe completar todos los campos");
            return;
        }

        $this->model->updateCategory($id, $tipoEnvio, $zonas, $premium, $paqueteAceptados);
        header('Location: http://localhost/tpe-web-dos/categorias-admin');
    }



}

?>