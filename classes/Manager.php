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
    }

?>