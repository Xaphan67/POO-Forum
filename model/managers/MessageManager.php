<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;
    // use Model\Managers\MessageManager;

    class MessageManager extends Manager{

        protected $className = "Model\Entities\Message";
        protected $tableName = "message";


        public function __construct(){
            parent::connect();
        }

        public function getAllPostsFromTopic($id)
        {
            $sql = "SELECT m.id_message, m.texteMessage, m.dateCreationMessage, m.visiteur_id, m.sujet_id
            FROM message m
            WHERE m.sujet_id = :id
            ORDER BY m.dateCreationMessage ASC";

            return $this->getMultipleResults(
                DAO::select($sql, ["id" => $id]),
                $this->className
            );
        }
    }