<?php


namespace App\Models;


class ExampleManager extends Manager
{
    // Use $this->query() to do your SQL queries
    public function getData(){
        return "success_test";
    }
};