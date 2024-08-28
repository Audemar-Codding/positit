<?php 

class HomeController {
  
    public function display() {
        
 // code php logique de la page home


 // redirection
    $template = "Views/donation.html";
    require_once "layout.phtml";
  }
}


?> 