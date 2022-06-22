<?php

namespace App\Core;

abstract class Controller
{

    public function render(string $view, array $data = []){
        extract($data);
        ob_start();
        require(VIEWS.strtolower($view).".php");
        $content = ob_get_clean();
        require(VIEWS.'layout.php');
    }
}