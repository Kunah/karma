<?php

require '../vendor/autoload.php';
require '../src/config/config.php';
include SRC.'/routes/web.php';
session_start();
use Tracy\Debugger;
use App\Core\Http\Router;

Debugger::$customCssFiles[] = __DIR__.'/error.css';
Debugger::$productionMode = MODE == "production";
Debugger::$strictMode = true;
Debugger::enable();
Router::run();