<?php
namespace Models;

class visitesManager extends BDD {
    
   private $db;
   private $query;
    
  public function __construct() {
    $this->db = $this->connexion();
  }
    

  public function GetVisitesNumber() {
        
        $this->query = $this-> db->prepare('SELECT Number FROM visites');
        $this->query->execute();
        
        $numberOfVisits = $this->query->fetchColumn();
        return $numberOfVisits;
}

  public function IncreaseVisitesNumber() {
        
        $this->query = $this-> db->prepare('UPDATE visites SET Number = Number + 1');
        $this->query->execute();
}


}

