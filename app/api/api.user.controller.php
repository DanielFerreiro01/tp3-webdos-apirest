<?php
require_once './app/models/user.model.php';
require_once './app/helpers/auth.helper.php';
require_once './app/api/api.view.php';


class UserApiController{
    private $model;
    private $view;
    private $authHelper;
    private $data; 

    function __construct(){
        $this->model = new UserModel();
        $this->view = new APIView(); 
        $this->authHelper = new AuthHelper(); 
        $this->data = file_get_contents("php://input"); 
    }

    function getData(){ 
        return json_decode($this->data); 
    }  

    public function getToken($params = null){
        $basic = $this->authHelper->getAuthHeaders();

        if(empty($basic)){
            $this->view->response('No se envió encabezado de autenticación', 401);
            return;
        }

        $basic = explode(" ", $basic); # ["Basic", "base64(user:pass)"]

        if($basic[0] != "Basic"){
            $this->view->response('Los encabezados de autenticación son incorrectos', 401);
            return;
        }

        $userpass = base64_decode($basic[1]);
        $userpass = explode(":", $userpass);

        $user = $userpass[0];
        $pass = $userpass[1];

        $userdata = $this->model->getByUsername($user);

        if($userdata && password_verify($pass, $userdata->contraseña)){
            # Usuario es valido 
            $token = $this->authHelper->createToken($userdata);
            $this->view->response($token, 200);
        } else {
            $this->view->response('El usuario o contraseña son incorrectos', 401);
            return;
        }

        
    }

}