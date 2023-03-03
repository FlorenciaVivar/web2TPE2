# TPE 2 web2 API REST

# Objectivo

Crear una API REST publica para brindar integración con otros sistemas. Se continua con la idea del tpe1 de web 2. Esta api permite ver los paquetes de viajes disponibles con su destino, hotel, comida y fecha.

Se trata de una API REStfull,

## Importar base de datos
Para su uso se debe importar la base de datos db_tpe.sql desde PHPMyAdmin u otro.

## Prueba con Postman o similar
El endpoint de la API es: http://localhost/proyectos/web2/TPE2Web2/api/packages

## API Endpoints


## Obtener todos los packages 

HTTP Verbs : GET
Url : api/packages
Response: 200

## Obtener un package

HTTP Verbs : GET
Url : api/packages/:ID
Response: 200

## Insertar un package

HTTP Verbs : POST
Url : api/packages/
Body :
{
    "destino": "Paris",
    "hotel": "Mulen Hotel",
    "comida": "Cena",
    "fecha": "01/01/23"
}
Response: 201

## Eliminar un package

HTTP Verbs : DELETE
Url : api/packages/:ID
Response: 200

## Ordenamiento

Obtiene un listado de todos los paquetes ordenados de forma ascendente(asc) o descendente(desc).

HTTP Verb: GET
Url: api/packages?sort=destino&order=asc
Response: 200

## Paginacion

Funcionalidad que permite elegir cuantos recursos mostrar por pagina y que pagina. En el ejemplo vemos 4 recursos de la pagina 2.

HTTP Verb: GET
Url: api/packages?limit=4&page=2
Response: 200

Aclaracion: page y limit siempre deben ser mayor a 0.

## Verificacion Token

Utilizando esta funcionalidad el usuario administrador podra eliminar, modificar o insertar un paquete nuevo. Con este endpoint podra adquirir un token por tiempo determinado que le permitirá realizar las funcionalidades antes mencionadas.

HTTP Verb: GET
Url: api/auth/token
Response: 200

## Filtrado por destino

Con esta funcionalidad podemos filtrar por destino. En el ejemplo se filtra por Tandil.

HTTP Verb: GET
Url: api/packages?destino=Tandil

## CODIGOS DE RESPUESTA HTTP
### 200 OK
Cuando la solicitud realizada por el usuario tuvo éxito.

### 201 CREATED
Cuando la solicitud tuvo éxito y se creó un nuevo recurso.

### 400 BAD REQUEST
Indica que el servidor no puede o no procesara la petición debido a una sintaxis invalida.

### 401 UNAUTHORIZED
Es necesario autenticarse para obtener la respuesta solicitada.

### 403 FORBIDDEN
El cliente no posee los permisos necesarios. 

### 404 NOT FOUND
Indica que una página buscada no puede ser encontrada.

### 500 INTERNAL SERVER ERROR
Indica que el servidor encontró una situación inesperada.
