<?php

require_once './app/views/homeRyderView.php';

class RyderController{
    //private $model;
    private $view;

    public function __construct() {
        $this->view = new RyderHomeView();
    }

    public function showHomeR(){
        $this->view->showHomeR();

    }

}


?>