<?php
use \App\Database\Initializer as Intializer;

define("SRC", '../src/');
define("CONTROLLERS", SRC.'Controllers/');
define("MODELS", SRC.'Models/');
define("MANAGERS", SRC.'Managers/');
define("VIEWS", SRC.'Views/');

define('HOST', '127.0.0.1');
define('DATABASE', 'example');
define('USER', 'root');
define('PASSWORD', '');
if (php_sapi_name() !== 'cli') define('PDO_CONNECTION', new Intializer());
