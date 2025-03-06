<?php

require_once "../config/config.php";


if (isset($_POST["login_connexion"]) && isset($_POST["password_connexion"])) {
    $login = $_POST["login_connexion"];
    $password = $_POST["password_connexion"];

    $sql = "SELECT id, password FROM user WHERE login = ?";
        
        $stmt = $database->getConnexion()->prepare($sql);
        
        // Exécute la requête avec le login
        $stmt->execute([$login]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si un utilisateur est trouvé et que le mot de passe est correct
        if ($result && password_verify($password, $result['password'])) {
            $_SESSION['id'] = $result['id'];
            echo "Utilisateur connecté.";
            header("location:acceuil.php");
                } else {
            echo "Erreur de connexion.";
        }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style1.css">
    <title>Document</title>
</head>
<body>

<header>
        <?php include 'header.php';?>
    </header>

<div class="container_conn">

        <div class="item_connexion">

            <form action="" method="post">

            <label for="login_connexion">
                <input type="text" name="login_connexion" placeholder="login connexion" required>
            </label>

            <label for="password_connexion">
                <input type="text" name="password_connexion" placeholder="password connexion" required>
            </label>

            <button type="submit">Connexion</button>

            </form>

        </div>

    </div>
    
</body>
</html>