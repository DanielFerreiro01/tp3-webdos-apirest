<?php
require_once 'app/panel.php';

define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/');

// el router va a leer la action desde el paramtro "action"

$action = 'panel'; // accion por defecto
if (!empty( $_GET['action'])) {
    $action = $_GET['action'];
}

//pedidos -> showOrder();
//agregar -> addTask();
//eliminar/:ID -> removeTask($id);
//finalizar/:ID -> finishTask($id);

// parsea la accion Ej: noticia/1 --> ['noticia', 1]
$params = explode('/', $action);

switch ($params[0]) { // en la primer posicion tengo la accion real
    case 'panel':
        showTask();
        break;
    default: 
        echo "error 404 not found";
        break;
}