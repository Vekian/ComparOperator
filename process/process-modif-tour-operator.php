<?php

require_once('../config/autoload.php');
require_once('../config/db.php');
if (isset($_POST['name'])){
    $manager = new Manager($db);
    $id = $_POST['tour_operator_id'];
    $name = ucfirst($_POST['name']);
    $link = $_POST['link'];
    $manager->updateTO($id, $name, $link);
}
header('Location:../admin.php');