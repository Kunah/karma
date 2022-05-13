<?php

session_start();

require '../src/config/config.php';
require '../vendor/autoload.php';

$router = new App\Router($_SERVER["REQUEST_URI"]);
$router->get('/', "ExampleController@index");

$router->run();
