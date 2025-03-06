<?php

include '../config/config.php';
if(isset($_GET['page']) && !empty($_GET['page'])){
    $currentPage = (int)strip_tags($_GET['page']);
}else{
    $currentPage = 1;
}
$parPage = 5;
$pages = ceil($livre->CountPage()/$parPage);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style1.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <header>
        <?php include '../includes/header.php' ?>
    </header>

    <main>

        <div class="research">
            <form action="" method="post">
                <label for="recherche" >Recherche de commentaire :
                    <input type="text" name="recherche" placeholder="Recherchez un commentaire">
                    <input type="submit" name="submit">
                </label>
            </form>

        </div>
        
        <div class="main">
        <?php 
        if(isset($_POST['submit']) && !empty($_POST['recherche'])){
        $recherche = $_POST['recherche'] ?>
        <h2>Votre Recherche</h2>
        <?php foreach ($livre->RechercheCommentaire($recherche) as $livres){?>
                <div class="comment">
                    <?php 
                    "<div class='sous_comment'>";
                    echo "<p class='date'><strong>{$livres['date']}</strong></p>";
                    echo "<p class='date'><strong>{$livres['username']}</strong></p>";
                    "</div>";
                    echo "<p class='txt'>{$livres['comment']}</p>";
                    ?>
                </div>
                
                <?php } 
                }?>

        </div>

        <?php 


// Traitement du formulaire lors de la soumission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["commentaire"]) ) {
    $commentaire = $_POST["commentaire"];

    // Préparer et exécuter la requête d'insertion du commentaire
    $sql = "INSERT INTO comment (comment, id_user, date) VALUES (:commentaire, :user_id, NOW())";
    $stmt = $database->getConnexion()->prepare($sql);
    $stmt->bindParam(':commentaire', $commentaire, PDO::PARAM_STR);
    $stmt->bindParam(':user_id', $_SESSION['id'], PDO::PARAM_INT);

    if ($stmt->execute() && !empty($_SESSION['id'])) {
        echo "Commentaire ajouté avec succès.";
    } else {
        echo "Vous devez vous connecter pour écrire un message";
    }
}
?>
    <div class="div_commentaire">
        <h2>Ajouter un commentaire</h2>

        <form action="" method="POST">
            <textarea name="commentaire" rows="4" cols="50" placeholder="Votre commentaire"></textarea>
            <br>
            <button type="submit">Envoyer</button>
        </form>

    </div>


        <div class="main">
            <h2>Livre d'Or</h2>
            <?php foreach ($livre->SelectLivre($currentPage, $parPage) as $livres){?>
                <div class="comment">
                    <?php 
                    "<div class='sous_comment'>";
                    echo "<p class='date'><strong>{$livres['date']}</strong></p>";
                    echo "<p class='date'><strong>{$livres['username']}</strong></p>";
                    "</div>";
                    echo "<p class='txt'>{$livres['comment']}</p>";
                    ?>
                </div>
                
                <?php } ?>
            </div>
            
    </main>
    <nav>
                <ul class="pagination">
                    <li class="page-item <?= ($currentPage ==1) ? "disabled" : "" ?>">
                        <a href="?page= <?= $currentPage - 1 ?>" class="page-link">Précédente</a>
                    </li>
                    <?php for($page = 1; $page <= $pages; $page++): ?>
                    <li class="page-item <?=($currentPage == $page) ? "active" : "" ?>">
                        <a href="?page= <?= $page ?>" class="page-link" ><?= $page ?></a>
                    </li>
                    <?php endfor ?>
                    <li class="page-item <?=($currentPage == $pages) ? "disabled" : "" ?>">
                        <a href="?page= <?= $currentPage + 1 ?>" class="page-link">Suivant</a>
                    </li>
                </ul>
            </nav>
    
</body>
</html>

<?php 



?>