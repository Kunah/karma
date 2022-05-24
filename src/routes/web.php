<?php
use App\Controllers\ExampleController;
use App\Controllers\MewenController;
use App\Http\Router;

Router::get('/', [ExampleController::class, "index"]);
Router::get('/mewen', [MewenController::class, "index"]);
Router::get('/:param', [ExampleController::class, "index"]);