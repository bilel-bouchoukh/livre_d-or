<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style1.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <header>
        <div class="navbar">
            <a href="acceuil.php">Page D'acceuil</a>

            <?php if(empty($_SESSION['id'])): ?>
                 <a  href="connexion.php">Connexion</a>
                <?php else: ?>
                    <a hidden href="connexion.php">Connexion</a>
            <?php endif; ?>

            <?php if(empty($_SESSION['id'])): ?>
                 <a  href="inscription.php">Inscription</a>
                <?php else: ?>
                    <a hidden href="inscription.php">Inscription</a>
            <?php endif; ?>

            <a href="livre-or.php">Livre d'Or</a>

            <?php if(empty($_SESSION['id'])): ?>
                 <a hidden href="profil.php">Profil</a>
                <?php else: ?>
                    <a href="profil.php">Profil</a>
            <?php endif; ?>

            <?php if(empty($_SESSION['id'])): ?>
                 <a hidden href="logout.php">Déconnexion</a>
                <?php else: ?>
                    <a href="logout.php">Déconnexion</a>
            <?php endif; ?>
             
        </div>
    </header>
    
</body>
</html>