<?php

namespace App\Controllers;
use App\Core\Controller;

class ExampleController extends Controller
{
    public function index(){
        $this->render('example');
    }
}