<?php
namespace App\Http;

use Error;

class Route {

    private $path;
    private $callable;
    private $matches = [];

    public function __construct($path, $callable){
        $this->path = trim($path, '/');
        $this->callable = $callable;
    }

    public function match($url){
        $url = trim($url, '/');
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        $regex = "#^$path$#i";
        if(!preg_match($regex, $url, $matches)){
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;
        return true;
    }

    public function call() {
        $controller = new $this->callable[0]();
        $method = $this->callable[1];
        if(method_exists($controller, $method)){
            call_user_func_array([$controller, $method], $this->matches);
        } else echo new Error("Method {$method} doesn't exists in {$this->callable[0]} class");
    }

}
