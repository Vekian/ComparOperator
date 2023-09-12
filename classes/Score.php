<?php
    class Score {
        private int $id;
        private int $value;
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
         * Get the value of value
         */
        public function getValue(): int
        {
                return $this->value;
        }

        /**
         * Set the value of value
         */
        public function setValue(int $value): self
        {
                $this->value = $value;

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

        public function __construct($data) {
                $this->hydrate($data);
        }

        public function hydrate($data) {
                $this->setId($data['id']);
                $this->setValue($data['value']);
                $this->setAuthor($data['name']);
        }
    }


?>