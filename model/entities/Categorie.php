<?php
    namespace Model\Entities;

    use App\Entity;

    final class Categorie extends Entity{

        private $id;
        private $nomCategorie;

        private $nbSujets;
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

        public function getNomCategorie()
        {
                return $this->nomCategorie;
        }

        public function setNomCategorie($nomCategorie)
        {
                $this->nomCategorie = $nomCategorie;

                return $this;
        }

        public function getNbSujets()
        {
                return $this->nbSujets;
        }

        public function setNbSujets($nbSujets)
        {
                $this->nbSujets = $nbSujets;

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
            return $this->nomCategorie;
        }
    }