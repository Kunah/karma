<?php

namespace App\Controllers;

class ExampleController extends Controller
{
    public function index($p = "ok"){
        $this->render('example');
        echo "Param value is: {$p}";
    }
}