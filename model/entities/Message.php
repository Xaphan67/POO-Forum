<?php
    namespace Model\Entities;

    use App\Entity;

    final class Message extends Entity{

        private $id;
        private $texteMessage;
        private $dateCreationMessage;
        private $visiteur;
        private $sujet;

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

        public function getTexteMessage()
        {
                return $this->texteMessage;
        }

        public function setTexteMessage($texteMessage)
        {
                $this->texteMessage = $texteMessage;

                return $this;
        }

        public function getDateCreationMessage(){
            $formattedDate = $this->dateCreationMessage->format("d/m/Y, H:i:s");
            return $formattedDate;
        }

        public function setDateCreationMessage($dateMessage){
            $this->dateCreationSujet = new \DateTime($dateMessage);
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

        public function getSujet()
        {
                return $this->sujet;
        }

        public function setSujet($sujet)
        {
                $this->sujet = $sujet;

                return $this;
        }
    }