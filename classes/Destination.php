<?php
class Destination {
    private int $id;
    private string $location;
    private int $price;
    private string $picture;
    

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
     * Get the value of location
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * Set the value of location
     */
    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get the value of price
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * Set the value of price
     */
    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of picture
     */
    public function getPicture(): string
    {
        return $this->picture;
    }

    /**
     * Set the value of picture
     */
    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function __construct(array $data) {
        $this->hydrate($data);
    }

    public function hydrate(array $data) {
        $this->setId($data['id']);
        $this->setLocation($data['location']);
        $this->setPrice($data['price']);
        $this->setPicture($data['picture']);
    }
}

?>