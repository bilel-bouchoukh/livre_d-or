<?php

include '../config/config.php';

session_destroy();
echo "Vous avez été deconnecter";
header('location: acceuil.php');