<?php
use App\Controllers\ExampleController;
use App\Core\Http\Router;

Router::get('/', [ExampleController::class, "index"]);
Router::get('/:param', [ExampleController::class, "index"]);