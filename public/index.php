<?php
/*---------- Including necessary files (autoload, config, and routes)  ----------*/ 
require '../vendor/autoload.php';
require '../src/config/config.php';
include SRC.'/routes/web.php';
session_start();

/*---------- Using necessary classes (debugger and router) ----------*/
use Tracy\Debugger;
use App\Core\Http\Router;

/*---------- Debugger config  ----------*/
Debugger::$customCssFiles[] = __DIR__.'/error.css';
Debugger::$productionMode = MODE == "production";
Debugger::$strictMode = true;
Debugger::enable();

/*---------- Starting router  ----------*/
Router::run();