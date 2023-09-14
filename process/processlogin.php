<?php
require_once('../config/autoload.php');
require_once('../config/db.php');
$manager = new Manager($db);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    if ($username === "yvan" && $password === "vivan") {
        $_SESSION["username"] = $username;
        header("Location: ../admin.php");
        exit;
    } else {
        echo "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>