<?php

require '../config/config.php';

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
        <?php include 'header.php' ;?>
    </header>

    <main>
        <?php

        if(isset($_SESSION['id'])){
            echo "Vous étes bien connecter";
        }

        ?>
        <?php include 'main.php';?>
    </main>
    
</body>
</html>