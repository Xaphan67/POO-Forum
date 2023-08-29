<?php
    namespace Model\Entities;

    use App\Entity;

    final class Sujet extends Entity{

        private $id;
        private $titreSujet;
        private $dateCreationSujet;
        private $verouilleSujet;
        private $visiteur;
        private $categorie;

        private $nbMessages;

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

        public function getTitreSujet()
        {
                return $this->titreSujet;
        }

        public function setTitreSujet($titreSujet)
        {
                $this->titreSujet = $titreSujet;

                return $this;
        }

        public function getDateCreationSujet(){
            $formattedDate = $this->dateCreationSujet->format("d/m/Y, H:i:s");
            return $formattedDate;
        }

        public function setDateCreationSujet($dateSujet){
            $this->dateCreationSujet = new \DateTime($dateSujet);
            return $this;
        }

        public function getVerouilleSujet()
        {
                return $this->verouilleSujet;
        }

        public function setVerouilleSujet($verouilleSujet)
        {
                $this->verouilleSujet = $verouilleSujet;

                return $this;
        }

        public function getVisiteur()
        {
                return $this->visiteur;
        }

        public function setVisiteur($visiteur)
        {
                $this->visiteur = $visiteur;

                return $this;
        }

        public function getCategorie()
        {
                return $this->categorie;
        }

        public function setCategorie($categorie)
        {
                $this->categorie = $categorie;

                return $this;
        }

        public function getNbMessages()
        {
                return $this->nbMessages;
        }

        public function setNbMessages($nbMessages)
        {
                $this->nbMessages = $nbMessages;

                return $this;
        }

        public function __toString()
        {
                return $this->titreSujet;
        }
    }