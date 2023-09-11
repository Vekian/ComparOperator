<?php
class Review {
    private int $id;
    private string $message;
    private string $author;
    

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
     * Get the value of message
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Set the value of message
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get the value of author
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * Set the value of author
     */
    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function __construct($data){
        $this->hydrate($data);
    }

    public function hydrate($data){
        $this->setId($data['id']);
        $this->setMessage($data['message']);
        $this->setAuthor($data['name']);
    }
}

?>