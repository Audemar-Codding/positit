<?php 

class HomeController {
  
  private $posititManager;
  private $userManager;
  private $visitesManager;
  
  public function __construct()
  {
   $this->posititManager = new Models\posititManager();
   $this->userManager = new Models\userManager();
   $this->visitesManager = new Models\visitesManager();
   $this->visitesManager->IncreaseVisitesNumber();
  }

    public function display() {
        
$randPositits = $this->posititManager->GetRandomPositit(4);

      // code php logique de la page home
 $statPosititCount = count($this->posititManager->GetAllValues());
 $statGoodViberCount = count($this->userManager->GetAllValues());
 $statHappyPeopleCount = $this->visitesManager->GetVisitesNumber();
 $posititUsers = [];
 $actualUserId = -1;
 $currentUser;
 $currentUserRank;
 $usersTop = $this->userManager->GetUsersSortedByHearts(3);
 $pinnedPositit = $this->posititManager->GetSinglePositit('pinned',1);
 
 $allCities = json_encode($this->userManager->GetAllCoordinates());

if(isset($_SESSION['connected']) && $_SESSION['connected'] === true)
{
    

   $currentUser =  $this->userManager->getSingleUser('username',$_SESSION['userName']);
   $currentUserRank = $this->userManager->GetLeaderboardRank($currentUser->getId());

   
    if($currentUser != null) {
  $actualUserId = $currentUser->getId(); 
    }else{
        $_SESSION['connected'] = false;
    }

}

 // redirection
    $template = "Views/home.html";
    require_once "layout.html";
  }
}




    
        
        
