<?php

namespace Model\Managers;

use App\Manager;
use App\DAO;

class SujetManager extends Manager
{

    protected $className = "Model\Entities\Sujet";
    protected $tableName = "sujet";


    public function __construct()
    {
        parent::connect();
    }

    public function getAllTopicsFromCategory($id)
    {
        $sql = "SELECT s.id_sujet, s.titreSujet, s.dateCreationSujet, s.verouilleSujet, COUNT(m.id_message) AS nbMessages, s.visiteur_id
                FROM sujet s
                LEFT JOIN message m ON m.sujet_id = s.id_sujet
                WHERE s.categorie_id = :id
                GROUP BY s.id_sujet
                ORDER BY s.dateCreationSujet DESC";

        return $this->getMultipleResults(
            DAO::select($sql, ["id" => $id]),
            $this->className
        );
    }

    public function lockTopic($id)
    {
        $sql = "UPDATE sujet s
            SET s.verouilleSujet = 1
            WHERE s.id_sujet = :id";

        return $this->getOneOrNullResult(
            DAO::select($sql, ["id" => $id]),
            $this->className
        );
    }

    public function unlockTopic($id)
    {
        $sql = "UPDATE sujet s
            SET s.verouilleSujet = 0
            WHERE s.id_sujet = :id";

        return $this->getOneOrNullResult(
            DAO::select($sql, ["id" => $id]),
            $this->className
        );
    }
}
