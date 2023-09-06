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

    // Retourne la liste de tout les sujets d'une catégroie
    public function getAllTopicsFromCategory($id)
    {
        $sql = "SELECT s.id_sujet, s.titreSujet, s.dateCreationSujet,
                MAX(m.dateCreationMessage) AS dateMessageRecent, s.verouilleSujet,
                COUNT(m.id_message) AS nbMessages, s.visiteur_id,
                (SELECT v.id_Visiteur
                    FROM message m
                    INNER JOIN visiteur v ON v.id_visiteur = m.visiteur_id
                    WHERE m.sujet_id = s.id_sujet
                    ORDER BY m.id_message DESC LIMIT 1) AS idVisiteurRecent,
                (SELECT v.pseudoVisiteur
                    FROM message m
                    INNER JOIN visiteur v ON v.id_visiteur = m.visiteur_id
                    WHERE m.sujet_id = s.id_sujet
                    ORDER BY m.id_message DESC LIMIT 1) AS pseudoVisiteurRecent
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

    // Modifie le nom du sujet
    public function edit($id, $nom)
    {
        $sql = "UPDATE sujet s
            SET s.titreSujet = :nom
            WHERE s.id_sujet = :id";

        return $this->getOneOrNullResult(
            DAO::select($sql, ["nom" => $nom, "id" => $id]),
            $this->className
        );
    }

    // Verrouille un sujet
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

    // Déverrouille un sujet
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
