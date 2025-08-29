<?php
require_once('../config/autoload.php');
require_once('../config/db.php');

    $manager = new Manager($db);

// Testons si le fichier a bien été envoyé et s'il n'y a pas d'erreur
if (isset($_FILES['screenshot']) && $_FILES['screenshot']['error'] == 0)
{
    // Testons si le fichier n'est pas trop gros
    if ($_FILES['screenshot']['size'] <= 1000000)
    {
        // Testons si l'extension est autorisée
        $fileInfo = pathinfo($_FILES['screenshot']['name']);
        $extension = $fileInfo['extension'];
        $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];
        if (in_array($extension, $allowedExtensions))
        {
            // On peut valider le fichier et le stocker définitivement
            move_uploaded_file($_FILES['screenshot']['tmp_name'], '../public/images/' . basename($_FILES['screenshot']['name']));
                        echo "L'envoi a bien été effectué !";
            $picture = '../public/images/' . basename($_FILES['screenshot']['name']);
        }
        else
        {
            echo "Extension de fichier non autorisée. Les extensions autorisées sont : " . implode(', ', $allowedExtensions);
        }
    }
    else
    {
        echo "Le fichier est trop gros. La taille maximale autorisée est 1 Mo.";
    }
}
else
{
    echo "Une erreur est survenue lors de l'envoi du fichier.";
}

if (isset($_POST['add_destination'])) {
    // Récupérer les données du formulaire
    $location = $_POST['destination_location'];
    $price = $_POST['destination_price'];
    $tourOperatorId = $_POST['tour_operator_id'];

    // Valider et ajouter la destination à la base de données
    $manager->addDestination($location, $price, $picture, $tourOperatorId);

}
?>