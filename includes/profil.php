<?php
require_once "../config/config.php"; 

// Démarrer la session si elle n'est pas déjà démarrée
// if (session_status() == PHP_SESSION_NONE) {
//     session_start();
// }

if (!isset($_SESSION['id'])) {
    header("Location: inscription_connexion.php");
    exit();
}

$id_user = $_SESSION['id']; 

// Récupérer les informations de l'utilisateur actuel
$currentUser = $user->selectUserById($id_user);

if (isset($_POST['login_modification']) && isset($_POST['password_modification'])) {
    $login = $_POST['login_modification'];
    $password = $_POST['password_modification'];

    $updateResult = $user->upDateUserbyId($id_user, $login, $password);

    if ($updateResult) {
        echo "Les données ont été mises à jour avec succès.";
    } else {
        echo "Une erreur s'est produite lors de la mise à jour.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style1.css">
    <title>Mon Profil</title>
</head>
<body>
    <header>
        <?php include ('header.php');?>
    </header>

    <h1>Modifier mon profil</h1>

    <?php if ($currentUser): ?>
        <form action="profil.php" method="post">
            <label for="login_modification">Nom d'utilisateur :</label>
            <input type="text" name="login_modification" value="<?php echo htmlspecialchars($currentUser['login']); ?>" required>

            <label for="password_modification">Mot de passe :</label>
            <input type="password" name="password_modification" required>

            <button type="submit">Mettre à jour</button>
        </form>
    <?php else: ?>
        <p>Utilisateur introuvable.</p>
    <?php endif; ?>

</body>
</html>