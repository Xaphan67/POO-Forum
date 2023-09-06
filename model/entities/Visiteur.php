<?php

namespace Model\Entities;

use App\Entity;

final class Visiteur extends Entity
{

        private $id;
        private $pseudoVisiteur;
        private $mdpVisiteur;
        private $dateInscriptionVisiteur;
        private $emailVisiteur;
        private $roleVisiteur;
        private $dateBanissementVisiteur;

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

        public function getPseudoVisiteur()
        {
                return $this->pseudoVisiteur;
        }

        public function setPseudoVisiteur($pseudoVisiteur)
        {
                $this->pseudoVisiteur = $pseudoVisiteur;
        }

        public function getMdpVisiteur()
        {
                return $this->mdpVisiteur;
        }

        public function setMdpVisiteur($mdpVisiteur)
        {
                $this->mdpVisiteur = $mdpVisiteur;
        }

        public function getDateInscriptionVisiteur()
        {
                if ($this->dateInscriptionVisiteur != null)
                {
                        $formattedDate = $this->dateInscriptionVisiteur->format("d/m/Y à H:i");
                        return $formattedDate;
                }
                return null;
        }

        public function setDateInscriptionVisiteur($dateInscriptionVisiteur)
        {
                $this->dateInscriptionVisiteur = new \DateTime($dateInscriptionVisiteur);
        }

        public function getEmailVisiteur()
        {
                return $this->emailVisiteur;
        }

        public function setEmailVisiteur($emailVisiteur)
        {
                $this->emailVisiteur = $emailVisiteur;
        }

        public function getRoleVisiteur()
        {
                $role = ($this->roleVisiteur == "ROLE_ADMIN" ? "Administrateur" : ($this->roleVisiteur == "ROLE_MODERATOR" ? "Modérateur" : "Membre"));
                return $role;
        }

        public function setRoleVisiteur($roleVisiteur)
        {
                $this->roleVisiteur = $roleVisiteur;
        }

        public function getDateBanissementVisiteur()
        {
                return $this->dateBanissementVisiteur = null ? null : $this->dateBanissementVisiteur;
        }

        public function setDateBanissementVisiteur($dateBanissementVisiteur)
        {
                $this->dateBanissementVisiteur = ($dateBanissementVisiteur == null ? null : new \DateTime($dateBanissementVisiteur));
        }

        public function __toString()
        {
                return $this->getPseudoVisiteur();
        }

        public function hasRole($role)
        {
                return $this->roleVisiteur == $role ? true : false;
        }

        public function isBanned()
        {
                $today = new \DateTime();
                return $this->getDateBanissementVisiteur() > $today;
        }
}
