<?php
define("AMBIENTE", "DESARROLLO");
define("APP_ENV", "local");
//Database

# -- CONFIG TRANSACTION SCHEMA --
define("DB_TRANS_DRIVER", "mysql");
define("DB_TRANS_PORT", "3306");
define("DB_TRANS_HOST", "localhost");
define("DB_TRANS_NAME", "prueba");
define("DB_TRANS_USERNAME", "root");
define("DB_TRANS_PASSWORD", "");
# -- END CONFIG TRANSACTION SCHEMA --

define("JWT_TOKEN", "authorization");
define("JWT_URL", "");
define("IGNORE_TOKEN", []);
define("CORS_DOMAIN", ["localhost","::1","2"]);