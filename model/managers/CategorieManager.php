<?php

namespace Model\Managers;

use App\Manager;
use App\DAO;

class CategorieManager extends Manager
{

    protected $className = "Model\Entities\Categorie";
    protected $tableName = "categorie";


    public function __construct()
    {
        parent::connect();
    }

    // Retourne la liste de toutes les catégories du forum avec leur id, nom, nombre de sujets et nombre de messages
    public function getAllCategories()
    {
        $sql = "SELECT
            c.id_categorie,
            c.id_categorie AS idCategorie,
            c.nomCategorie,
            c.descriptionCategorie,
            (SELECT COUNT(*)
                FROM sujet s
                INNER JOIN categorie c ON c.id_categorie = s.categorie_id
                WHERE s.categorie_id = idCategorie) AS nbSujets,
            (SELECT COUNT(*)
                FROM sujet s
                INNER JOIN message m ON m.sujet_id = s.id_sujet
                WHERE s.categorie_id = idCategorie) AS nbMessages,
            (SELECT m.visiteur_id
                FROM message m
                INNER JOIN visiteur v ON v.id_visiteur = m.visiteur_id
                INNER JOIN sujet s ON s.id_sujet = m.sujet_id
                INNER JOIN categorie c ON c.id_categorie = s.categorie_id
                WHERE c.id_categorie = idCategorie
                ORDER BY v.id_visiteur DESC LIMIT 1) AS idVisiteurRecent,
            (SELECT v.pseudoVisiteur
                FROM message m
                INNER JOIN visiteur v ON v.id_visiteur = m.visiteur_id
                INNER JOIN sujet s ON s.id_sujet = m.sujet_id
                INNER JOIN categorie c ON c.id_categorie = s.categorie_id
                WHERE c.id_categorie = idCategorie
                ORDER BY v.id_visiteur DESC LIMIT 1) AS pseudoVisiteurRecent,
            MAX(m.dateCreationMessage) AS dateMessageRecent
            FROM sujet s
            RIGHT JOIN categorie c ON c.id_categorie = s.categorie_id
            LEFT JOIN message m ON m.sujet_id = s.id_sujet
            GROUP BY c.id_categorie";

        return $this->getMultipleResults(
            DAO::select($sql),
            $this->className
        );
    }

    // Modifie le nom de la catégorie
    public function edit($id, $nom)
    {
        $sql = "UPDATE categorie c
            SET c.nomCategorie = :nom
            WHERE c.id_categorie = :id";

        return $this->getOneOrNullResult(
            DAO::select($sql, ["nom" => $nom, "id" => $id]),
            $this->className
        );
    }

    //
    public function editDesc($id, $description)
    {
        $sql = "UPDATE categorie c
            SET c.descriptionCategorie = :description
            WHERE c.id_categorie = :id";

        return $this->getOneOrNullResult(
            DAO::select($sql, ["description" => $description, "id" => $id]),
            $this->className
        );
    }
}
