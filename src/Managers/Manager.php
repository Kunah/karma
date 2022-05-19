<?php

namespace App\Managers;


class Manager
{
    public function __construct(){
        $this->classname = str_replace("Manager", "", str_replace("App\\Managers\\", "", get_class($this)));
    }
}