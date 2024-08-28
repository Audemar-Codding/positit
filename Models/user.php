<?php
namespace Models;

class user {
    private $id;
    private $username;
    private $password;
    private $style_class;
    private $stickers_html;
    private $heart;
    private $city;
    private $coordinate;
    private $positit_created;
    private $question;
    private $canpin;
    
    public function getId() {
        return $this->id;
    }
    
    public function getUsername() {
        return htmlspecialchars_decode($this->username);
    }
    
    public function getPassword() {
        return $this->password;
    }
    
    public function getStyleClass() {
        return htmlspecialchars_decode($this->style_class);
    }
    
    public function getStickersHtml() {
        return htmlspecialchars_decode($this->stickers_html);
    }
    
    public function getHeart() {
        return $this->heart;
    }
    
    public function getCity() {
        return htmlspecialchars_decode($this->city);
    }
    
    public function getCoordinate() {
        return $this->coordinate;
    }
    
    public function getPosititCreated() {
        return $this->positit_created;
    }
    
    public function getQuestion() {
        return htmlspecialchars_decode($this->question);
    }
    
    public function getCanpin() {
        return $this->canpin;
    }
    
}