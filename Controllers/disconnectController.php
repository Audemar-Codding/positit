<?php 

class disconnectController {

  
  public function display() {


session_unset();
  session_destroy();

     header("Location: ./index.php?route=account");
     exit();

  }

    
}


?> 