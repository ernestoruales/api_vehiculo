# API Modulo Vehiculo

This is the simple REST Api implementing basic CRUD operations related to a user.

## Installation

#### Git Clone

To get the latest source you can use git clone.

`$ git clone https://github.com/ernestoruales/api_vehiculo.git /path/to/vehiculo`

#### Composer

Installation can be done with the use of composer. If you don't have composer yet you can install it by doing:

`$ curl -s https://getcomposer.org/installer | php`

To install it globally

`$ sudo mv composer.phar /usr/local/bin/composer`

```
$ cd /path/to/vehiculo
$ composer update
$ composer install
```

## Database Setup

 - Import `scripsDB/ScriptAngular.sql` in your MySQL Server, this will create the tables
 - Update `src/enviroment.php` with your database credentials
 
```
// .env 

# Database
define("DB_TRANS_DRIVER", "mysql");
define("DB_TRANS_PORT", "3306");
define("DB_TRANS_HOST", "localhost");
define("DB_TRANS_NAME", "prueba");
define("DB_TRANS_USERNAME", "root");
define("DB_TRANS_PASSWORD", "");
```

## Usage

### Api Endpoints

```

$ GET      /api/vehiculo/{id}     // Datos del vehiculo
$ GET      /api/vehiculos/     	  // Datos de los vehiculos
$ POST      /api/vehiculo/     	  // Registrar un vehiculo
```
{
    "codigo": "001",
	"marca": "",
	"modelo": "",
	"anio": 2023,
	"calificacion": 5,
	"foto": "" // URL de la foto
}
HTTPCODE: 200 OK
```
$ PUT      /api/vehiculo/{id}     	  // Actualiza un vehiculo por ID
```
{
    "codigo": "001",
	"marca": "",
	"modelo": "",
	"anio": 2023,
	"calificacion": 5,
	"foto": "" // URL de la foto
}
HTTPCODE: 200 OK
```
$ GET      /api/cliente/{id}      // Datos de la agenda

```

...

### Responses (POST/PUT/GET)

Cada servicio rest api retorna la siguiente trama:

```
{
    "codigo": 1,
	"mensaje": "...",
    "data":"...",
	"error":"[{...},{...}]" // opcional en caso de error
}
HTTPCODE: 200 OK
```