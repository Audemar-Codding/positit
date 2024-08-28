<?php 

class LoginController {
  
  private $userManager;
  
  public function __construct()
  {
    $this->userManager = new Models\userManager();
  }
  
  
    public function display() {
     
     $message = "";
     $timeok = true;
     
 if(isset($_POST['userName']) && isset($_POST['password']))
 {
     $user = $this->userManager->SingleUser($_POST['userName'],$_POST['password']);
     
     if($user)
     {
         $_SESSION['connected'] = true;
         $_SESSION['userName'] = $_POST['userName'];

         $message = "vous êtes connecté";
         
         if($user->getUsername() == 'IAMTHEADMIN') {
             $_SESSION['admin'] = true;
         }else{
             $_SESSION['admin'] = false;
         }
         
     }
     else 
     {
        $message = "Identifiant ou mots de passe incorrect";
     }
     
 }
 
 if(isset($_SESSION['connected']) && $_SESSION['connected'] === true)
 {
    header("Location: ./index.php?route=home");
    exit();
 }
 
 
 
 if(isset($_POST['userName'])) {
  if(isset($_POST['question']) && isset($_POST['answer']))
 {

        if(isset($_SESSION['last_submission_time'])) {
        $lastSubmissionTime = $_SESSION['last_submission_time'];
        $currentTime = time();
        
             if(($currentTime - $lastSubmissionTime) < 5) {
                $message = "Veuillez attendre ".($currentTime - $lastSubmissionTime)." secondes avant de réinitialisez votre mot de passe.";
                $timeok = false;
            }
        }

   $_SESSION['last_submission_time'] = time();   
     
    if($timeok){ 
    $question =  strtolower($_POST['question'].$_POST['answer']);
    $user = $this->userManager->getSingleUser('username',$_POST['userName']);
  if($user != null) {
  if($question == $user->getQuestion())
  {

   $this->userManager->EditRow('username',$_POST['userName'],null,$_POST['userName'].'12345678!');
       

   $message="mots de passe:".$_POST['userName'].'12345678!'."</br> changer le rapidement dans compte";
  }else{ $message="la réponse ou la question n'est pas la bonne.";}
  }else{$message="aucun utilisateur ne porte ce nom";}
}   
     
     
     
 }
 }else{$message="veuillez rentrer votre nom d'utilisateur";}
 
 
 
 // redirection
    $template = "Views/login.html";
    require_once "layout.html";
  }
}


