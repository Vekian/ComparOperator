<?php
    require_once('config/autoload.php');
    require_once('config/db.php');

// Vérifier si l'utilisateur est authentifié en tant qu'administrateur (vous devez implémenter l'authentification)
$isAdmin = true; // Remplacez ceci par votre logique d'authentification

if (!$isAdmin) {
    // Rediriger les utilisateurs non autorisés vers une page d'authentification ou une page d'accueil
    header("Location: index.php");
    exit();
}

// Traitement de la soumission du formulaire pour ajouter un tour-opérateur
if (isset($_POST['add_tour_operator'])) {
    // Récupérer les données du formulaire
    $name = $_POST['tour_operator_name'];
    $link = $_POST['tour_operator_link'];

    // Valider et ajouter le tour-opérateur à la base de données (vous devez implémenter cette fonction)
    // Exemple : addTourOperator($name, $link);

    // Rediriger l'utilisateur après l'ajout
    header("Location: admin.php");
    exit();
}

// Traitement de la soumission du formulaire pour ajouter une destination à un tour-opérateur
if (isset($_POST['add_destination'])) {
    // Récupérer les données du formulaire
    $location = $_POST['destination_location'];
    $price = $_POST['destination_price'];
    $tourOperatorId = $_POST['tour_operator_id'];

    // Valider et ajouter la destination à la base de données (vous devez implémenter cette fonction)
    // Exemple : addDestination($location, $price, $tourOperatorId);

    // Rediriger l'utilisateur après l'ajout
    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Administration</title>
</head>
<body>
    <?php include("header.php"); ?>
    <h1>Page d'Administration</h1>

    <!-- Formulaire pour ajouter un tour-opérateur -->
    <h2>Ajouter un Tour-Opérateur</h2>
    <form action="admin.php" method="POST">
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
    <form action="admin.php" method="POST">
        <label for="destination_location">Location de la Destination:</label>
        <input type="text" name="destination_location" required>
        <br>
        <label for="destination_price">Prix de la Destination:</label>
        <input type="number" name="destination_price" required>
        <br>
        <label for="tour_operator_id">Sélectionnez un Tour-Opérateur:</label>
        <select name="tour_operator_id" required>
            <!-- Remplissez cette liste déroulante avec les noms des Tour-Opérateurs depuis la base de données -->
            <option value="1">Salaun Holidays</option>
            <option value="2">Fram</option>
            <!-- Ajoutez les autres options ici -->
        </select>
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
</body>
</html>
