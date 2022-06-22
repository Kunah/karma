<?php
/*----------------------------\
|---------- Config  ----------|
\----------------------------*/

/*---------- Using necessary class (DB Connection) ----------*/
use App\Core\Database\Initializer as Intializer;

/*---------- App mode (production/development) ----------*/
// Production mode disables debugger
define("MODE", "dev");

/*---------- App name ----------*/
define('APP_NAME', "App");

/*---------- Paths to useful folders ----------*/
define("SRC", '../src/');
define("CONTROLLERS", SRC.'Controllers/');
define("MODELS", SRC.'Models/');
define("MANAGERS", SRC.'Managers/');
define("VIEWS", SRC.'Views/');

/*---------- Database connection configuration ----------*/
define('HOST', '127.0.0.1');
define('DATABASE', 'example');
define('USER', 'root');
define('PASSWORD', '');

/*---------- PDO Connection cretion ----------*/
// Checking if sapi_name is not "cli" to prevent cli commands to create a database connection, and crash
if (php_sapi_name() !== 'cli') $_ENV["pdo"] = new Intializer(); 
