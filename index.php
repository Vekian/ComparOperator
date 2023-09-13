<?php
    include('header.php');
    $manager = new Manager($db);
    ?>
<div id="imgIndex">

</div>
<div class="d-flex flex-wrap justify-content-center">
    <?php
        $manager->displayDestination($manager->getAllDestination());
    ?>
</div>
<?php
    include('footer.php');
?>