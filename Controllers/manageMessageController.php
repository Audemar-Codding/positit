<?php 

class manageMessageController {
  
  private $userManager;
  private $messagesManager;
  
  public function __construct()
  {
    $this->userManager = new Models\userManager();
    $this->messagesManager = new Models\messagesManager();
  }

    public function display() {

// la logique de like

if( isset($_GET['messageid']) && isset($_SESSION['connected']) && $_SESSION['connected'] ) {
$currentUser =  $this->userManager->GetSingleUser('username',$_SESSION['userName']);
$currentMessage = $this->messagesManager->GetSingleMessage('id',$_GET['messageid']);

    if($currentMessage->getUserId() === $currentUser->getId()){
    $this->messagesManager->DeleteRow('id',$_GET['messageid']);
    }
    
    
}else{
     header("Location: ./index.php?route=home");
     exit();
 
}


 // redirection
      header("Location: ./Views/closePage.html");
      exit();
  }
}


