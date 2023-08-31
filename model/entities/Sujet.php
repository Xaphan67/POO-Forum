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
        private $dateMessageRecent;

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
        }

        public function getTitreSujet()
        {
                return $this->titreSujet;
        }

        public function setTitreSujet($titreSujet)
        {
                $this->titreSujet = $titreSujet;
        }

        public function getDateCreationSujet(){
            $formattedDate = $this->dateCreationSujet->format("d/m/Y, H:i:s");
            return $formattedDate;
        }

        public function setDateCreationSujet($dateSujet){
            $this->dateCreationSujet = new \DateTime($dateSujet);
        }

        public function getVerouilleSujet()
        {
                return $this->verouilleSujet;
        }

        public function setVerouilleSujet($verouilleSujet)
        {
                $this->verouilleSujet = $verouilleSujet;
        }

        public function getVisiteur()
        {
                return $this->visiteur;
        }

        public function setVisiteur($visiteur)
        {
                $this->visiteur = $visiteur;
        }

        public function getCategorie()
        {
                return $this->categorie;
        }

        public function setCategorie($categorie)
        {
                $this->categorie = $categorie;
        }

        public function getNbMessages()
        {
                return $this->nbMessages;
        }

        public function setNbMessages($nbMessages)
        {
                $this->nbMessages = $nbMessages;
        }

        public function getDateMessageRecent()
        {
                if ($this->dateMessageRecent != null)
                {
                        $formattedDate = $this->dateMessageRecent->format("d/m/Y, H:i:s");
                        return $formattedDate;
                }
                return null;
        }

        public function setDateMessageRecent($dateMessageRecent)
        {
                if ($dateMessageRecent != null)
                {
                        $this->dateMessageRecent = new \DateTime($dateMessageRecent);
                }
        }

        public function __toString()
        {
                return $this->titreSujet;
        }
    }