<?php
require_once('config/autoload.php');
require_once('config/db.php');
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}
$manager = new Manager($db);
$destinations = $manager->filterDoubleDestination($manager->getAllDestination());
?>

<?php include("header.php"); ?>
<div class="d-flex bg-dark">
    <div class="col-12 col-sm-4 col-xl-2 px-sm-2 px-0 d-flex  bg-dark" id="menuSideNav">
        <div class="d-flex flex-sm-column flex-row flex-grow-1 align-items-center align-items-sm-start px-3 pt-2 text-white">
            <a href="/" class="d-flex align-items-center pb-sm-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <span class="fs-5">Panneau Admin</span></span>
            </a>
            <ul class="nav nav-pills flex-sm-column flex-row flex-nowrap flex-shrink-1 flex-sm-grow-0  mb-sm-auto mb-0 justify-content-center align-items-center align-items-sm-start" id="menu">
                <li class="nav-item">
                    <a href="index.php" class="nav-link px-sm-0 px-2">
                        <i class="fa-solid fa-house ms-2 ms-sm-0" style="color: #ffffff;"></i><span class="ms-1 d-none d-sm-inline text-light">Accueil</span>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" class="nav-link dropdown-toggle px-sm-0 px-1 text-light" id="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-headset ms-4 ms-sm-0" style="color: #ffffff;"></i><span class="ms-1 d-none d-sm-inline text-light">Tour Opérateur</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdown">
                        <li><a class="dropdown-item" href="#addTO">Ajouter un TO</a></li>
                        <li><a class="dropdown-item" href="#addDestinationTO">Ajouter une Destination à un TO</a></li>
                        <li><a class="dropdown-item" href="#addCertif">Ajouter premium à un TO</a></li>
                        <li><a class="dropdown-item" href="#modifTO">Modifier un TO</a></li>
                    </ul>
                </li>
                <li class="dropdown pt-sm-2 pb-sm-4 mt-sm-auto ms-auto ms-sm-0 flex-shrink-1">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-computer" style="color: #ffffff;"></i><span class="d-none d-sm-inline mx-1">Compte</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                        <li><a class="dropdown-item" href="process/logout.php">Log out</a></li>
                    </ul>
                </li>
            </ul>
            
        </div>
    </div>
    <div class="text-center col-12"> 
        <h1 class=" text-light pt-5 pb-3"><div class="pt-5"></div>
        <div class="pt-5"></div>Page d'Administration</h1>
    </div>
</div>
<!-- Formulaire pour ajouter un tour-opérateur -->



<div class="col-10 offset-1">
<section class="mt-5 mb-5" id="addTO">
    <form action="process/process-add-tour-operator.php" method="POST" class="d-flex flex-column align-items-center mt-5 mb-5">
        <h2>Ajouter un Tour-Opérateur</h2>
        <label for="tour_operator_name">Nom du Tour-Opérateur:</label>
        <input type="text" name="tour_operator_name" required class="m-2">
        <br>
        <label for="tour_operator_link">Lien vers le site officiel:</label>
        <input type="text" name="tour_operator_link" required class="m-2">
        <br>
        <button type="submit" class="mt-3">Ajouter Tour-Opérateur</button>
    </form>
</section>
    <!-- Formulaire pour ajouter une destination à un tour-opérateur -->
<section class="mt-5 mb-5" id="addDestinationTO">
    <form action="process/process-add-destination.php" method="POST" enctype="multipart/form-data" class="d-flex flex-column align-items-center mt-5 mb-5">
        <h2>Ajouter une Destination à un Tour-Opérateur</h2>
        <label for="destination_location">Location de la Destination:</label>
        <input type="text" name="destination_location" required class="m-2">
        <br>
        <label for="destination_price">Prix de la Destination:</label>
        <input type="number" name="destination_price" required class="m-2">
        <br>
        <label for="tour_operator_id">Sélectionnez un Tour-Opérateur:</label>
        <select name="tour_operator_id" required class="m-2">
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
        <input class="m-2" type="file" class="form-control" id="screenshot" name="screenshot" />
        <br>
        <button type="submit" class="mt-3">Ajouter Destination</button>
    </form>
</section>

<section class="mt-5 mb-5" id="addCertif">
    <form action="process/process-get-certificate.php" method="POST" class="d-flex flex-column align-items-center mt-5 mb-5">
        <h2>Ajouter un certificat premium à un Tour-Opérateur</h2>
        <label for="nameSignatory">Nom du signataire du contrat</label>
        <input type="text" name="name" id="nameSignatory"  class="m-2"/>
        <br>
        <label for="tour_operator_id">Sélectionnez un Tour-Opérateur:</label>
        <select name="tour_operator_id" required class="m-2">
            <?php
            foreach ($operators as $operator) {
                echo '<option value="' . $operator->getId() . '">' . $operator->getName() . '</option>';
            }
            ?>
        </select>
        <br>
        <label>Définir la date de validité</label>
        <input type="date" name="date" id="date"  class="m-2"/>
        <br>
        <button type="submit" class="mt-3">Envoyer</button>
    </form>
</section>

<section class="mt-5 mb-5" id="modifTO">
    <form action="process/process-modif-tour-operator.php" method="POST" class="d-flex flex-column align-items-center mt-5 mb-5">
        <h2>Modifier un Tour-Opérateur</h2>
        <select name="tour_operator_id" required class="m-2">
            <?php
            foreach ($operators as $operator) {
                echo '<option value="' . $operator->getId() . '">' . $operator->getName() . '</option>';
            }
            ?>
        </select>
        <br>
        <label for="nameTO">Nom du TO</label>
        <input type="text" name="name" id="nameTO"  class="m-2"/>
        <br>
        <label for="link">Lien du site du TO</label>
        <input type="text" name="link" id="link"  class="m-2"/>
        <button type="submit" class="mt-3">Envoyer</button>
    </form>
</section>

<section class="mt-5 mb-5" id="modifDestination">
    <form action="process/process-modif-destination.php" method="POST" class="d-flex flex-column align-items-center mt-5 mb-5">
        <h2>Modifier une destination</h2>
        <select name="destinationId" required class="m-2">
            <?php
            foreach ($destinations as $destination) {
                echo '<option value="' . $destination->getId() . '">' . $destination->getLocation() . '</option>';
            }
            ?>
        </select>
        <label for="nameDestination">Nom de la destination</label>
        <input type="text" name="name" id="nameDestination"  class="m-2"/>
        <br>
        <label for="destination_price">Prix de la Destination:</label>
        <input type="number" name="destination_price" required class="m-2">
        <label for="picture">Image de la destination</label>
        <input type="text" name="name" id="picture"  class="m-2"/>
        <select name="tour_operator_id" required class="m-2">
            <?php
            foreach ($operators as $operator) {
                echo '<option value="' . $operator->getId() . '">' . $operator->getName() . '</option>';
            }
            ?>
        </select>
    </form>
</section>

    <!-- Liens pour d'autres actions d'administration -->
    <div class="mt-5 pt-5"></div>
    <h2>Autres Actions d'Administration</h2>
    <ul>
        <li><a href="modifier-destination.php">Modifier une Destination</a></li>
        <!-- Ajoutez d'autres liens vers des pages d'administration ici -->
    </ul>
</div>
    <?php include("footer.php"); ?>