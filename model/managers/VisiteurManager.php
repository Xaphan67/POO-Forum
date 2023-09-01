<?php

namespace Model\Managers;

use App\Manager;
use App\DAO;

class VisiteurManager extends Manager
{

    protected $className = "Model\Entities\Visiteur";
    protected $tableName = "visiteur";


    public function __construct()
    {
        parent::connect();
    }

    // Retourne un visiteur par son e-mail
    public function findOneByEmail($email)
    {
        $sql = "SELECT *
            FROM visiteur v
            WHERE v.emailVisiteur = :email";

        return $this->getOneOrNullResult(
            DAO::select($sql, ["email" => $email], false),
            $this->className
        );
    }

    // Retourne un visiteur par son pseudo
    public function findOneByPseudo($pseudo)
    {
        $sql = "SELECT *
            FROM visiteur v
            WHERE v.pseudoVisiteur = :pseudo";

        return $this->getOneOrNullResult(
            DAO::select($sql, ["pseudo" => $pseudo], false),
            $this->className
        );
    }

    // Retourne le hash du mdp d'un visiteur -> Renvoie un tableau "mdpVisiteur => hash du mdp du visiteur"
    public function getPasswordHash($email)
    {
        $sql = "SELECT v.mdpVisiteur
        FROM visiteur v
        WHERE v.emailVisiteur = :email";

        return $this->getSingleScalarResult(
            DAO::select($sql, ["email" => $email])
        );
    }

    // Modifie le rôle du sujet
    public function edit($id, $role)
    {
        $sql = "UPDATE visiteur v
            SET v.roleVisiteur = :role
            WHERE v.id_visiteur = :id";

        return $this->getOneOrNullResult(
            DAO::select($sql, ["role" => $role, "id" => $id]),
            $this->className
        );
    }
}
