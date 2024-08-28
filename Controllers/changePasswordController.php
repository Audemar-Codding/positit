<?php 

class ChangePasswordController {
    
  private $userManager;

    public function __construct()
  {
   $this->userManager = new Models\userManager();
  }
    
  
    public function display() {

 $message = "";

 // code php logique de la page home

 if(isset($_SESSION['connected']) && $_SESSION['connected'] === true)
{

  if(isset($_POST['newPassword']) && isset($_POST['oldPassword']) )  {

$user = $this->userManager->getSingleUser('userName',$_SESSION['userName']);

if(password_verify($_POST['oldPassword'], $user->getPassword())){

     $this->userManager->EditRow('id',$user->getId(),null,$_POST['newPassword']);
     $message = "mots de passe mis à jour";
     
     header("Location: ./index.php?route=account");
     exit();
}
else{$message = "votre ancien mots de passe est incorrect";}



  }
  
  
}

 // redirection
    $template = "Views/changePassword.html";
    require_once "layout.html";
  }
}


?> 