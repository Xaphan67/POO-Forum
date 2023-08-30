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

    // Vérifie si l'email éxiste déja en BDD -> Renvoie un tableau "emailCheck => 0 ou 1"
    public function checkIfEmailExist($email)
    {
        $sql = "SELECT COUNT(1) AS emailCheck
            FROM $this->tableName v
            WHERE v.emailVisiteur = :email";

        return $this->getSingleScalarResult(
            DAO::select($sql, ["email" => $email])
        );
    }

    // Vérifie si le pseudo éxiste déja en BDD -> Renvoie un tableau "pseudoCheck => 0 ou 1"
    public function checkIfPseudoExist($pseudo)
    {
        $sql = "SELECT COUNT(1) AS pseudoCheck
            FROM $this->tableName v
            WHERE v.pseudoVisiteur = :pseudo";

        return $this->getSingleScalarResult(
            DAO::select($sql, ["pseudo" => $pseudo])
        );
    }
}
