<?php
    include('header.php');
?>
<div class="text-center">

<?php
    $manager = new Manager($db);
    if (isset($_GET['name'])){
        $name = $_GET['name'];
        $operators = $manager->getOperatorByDestination($name);
        $picture = $manager->getDestinationByOperator($operators[0], $name)->getPicture();
        echo('<img src="'. $picture .'" height="300px"/>');
        foreach($operators as $operator){
            $destination = $manager->getDestinationByOperator($operator, $name);
            $manager->displayTourOperator($operator, $destination);
        }
    }
?>


</div>
<?php
    include('footer.php');
?>