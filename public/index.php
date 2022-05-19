<?php

require '../vendor/autoload.php';
require '../src/config/config.php';
include SRC.'/routes/web.php';
session_start();
use App\Router;
Router::run();