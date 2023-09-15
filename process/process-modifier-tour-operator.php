<?php
    require_once('config/autoload.php');
    require_once('config/db.php');
    $manager = new Manager($db);

    // Récupérez la liste des tour-opérateurs depuis la base de données
    $operators = $manager->getAllTourOperators();

    // Traitez la soumission du formulaire de modification ici
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Récupérez les données soumises depuis le formulaire
        $operatorId = $_POST["operator_id"];
        $newName = $_POST["new_name"];
        $newLink = $_POST["new_link"];

        // Mettez à jour les informations du tour-opérateur dans la base de données
        $manager->addTourOperator($name, $link);
        // Affichez un message de succès ou d'erreur
        // Redirigez ou affichez le formulaire à nouveau si nécessaire
    }
?>
