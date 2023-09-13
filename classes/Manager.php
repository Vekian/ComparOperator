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
                $destination = new Destination ($locationData);
                array_push($array, $destination);
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

        public function getOperatorByDestination($name ="none") {
            if ($name != "none") {
                $queryContent = 'SELECT * FROM destination 
                JOIN tour_operator ON destination.tour_operator_id = tour_operator.id
                WHERE destination.location="'. $name .'" ORDER BY price ASC';
            }
            else {
                $queryContent = 'SELECT * FROM tour_operator ORDER BY name ASC';
            }
            $query = $this->bdd->query($queryContent);
            $operatorsData = $query->fetchAll(PDO :: FETCH_ASSOC);
            $operators = [];
            foreach($operatorsData as $operatorData) {
                $id = $operatorData['tour_operator_id'];
                $destinations = $this->getAllDestination($id);
                $reviews = $this->getAllReviews($id);
                $scores = $this->getScores($id);
                $certificate = $this->getCertificate($id);
                $operator = new TourOperator($operatorData, $destinations, $reviews, $scores, $certificate);
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

        public function getCertificate($tourOperatorId){
            $query = $this->bdd->query('SELECT * FROM certificate WHERE tour_operator_id = "' . $tourOperatorId . '"');
            $certificateData = $query->fetch(PDO :: FETCH_ASSOC);
            if ($certificateData !== false) {
                $certificate = new Certificate($certificateData);
                return $certificate;
            }
            else return ("none");
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

        public function getIdOfUser($name){
            $query = $this->bdd->query('SELECT * FROM author WHERE name = "' . $name . '"');
            $user = $query->fetch(PDO :: FETCH_ASSOC);
            return $user['id'];
        }

        public function filterDoubleDestination($array) {
            $checked = false;
            $arrayAnswer = [];
            foreach($array as $object){
                foreach($arrayAnswer as $objectAnswer){
                    if($objectAnswer->getLocation() === $object->getLocation()) {
                        $checked = true;
                    }
                }
                if ($checked === false){
                    array_push($arrayAnswer, $object);
                }
                $checked = false;
            }
            return $arrayAnswer;
        }

        public function checkUser($name) {
            $query = $this->bdd->query('SELECT * FROM author');
            $usersData = $query->fetchAll(PDO :: FETCH_ASSOC);
            foreach($usersData as $user){
                if ($user['name'] === $name) {
                    return true;
                }
            }
            return false;
        }

        public function addMessage($message, $tourOperatorId, $author_id){
            $query = $this->bdd->prepare('INSERT INTO review (message, tour_operator_id, author_id) VALUES (:message, :tour_operator_id, :author_id)');
            $query->bindValue(':message', $message);
            $query->bindValue(':tour_operator_id', $tourOperatorId);
            $query->bindValue(':author_id', $author_id);
            $query->execute();
        }

        public function addUser($name){
            $q = $this->bdd->prepare('INSERT INTO author (name) VALUES (:name)');
            $q->bindValue(':name', $name);
            $q->execute();

            return intval($this->bdd->lastInsertId());
        }

        public function addReview($name, $score, $tourOperatorId, $message){
            $answered = false;
            if (!($this->checkUser($name))){
                $id = $this->addUser($name);
            }
            else {
                $query = $this->bdd->query('SELECT * FROM author 
                                    JOIN review ON author.id = review.author_id
                                    WHERE name = "'. $name . '"');
                $reviews = $query->fetchAll(PDO :: FETCH_ASSOC);
                if (count($reviews) > 0) {
                    $id = $reviews[0]['author_id'];
                }
                else {
                    $id = $this->getIdOfUser($name);
                }
                foreach($reviews as $review){
                    if($review['tour_operator_id'] == $tourOperatorId) {
                        $answered = true;
                    }
                }
            };
            if ($answered === false) {
                $this->addScore($score, $tourOperatorId, $id);
                if (strlen($message) > 0){
                    $this->addMessage($message, $tourOperatorId, $id);
                }
            }
        }
        public function addScore($score, $tourOperatorId, $author_id){
            $query = $this->bdd->prepare('INSERT INTO score (value, tour_operator_id, author_id) VALUES (:value, :tour_operator_id, :author_id)');
            $query->bindValue(':value', $score);
            $query->bindValue(':tour_operator_id', $tourOperatorId);
            $query->bindValue(':author_id', $author_id);
            $query->execute();
        }

        public function addCertificate($id, $name, $date){
            $query = $this->bdd->prepare('INSERT INTO certificate (tour_operator_id, expires_at, signatory) VALUES (:tour_operator_id, :expires_at, :signatory)');
            $query->bindValue(':tour_operator_id', $id);
            $query->bindValue(':expires_at', $date);
            $query->bindValue(':signatory', $name);
            $query->execute();
        }
        public function updateCertificate($id, $name, $date){
            $query = $this->bdd->prepare('UPDATE certificate SET expires_at = :expires_at, signatory = :signatory WHERE tour_operator_id = ' . $id);
            $query->bindValue(':expires_at', $date);
            $query->bindValue(':signatory', $name);
            $query->execute();
        }

        public function displayDestination($data){
            $array= $this->filterDoubleDestination($data);
            foreach($array as $destination){
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
                        </p>');
            if ($operator->isPremium()) {
                echo('<a href="#" class="btn btn-primary">Allez sur le site du TO</a>');
            }
                        echo('<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal'. $operator->getId() .'">
                            Ajouter un avis
                        </button>
                    </div>
                    <div class="col-3 border text-center">
                        <h4 class="bg-light">
                            Avis
                        </h4>
                        
                        '. $this->displayReviews($this->getAllReviews($operator->getId())) .'
                    </div>
                </div>

              <div class="modal fade" id="exampleModal'. $operator->getId() .'" tabindex="-1" aria-labelledby="exampleModalLabel'. $operator->getId() .'" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel'. $operator->getId() .'">Ajouter un avis sur '. $operator->getName() .'</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="process/add-review.php" method="POST">
                            <label for="pseudo">Votre pseudo</label>
                            <input type="text" name="pseudo" id="pseudo" required /><br />
                            <label for="score">Votre note</label>
                            <input type="number" class="mt-3 mb-3" name="score" id="score" min="0" max="5" required /><br />
                            <label for="message">Tapez votre message ici</label>
                            <input type="text" name="message" id="message" />
                            <input type="hidden" name="nameDestination" value="'. $destination->getLocation() .'" />
                            <input type="hidden" name="tourOperatorId" value="'. $operator->getId() .'"/>
                            <input type="submit" class="mt-3" value="Envoyer" />
                        </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                  </div>
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
            $operators = $this->getOperatorByDestination($name ="none");
            return $operators;
        }
    }

?>