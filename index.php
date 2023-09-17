<?php
    include('header.php');
    $manager = new Manager($db);
    ?>
<div id="imgIndex" class="d-flex justify-content-center align-items-center pt-5">
    <form action="index.php" method="POST" class="d-flex col-xxl-6 col-lg-8 col-11 mt-5 flex-wrap">
        <div class="d-flex flex-column col-lg-4 col-6">
            <label for="destinationSearch" class="text-light">Destination ?</label>
            <input type="text" name="destination" id="destinationSearch" class="p-2" placeholder="ex: Rome" />
        </div>
        <div class="d-flex flex-column col-lg-4 col-6">
            <label for="price" class="text-light">Prix maximum</label>
            <input type="number" name="price" id="price" class="p-2" min="0" value="0" />
        </div>
        <button type="submit" class="mt-4 col-lg-4 col-sm-8 offset-sm-2 offset-lg-0 col-12"> Rechercher</button>
    </form>
</div>
<div class="d-flex flex-wrap justify-content-center" id="listDestinations">
    <?php
        $manager->displayDestination($manager->getAllDestination());
    ?>
</div>

<?php
    include('footer.php');
?>