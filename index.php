<?php
    include('header.php');
    $manager = new Manager($db);
    ?>
<div class="d-flex flex-wrap justify-content-center">
    <?php
        $manager->displayDestination($manager->getAllDestination());
        var_dump($manager->getAllTourOperators());
    ?>
</div>
<?php
    include('footer.php');
?>