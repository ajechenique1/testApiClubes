# Test Api Club

## Introducción

Este proyecto esta bassado en Symfony 6, refiere a un Api en el cual sus diferentes
endpoints generan Clubs, Jugadores y Entrenadores, asi como tambien modifica la información
de estos registros.

## Requerimentos de sistema

- [Docker](https://www.docker.com) >= 17.06 CE
- [Docker Compose](https://docs.docker.com/compose/install/)

## Tecnología

- [PHP](https://www.php.net/releases/8.0/en.php): Version 8.0
- [MySQL](https://dev.mysql.com/doc/relnotes/mysql/8.0/en/): Version 8.0

## Instalación

1.- Dentro de la carpeta app clonar archivo .env.example y renombrarlo .env
2.- Ejecutar comando para construir y levantar los contenedores:
- Al levantar los contenedores se ejecutara en el servidor el composer y los migrations.
```bash
   $ docker-compose up --build
```
3.- Ejecutar comando para composer install
```bash
   $ docker-compose exec php /bin/sh -c "composer -n install"
```
4.- Ejecutar comando para composer update
```bash
   $ docker-compose exec php /bin/sh -c "composer -n update"
```
5.- Ejecutar comando migrations
```bash
   $ docker-compose exec php /bin/sh -c "php bin/console doctrine:migrations:migrate"
```

## Endpoints

1.- Crear club

### POST
[http://localhost:8091/api/clubes]
**Parameters**
|     Nombre | Requerido |  Tipo |Description                                                                                                                                                           |
| -------------:|:--------:|:-------:| --------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
|     `name` | requerido | string  |  Nombre del cliub.                                                               |
|     `description` | requerido | string  | Descripcion del club.
|     `total_budget` | requerido | decimal(18,2)  | Refiere al total de presupuesto establecido para el club.
|     `enabled` | opcional | boolean  | Permite establecer si el club esta activo o inactivo. Valor por defecto 1.

**Request**

```
{
    "name":"Caracas FC",
    "description":"Club de futbol de la capital Venezolana, Caracas Futbol Club",
    "total_budget":"1000000.00",
    "enabled":1
}
```

**Response**

```
{
    "status": "success",
    "id": XX
}
```

2.- Crear Jugador

- Se usa el mismo endpoint para crear un jugador sin club o para crear un jugador dentro de un club.

### POST

[http://localhost:8091/api/jugadores]
**Parameters**
|     Nombre | Requerido |  Tipo |Description                                                                                                                                                           |
| -------------:|:--------:|:-------:| --------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
|     `number_document` | requerido | integer  |  Numero de documento de intentidad del jugador
|     `name` | requerido | string  |  Nombre del Jugador.
|     `lastname` | requerido | string  |  Apellido del Jugador.                                                         |
|     `email` | requerido | string  | Correo electronico del Jugador
|     `code_country` | requerido | string  | Codigo de pais referente al numero de telefono del jugador
|     `phone` | requerido | integer  | Numero de telefono del juagador
|     `position` | requerido | string  | Posición que el jugador tendra dentro del club
|     `number` | requerido | integer | Numero que el jugador tendra dentro del club
|     `salary` | requerido | decimal(18,2)  | Refiere al salario que el jugador tendra dentro del club.
|     `enabled` | opcional | boolean  | Permite establecer si el jugador esta activo o inactivo. Valor por defecto 1.
|     `club` | opcional | integer  | Id del club, solo se envia si el jugador ya tiene un club asigando, de no se asi se debe enviar vacio.  

**Request**

```
{
    "document_number": "18740144",
    "name":"Juana",
    "lastname":"Melosa",
    "email":"ajecheniqueavila@gmail.com",
    "code_country":"+51",
    "phone":"935351555",
    "position": "Delantero",
    "number": 10,
    "salary": 600.00,
    "enabled": 1,
    "club":""
}
```

**Response**

```
{
    "status": "success",
    "id": XX
}
```

3.- Crear Entrenador

- Se usa el mismo endpoint para crear un entrenador sin club o para crear un entrenador dentro de un club.

### POST

[http://localhost:8091/api/entrenadores]
**Parameters**
|     Nombre | Requerido |  Tipo |Description                                                                                                                                                           |
| -------------:|:--------:|:-------:| --------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
|     `number_document` | requerido | integer  |  Numero de documento de intentidad del Entrenador
|     `name` | requerido | string  |  Nombre del Entrenador.
|     `lastname` | requerido | string  |  Apellido del Entrenador.                                                         |
|     `email` | requerido | string  | Correo electronico del Entrenador
|     `code_country` | requerido | string  | Codigo de pais referente al numero de telefono del Entrenador
|     `phone` | requerido | integer  | Numero de telefono del Entrenador
|     `description` | requerido | string  | Descripcion del Entrenador
|     `salary` | requerido | decimal(18,2)  | Refiere al salario que el Entrenador tendra dentro del club.
|     `enabled` | opcional | boolean  | Permite establecer si el Entrenador esta activo o inactivo. Valor por defecto 1.
|     `club` | opcional | integer  | Id del club, solo se envia si el Entrenador ya tiene un club asigando, de no se asi se debe enviar vacio.  
**Request**

```
{
    "document_number": "18740144",
    "name":"Juana",
    "lastname":"Melosa",
    "description": "Entrenador de la seleccion de niños de la trinidad",
    "email":"ajecheniqueavila@gmail.com",
    "code_country":"+51",
    "phone":"935351555",
    "salary":"600",
    "enabled":"1",
    "club":""
}
```

**Response**

```
{
    "status": "success",
    "id": XX
}
```

4.- Modificar presupuesto del Club

### PUT

[http://localhost:8091/api/clubes/{id}]
**Parameters**
|     Nombre | Requerido |  Tipo |Description                                                                                                                                                           |
| -------------:|:--------:|:-------:| --------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
|     `id` | requerido | integer  |  Id del Club  
|     `total_budget` | requerido | decimal(18,2)  |  Monto de presupuesto
**Request**

```
{
    "total_budget":"900000.56"
}
```

**Response**

```
{
    "status": "success"
}
```

5.- Dar de baja a un jugador en el Club

### PUT

[http://localhost:8091/api/club/jugadores/delete/{id}]
**Parameters**
|     Nombre | Requerido |  Tipo |Description                                                                                                                                                           |
| -------------:|:--------:|:-------:| --------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
|     `id` | requerido | integer  |  Id del Jugador
**Response**

```
{
    "status": "success"
}
```

6.- Dar de baja a un entrenador en el Club

### PUT

[http://localhost:8091/api/club/entrenadores/delete/{id}]
**Parameters**
|     Nombre | Requerido |  Tipo |Description                                                                                                                                                           |
| -------------:|:--------:|:-------:| --------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
|     `id` | requerido | integer  |  Id del Entrenador
**Response**  

```
{
    "status": "success"
}
```

7.- Listar jugadores asociados a un Club

### GET

[http://localhost:8091/api/club/jugadores/{idClub}]
**Parameters**
|     Nombre | Requerido |  Tipo |Description                                                                                                                                                           |
| -------------:|:--------:|:-------:| --------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
|     `idClub` | requerido | integer  |  Id del Club
|     `filter` | requerido | string |  Filtro de busqueda, puede ser nombre del jugador, apellido del jugador o emial del jugador
|     `page` | requerido | integer  |  Numero de pagina de resultados a mostar
|     `limit` | requerido | integer  |  Limite de registros a mostar por pagina
**Request**
```
{
    "filter":"",
    "page":"1",
    "limit":"1"
}
```

**Response**
```
{
    "currentPage": "1",
    "maxPages": 1,
    "data": [
        {
            "id": 2,
            "document_number": 48997079,
            "name": "Gelber",
            "lastname": "Guillen",
            "email": "gelberguillen@gmail.com",
            "code_country": "+51",
            "phone": 935351933,
            "number": 28,
            "position": "Delantero",
            "salary": "155.01",
            "enabled": true,
            "club": "Caracas FC"
        },
        {
            "id": 4,
            "document_number": 48997077,
            "name": "Manuel",
            "lastname": "Guillen",
            "email": "manuelguilen@gmail.com",
            "code_country": "+51",
            "phone": 935351555,
            "number": 0,
            "position": "Aguador",
            "salary": "100.00",
            "enabled": true,
            "club": "Caracas FC"
        },
        {
            "id": 5,
            "document_number": 18164977,
            "name": "Rosimar",
            "lastname": "Contreras",
            "email": "rosmarcontreras@gmail.com",
            "code_country": "+51",
            "phone": 935351555,
            "number": 0,
            "position": "Animadora",
            "salary": "20.00",
            "enabled": true,
            "club": "Caracas FC"
        },
        {
            "id": 6,
            "document_number": 30588881,
            "name": "Leonardo",
            "lastname": "Aranguibel",
            "email": "leoaranguibel@gmail.com",
            "code_country": "+51",
            "phone": 935351555,
            "number": 30,
            "position": "Portero",
            "salary": "180.00",
            "enabled": true,
            "club": "Caracas FC"
        }
    ]
}
```
## Pruebas Unitarias


1.- Cambiar variable de entorno 'APP_ENV' en archivo .env a 'test'
2.- Ejecutar comando para iniciar pruebas
```bash
   $ docker-compose exec php /bin/sh -c "bin/phpunit"
```