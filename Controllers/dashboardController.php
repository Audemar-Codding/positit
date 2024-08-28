<?php 

class DashboardController {
 
private $posititManager;
private $userManager;
  private $messagesManager;

    public function __construct()
    {
   $this->posititManager = new Models\posititManager();
   $this->userManager = new Models\userManager();
   $this->messagesManager = new Models\messagesManager();
    }
    
        

    public function display() {
     
     $message = "";

 if(isset($_SESSION['admin']) && $_SESSION['admin'])
 {



 if(isset($_GET['option'])){

$positit = $this->posititManager->GetSinglePositit('id',$_GET['posititid']);
$sanction ="";

switch($_GET['option']) {
 case 1:
   $this->posititManager->EditRow('id',$_GET['posititid'],null,null,null,null,null,null,null,1);
  break;
  case 3:
   $this->userManager->EditRow('id',$positit->getIdAuteur(),null,null,null,null,-1);
   $sanction = "</br>Addittionellement, vous avez perdu un coeur.";
  break; 
  case 4:
   $this->userManager->DeleteRow('id',$positit->getIdAuteur());
  break; 
  
}  
  
if($_GET['option'] !=1) { 

 $this->messagesManager->InsertRow("L'un de vos positits à été supprimé.".$sanction,$positit->getIdAuteur());
  $this->posititManager->DeleteRow('id',$_GET['posititid']); 
}  
  
}

 $positits = $this->posititManager->getAllValues();

 }else{
    header("Location: ./index.php?route=home");
    exit();
 }
 
 // redirection
    $template = "Views/dashboard.html";
    require_once "layout.html";
  }
}


