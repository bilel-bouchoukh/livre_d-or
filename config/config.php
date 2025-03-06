<?php 

session_start();

require '../classes/database.php';
require '../classes/livre.php';
require '../classes/user.php';

$database = new Database();
$livre = new Livre($database);

$user = (isset($_SESSION["id"])) ? new User(new Database(), $_SESSION['id']) : null;






?>