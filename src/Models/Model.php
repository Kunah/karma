<?php

namespace App\Models;

class Model {

    public function __call($name, $arguments)
    {
        return call_user_func($this->{$name}, $arguments);
    }

    function getvars()
    {
        $reflection = new \ReflectionClass($this);
        return $reflection->getProperties(\ReflectionProperty::IS_PROTECTED);
    }

    public function __construct(){
        foreach ($this->getvars() as $arg){
            $getter = "get".ucfirst($arg->getName());
            $setter = "set".ucfirst($arg->getName());
            $getMethod = (function() use ($arg){
                return $this->{$arg->getName()};
            });
            $setMethod = (function($param) use ($arg){
                $this->{$arg->getName()} = $param;
            });

            $this->{$getter} = $getMethod;
            $this->{$setter} = $setMethod;
        }
    }

}
