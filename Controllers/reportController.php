<?php 

class reportController {
  
  private $posititManager;
  private $userManager;
  
  public function __construct()
  {
   $this->posititManager = new Models\posititManager();
    $this->userManager = new Models\userManager();
  }

    public function display() {

// la logique de like

if(isset($_GET['posititid']) && !empty($_GET['posititid'])) {
$this->posititManager->EditRow('id',$_GET['posititid'],null,null,null,null,null,null,null,'0'); 
}


 // redirection
    header("Location: ./Views/closePage.html");
    exit();
  }
}


