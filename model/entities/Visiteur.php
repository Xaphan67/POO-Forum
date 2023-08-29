<?php
    namespace Model\Entities;

    use App\Entity;

    final class Visiteur extends Entity{

        private $id;
        private $pseudoVisiteur;
        private $mdpVisiteur;
        private $dateInscriptionVisiteur;
        private $emailVisiteur;
        private $roleVisiteur;

        public function __construct($data){         
            $this->hydrate($data);        
        }
 
        public function getId()
        {
                return $this->id;
        }

        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

        public function getPseudoVisiteur()
        {
                return $this->pseudoVisiteur;
        }

        public function setPseudoVisiteur($pseudoVisiteur)
        {
                $this->pseudoVisiteur = $pseudoVisiteur;

                return $this;
        }

        public function getMdpVisiteur()
        {
                return $this->mdpVisiteur;
        }

        public function setMdpVisiteur($mdpVisiteur)
        {
                $this->mdpVisiteur = $mdpVisiteur;

                return $this;
        }

        public function getDateInscriptionVisiteur(){
            $formattedDate = $this->dateInscriptionVisiteur->format("d/m/Y, H:i:s");
            return $formattedDate;
        }

        public function setDateInscriptionVisiteur($dateInscriptionVisiteur){
            $this->dateInscriptionVisiteur = new \DateTime($dateInscriptionVisiteur);
            return $this;
        }

        public function getEmailVisiteur()
        {
                return $this->emailVisiteur;
        }

        public function setEmailVisiteur($emailVisiteur)
        {
                $this->emailVisiteur = $emailVisiteur;

                return $this;
        }

        public function getRoleVisiteur()
        {
                return $this->roleVisiteur;
        }

        public function setRoleVisiteur($roleVisiteur)
        {
                $this->roleVisiteur = $roleVisiteur;

                return $this;
        }

        public function __toString(){
                return $this->getPseudoVisiteur();
        }
    }