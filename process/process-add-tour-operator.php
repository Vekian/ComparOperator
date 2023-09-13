<?php
require_once('../config/autoload.php');
require_once('../config/db.php');

    // Instance du gestionnaire (Manager)
    $manager = new Manager($db);

    // Traitement de la soumission du formulaire pour ajouter un tour-opérateur
    if (isset($_POST['add_tour_operator'])) {
        // Récupérer les données du formulaire
        $name = $_POST['tour_operator_name'];
        $link = $_POST['tour_operator_link'];

        // Valider et ajouter le tour-opérateur à la base de données
        $manager->addTourOperator($name, $link);

    }

    if (isset($_POST['add_destination'])) {
        // Récupérer les données du formulaire
        $location = $_POST['destination_location'];
        $price = $_POST['destination_price'];
        $tourOperatorId = $_POST['tour_operator_id'];
    
        // Valider et ajouter la destination à la base de données
        $manager->addDestination($location, $price, $tourOperatorId);
    
        // Rediriger l'utilisateur après l'ajout
        header("Location: admin.php");
        exit();
    }