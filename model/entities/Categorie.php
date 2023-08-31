<?php
    namespace Model\Entities;

    use App\Entity;

    final class Categorie extends Entity{

        private $id;
        private $nomCategorie;

        private $nbSujets;
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

        public function getNomCategorie()
        {
                return $this->nomCategorie;
        }

        public function setNomCategorie($nomCategorie)
        {
                $this->nomCategorie = $nomCategorie;
        }

        public function getNbSujets()
        {
                return $this->nbSujets;
        }

        public function setNbSujets($nbSujets)
        {
                $this->nbSujets = $nbSujets;
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
                return $this->nomCategorie;
        }
    }