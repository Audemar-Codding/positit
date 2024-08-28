<?php
namespace Models;

class iconManager extends BDD {
    
   private $db;
   private $query;
    
  public function __construct() {
    $this->db = $this->connexion();
  }
    


// Renvoie toute les lignes de la table
  public function GetAllValues() {
        
        $this->query = $this-> db->prepare('SELECT * FROM Icon');
        $this->query->execute();
        
        $this->query->setFetchMode(\PDO::FETCH_CLASS, \Models\icon::class);
        
        $icons = $this->query->fetchAll();
        return $icons;
}

   
}

