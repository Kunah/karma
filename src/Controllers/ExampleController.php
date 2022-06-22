<?php

namespace App\Controllers;
use App\Core\Controller;
use App\Models\Example;

class ExampleController extends Controller
{
    public function index(){
        $this->render('example');
    }
}