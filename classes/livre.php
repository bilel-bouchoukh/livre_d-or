<?php

class Livre{
    public  $comment;
    public DateTime $date;
    public $db;

    public function __construct(Database $db){
        $this->db = $db->getConnexion();
    }

    public function SelectLivre($currentPage,$parPage){
        
        $premier = ($currentPage * $parPage) - $parPage;

        $sql = "SELECT comment, date, user.login as username FROM comment 
        INNER JOIN user ON id_user = user.id
        ORDER BY date 
        DESC LIMIT :premier, :parpage";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':premier', $premier, PDO::PARAM_INT);
        $stmt->bindValue(':parpage', $parPage, PDO::PARAM_INT);
    

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function CountPage(){
        $sql = "SELECT COUNT(*) as nb_articles FROM comment";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result= $stmt->fetch();
        $nbArticle = (int) $result['nb_articles'];

        return $nbArticle ;
    }

    public function RechercheCommentaire($cara){
        $sql = "SELECT comment, date, user.login as username 
        FROM comment 
        INNER JOIN user ON id_user = user.id
        WHERE MATCH(comment) AGAINST (:cara)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':cara', $cara, PDO::PARAM_STR);
        
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

}

?>