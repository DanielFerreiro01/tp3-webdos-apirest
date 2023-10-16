<?php 

require_once './app/views/homeAdminView.php';
require_once './app/models/categorias.model.php';

class AdminController {
    private $view;
    private $model;

    public function __construct(){
        $this->view = new AdminHomeView();
        $this->model = new categoriesModel();
    }

    // Mostrar secciones home y categorias del Admin
    
    public function showHomeA() {
        $tipoEnvios = $this->model->getCategoriesEnvios();
        $this->view->showHomeA($tipoEnvios);
    }

    public function showCategoriesA() {
        $tipoEnvios = $this->model->getCategoriesEnvios();
        $this->view-> showCategoriesA($tipoEnvios);
    }

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
            $this->view->showError("Error al insertar la tarea");
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