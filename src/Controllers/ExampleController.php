<?php

namespace App\Controllers;

class ExampleController extends Controller
{
    public function index(){
        $this->render('example');
        print_r($this->manager->test());
    }
}