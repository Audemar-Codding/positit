<?php 

class RegisterController {
  
  private $userManager;
  private $messagesManager;
  
  public function __construct()
  {
    $this->userManager = new Models\userManager();
    $this->messagesManager = new Models\messagesManager();
  }
  
  
    public function display() {
        
    $message = "";
     
    if(isset($_POST['userName']) && isset($_POST['password'])  && isset($_POST['city']))
    {
         if($this->userManager->GetSingleUser('username',$_POST['userName']))
        {
         $message = "Utilisateur déjà existant";
        }
         else 
        {
            
         $question =   strtolower($_POST['question'].$_POST['answer']);

         $this->userManager->InsertRow($_POST['userName'], $_POST['password'], $_POST['city'],$_POST['coordinate'],$question);
         $user = $this->userManager->GetSingleUser('username',$_POST['userName']);
         $this->messagesManager->InsertRow('Bienvenue parmi les goods viber !',$user->getId());
         
         $_SESSION['connected'] = true;
         $_SESSION['userName'] = $_POST['userName'];
         $_SESSION['password'] = $_POST['password'];
         
         $message = "Compte crée et connecté";

        }
    }
 
 
 if(isset($_SESSION['connected']) && $_SESSION['connected'] === true)
 {
    header("Location: ./index.php?route=home");
    exit();
 }
 
 // redirection
    $template = "Views/register.html";
    require_once "layout.html";
  }
}


