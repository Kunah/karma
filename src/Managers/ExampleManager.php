<?php

namespace App\Managers;

class ExampleManager extends Manager
{
    public function getData($param){
        return ($param ? "success_test" : "error_test");
    }
};