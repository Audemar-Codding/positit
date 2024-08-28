<?php

namespace Models;

abstract class BDD  {

    public function connexion() {

         $db = new \PDO(
            'mysql:host=sql110.infinityfree.com;port=3306;dbname=secretname;charset=utf8mb4',
            'scretUsername',
            'secretMdp'
            );
        
        return $db;
    }
    
}

