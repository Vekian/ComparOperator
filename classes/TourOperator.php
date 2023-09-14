<?php 

class TourOperator {
    private int $id;
    private string $name;
    private string $link;
    private $certificate;
    private $destinations;
    private $reviews;
    private $scores;

    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of link
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * Set the value of link
     */
    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get the value of certificate
     */
    public function getCertificate()
    {
        return $this->certificate;
    }

    /**
     * Set the value of certificate
     */
    public function setCertificate($certificate): self
    {
        $this->certificate = $certificate;

        return $this;
    }

    /**
     * Get the value of destinations
     */
    public function getDestinations()
    {
        return $this->destinations;
    }

    /**
     * Set the value of destinations
     */
    public function setDestinations($destinations): self
    {
        $this->destinations = $destinations;

        return $this;
    }

    /**
     * Get the value of reviews
     */
    public function getReviews()
    {
        return $this->reviews;
    }

    /**
     * Set the value of reviews
     */
    public function setReviews($reviews): self
    {
        $this->reviews = $reviews;

        return $this;
    }

    /**
     * Get the value of scores
     */
    public function getScores()
    {
        return $this->scores;
    }

    /**
     * Set the value of scores
     */
    public function setScores($scores): self
    {
        $this->scores = $scores;

        return $this;
    }

    public function __construct($data, $destinations, $reviews, $scores, $certificate) {
        $this->hydrate($data, $destinations, $reviews, $scores, $certificate);
    }

    public function hydrate($data, $destinations, $reviews, $scores, $certificate){
        $this->setId($data['id']);
        $this->setName($data['name']);
        $this->setLink($data['link']);
        $this->setDestinations($destinations);
        $this->setReviews($reviews);
        $this->setScores($scores);
        $this->setCertificate($certificate);
    }

    public function getAverageScore(){
        $answer = 0;
        foreach($this->scores as $score) {
            $answer += $score->getValue();
        }
        if(count($this->scores) > 0) {
            return $answer/count($this->scores);
        }
        else return ('Aucune note');
    }
    public function getDateLocale(){
        $locale = 'fr_FR'; // Définissez la locale de votre choix
        $dateTime = new DateTime('now', new DateTimeZone('UTC')); // Créez un objet DateTime avec l'heure UTC
        $dateFormatter = new IntlDateFormatter($locale, IntlDateFormatter::FULL, IntlDateFormatter::FULL);
        $dateFormatter->setPattern('yyyy-MM-dd HH:mm:ss');
        $dateLocale = $dateFormatter->format($dateTime);
        return $dateLocale;
    }
    public function isPremium() {
        if ($this->getCertificate($this->getId()) != "none") {
            $dateExpire= $this->getCertificate($this->getId())->getExpiresAt();
            $dateLocale = $this->getDateLocale();
            if ($dateExpire > $dateLocale){
                return true;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }
}



?>