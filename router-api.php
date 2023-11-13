<?php

require_once 'libs/router.php';
require_once 'app/api/api.admin.controller.php';
require_once 'app/api/api.user.controller.php';

// recurso solicitado
$resource = $_GET["resource"];
// método utilizado
$method = $_SERVER["REQUEST_METHOD"];

// instancia el router
$router = new Router();

// arma la tabla de ruteo
$router->addRoute("pedidos", "GET", "PedidosApiController", "getPedidos");
$router->addRoute("pedido/:ID", "GET", "PedidosApiController", "getPedido");
$router->addRoute("pedido", "POST", "PedidosApiController", "addPedido");
$router->addRoute("categoria/:ID", "PUT", "PedidosApiController", "updateCategoria");
$router->addRoute("pedido/:ID", "DELETE", "PedidosApiController", "deletePedido");
$router->addRoute("user/token", "GET", "UserApiController", "getToken");

// rutea
$router->route($resource, $method);
