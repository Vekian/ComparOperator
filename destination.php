<?php
    include('header.php');
    $manager = new Manager($db);
    if (isset($_GET['name'])){
        $name = $_GET['name'];
        $operators = $manager->getOperatorByDestination($name);
    }
?>
<div class="d-flex justify-content-center">
    <img src="images/londres.jpg" height="300px" >
    <div class="d-flex flex-column align-items-center">
        <h2>
            Londres
        </h2>
    </div>
</div>