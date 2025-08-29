<?php

$dbUser = getenv("MYSQL_USER");
$dbPass = getenv("MYSQL_PASSWORD");
$dbName = getenv("MYSQL_DATABASE");
try {
    $db = new PDO("mysql:host=mysql_voyage;dbname=$dbName;charset=utf8", $dbUser, $dbPass);
} catch (Exception $e) {
    die('Erreur : ' .$e->getMessage());
}
