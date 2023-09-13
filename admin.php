<?php
    require_once('config/autoload.php');
    require_once('config/db.php');
    $manager = new Manager($db);
?>

<?php include("header.php"); ?>

<h1>Page d'Administration</h1>

<!-- Formulaire pour ajouter un tour-opérateur -->
<h2>Ajouter un Tour-Opérateur</h2>
<form action="process/process-add-tour-operator.php" method="POST">
    <label for="tour_operator_name">Nom du Tour-Opérateur:</label>
    <input type="text" name="tour_operator_name" required>
    <br>
    <label for="tour_operator_link">Lien vers le site officiel:</label>
    <input type="text" name="tour_operator_link" required>
    <br>
    <input type="submit" name="add_tour_operator" value="Ajouter Tour-Opérateur">
</form>

<!-- Formulaire pour ajouter une destination à un tour-opérateur -->
<h2>Ajouter une Destination à un Tour-Opérateur</h2>
<form action="process/process-add-destination.php" method="POST" enctype="multipart/form-data">
    <label for="destination_location">Location de la Destination:</label>
    <input type="text" name="destination_location" required>
    <br>
    <label for="destination_price">Prix de la Destination:</label>
    <input type="number" name="destination_price" required>
    <br>
    <label for="tour_operator_id">Sélectionnez un Tour-Opérateur:</label>
    <select name="tour_operator_id" required>
        <!-- liste déroulante avec les noms des Tour-Opérateurs depuis la base de données -->
        <?php   
        $operators = $manager->getAllTourOperators(); // Récupérer tous les tour-opérateurs depuis la base de données
        foreach ($operators as $operator) {
            echo '<option value="' . $operator->getId() . '">' . $operator->getName() . '</option>';
        }
        ?>
    </select>
    <br>
    <label for="screenshot" class="form-label">Votre capture d'écran</label>
    <input type="file" class="form-control" id="screenshot" name="screenshot" />
    <br>
    <input type="submit" name="add_destination" value="Ajouter Destination">
</form>

<!-- Liens pour d'autres actions d'administration -->
<h2>Autres Actions d'Administration</h2>
<ul>
    <li><a href="modifier_tour_operator.php">Modifier un Tour-Opérateur</a></li>
    <li><a href="modifier_destination.php">Modifier une Destination</a></li>
    <!-- Ajoutez d'autres liens vers des pages d'administration ici -->
</ul>
<?php include("footer.php"); ?>