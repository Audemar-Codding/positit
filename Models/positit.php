<?php
namespace Models;

//htmlspecialchars
//htmlspecialchars_decode(

class positit {
    private $id;
    private $content;
    private $created_at;
    private $style_class;
    private $stickers_html;
    private $like_users;
    private $pinned;
    private $id_auteur;
    private $safe;
    
    public function getId() {
        return $this->id;
    }
    
    public function getContent() {
        return htmlspecialchars_decode($this->content);
    }
    
    public function getCreatedAt() {
        return $this->created_at;
    }

    public function getStyleClass() {
        return htmlspecialchars_decode($this->style_class);
    }
    
    public function getStickersHtml() {
        return htmlspecialchars_decode($this->stickers_html);
    }
    
    public function getLikeUsers() {
        return $this->like_users;
    }

    public function getPinned() {
        return $this->pinned;
    }
    
    public function getIdAuteur() {
        return $this->id_auteur;
    }
    
    public function getSafe() {
        return $this->safe;
    }
    
    public function getAuteurName() {

    $name = "Anonymous";

         $users = new userManager();
         
         if($this->id_auteur != null || $this->id_auteur != "") {
             $user = $users->GetSingleUser('id',$this->id_auteur);
             $name = $user->getUsername();}
   
   return htmlspecialchars_decode($name);

    }

}