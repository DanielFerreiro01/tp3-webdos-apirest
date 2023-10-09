<?php 

require_once './app/views/homeView.php';


class HomeController {
    // private $model;
    private $view;

    public function __construct() {
        $this->view = new HomeView();
    }


    public function showHome() {
        
        $this->view->showHome();

    }

}

?>