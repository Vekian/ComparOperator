<?php
require_once('config/autoload.php');
require_once('config/db.php');

$manager = new Manager($db);
?>

<?php include("header.php"); ?>

<h1>Modifier un Tour-Opérateur</h1>

<!-- Affichez la liste des tour-opérateurs -->
<ul>
<?php
            $operators = $manager->getAllTourOperators(); // Récupérer tous les tour-opérateurs depuis la base de données
            foreach ($operators as $operator) {
            }
            ?>
        <li>
            <?php echo $operator->getName(); ?>
            <!-- Ajoutez un bouton ou un lien pour sélectionner ce tour-opérateur -->
            <form action="process/process-modifier-tour-operator.php" method="POST">
                <input type="hidden" name="operator_id" value="<?php echo $operator->getId(); ?>">
                <input type="submit" value="Modifier">
            </form>
        </li>
</ul>

<!-- Affichez le formulaire de modification ici -->
<?php if (isset($_POST["operator_id"])) { ?>
    <h2>Modifier le Tour-Opérateur</h2>
    <form action="process/process-modifier-tour-operator.php" method="POST">
        <!-- Affichez les champs du formulaire avec les valeurs actuelles du tour-opérateur -->
        <input type="hidden" name="operator_id" value="<?php echo $_POST["operator_id"]; ?>">
        <label for="new_name">Nouveau nom:</label>
        <input type="text" name="new_name" value="<?php echo $operator->getName(); ?>">
        <br>
        <label for="new_link">Nouveau lien:</label>
        <input type="text" name="new_link" value="<?php echo $operator->getLink(); ?>">
        <br>
        <input type="submit" value="Enregistrer les modifications">
    </form>
<?php } ?>

<?php include("footer.php"); ?>
