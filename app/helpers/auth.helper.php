<?php

require_once './config/config.php';

function base64url_encode($data){
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

class AuthHelper {

    public static function init() {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function login($user) {
        AuthHelper::init();
        $_SESSION['USER_ID'] = $user->usuarioId;
        $_SESSION['USER_USERNAME'] = $user->nombre; 
    }

    public static function logout() {
        AuthHelper::init();
        session_destroy();
    }

    public static function verify() {
        AuthHelper::init();
        if (!isset($_SESSION['USER_ID'])) {
            header('Location: ' . BASE_URL . '/login');
            die();
        }
    }

    public static function getAuthHeaders() {
        $header = "";
        if(isset($_SERVER['HTTP_AUTHORIZATION'])){
            $header = $_SERVER['HTTP_AUTHORIZATION'];
        }
        if(isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])){
            $header = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
        }
        return $header;
    }

    public static function createToken($payload) {
        $header = array(
            'alg' => 'HS256',
            'typ' => 'JWT'
        );

        $payload->exp = time() + JWT_EXP;

        $header = base64url_encode(json_encode($header));
        $payload = base64url_encode(json_encode($payload));

        $signature = hash_hmac('SHA256', "$header.$payload", JWT_KEY, true );
        $signature = base64url_encode($signature);

        $token = "$header.$payload.$signature";

        return $token;
    }   

    function verifyToken($token){

        $token = explode(".", $token); # [$header, $payload, $signature]
        $header = $token[0];
        $payload = $token[1];
        $signature = $token[2];

        $new_signature = hash_hmac('SHA256', "$header.$payload", JWT_KEY, true );
        $new_signature = base64url_encode($new_signature);

        if($signature!=$new_signature){
            return false;
        }

        $payload = json_decode(base64_decode($payload));

        if($payload->exp<time()){
            return;
        }

        return $payload;
    }

    function currentUser(){
        $auth = $this->getAuthHeaders(); # "Bearer $token"
        $auth = explode(" ", $auth); # ["Bearer", "$token"]

        if($auth[0]!="Bearer"){
            return false;
        }

        return $this->verifyToken($auth[1]);
    }
}
