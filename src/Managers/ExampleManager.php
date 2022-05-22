<?php

namespace App\Managers;

use App\Models\Example;

class ExampleManager extends Manager
{
    public function getData($param){
        return ($param ? "success_test" : "error_test");
    }
};