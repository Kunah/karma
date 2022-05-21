<?php
namespace App\Http;
        
class Router {

    private static $routes = [];

    public static function get($path, $callable) {
        $route = new Route($path, $callable);
        Router::$routes["GET"][] = $route;
        return $route;
    }

    public static function post($path, $callable) {
        $route = new Route($path, $callable);
        Router::$routes["POST"][] = $route;
        return $route;
    }

    public static function run() { 

        if(!isset(Router::$routes[$_SERVER['REQUEST_METHOD']])){
            throw new \Exception('REQUEST_METHOD does not exist');
        }
        foreach(Router::$routes[$_SERVER['REQUEST_METHOD']] as $route){
            if($route->match($_SERVER['REQUEST_URI'])){
                return $route->call();
            }
        }
        require VIEWS . '404.php';
    }

}
