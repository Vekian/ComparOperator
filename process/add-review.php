<?php
require_once('../config/autoload.php');
require_once('../config/db.php');
if (isset($_POST['pseudo'])){
    $manager = new Manager($db);
    $name = ucfirst($_POST['pseudo']);
    $nameDestination = $_POST['nameDestination'];
    $tourOperatorId = $_POST['tourOperatorId'];
    $message = $_POST['message'];
    $manager->addReview($name, $tourOperatorId, $message);
}
header('Location:../destination.php?name='. $nameDestination);