<?php


namespace App\Controllers;


class Controller
{

    protected $manager;

    public function __construct(){
        $this->classname = str_replace("Controller", "", str_replace("App\\Controllers\\", "", get_class($this)));
        $manager = "App\\Models\\".$this->classname."Manager";
        $model = "App\\Models\\".$this->classname;
        $this->manager = new $manager();
        $this->model = new $model("YO", "Truc", "Random");
        print_r($this->model);
    }

    public function render(string $view, array $data = []){
        extract($data);
        ob_start();
        require(VIEWS.strtolower($view).".php");
        $content = ob_get_clean();
        //require(VIEWS.'layout.php');
    }
}