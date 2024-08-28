<?php 

class SendPosititController {
  
  private $posititManager;
  private $userManager;
  private $textModeration;
  
  public function __construct()
  {
   $this->posititManager = new Models\posititManager();
   $this->userManager = new Models\userManager();
   $this->textModeration = new Ai\textModeration();
  }
  
  
    public function display() {
$currentUser = false;
$message = "";
$timeok = true; // on gére un délai de 5s pour les spammeur
$currentUserRank;
$usersTop = $this->userManager->GetUsersSortedByHearts(3);
        
 // code php logique de la page home
 if(isset($_SESSION['connected']) && $_SESSION['connected'] ) {
    $currentUser =  $this->userManager->getSingleUser('username',$_SESSION['userName']);
   $currentUserRank = $this->userManager->GetLeaderboardRank($currentUser->getId());
 }
 
 
 
if(isset($_POST['posititMessage']) && !empty($_POST['posititMessage']) && strlen($_POST['posititMessage'])>9 ) {
    
    
    if(isset($_SESSION['last_submission_time'])) {
        $lastSubmissionTime = $_SESSION['last_submission_time'];
        $currentTime = time();
        
         if(($currentTime - $lastSubmissionTime) < 5) {
           $message = "Veuillez attendre ".($currentTime - $lastSubmissionTime)." secondes avant de soumettre un nouveau message.";
            $timeok = false;
        }
    }
    
    
    
 if($timeok){   
     
    $message = "... moderation en cours";
    $nsfwReasons = $this->textModeration->isSafe(trim(preg_replace('/[^a-zA-ZÀ-ÿ0-9\s]/u', '', preg_replace('/\s+/', ' ', $_POST['posititMessage']))), $_SESSION['lang']);
 

 
 if(empty($nsfwReasons))
 {
 if($currentUser) { //if connected
 
 if(isset($_POST['messagePin'])){$this->userManager->EditRow('id',$currentUser->getId(),null,null,null,null,null,null,null,null,null,0); $currentUser =  $this->userManager->getSingleUser('username',$_SESSION['userName']);}
 
  $this->posititManager->InsertRow(false,$_POST['posititMessage'],$currentUser->getStyleClass(),$currentUser->getstickersHtml(),$currentUser->getId(),isset($_POST['messagePin']) ? 1 : 0);
   $this->userManager->EditRow('id',$currentUser->getId(),null,null,null,null,null,null,null,'1');

 }else { $this->posititManager->InsertRow(true,$_POST['posititMessage']); }
    $_SESSION['last_submission_time'] = time(); 
    $message = "merci pour votre positit!";
    
 }
 else{
    $message = "votre message n'a pas été prit en compte pour les raison suivantes: </br>";
 foreach($nsfwReasons as $reason) {
     $message .= $reason.',';
 } 
 
 }
    
}
}else {
    if(isset($_POST['posititMessage'])) {
    if(empty($_POST['posititMessage'])){
        $message = "votre message est vide... oups ?";
    }else{
        $message = "votre message est trop court, il doit faire au moins 10 caractéres.";
    }
}
    
}


 // redirection
    $template = "Views/sendpositit.html";
    require_once "layout.html";
  }
}


?> 