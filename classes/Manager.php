<?php
    class Manager {
        private $bdd;
        /**
         * Get the value of bdd
         */
        public function getBdd()
        {
                return $this->bdd;
        }

        /**
         * Set the value of bdd
         */
        public function setBdd($bdd): self
        {
                $this->bdd = $bdd;

                return $this;
        }

        public function __construct($db){
            $this->setBdd($db);
        }

        public function getAllDestination(){
            $query = $this->bdd->query('SELECT * FROM destination');
            $locationsData = $query->fetchAll(PDO :: FETCH_ASSOC);
            $array = [];
            foreach($locationsData as $locationData) {
                $destination = new Destination ($locationData);
                array_push($array, $destination);
            }
            return $array;
        }

        public function getOperatorByDestination($destination) {
            $query = $this->bdd->query('SELECT * FROM destination');
            $operatorsData = $query->fetchAll(PDO :: FETCH_ASSOC);
        }

        public function displayDestination($data){
            foreach($data as $destination){
                echo('<div class="card" style="width: 18rem;">
                        <div class="card-body">
                        <h5 class="card-title">Nom : '. $destination->getLocation() .'</h5>
                        <p class="card-text">Prix : '. $destination->getPrice() .'</p>
                        <a href="destination.php?id='. $destination->getId() .'" class="btn btn-primary">En savoir plus </a>
                        </div>
                    </div>');
            }
        }
    }

?>