<?php

require '../vendor/autoload.php';
require '../src/config/config.php';
include SRC.'/routes/web.php';
session_start();
use Tracy\Debugger;
use App\Http\Router;

Debugger::$customCssFiles[] = __DIR__.'/error.css';
Debugger::$productionMode = false; // Set it to true when your project is in production
Debugger::enable();
Router::run();