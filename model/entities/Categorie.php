<?php
    namespace Model\Entities;

    use App\Entity;

    final class Categorie extends Entity{

        private $id;
        private $nomCategorie;

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
    }