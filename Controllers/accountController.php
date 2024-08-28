<?php 

class AccountController {
    
  private $posititManager;
  private $userManager;
  private $iconManager;
  private $messagesManager;
    
    public function __construct()
  {
   $this->posititManager = new Models\posititManager();
   $this->userManager = new Models\userManager();
   $this->iconManager = new Models\iconManager();
   $this->messagesManager = new Models\messagesManager();
  }
    
  
    public function display() {

 $message = "";
 $message2 = "";
 $currentUser;
 $currentUserRank;
 $usersTop = $this->userManager->GetUsersSortedByHearts(3);
        
 // code php logique de la page home

 if(isset($_SESSION['connected']) && $_SESSION['connected'] === true)
{
  $currentUser =  $this->userManager->getSingleUser('username',$_SESSION['userName']);
  $icons = $this->iconManager->GetAllValues();
  $currentUserRank = $this->userManager->GetLeaderboardRank($currentUser->getId());
  $stickersMax = floor(4 + ($currentUser->getHeart()/10));
  $usermessages = $this->messagesManager->GetAllUserMessages($currentUser->getId());
  
  if(isset($_POST['userName']) && isset($_POST['city']) && isset($_POST['coordinate']) )  {

        if($_POST['userName'] != $_SESSION['userName'] && $this->userManager->GetSingleUser('username',$_POST['userName']))
        {
         $message = "Nom d'utilisateur déjà utilisé";
        }
        else
        {
         $this->userManager->EditRow('id',$currentUser->getId(),$_POST['userName'],null,null,null,null,$_POST['city'], $_POST['coordinate']);

         $_SESSION['userName'] = $_POST['userName'];
         $currentUser =  $this->userManager->getSingleUser('username',$_SESSION['userName']);
         $message = "Informations mises à jour";
        }
  }
  
  

  if(isset($_POST['hiddenInputSticker']) && isset($_POST['hiddenInputStyle'])) {
   
 
   
   // VERIFICATION DU CONTENU DES STICKERS
   
   
   if($_POST['hiddenInputStyle'] != "positit-yellow" && $_POST['hiddenInputStyle'] != "positit-white" && $_POST['hiddenInputStyle'] != "positit-blue"){
   $_POST['hiddenInputStyle'] = "positit-yellow";
   }
   
   
   $dom = new DOMDocument();
   libxml_use_internal_errors(true);
   
   $stickers = $_POST['hiddenInputSticker'];
   
   $dom->loadHTML($stickers);
   libxml_clear_errors();
   
   
   $valid_elements = [];
   
   foreach ($dom->getElementsByTagName('div') as $index => $div) { 
    
    if($div->hasAttribute('class') && $div->getAttribute('class') === "stickers" && strpos($div->getAttribute('class'), ' ') === false && $div->attributes->length === 2 && $div->getElementsByTagName('object')->length == 1){


     // vérif de l'object
     
 $objectvalid = false;

 $object = $div->getElementsByTagName('object')->item(0);
 
    while ($div->hasChildNodes()) {$div->removeChild($div->firstChild);}

if($object->attributes->length === 3 && $object->getAttribute('type') === "image/svg+xml" && strpos($object->getAttribute('data'), 'ssets/pictures/icons/') != 0) {

       $styles = array_filter(array_map('trim', explode(';', $object->getAttribute('style'))));

     if(count($styles) === 2){
        foreach ($styles as $style) {
            if ($style) {
                list($property) = explode(':', $style, 2);
                if (in_array(trim($property), ['width', 'transform'])) {
                 
                 
                 // Extraction de l'attribut 'style'
                 $style = $object->getAttribute('style');

                // Vérification de la présence de 'transform' dans le style
                $transformValue = $this->getStyleProperty($style, 'transform');
                $widthValue =  $this->getStyleProperty($style, 'width');
                 
                     if (preg_match('/^rotate\(-?\d+(\.\d+)?turn\)(\s+rotate\(-?\d+(\.\d+)?turn\))*$/', $transformValue))  {

                     if ( preg_match('/^(\d+(\.\d+)?)%$/', $widthValue, $matches)) {
                     $numericValue = (float) $matches[1];
                       if ($numericValue >= 0 && $numericValue <= 120) {
                       
                       while ($object->hasChildNodes()) {$object->removeChild($object->firstChild);   }
                       
                        $div->appendChild($object);
                       
                        $objectvalid = true;
                           break;
                            }
                        }
                       
                     
                   }
                 
          
                }
            }
        }
    }


}

       $styles = array_filter(array_map('trim', explode(';', $div->getAttribute('style'))));

$validcount = 0;
 foreach ($styles as $style) {
            if ($style) {
                list($property) = explode(':', $style, 2);
                if (in_array(trim($property), ['top', 'left', 'fill'])) {
$validcount++;
                }
            }
        }

     if($validcount === 3 && count($styles) === 3 && $objectvalid && count($valid_elements) < $stickersMax){
     $valid_elements[] = $dom->saveHTML($div);
     }
     
     

     
     
     

    }
    
   }
   
   
   
   $_POST['hiddenInputSticker'] = implode('', $valid_elements);;
  
  // =====================================
   
   
   
      $this->userManager->EditRow('id',$currentUser->getId(),null,null,$_POST['hiddenInputStyle'],$_POST['hiddenInputSticker']);
       $message2 = "Votre style est enregisté";
       $currentUser =  $this->userManager->getSingleUser('username',$_SESSION['userName']);
  }
  

 // Pour sécuriser l'accès aux page target=_blank qui ont des get
 $access_token = bin2hex(openssl_random_pseudo_bytes(32));
 $_SESSION['access_token'] = $access_token;

}
 

 // redirection
    $template = "Views/account.html";
    require_once "layout.html";
  }
  
       // Fonction pour extraire la valeur d'une propriété CSS depuis une chaîne de style
private function getStyleProperty($style, $property) {
    // Convertit la chaîne de style en tableau de propriétés
    $properties = explode(';', $style);
    foreach ($properties as $prop) {
        // Sépare la propriété et la valeur
        list($name, $value) = explode(':', $prop, 2) + [NULL, NULL];
        if (trim($name) === $property) {
            return trim($value);
        }
    }
    return null;
}


}


