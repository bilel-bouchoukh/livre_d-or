<?php

require_once '../config/config.php'; 

//Vérifier si l'utilisateur est connecté

if (!isset($_SESSION['id'])) {
    echo "Vous devez être connecté pour écrire un commentaire";
    exit; 
}


// Traitement du formulaire lors de la soumission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["commentaire"])) {
    $commentaire = $_POST["commentaire"];
    $user_id = $_SESSION['id']; // Récupérer l'ID de l'utilisateur connecté

    // Préparer et exécuter la requête d'insertion du commentaire
    $sql = "INSERT INTO comment (comment, id_user, date) VALUES (:commentaire, :user_id, NOW())";
    $stmt = $db->getConnexion()->prepare($sql);
    $stmt->bindParam(':commentaire', $commentaire, PDO::PARAM_STR);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Commentaire ajouté avec succès.";
    } else {
        echo "Erreur lors de l'ajout du commentaire.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style1.css">
    <title>Ajouter un commentaire</title>
</head>
<body>
    <header>
        <?php include 'header.php';?>
    </header>

    <h2>Ajouter un commentaire</h2>

    <form action="" method="POST">
        <textarea name="commentaire" rows="4" cols="50" placeholder="Votre commentaire"></textarea>
        <br>
        <button type="submit">Envoyer</button>
    </form>

</body>
</html>
