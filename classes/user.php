<?php

class User
{
    protected $db;
    protected $id;

    public function __construct(Database $db, Int $id)
    {
        $this->db = $db->getConnexion();

            // Si un ID d'utilisateur est stocké en session, on le récupère
            if (isset($_SESSION['id'])) {
                $this->id = $id;
            }
    }

    public function createUser($login, $password)
    {   
        // Vérification que l'utilisateur n'existe pas en base de données
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM user WHERE login = :login");
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        $usernameExists = $stmt->fetchColumn();

        if ($usernameExists > 0) {
            echo "Ce nom d'utilisateur est déjà pris.";
        } else {
            // Hashage du mot de passe
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO user (login, password) VALUES (?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(1, $login);
            $stmt->bindParam(2, $hashedPassword);

            return $stmt->execute();
        }
    }


   public function selectUserById($id)
   {
       $query = "SELECT * FROM user WHERE id = :id";
       $stmt = $this->db->prepare($query);
       $stmt->bindParam(':id', $id, PDO::PARAM_INT);
       $stmt->execute();
  
       // Vérifie si l'utilisateur existe
       if ($stmt->rowCount() > 0) {
           return $stmt->fetch(PDO::FETCH_ASSOC); // Retourne l'utilisateur sous forme de tableau associatif
       } else {
           return null; // Aucun utilisateur trouvé
       }
    }

  
    public function getAllUsers()
    {
        $query = "SELECT * FROM user";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        // Vérifie si des utilisateurs ont été trouvés
        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourne tous les utilisateurs sous forme de tableau associatif
        } else {
            return []; // Aucun utilisateur trouvé
        }
    }
  

     // Requête DELETE pour supprimer un utilisateur par son ID
    public function deleteUserById($id)
    {
        $query = "DELETE FROM user WHERE id = :id";
        $params = ['id' => $id];
        
        $stmt = $this->db->prepare($query);
        return $stmt->execute($params); // Exécute la requête
    }


    // Mettre à jour un utilisateur
    public function updateUser($id, $new_login, $new_password)
    {   
        $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);

        $query = "UPDATE user SET login = :login, password = :password WHERE id = :id";
        $params = [
            ':login' => $new_login,
            ':password' => $hashedPassword,
            ':id' => $id
        ];

        $stmt = $this->db->prepare($query);
        return $stmt->execute($params); // Exécute la requête
    }

    public function findUser()
    {
    
        $query = "SELECT * FROM user ORDER BY id DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        // Vérifie si des utilisateurs existent
    
    }

        
    public function selectUserByIdDesc($result_search)
    {
        $query = "SELECT login FROM user WHERE user LIKE" ."%" . $result_search . "%" . "ORDER BY id DESC";
    }

    public function connectUser($login, $password)
    {
        $sql = "SELECT password FROM user WHERE login = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(1, $login);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $storedPassword = $stmt->fetchColumn();

            if (password_verify($password, $storedPassword)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
 
    public function selectUserbyIdPassword($login, $password)
    {
        $sql = "SELECT id, password FROM user WHERE login = ?";
        
        // Prépare la requête
        $stmt = $this->db->prepare($sql);
        
        // Exécute la requête avec le login
        $stmt->execute([$login]);

        // Récupère le résultat sous forme de tableau associatif
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si un utilisateur est trouvé et que le mot de passe est correct
        if ($result && password_verify($password, $result['password'])) {
            $_SESSION['id'] = $result['id'];
            return true;
        } else {
            return false;
        }
    }

    public function upDateUserbyId($id, $new_login, $new_password)
    {   
        $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);

        $query = "UPDATE user SET login = :login, password = :password WHERE id = :id";
        $params = [
            ':login' => $new_login,
            ':password' => $hashedPassword,
            ':id' => $id
        ];

        try {
          
            $stmt = $this->db->prepare($query);
            
            $result = $stmt->execute($params);
            
            // Retourne le résultat de l'exécution (true ou false)
            return $result;
        } catch (PDOException $e) {
            // Gestion d'une exception en cas d'erreur avec la base de données
            echo "Erreur lors de la mise à jour : " . $e->getMessage();
            return false;
        }
    }

}

    
    
 
    
        
?>