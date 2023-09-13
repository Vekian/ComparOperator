<?php
require_once('../config/autoload.php');
require_once('../config/db.php');
$manager = new Manager($db);

if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $tourOperatorId = intval($_POST['tour_operator_id']);
    $date = $_POST['date'];
    if($manager->getCertificate($tourOperatorId) === "none") {
        $manager->addCertificate($tourOperatorId, $name, $date);
    }
    else {
        $manager->updateCertificate($tourOperatorId, $name, $date);
    };
}
header('Location:../admin.php');