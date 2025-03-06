<?php

include '../config/config.php';

// var_dump($db);

if(isset($_POST["login_inscription"]) && isset($_POST["password_inscription"])) {
    $login = $_POST["login_inscription"];
    $password = $_POST["password_inscription"];

   $stmt = $database->getConnexion()->prepare("SELECT COUNT(*) FROM user WHERE login = :login");
   $stmt->bindParam(':login', $login);
   $stmt->execute();
   $usernameExists = $stmt->fetchColumn();

   if ($usernameExists > 0) {
       echo "Ce nom d'utilisateur est déjà pris.";
   } else {
  
       $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

       $sql = "INSERT INTO user (login, password) VALUES (?, ?)";
       $stmt = $database->getConnexion()->prepare($sql);
       $stmt->bindParam(1, $login);
       $stmt->bindParam(2, $hashedPassword);
       $stmt->execute();
       echo "Utilisateur inscrit en base de donnée.";
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style1.css">
    <title>Inscription</title>
</head>
<body>
<header>
        <?php include 'header.php';?>
    </header>

    <div class="container_inscription">

        <div class="item_inscription">

            <form action="" method="post">

            <label for="login_inscription">
                <input type="text" name="login_inscription" placeholder="login inscription" required>
            </label>

            <label for="password_inscription">
                <input type="password" name="password_inscription" placeholder="password inscription" required>
            </label>

            <button type="submit">Inscription</button>

            </form>

        </div>

    </div>

</body>
</html>