<?php
namespace App\Core\Http;

use Error;

/*---------- Route Class ----------*/
class Route {

    /*---------- Defining necessary variables (table name and db name) ----------*/
    private $path;
    private $callable;
    private $matches = [];

    public function __construct($path, $callable){
        $this->path = trim($path, '/');
        $this->callable = $callable;
    }

    /*---------- Get url params ----------*/
    // This method gets the url you entered, checks if the
    // corresponding route takes params, if yes, it try to get
    // it in your url, and saves it in $this->matches
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

    /*---------- Calling route ----------*/
    // This method calls the controller method corresponding to the
    // route you asked for, with the params if this route takes any
    public function call() {
        $controller = new $this->callable[0]();
        $method = $this->callable[1];
        if(method_exists($controller, $method)){
            call_user_func_array([$controller, $method], $this->matches);
        } else echo new Error("Method {$method} doesn't exists in {$this->callable[0]} class");
    }

}
