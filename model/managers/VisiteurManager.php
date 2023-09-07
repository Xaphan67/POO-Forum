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

    // Modifie le pseudo d'un visiteur
    public function editPseudo($id, $pseudo)
    {
        $sql = "UPDATE visiteur v
            SET v.pseudoVisiteur = :pseudo
            WHERE v.id_visiteur = :id";

        return $this->getOneOrNullResult(
            DAO::select($sql, ["pseudo" => $pseudo, "id" => $id]),
            $this->className
        );
    }

    // Modifie l'email d'un visiteur
    public function editEmail($id, $email)
    {
        $sql = "UPDATE visiteur v
            SET v.emailVisiteur = :email
            WHERE v.id_visiteur = :id";

        return $this->getOneOrNullResult(
            DAO::select($sql, ["email" => $email, "id" => $id]),
            $this->className
        );
    }

    // Modifie le mot de passe d'un visiteur
    public function editMdp($id, $mdp)
    {
        $sql = "UPDATE visiteur v
            SET v.mdpVisiteur = :mdp
            WHERE v.id_visiteur = :id";

        return $this->getOneOrNullResult(
            DAO::select($sql, ["mdp" => $mdp, "id" => $id]),
            $this->className
        );
    }

    // Modifie l'avatar d'un visiteur
    public function editAvatar($id, $avatar)
    {
        $sql = "UPDATE visiteur v
            SET v.avatarVisiteur = :avatar
            WHERE v.id_visiteur = :id";

        return $this->getOneOrNullResult(
            DAO::select($sql, ["avatar" => $avatar, "id" => $id]),
            $this->className
        );
    }

    // Modifie le rôle d'un visiteur
    public function editRole($id, $role)
    {
        $sql = "UPDATE visiteur v
            SET v.roleVisiteur = :role
            WHERE v.id_visiteur = :id";

        return $this->getOneOrNullResult(
            DAO::select($sql, ["role" => $role, "id" => $id]),
            $this->className
        );
    }

    // Supprime (anonymise) un utilisateur
    public function delete ($id)
    {
        $mdp = uniqid();

        $sql = "UPDATE visiteur v
            SET v.pseudoVisiteur = 'Utilisateur supprimé', mdpVisiteur = :mdp, dateInscriptionvisiteur = '1900-01-01 00:00:00', emailVisiteur = 'deleted@no-mail.com', roleVisiteur = 'ROLE_DELETED', avatarVisiteur = 'avatar.png'
            WHERE v.id_visiteur = :id";

        return $this->getOneOrNullResult(
            DAO::select($sql, ["mdp" => $mdp, "id" => $id]),
            $this->className
        );
    }

    // Bannis le visiteur
    public function ban ($id, $date)
    {
        $sql = "UPDATE visiteur v
            SET v.dateBanissementVisiteur = :date
            WHERE v.id_visiteur = :id";

        return $this->getOneOrNullResult(
            DAO::select($sql, ["date" => $date, "id" => $id]),
            $this->className
        );
    }

    // Débannis le visiteur
    public function unban($id)
    {
        $sql = "UPDATE visiteur v
            SET v.dateBanissementVisiteur = NULL
            WHERE v.id_visiteur = :id";

        return $this->getOneOrNullResult(
            DAO::select($sql, ["id" => $id]),
            $this->className
        );
    }
}
