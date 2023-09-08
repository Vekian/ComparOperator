<?php
    class Certificate {
        private $certificateAt;
        private $signatory;

        /**
         * Get the value of certificateAt
         */
        public function getCertificateAt()
        {
                return $this->certificateAt;
        }

        /**
         * Set the value of certificateAt
         */
        public function setCertificateAt($certificateAt): self
        {
                $this->certificateAt = $certificateAt;

                return $this;
        }

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
    }


?>