<?php
require_once('../config/autoload.php');
require_once('../config/db.php');
if (isset($_POST['pseudo'])){
    $manager = new Manager($db);
    $name = ucfirst($_POST['pseudo']);
    $score = $_POST['score'];
    $nameDestination = $_POST['nameDestination'];
    $tourOperatorId = $_POST['tourOperatorId'];
    $message = $_POST['message'];
    $manager->addReview($name, $score, $tourOperatorId, $message);
}
header('Location:../destination.php?name='. $nameDestination);