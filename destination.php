<?php
    include('header.php');
    $manager = new Manager($db);
    if (isset($_GET['name'])){
        $name = $_GET['name'];
        $operators = $manager->getOperatorByDestination($name);
        foreach($operators as $operator){
            $destination = $manager->getDestinationByOperator($operator, $name);
            $manager->displayTourOperator($operator, $destination);
        }
    }
?>