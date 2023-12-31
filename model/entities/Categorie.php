<?php

namespace Model\Entities;

use App\Entity;

final class Categorie extends Entity
{

        private $id;
        private $nomCategorie;
        private $descriptionCategorie;

        private $nbSujets;
        private $nbMessages;
        private $dateMessageRecent;
        private $idVisiteurRecent;
        private $pseudoVisiteurRecent;
        private $roleVisiteurRecent;

        public function __construct($data)
        {
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

        public function getDescriptionCategorie()
        {
                return $this->descriptionCategorie;
        }

        public function setDescriptionCategorie($descriptionCategorie)
        {
                $this->descriptionCategorie = $descriptionCategorie;
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
                if ($this->dateMessageRecent != null) {
                        $formattedDate = $this->dateMessageRecent->format("d/m/Y à H:i");
                        return $formattedDate;
                }
                return null;
        }

        public function setDateMessageRecent($dateMessageRecent)
        {
                if ($dateMessageRecent != null) {
                        $this->dateMessageRecent = new \DateTime($dateMessageRecent);
                }
        }

        public function getIdVisiteurRecent()
        {
                return $this->idVisiteurRecent;
        }

        public function setIdVisiteurRecent($idVisiteurRecent)
        {
                $this->idVisiteurRecent = $idVisiteurRecent;
        }

        public function getPseudoVisiteurRecent()
        {
                return $this->pseudoVisiteurRecent;
        }

        public function setPseudoVisiteurRecent($pseudoVisiteurRecent)
        {
                $this->pseudoVisiteurRecent = $pseudoVisiteurRecent;
        }

        public function getRoleVisiteurRecent()
        {
                return $this->roleVisiteurRecent;
        }

        public function setRoleVisiteurRecent($roleVisiteurRecent)
        {
                $this->roleVisiteurRecent = $roleVisiteurRecent;
        }

        public function __toString()
        {
                return $this->nomCategorie;
        }
}
