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

        public function getAllDestination($id = 0){
            if ($id == 0) {
                $query = $this->bdd->query('SELECT * FROM destination');
            }
            else {
                $query = $this->bdd->query('SELECT * FROM destination WHERE tour_operator_id = "'. $id .'"');
            }
            $locationsData = $query->fetchAll(PDO :: FETCH_ASSOC);
            $array = [];
            foreach($locationsData as $locationData) {
                $checked = false;
                foreach($array as $object){
                    if ($object->getLocation() === $locationData['location']) {
                        $checked = true;
                    }
                }
                if ($checked === false){
                    $destination = new Destination ($locationData);
                    array_push($array, $destination);
                }
            }
            return $array;
        }

        public function getAllReviews($id){
            $query = $this->bdd->query('SELECT * FROM review
                                        WHERE tour_operator_id = "'. $id .'"');
            $reviewsData = $query->fetchAll(PDO :: FETCH_ASSOC);
            $array = [];
            foreach($reviewsData as $reviewData) {
                $review = new Review($reviewData);
                array_push($array, $review);
            }
            return $array;
        }

        public function getScores($id){
            $query = $this->bdd->query('SELECT * FROM score
                                        JOIN author ON score.author_id = author.id
                                        WHERE tour_operator_id = "'. $id .'"');
            $scoresData = $query->fetchAll(PDO :: FETCH_ASSOC);
            $array = [];
            foreach($scoresData as $scoreData) {
                $score = new Score($scoreData);
                array_push($array, $score);
            }
            return $array;
        }

        public function getOperatorByDestination($name) {
            $query = $this->bdd->query('SELECT * FROM destination 
                                        JOIN tour_operator ON destination.tour_operator_id = tour_operator.id
            WHERE destination.location="'. $name .'"');
            $operatorsData = $query->fetchAll(PDO :: FETCH_ASSOC);
            $operators = [];
            foreach($operatorsData as $operatorData) {
                $id = $operatorData['tour_operator_id'];
                $destinations = $this->getAllDestination($id);
                $reviews = $this->getAllReviews($id);
                $scores = $this->getScores($id);
                $operator = new TourOperator($operatorData, $destinations, $reviews, $scores);
                array_push($operators, $operator);
            }
            return $operators;
        }

        public function displayDestination($data){
            foreach($data as $destination){
                echo('<div class="card" style="width: 18rem;">
                        <img src="'. $destination->getPicture() .'" class="card-img-top" alt="'. $destination->getLocation() .'" height="200px">
                        <div class="card-body">
                        <h5 class="card-title">Nom : '. $destination->getLocation() .'</h5>
                        <p class="card-text">À partir de '. $destination->getPrice() .' euros</p>
                        <a href="destination.php?name='. $destination->getLocation() .'" class="btn btn-primary">En savoir plus </a>
                        </div>
                    </div>');
            }
        }
    }

?>