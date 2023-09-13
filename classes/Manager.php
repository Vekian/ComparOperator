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
                                        JOIN author ON review.author_id = author.id
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
            WHERE destination.location="'. $name .'" ORDER BY price ASC');
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

        public function getDestinationByOperator($operator, $name){
            $destinations = $operator->getDestinations();
            foreach($destinations as $destination) {
                if ($destination->getLocation() === $name) {
                    return $destination;
                }
            }
        }

        public function getLowerPrice($destinations, $name){
            $price = 0;
            foreach($destinations as $destination) {
                if (($price === 0 && $name === $destination->getLocation()) || ($destination->getPrice() < $price && $name === $destination->getLocation())) {
                    $price = $destination->getPrice();
                }
            }
            return $price;
        }

        public function displayDestination($data){
            foreach($data as $destination){
                $price = $this->getLowerPrice($data, $destination->getLocation());
                echo('<div class="card" style="width: 18rem;">
                        <img src="'. $destination->getPicture() .'" class="card-img-top" alt="'. $destination->getLocation() .'" height="200px">
                        <div class="card-body">
                        <h5 class="card-title">Nom : '. $destination->getLocation() .'</h5>
                        <p class="card-text">À partir de '. $price .' euros</p>
                        <a href="destination.php?name='. $destination->getLocation() .'" class="btn btn-primary">En savoir plus </a>
                        </div>
                    </div>');
            }
        }

        public function displayTourOperator($operator, $destination){
            echo('<div class="d-flex justify-content-center flex-wrap">
                    <img src="'. $destination->getPicture() .'" height="300px" class="col-3">
                    <div class="col-3 d-flex flex-column align-items-center border text-center">
                        <h2 class="bg-light col-12">
                            '. $operator->getName() .'
                        </h2>
                        <p>
                            Destination: '. $destination->getLocation() .'
                        </p>
                        <p>
                            Prix: '. $destination->getPrice() .'
                        </p>
                        <p>
                            Avis moyen du TO : '. $operator->getAverageScore() .'
                        </p>
                        <button class="btn btn-primary">
                            Ecrire un avis
                        </button>
                    </div>
                    <div class="col-3 border text-center">
                        <h4 class="bg-light">
                            Avis
                        </h4>
                        
                        '. $this->displayReviews($this->getAllReviews($operator->getId())) .'
                    </div>
                </div>');
        }

        public function displayReviews($reviews) {
            $answer = '';
            foreach ($reviews as $review) {
            $answer .= '<div class="border m-3">
                    '. $review->getMessage() .'
            </div>
            <div>Par 
                '. $review->getAuthor() .'
            </div>';
            }
            return $answer;
        }

        public function addTourOperator($name, $link) {
            $query = $this->bdd->prepare('INSERT INTO tour_operator (name, link) VALUES (?, ?)');
            $query->bindValue(':name', $name);
            $query->bindValue(':link', $link);
            $query->execute([$name, $link]);
        }  
    
        public function addDestination($location, $price, $tourOperatorId) {
            $query = $this->bdd->prepare('INSERT INTO destination (location, price, tour_operator_id) VALUES (?, ?, ?)');
            $query->bindValue(':location', $location);
            $query->bindValue(':price', $price);
            $query->bindValue(':tour_operator_id', $tourOperatorId);
            $query->execute([$location, $price, $tourOperatorId]);
        }

        public function getAllTourOperators() {
            $query = $this->bdd->query('SELECT * FROM tour_operator');
            $operatorsData = $query->fetchAll(PDO::FETCH_ASSOC);
            $operators = [];
            foreach ($operatorsData as $operatorData) {
                $operator = new TourOperator($operatorData, [], [], []);
                array_push($operators, $operator);
            }
            return $operators;
        }
        
    }

?>