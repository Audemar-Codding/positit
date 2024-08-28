<?php
namespace Models;

class message {
    private $id;
    private $created_at;
    private $content;
    private $user_id;

    
    public function getId() {
        return $this->id;
    }
    
    public function getCreatedAt() {
        return $this->created_at;
    }
    
    public function getContent() {
        return $this->content;
    }
    
    public function getUserId() {
        return $this->user_id;
    }
    
   

}