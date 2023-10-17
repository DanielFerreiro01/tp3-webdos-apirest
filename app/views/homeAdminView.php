<?php 

class AdminHomeView {

    public function showHomeA($tipoEnvios, $pedidos, $repartidores){
        require_once './templates/homeAdmin.phtml';
    }

    public function showCategoriesA($tipoEnvios){
        require_once './templates/categoriasAdmin.phtml';
    }

    public function showError($error) {
        require './templates/error.phtml';
    }


}

?>