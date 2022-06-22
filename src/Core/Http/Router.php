<?php
namespace App\Core\Http;

/*---------- Router Class ----------*/
class Router {

    /*---------- Defining necessary variables (table name and db name) ----------*/
    private static $routes = [];

    /*---------- Creating GET Route ----------*/
    // This method is the one you have to call if you want to create
    // a GET route, example:
    // Router::get('/myroute', [MyController::class, "MyMethod"])
    public static function get($path, $callable) {
        $route = new Route($path, $callable);
        Router::$routes["GET"][] = $route;
        return $route;
    }

    /*---------- Creating POST Route ----------*/
    // This method is the one you have to call if you want to create
    // a POST route, example:
    // Router::get('/myroute', [MyController::class, "MyMethod"])
    //
    // !! REMINDER
    // If you go to a route in your browser, it will be a GET request,
    // a post won't work in this case, if you have a doubt, check
    // https://developer.mozilla.org/docs/Web/HTTP/Methods
    public static function post($path, $callable) {
        $route = new Route($path, $callable);
        Router::$routes["POST"][] = $route;
        return $route;
    }

    /*---------- Running router ----------*/
    // This method is charged to run the router, and
    // make all your routes working, you have nothing
    // to do, everything is already working, if you
    // add params to this method, the file that calls
    // it is "public/index.php", so you'll have to edit it too
    // 
    // !! WARNING
    // If you're seeing a page that displays "Page not found"
    // it means that the route you entered is not existing in
    // your routes/web.php, don't forget to add it, or check
    // the method
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
