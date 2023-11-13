<?php
require_once './app/models/pedidos.model.php';
require_once './app/models/categorias.model.php';
require_once './app/helpers/auth.helper.php';
require_once './app/api/api.view.php';


class PedidosApiController{
    private $model;
    private $modelCategorias;
    private $view;
    private $data; 
    private $authHelper;

    function __construct(){
        $this->model = new PedidosModel();
        $this->modelCategorias = new categoriesModel(); 
        $this->view = new APIView();
        $this->authHelper = new AuthHelper(); 
        $this->data = file_get_contents("php://input"); 
    }

    function getData(){ 
        return json_decode($this->data); 
    }  

    public function getPedidos($params = null){

        $parametros = [];

// Condiciones de ordenamiento
        if(isset($_GET['sort'])){
            $parametros['sort'] = $_GET['sort'];
        }

        if(isset($_GET['order'])){
            $parametros['order'] = $_GET['order'];
        }

// Condiciones de filtrado
        if(isset($_GET['campo'])){
            $parametros['campo'] = $_GET['campo'];
        }

        if(isset($_GET['valor'])){
            $parametros['valor'] = $_GET['valor'];
        }

        $pedidos = $this->model->getPedidos($parametros);
        $this->view->response($pedidos, 200);

    }

    public function getPedido($params = null){
        // $params es un array asociativo con los parametros de la ruta
        $idPedido = $params[':ID'];

        $pedido = $this->model->getPedido($idPedido);
            
        if ($pedido) {
            $this->view->response($pedido, 200);   
        } else {
            $this->view->response("No existe el pedido con el id={$idPedido}", 404);
        }
    }

    public function addPedido($params = null){
        // Verificamos usuario 

        $user = $this->authHelper->currentUser();

        if(!$user){
            $this->view->response("Unauthorized", 401);
            return;
        }

        if($user->rolId != 1){
            $this->view->response("Forbidden", 403);
            return;
        }

        // la obtengo del body
        $body = $this->getData();

        // Inserto el nuevo pedido
        $pedidoId = $this->model->insertOrder($body->nombreCliente, $body->ciudadCliente, $body->direccionCliente, $body->codigoPostal, $body->fechaEnvio, $body->producto, $body->cantidad, $body->totalPagar, $body->tipoEnvio, $body->repartidorAsignado);
        
        // obtengo el recien creado
        $pedidoNuevo = $this->model->getPedido($pedidoId);

        if ($pedidoNuevo) {
            $this->view->response($pedidoNuevo, 201);   
        } else {
            $this->view->response("Error al insertar el pedido", 500);
        }
    }

    public function updateCategoria($params = null) {
        // Verificamos usuario 

        $user = $this->authHelper->currentUser();

        if(!$user){
            $this->view->response("Unauthorized", 401);
            return;
        }

        if($user->rolId != 1){
            $this->view->response("Forbidden", 403);
            return;
        }

        $envioId = $params[':ID'];
        $categoria = $this->modelCategorias->getCategoria($envioId);

        if ($categoria) {
            $body = $this->getData();
            $categoria = $this->modelCategorias->updateCategory($envioId, $body->nombreEnvio, $body->zonasDisponibles, $body->premium, $body->tipoPaquete);
            $this->view->response("Categoria id=$envioId actualizada con éxito", 200);
        }
        else 
            $this->view->response("Categoria id=$envioId not found", 404);
    }


    public function deletePedido($params = null){
        $idPedido = $params[':ID'];
        $pedido = $this->model->getPedido($idPedido);

        if ($pedido) {
            $this->model->deleteOrder($idPedido);
            $this->view->response("Pedido id=$idPedido eliminado con éxito", 200);   
        } else {
            $this->view->response("Pedido id={$idPedido} not found", 404);
        }

    }
}