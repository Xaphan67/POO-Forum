<?php

namespace Model\Managers;

use App\Manager;
use App\DAO;

class MessageManager extends Manager
{

    protected $className = "Model\Entities\Message";
    protected $tableName = "message";


    public function __construct()
    {
        parent::connect();
    }

    // Retourne la liste de tout les messages d'un sujet avec leur id, texte, date de création, id de l'auteur et id du sujet auxquel il sont ratachés
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
