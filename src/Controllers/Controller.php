<?php


namespace App\Controllers;


class Controller
{

    protected $manager;

    public function __construct(){
        $this->classname = str_replace("Controller", "", str_replace("App\\Controllers\\", "", get_class($this)));
        $manager = "App\\Models\\".$this->classname."Manager";
        $this->manager = new $manager();
    }

    public function render(string $view, array $data = []){
        extract($data);
        ob_start();
        require(VIEWS.strtolower($view).".php");
        $content = ob_get_clean();
        require(VIEWS.'layout.php');
    }
}