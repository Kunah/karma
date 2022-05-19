<?php

require '../vendor/autoload.php';
require '../src/config/config.php';
session_start();

use App\Controllers\ExampleController;
use App\Router;

Router::get('/', [ExampleController::class, "index2"]);
Router::get('/:param', [ExampleController::class, "index"]);
Router::run();