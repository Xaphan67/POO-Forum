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

    // Retourne la liste de tout les messages d'un sujet avec leur id, texte, date de création, date de modification, id de l'auteur et id du sujet auxquel il sont ratachés
    public function getAllPostsFromTopic($id)
    {
        $sql = "SELECT m.id_message, m.texteMessage, m.dateCreationMessage, m.dateModificationMessage, m.visiteur_id, m.sujet_id
            FROM message m
            WHERE m.sujet_id = :id
            ORDER BY m.dateCreationMessage ASC";

        return $this->getMultipleResults(
            DAO::select($sql, ["id" => $id]),
            $this->className
        );
    }

    // Retourne la liste des 5 derniers messages d'un utilisateur
    public function getLastPostsFromVisitor($id)
    {
        $sql= "SELECT *
            FROM message m
            WHERE m.visiteur_id = :id
            ORDER BY m.dateCreationMessage DESC
            LIMIT 5";
        return $this->getMultipleResults(
            DAO::select($sql, ["id" => $id]),
            $this->className
        );
    }

    // Retourne le nombre de messages d'un utilisateur
    public function getTotalPostsFromVisitor($id)
    {
        $sql = "SELECT COUNT(*) AS nbPosts
            FROM message m
            WHERE m.visiteur_id = :id";

        return $this->getSingleScalarResult(
            DAO::select($sql, ["id" => $id]),
            $this->className
        );
    }

    // Modifie le texte d'un messsage
    public function edit($id, $text)
    {
        $sql = "UPDATE message m
            SET m.texteMessage = :text, m.dateModificationMessage = CURRENT_TIMESTAMP()
            WHERE m.id_message = :id";

        return $this->getOneOrNullResult(
            DAO::select($sql, ["text" => $text, "id" => $id]),
            $this->className
        );
    }
}
