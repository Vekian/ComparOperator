<?php
    include('header.php');
?>
<div>

<?php
    $manager = new Manager($db);
    if (isset($_GET['name'])){
        $name = $_GET['name'];
        $operators = $manager->getOperatorByDestination($name);
        $picture = $manager->getDestinationByOperator($operators[0], $name)->getPicture();
        echo('<img src="'. $picture .'" height="300px" id="destinationMainImg" class="mb-3"/>');
        foreach($operators as $operator){
            $destination = $manager->getDestinationByOperator($operator, $name);
            $manager->displayTourOperator($operator, $destination);
        }
    }
?>
<span class="fa fa-star checked"></span>
<span class="fa fa-star checked"></span>
<span class="fa fa-star checked"></span>
<span class="fa fa-star"></span>
<span class="fa fa-star"></span>
</div>
<?php
    include('footer.php');
?>