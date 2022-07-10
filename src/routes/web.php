<?php
use App\Controllers\ExampleController;
use App\Core\Http\Router;

Router::get('/', [ExampleController::class, "index"]);
