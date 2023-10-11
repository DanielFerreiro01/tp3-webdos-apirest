<?php 

require_once './app/views/homeAdminView.php';

class AdminController {
    private $view;

    public function __construct(){
        $this->view = new AdminHomeView();
    }
    
    public function showHomeA() {
        $this->view->showHomeA();
    }

}

?>