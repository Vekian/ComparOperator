<?php
    include('header.php');
    $manager = new Manager($db);
    ?>
<div class="d-flex flex-wrap justify-content-center">
    <?php
        $manager->displayDestination($manager->getAllDestination());
    ?>
</div>
<?php
    include('footer.php');
?>