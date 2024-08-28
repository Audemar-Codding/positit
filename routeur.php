<?php

class routeur {

    public function Display($url) {
        $controllerName = ucfirst($url)."Controller"; 
        $controller = new $controllerName();
        $controller->display();
    }

}
    
