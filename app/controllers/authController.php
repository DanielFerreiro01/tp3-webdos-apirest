<?php 

require_once './app/views/auth.view.php';
require_once './app/models/user.model.php';
require_once './app/helpers/auth.helper.php';


class AuthController{
    private $view;
    private $model;

    function __construct() {
        $this->model = new UserModel();
        $this->view = new AuthView();
    }

    public function showLogin() {
        $this->view->showLogin();
    }

    public function showRegistro() {
        $this->view->showRegistro();
    }

    public function registrarse() {
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $usuario = $this->model->registro($email, $username, $password);

        if($usuario){
            header('Location: http://localhost/tpe-web-dos/acceso-publico');
        }else{
            
        }
    }

    public function auth() {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (empty($username) || empty($password)) {
            $this->view->showLogin('Faltan completar datos');
            return;
        }

        $user = $this->model->getByUsername($username);
        if ($user && password_verify($password, $user->contraseña)) {
            
            
            AuthHelper::login($user);
        
            header('Location: http://localhost/tpe-web-dos/home-admin');
            
            
        } else {
            $this->view->showLogin('Usuario inválido');
            var_dump($password, $username);
        }
    }

    public function logout() {
        AuthHelper::logout();
        header('Location: ' . BASE_URL);    
    }

}


?>