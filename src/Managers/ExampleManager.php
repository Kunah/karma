<?php

namespace App\Managers;

class ExampleManager extends Manager
{
    // Use $this->query() to do your SQL queries
    public function getData($param){
        return ($param ? "success_test" : "error_test");
    }
};