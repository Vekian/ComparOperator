<?php

require_once('../config/autoload.php');
require_once('../config/db.php');
if (isset($_POST['name'])){
    $manager = new Manager($db);
    $id = $_POST['destinationId'];
    $name = ucfirst($_POST['name']);
    $price = $_POST['destination_price'];
    $picture = ucfirst($_POST['picture']);
    $idTO = $_POST['tour_operator_id'];
    $manager->updateDestination($id, $name, $price, $picture, $idTO);
}
header('Location:../admin.php');