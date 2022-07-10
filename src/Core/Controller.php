<?php

namespace App\Core;

/*---------- Controller Class ----------*/
abstract class Controller
{

    /*---------- Rendering view ----------*/
    // This method renders the view you given as first parameter
    // with the data you given as second parameter
    public function render(string $view, array $data = []){
        extract($data); // Get all params
        ob_start();
        require(VIEWS.strtolower($view).".php");
        $content = ob_get_clean();
        require(VIEWS.'layout.php');
    }
    public function render_without_layout(string $view, array $data = []){
        extract($data);
        ob_start();
        require(VIEWS.strtolower($view).".php");
        $content = ob_get_clean();
    }
}
