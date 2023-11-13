Nombres de los integrantes:

Daniel Ferreiro: daniiferreiro26@gmail.com
Francisco Leiva: franciscoleiva1320@gmail.com

Temática del TPE:

Sitio web SaaS Logistica 

Breve descripción de la temática:

Se presenta un sitema de asignacion de pedidos a repartidores. El usuario administrador es quien puede crear, modificar o eliminar los pedidos a realizar, ademas de asignar al repartidor. Por otro lado, se encuentra el usuario comun (repartidor) que puede ver los pedidos, aceptarlos y darlos por finalizados. 

ACLARACIONES SEGUNDA ENTREGA:

1: En esta instancia, el unico formulario en la seccíon Categorias con las funciones para crear, modificar y eliminar es el formulario Tipo de envio. 

2: Los estilos se aplican mediante el atributo Style ya que ocurrieron complicaciones para trabajar con la hoja de estilos (hay algun error que no permite visualizar cambios mediante archivo style.css).

3: El listado de item por categoria figura en un listado aparte de la tabla pedidos en la vista del repartidor dadas complicaciones para filtrar los datos de la tabla segun se filtren o no los datos. 

ACLARACIONES TERCER ENTREGA: 
1: La API de nuestro sistema puede permitir a ecommerce integrar el servicio logistico de esta aplicacion al ingresar pedidos nuevos automaticamente desde sus tiendas online.

2: Detalle de endpoint

Listar pedidos:
http://localhost/tpe-web-dos/api/pedidos
Metodo: GET

Listar pedido por id:
http://localhost/tpe-web-dos/api/pedido/29 
Metodo: GET
Aclaracion: El ID debe ser el mismo que figura en la tabla Pedido en la DB

Agregar pedido:
http://localhost/tpe-web-dos/api/pedido
Metodo: POST
Aclaracion: ver punto 3

Agregar pedido:
http://localhost/tpe-web-dos/api/categoria/19
Metodo: PUT
Aclaracion: ver punto 3

Eliminar pedido por id:
http://localhost/tpe-web-dos/api/pedido/29 
Metodo: DELETE
Aclaracion: El ID debe ser el mismo que figura en la tabla Pedido en la DB

Listar ordenadamente:
Metodo: GET
http://localhost/tpe-web-dos/api/pedidos?order=fechaEnvio&sort=desc
Aclaracion: "order" debe ser igual a alguno de los campos en la tabla Pedido 

Filtrar pedidos:
http://localhost/tpe-web-dos/api/pedidos?campo=nombreCliente&valor=iglu 
Metodo: GET
Aclaracion: El valor en "campo" debe ser alguno existente dentro de la tabla Pedido y "valor" ser el dato existente por el cual se desea filtrar. El ejemplo que se muestra filtra solo los pedidos encargados para el cliente Iglu.

Token:
http://localhost/tpe-web-dos/api/user/token
Metodo: GET
Aclaracion: Dentro de la DB existen solo dos usuarios, uno con permiso Admin y otro sin él, depende cual usuario sea ingresado podrá realizar las modificaciones POST o PUT. El usuario y contraseña Admin se detalla en el punto 3.

3: Para agregar un nuevo pedido en nuestra API se debe enviar un request similar al que se detalla a continuacion respetando los valores de "tipoEnvioId" y "repartidorId". En caso de desear utilizar distintos, se debe de tener en cuenta los ID existente en las tablas de cada uno de esos campos en la DB. Además, como se implementa el uso de un token para realizar modificaciones POST y PUT, se debe utilizar el usuario Admin sugerido para el TP2 (usuario: webadmin, contraseña: admin) ya que el otro usuario cargado en la DB no cuenta con el permiso de Admin (usuario: Daniel Ferreiro, contraseña: 1234). Por otro lado, tener en consideración que se puede cambiar el vencimiento de los token en el archivo config.php modificando el valor de JWT_EXP.

Ejemplo body para agregar un pedido (tabla Pedido)

{
    "nombreCliente": "Lucciano´s",
    "ciudadCliente": "Tandil",
    "direccionCliente": "Av. España 1567",
    "codigoPostal": "7000",
    "fechaEnvio": "2023-11-13 23:59:00",
    "producto": "Helado",
    "cantidad": "1",
    "totalPagar": "1568",
    "tipoEnvio": "22",
    "repartidorAsignado": "1"
}

Ejemplo body para modificar una categoria (tabla Tipo de Envio)

{
    "nombreEnvio": "Andreani",
    "zonasDisponibles": "Tandil",
    "premium": "0",
    "tipoPaquete": "Hasta tipo 2"
}

