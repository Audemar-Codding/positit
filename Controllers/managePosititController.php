<?php 

class managePosititController {
  
  private $posititManager;
  private $userManager;
  
  public function __construct()
  {
   $this->posititManager = new Models\posititManager();
    $this->userManager = new Models\userManager();
  }

    public function display() {

// la logique de like

if( isset($_GET['auteurid']) && isset($_GET['posititid']) && isset($_SESSION['connected'])) {
$currentUser =  $this->userManager->GetSingleUser('username',$_SESSION['userName']);
$positit =  $this->posititManager->GetSinglePositit('id',$_GET['posititid']);

if($currentUser && $positit && $currentUser->getId() != $positit->getIdAuteur() ) {

    // ajout de l'user dans la liste des utilisateur ayant liké
    $string = $positit->getLikeUsers();
    $posititUsers = explode(',', $string);
   
    
    if(array_search($currentUser->getId(),$posititUsers) == "" || $posititUsers[0] == "") {

    // ajout d'un like pour l'utilisateur
    $this->userManager->EditRow('id',$_GET['auteurid'], null,null,null,null,'1');
    
    // vérification si le post a 100 like, si non ajout de l'user dans la liste sinon suppression
    if( $posititUsers[0] == "" || count($posititUsers) < 99) {
    $this->posititManager->EditRow('id',$_GET['posititid'],null,null,null,null,$currentUser->getId().', ',null,null);
    }else{
    $this->posititManager->DeleteRow('id',$_GET['posititid']);
    }
    
    }
    
    
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


