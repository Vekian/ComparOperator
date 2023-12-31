<?php
    class Certificate {
        private $expiresAt;
        private $signatory;


        /**
         * Get the value of signatory
         */
        public function getSignatory()
        {
                return $this->signatory;
        }

        /**
         * Set the value of signatory
         */
        public function setSignatory($signatory): self
        {
                $this->signatory = $signatory;

                return $this;
        }

        /**
         * Get the value of expiresAt
         */
        public function getExpiresAt()
        {
                return $this->expiresAt;
        }

        /**
         * Set the value of expiresAt
         */
        public function setExpiresAt($expiresAt): self
        {
                $this->expiresAt = $expiresAt;

                return $this;
        }
        public function __construct($data){
                $this->hydrate($data);
        }

        public function hydrate($data){
                $this->setExpiresAt($data['expires_at']);
                $this->setSignatory($data['signatory']);
        }
    }


?>