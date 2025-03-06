<?php

class Database {
    private $host = "localhost";
    private $dbname = "livreor";
    private $username = "root";
    private $password = "";
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->dbname};charset=utf8", $this->username, $this->password);

        }
    
    public function getConnexion(){
        return $this->pdo;
    }

    //methode generique de select
    public function select($query, $params = [], $fetchAll = false)
    {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            //recuperation des resultats
            if ($fetchAll)
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            else
                return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            //gestion des erreurs et affichage
            echo "Erreur de requête : " . $e->getMessage();
            return false;

        }
       
    }

    //methode generique de insert
    public function insert($query, $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($query);
            //Execute la requete avec les parametres fournis
            return $stmt->execute($params);
            //Retourne true si l'insertion réussie sinon false
        } catch (PDOException $e) {
            echo "erreur d'insertion" . $e->getMessage();
            return false;
        }
    }
    
    //methode generique de delete
    public function delete($query, $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($query);
            //Execute la requete avec les parametres fournis
            return $stmt->execute($params);
        } catch (PDOException $e) {
            echo "Erreur de suppression : " . $e->getMessage();
            return false;
        }

    }

}
?>

