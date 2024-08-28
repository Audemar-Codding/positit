<?php 

class leaderboardController {
  
  private $userManager;
  
  public function __construct()
  {
   $this->userManager = new Models\userManager();
  }
  
  
    public function display() {

$currentuser;
$currentUserRank;


    $users = $this->userManager->GetUsersSortedByHearts(3);
        
        
        
  if(isset($_SESSION['connected']) && $_SESSION['connected']) {
      $currentUser =  $this->userManager->SingleUser($_SESSION['userName'], $_SESSION['password']);
      $currentUserRank = $this->userManager->GetLeaderboardRank($currentUser->getId());
    
  }
        
        
    // redirection
    $template = "Views/leaderboard.html";
    require_once "layout.html";
    }
    
}

