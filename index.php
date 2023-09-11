<?php
    include('header.php');
    $manager = new Manager($db);
    ?>
<div class="d-flex">
    <?php
        $manager->displayDestination($manager->getAllDestination());
    ?>
</div>
<?php
    include('footer.php');
?>