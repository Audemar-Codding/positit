<?php
namespace Models;

class messagesManager extends BDD {
    
   private $db;
   private $query;
     private $stmt;
    
  public function __construct() {
    $this->db = $this->connexion();
  }

public function GetAllUserMessages($user_id) {
    // Préparer la requête avec un placeholder
    $this->query = $this->db->prepare('SELECT * FROM messages WHERE user_id = :user_id');
    
    // Exécuter la requête avec les valeurs liées
    $this->query->execute([':user_id' => $user_id]);
    
    // Définir le mode de récupération
    $this->query->setFetchMode(\PDO::FETCH_CLASS, \Models\message::class);
    
    // Récupérer toutes les lignes correspondantes
    $messages = $this->query->fetchAll();
    
    return $messages;
}

// Récupére un message precit
public function GetSingleMessage($ref, $refvalue) {
      $this->query = 'SELECT * FROM messages WHERE ' . $ref . ' = :refvalue';
      $this->stmt = $this->db->prepare($this->query);
      $this->stmt->execute(['refvalue' => htmlspecialchars($refvalue)]);

      $this->stmt->setFetchMode(\PDO::FETCH_CLASS, \Models\message::class);

      $positit = $this->stmt->fetch();

      if ($positit) {
         return $positit;
      }
      return null;
   }

// Renvoie toute les lignes de la table
public function GetAllValues() {
        
        $this->query = $this-> db->prepare('SELECT * FROM messages');
        $this->query->execute();
        
        $this->query->setFetchMode(\PDO::FETCH_CLASS, \Models\message::class);
        
        $message = $this->query->fetchAll();
        return $message;
}
    

// Insert une ligne dans la table
public function InsertRow(...$args) {
    $id =  bin2hex(openssl_random_pseudo_bytes(32)).date('YmdHis');
    $content = $args[0];
    $user_id = $args[1];



    $this->query = 'INSERT INTO messages (id, content, user_id) VALUES (:id ,:content, :user_id)';

    $stmt = $this->db->prepare($this->query);
    $stmt->execute([
        ':id' => htmlspecialchars($id),
        ':content' => $content,
        ':user_id' => $user_id
    ]);

   
}
    

// Supprime les ligne de la table avec $ref = $refvalue
public function DeleteRow($ref,$refvalue) {
        
    $this->query = 'DELETE FROM messages
    WHERE '.$ref.' = "'.$refvalue.'"';

    $this->execute();
        
} 
    

// Supprime toutes les valeurs de la table    
public function DeleteValuesTable() {
     
    $this->query = 'DELETE FROM messages';
    $this->execute();
     
} 
    

private function execute() {
    $stmt = $this->db->prepare($this->query);
    $stmt->execute();
}     
   
}

