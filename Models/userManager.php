<?php

namespace Models;

class userManager extends BDD {
    
   private $db;
   private $query;
   private $stmt;
    
  public function __construct() {
    $this->db = $this->connexion();
  }
    
// Récupère un user
public function SingleUser($username, $password) {
    $this->query = $this->db->prepare('SELECT * FROM `users` WHERE BINARY username=:username');
    $this->query->execute(['username' => htmlspecialchars($username)]);
    
    $this->query->setFetchMode(\PDO::FETCH_CLASS, \Models\user::class);
    
    $user = $this->query->fetch();
    

    if ($user && !empty($password) && password_verify($password, $user->getPassword())) {
        return $user;
    }
  
    return null;
}

// Récupère un user avec une ref
public function GetSingleUser($ref, $refvalue) {
    $this->query = 'SELECT * FROM users WHERE BINARY ' . $ref . ' = :refvalue';
    $this->stmt = $this->db->prepare($this->query);
    $this->stmt->execute(['refvalue' => htmlspecialchars($refvalue)]);

    $this->stmt->setFetchMode(\PDO::FETCH_CLASS, \Models\user::class);

    $user = $this->stmt->fetch();

    if ($user) {
        return $user;
    }
    return null;
}

// Renvoie toutes les lignes de la table
public function GetAllValues() {
    $this->query = $this->db->prepare('SELECT * FROM users');
    $this->query->execute();
    
    $this->query->setFetchMode(\PDO::FETCH_CLASS, \Models\user::class);
    
    $users = $this->query->fetchAll();
    return $users;
}

public function GetUsersSortedByHearts($limit) {

        $this->query = 'SELECT * FROM users ORDER BY heart DESC LIMIT ' . intval($limit);
        

        $this->stmt = $this->db->prepare($this->query);
        

        $this->stmt->execute();
    $this->stmt->setFetchMode(\PDO::FETCH_CLASS, \Models\user::class);
        $users = $this->stmt->fetchAll();
        return $users;

}

// Renvoie toutes les villes sans doublon
public function GetAllCoordinates() {
    $this->query = $this->db->prepare('SELECT DISTINCT coordinate FROM users');
    $this->query->execute();
    $coordinates = $this->query->fetchAll();
    return $coordinates;
}
    
//Renvoie la position de l'utilisateur dans le leaderboard
public function GetLeaderboardRank($user_id) {
    $query = $this->db->prepare('
        SELECT position
        FROM (
            SELECT id, heart,
                   @rank := @rank + 1 AS position
            FROM users, (SELECT @rank := 0) AS init
            ORDER BY heart DESC
        ) AS ranked
        WHERE id = :user_id
    ');


    $query->execute([':user_id' => $user_id]);

    $result = $query->fetchColumn();

    return $result;
}
    
// Édite les lignes de la table avec $ref
public function EditRow($ref, $refvalue, ...$args) {
    $username = isset($args[0]) ? $args[0] : null;
    $password = isset($args[1]) ? $args[1] : null;
    $style_class = isset($args[2]) ? $args[2] : null;
    $stickers_html = isset($args[3]) ? $args[3] : null;
    $heart = isset($args[4]) ? $args[4] : null;
    $city = isset($args[5]) ? $args[5] : null;
    $coordinate = isset($args[6]) ? $args[6] : null;
    $positit_created = isset($args[7]) ? $args[7] : null;
    $question = isset($args[8]) ? $args[8] : null;
    $canpin = isset($args[9]) ? $args[9] : null;

    $fields = [];
    $params = [':refvalue' => htmlspecialchars($refvalue)];

    if ($username !== null) {
        $fields[] = 'username = :username';
        $params[':username'] = htmlspecialchars($username);
    }
    if ($password !== null) {
        $fields[] = 'password = :password';
        $params[':password'] = $this->HashMDP($password);
    }
    if ($style_class !== null) {
        $fields[] = 'style_class = :style_class';
        $params[':style_class'] = htmlspecialchars($style_class);
    }
    if ($stickers_html !== null) {
        $fields[] = 'stickers_html = :stickers_html';
        $params[':stickers_html'] = htmlspecialchars($stickers_html);
    }
    if ($heart !== null) {
        if ($heart == 0) {
            $fields[] = 'heart = :heart';
        } else {
            $fields[] = 'heart = heart + :heart';
        }
        $params[':heart'] = $heart;
    }
    if ($city !== null) {
        $fields[] = 'city = :city';
        $params[':city'] = htmlspecialchars($city);
    }
    if ($coordinate !== null) {
        $fields[] = 'coordinate = :coordinate';
        $params[':coordinate'] = $coordinate;
    }
    if ($positit_created !== null) {
        if ($positit_created == 0) {
            $fields[] = 'positit_created = :positit_created';
        } else {
            $fields[] = 'positit_created = positit_created + :positit_created';
        }
        $params[':positit_created'] = $positit_created;
    }
    if ($question !== null) {
        $fields[] = 'question = :question';
        $params[':question'] = $question;
    }
    if ($canpin !== null) {
        $fields[] = 'canpin = :canpin';
        $params[':canpin'] = $canpin;
    }

    $query = 'UPDATE users SET ' . implode(', ', $fields) . ' WHERE ' . $ref . ' = :refvalue';
    
    $stmt = $this->db->prepare($query);
    $stmt->execute($params);
}

// Insère une ligne dans la table
public function InsertRow(...$args) {
    $id =  bin2hex(openssl_random_pseudo_bytes(32)).date('YmdHis');
    $username = $args[0];
    $password = $args[1];
    $city = $args[2];
    $coordinate = $args[3];
    $question = $args[4];
    
    $this->query = 'INSERT INTO users (id,username, password, city, coordinate, question) VALUES (:id,:username, :password, :city, :coordinate, :question)';
    
    $stmt = $this->db->prepare($this->query);
    $stmt->execute([
       'id' => htmlspecialchars($id),
        ':username' => htmlspecialchars($username),
        ':password' => htmlspecialchars($this->HashMDP($password)),
        ':city' => htmlspecialchars($city),
        ':coordinate' => $coordinate,
        ':question' => htmlspecialchars($question)
    ]);
}
    
// Supprime les lignes de la table avec $ref = $refvalue
public function DeleteRow($ref, $refvalue) {
    $this->query = 'DELETE FROM users WHERE ' . $ref . ' = :refvalue';

    $stmt = $this->db->prepare($this->query);
    $stmt->execute([':refvalue' => $refvalue]);
}

// Supprime toutes les valeurs de la table    
public function DeleteValuesTable() {
    $this->query = 'DELETE FROM users';
    $this->execute();
}

// Hashe les mots de passe    
public function HashMDP($mdp){
    return password_hash($mdp, PASSWORD_DEFAULT);
}    

private function execute() {
    $stmt = $this->db->prepare($this->query);
    $stmt->execute();
}     
}
