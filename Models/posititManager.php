<?php
namespace Models;

class posititManager extends BDD {
    
   private $db;
   private $query;
   private $stmt;
    
  public function __construct() {
    $this->db = $this->connexion();
  }
    

// Récupére un positit
public function GetSinglePositit($ref, $refvalue) {
      $this->query = 'SELECT * FROM positit WHERE ' . $ref . ' = :refvalue LIMIT 1';
      $this->stmt = $this->db->prepare($this->query);
      $this->stmt->execute(['refvalue' => htmlspecialchars($refvalue)]);

      $this->stmt->setFetchMode(\PDO::FETCH_CLASS, \Models\positit::class);

      $positit = $this->stmt->fetch();

      if ($positit) {
         return $positit;
      }
      return null;
   }
    

// Récupére des positit aléatoire au nombre défini
public function GetRandomPositit($number){
    
    $this->query = $this-> db->prepare('SELECT * FROM positit WHERE safe = 1 AND pinned = 0 ORDER BY RAND() LIMIT '.$number.';');
    $this->query->execute();
    
    $this->query->setFetchMode(\PDO::FETCH_CLASS, \Models\positit::class);
    
    $positit = $this->query->fetchAll();
    return $positit;

}

// Renvoie toute les lignes de la table
public function GetAllValues() {
        
        $this->query = $this-> db->prepare('SELECT * FROM positit');
        $this->query->execute();
        
        $this->query->setFetchMode(\PDO::FETCH_CLASS, \Models\positit::class);
        
        $positit = $this->query->fetchAll();
        return $positit;
}
    

// Edite les lignes de la table avec $ref
public function EditRow($ref, $refvalue, ...$args) {

    $content = isset($args[0]) ? $args[0] : null;
    $created_at = isset($args[1]) ? $args[1] : null;
    $style_class = isset($args[2]) ? $args[2] : null;
    $stickers_html = isset($args[3]) ? $args[3] : null;
    $like_users = isset($args[4]) ? $args[4] : null;
    $pinned = isset($args[5]) ? $args[5] : null;
    $id_auteur = isset($args[6]) ? $args[6] : null;
    $safe = isset($args[7]) ? $args[7] : null;
    $pinned = isset($args[8]) ? $args[8] : null;
    
    $fields = [];
    $params = [':refvalue' => htmlspecialchars($refvalue)];

    if ($content !== null) {
        $fields[] = 'content = :content';
        $params[':content'] = htmlspecialchars($content);
    }
    
    if ($created_at !== null) {
        $fields[] = 'created_at = :created_at';
        $params[':created_at'] = $created_at;
    }
    
    if ($style_class !== null) {
        $fields[] = 'style_class = :style_class';
        $params[':style_class'] = htmlspecialchars($style_class);
    }
    
    if ($stickers_html !== null) {
        $fields[] = 'stickers_html = :stickers_html';
        $params[':stickers_html'] = htmlspecialchars($stickers_html);
    }

    if ($like_users !== null) {
        $fields[] = 'like_users = :like_users';
        $params[':like_users'] = htmlspecialchars($like_users);
    }
    
    if ($pinned !== null) {
        $fields[] = 'pinned = :pinned';
        $params[':pinned'] = $pinned;
    }
    
    if ($id_auteur !== null) {
        $fields[] = 'id_auteur = :id_auteur';
        $params[':id_auteur'] = $id_auteur;
    }
    
    if ($safe !== null) {
        $fields[] = 'safe = :safe';
        $params[':safe'] = $safe;
    }
    
    if ($pinned !== null) {
        $fields[] = 'pinned = :pinned';
        $params[':pinned'] = $pinned;
    }

    $query = 'UPDATE positit SET ' . implode(', ', $fields) . ' WHERE ' . $ref . ' = :refvalue';

    $stmt = $this->db->prepare($query);
    $stmt->execute($params);

}


// Insert une ligne dans la table
public function InsertRow($anonymous,...$args) {

    $id =  bin2hex(openssl_random_pseudo_bytes(32)).date('YmdHis');
    $content = $args[0];
    $style_class = isset($args[1]) ? $args[1] : null;
    $stickers_html = isset($args[2]) ? $args[2] : null;
    $id_auteur = isset($args[3]) ? $args[3] : null;
    $pinned = isset($args[4]) ? $args[4] : null;

if($anonymous){
    $this->query = 'INSERT INTO positit (id, content)  VALUES (:id ,:content)';
    
    $stmt = $this->db->prepare($this->query);
    $stmt->execute([
        'id' => htmlspecialchars($id),
        ':content' => htmlspecialchars($content)
    ]);
    
}else{
    $this->query = 'INSERT INTO positit (id, content, style_class, stickers_html, id_auteur, pinned) VALUES (:id ,:content, :style_class, :stickers_html, :id_auteur, :pinned)';

    $stmt = $this->db->prepare($this->query);
    $stmt->execute([
        'id' => htmlspecialchars($id),
        ':content' => htmlspecialchars($content),
        ':style_class' => htmlspecialchars($style_class),
        ':stickers_html' => htmlspecialchars($stickers_html),
        ':id_auteur' => $id_auteur,
        ':pinned' => $pinned
    ]);
}
   
}
    

// Supprime les ligne de la table avec $ref = $refvalue
public function DeleteRow($ref,$refvalue) {
        
    $this->query = 'DELETE FROM positit
    WHERE '.$ref.' = "'.htmlspecialchars($refvalue).'"';

    $this->execute();
        
} 
    

// Supprime toutes les valeurs de la table    
public function DeleteValuesTable() {
     
    $this->query = 'DELETE FROM positit';
    $this->execute();
     
} 
    

private function execute() {
    $stmt = $this->db->prepare($this->query);
    $stmt->execute();
}     
   
}

