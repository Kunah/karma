<?php
namespace App\Models;

class Model {

    public function __call($name, $arguments)
    {
        return call_user_func($this->{$name}, $arguments);
    }

    public function __construct(){
        foreach (func_get_args() as $arg){
            $this->$arg = null;
            $getter = "get".ucfirst($arg);
            $setter = "set".ucfirst($arg);
            $getMethod = (function() use ($arg){
                return $this->$arg;
            });
            $setMethod = (function($param) use ($arg){
                $this->$arg = $param;
            });

            $this->{$getter} = $getMethod;
            $this->{$setter} = $setMethod;
        }
    }

}
