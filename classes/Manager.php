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
        public function getScore($name){
            $query = $this->bdd->query('SELECT value FROM score
                                        JOIN author ON score.author_id = author.id
                                        WHERE name = "'. $name .'"');
            $scoreData = $query->fetch(PDO :: FETCH_ASSOC);
            if($scoreData == false) {
                $score = [];
                $score['value'] = "Aucune note";
                return $score;
            }
            return $scoreData;
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
        public function updateTO($id, $name, $link) {
            $query = $this->bdd->prepare('UPDATE tour_operator SET name = :name, link = :link WHERE id = ' . $id);
            $query->bindValue(':name', $name);
            $query->bindValue(':link', $link);
            $query->execute();
        }
        public function updateDestination($id, $name, $price, $tourOperatorId){
            $query = $this->bdd->prepare('UPDATE destination SET location = :location, price = :price, tour_operator_id = :tour_operator_id WHERE id = ' . $id);
            $query->bindValue(':name', $name);
            $query->bindValue(':link', $link);
            $query->bindValue(':tour_operator_id', $tourOperatorId);
            $query->execute();
        }

        public function displayDestination($data){
            $array= $this->filterDoubleDestination($data);
            foreach($array as $destination){
                $price = $this->getLowerPrice($data, $destination->getLocation());
                echo('<div class="cardDestination col-xxl-3 col-lg-4 col-sm-6 col-12">
                        <div class="card" style="background-image: url(\''. $destination->getPicture() .'\');">
                            <div class="card-category p-1">À partir de '. $price .' euros</div>
                            <div class="card-description p-2 d-flex">
                                <p class="ms-2">'. $destination->getLocation() .'</p>
                                <p class="ms-auto knowMore"> En savoir plus ></p>
                            </div>
                            <a class="card-link" href="destination.php?name='. $destination->getLocation() .'" ></a>
                        </div>
                    </div>');
            }
        }

        public function displayScore($score){
            $answer = "";
            if ($score == "Aucune note") {
                $answer .= "Aucune note";
            } else{
            for ($i = 0; $i < 5; $i++){
                if (round($score) > $i){
                    $answer .= '<span class="fa fa-star checked"></span>';
                }
                else {
                    $answer .= '<span class="fa fa-star"></span>';
                }
            }}
            return $answer;
        }

        public function displayTourOperator($operator, $destination){
            echo('<div class="d-flex justify-content-center flex-wrap mb-5">
                    <div class="col-lg-5 col-xl-4 col-12 d-flex flex-column  border" id="infosTO">
                        <h2 class="text-warning col-12 text-center"  id="titleComments">
                            Récapitulatif de l\'offre
                        </h2>
                        <p class="mt-4 ps-3 border-bottom">
                            <span class="text-warning"> Destination: </span> '. $destination->getLocation() .'
                        </p>
                        <p class=" ps-3">
                            <span class="text-warning"> Tour Opérateur: </span> '. $operator->getName() .'
                        </p>
                        <p class=" ps-3">
                            <span class="text-warning"> Prix:</span> '. $destination->getPrice() .'
                        </p>
                        <p class=" ps-3">
                            <span class="text-warning"> Avis moyen du TO :</span> '. $this->displayScore($operator->getAverageScore()) .'
                        </p>
                        <div class="d-flex justify-content-center">');
            if ($operator->isPremium()) {
                echo('<button class="mb-2" onclick="window.location.href = \''. $operator->getLink() .'\';">Allez sur le site du TO</button>');
            }
                        echo('<button class="mb-2 ms-3" data-bs-toggle="modal" data-bs-target="#exampleModal'. $operator->getId() .'">
                            Ajouter un avis
                        </button>
                        </div>
                    </div>
                    <div class="col-lg-5 col-xl-4 col-12 border" id="sectionComments">
                        <h2 class="text-warning text-center" id="titleComments">
                            Avis
                        </h2>
                        
                        <div class="d-flex flex-column align-items-center" id="listComments">'. $this->displayReviews($this->getAllReviews($operator->getId())) .'</div>
                    </div>
                </div>

              <div class="modal fade" id="exampleModal'. $operator->getId() .'" tabindex="-1" aria-labelledby="exampleModalLabel'. $operator->getId() .'" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <form id="algin-form" action="process/add-review.php" method="POST">
                        <div class="form-group">
                            <h4>Laissez un avis</h4>
                            <label for="pseudo">Name</label>
                            <input type="text" name="pseudo" id="pseudo" class="form-control" required>
                        </div>
                        <p class="mb-0 mt-3 text-warning me-auto">Votre note</p>
                        <div class="rating d-flex flex-row-reverse justify-content-center">
                            <input type="radio" id="star5" name="score" value="5" />
                            <label class="star" for="star5" title="Awesome" aria-hidden="true"></label>
                            <input type="radio" id="star4" name="score" value="4" />
                            <label class="star" for="star4" title="Great" aria-hidden="true"></label>
                            <input type="radio" id="star3" name="score" value="3" />
                            <label class="star" for="star3" title="Very good" aria-hidden="true"></label>
                            <input type="radio" id="star2" name="score" value="2" />
                            <label class="star" for="star2" title="Good" aria-hidden="true"></label>
                            <input type="radio" id="star1" name="score" value="1" />
                            <label class="star" for="star1" title="Bad" aria-hidden="true"></label>
                        </div>
                        <div class="form-group">
                        <br /><label for="message">Message (optionnel)</label>
                            <textarea name="message" id=""message cols="30" rows="5" class="form-control"></textarea>
                        </div>
                        <div class="form-group text-center">
                            <input type="hidden" name="nameDestination" value="'. $destination->getLocation() .'" />
                            <input type="hidden" name="tourOperatorId" value="'. $operator->getId() .'"/>
                            <button class="mt-3" type="submit" id="post">Envoyer</button>
                        </div>
                    </form>
                  </div>
                </div>
              </div>');
        }

        public function displayReviews($reviews) {
            $answer = '';
            foreach ($reviews as $review) {
            $answer .= '<div class="mt-2 mb-2 text-light col-10  text-center">
            <div class="d-flex">
                <div class="col-4 bg-light p-1 ps-2 text-warning" id="authorComments">Par 
                    '. $review->getAuthor() .' : 
                </div>
                <div class="ms-auto text-dark mt-1">
                '. $this->displayScore($this->getScore($review->getAuthor())['value']) .'
                </div>
            </div>
            <div class=" text-center p-2 col-12" id="comments">
                    '. $review->getMessage() .'
            </div></div>
            ';
            }
            return $answer;
        }

        public function addTourOperator($name, $link) {
            $query = $this->bdd->prepare('INSERT INTO tour_operator (name, link) VALUES (?, ?)');
            $query->bindValue(':name', $name);
            $query->bindValue(':link', $link);
            $query->execute([$name, $link]);
        }  
    
        public function addDestination($location, $price,  $picture, $tourOperatorId) {
            $query = $this->bdd->prepare('INSERT INTO destination (location, price, picture, tour_operator_id) VALUES (?, ?, ?, ?)');
            $query->bindValue(':location', $location);
            $query->bindValue(':price', $price);
            $query->bindValue(':picture', $picture);
            $query->bindValue(':tour_operator_id', $tourOperatorId);
            $query->execute([$location, $price, $picture, $tourOperatorId]);
        }

        public function getAllTourOperators() {
            $operators = $this->getOperatorByDestination($name ="none");
            return $operators;
        }
    }

?>