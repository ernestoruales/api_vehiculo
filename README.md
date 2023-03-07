# API Modulo Agenda del Centro de Emprendimiento

This is the simple REST Api implementing basic CRUD operations related to a user.

## Installation

#### Git Clone

To get the latest source you can use git clone.

`$ git clone https://github.com/epicoguayaquil/api_agenda.git /path/to/api_agenda`

#### Composer

Installation can be done with the use of composer. If you don't have composer yet you can install it by doing:

`$ curl -s https://getcomposer.org/installer | php`

To install it globally

`$ sudo mv composer.phar /usr/local/bin/composer`

```
$ cd /path/to/api_agenda
$ composer update
$ composer install
```

## Database Setup

 - Import `dababase/mysql.sql` in your MySQL Server, this will create the tables
 - Copy `.env.example` to `.env`  
 - Update .env with your database credentials
 
```
// .env 

# Database
APP_ENV=local
DB_SEG_DRIVER=mysql
DB_SEG_HOST=localhost
DB_SEG_NAME=bd_seg
DB_SEG_USERNAME=root
DB_SEG_PASSWORD=
DB_SEG_PORT=3306
DB_TRANS_DRIVER=mysql
DB_TRANS_HOST=localhost
DB_TRANS_NAME=bd_trans
DB_TRANS_USERNAME=root
DB_TRANS_PASSWORD=
DB_TRANS_PORT=3306
JWT_TOKEN=authorization
JWT_URL=http://localhost/api_seguridad/public/api/login/verificar
IGNORE_TOKEN_PROGRAMA=["url"]

```

## Usage

### Api Endpoints

```

$ GET      /api/evento/{id}        // Datos del taller o evento
$ GET      /api/agenda/{id}     // Datos de la agenda

```


### Requests (POST/PUT/GET)

```
Header: Autorization:Token // Toda las peticiones deben llevar el token
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
Header: Autorization:Token
HTTPCODE: 200 OK
```