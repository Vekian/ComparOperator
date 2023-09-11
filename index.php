<?php
    include('header.php');
    $manager = new Manager($db);
    ?>
<div class="d-flex">
    <?php
        $manager->displayDestination($manager->getAllDestination());
    ?>
</div>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>