<?php
    include('header.php');
    $manager = new Manager($db);
    ?>
<div id="imgIndex" class="d-flex justify-content-center align-items-center mt-5">
    <form action="index.php" method="POST" class="d-flex col-6 mt-5">
        <div class="d-flex flex-column col-4">
            <label for="destinationSearch" class="text-light">Destination ?</label>
            <input type="text" name="destination" id="destinationSearch" class="p-2" placeholder="ex: Rome" />
        </div>
        <div class="d-flex flex-column col-4">
            <label for="price" class="text-light">Prix maximum</label>
            <input type="number" name="price" id="price" class="p-2" min="0" value="0" />
        </div>
        <button type="submit" class="mt-4 col-4"> Rechercher</button>
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