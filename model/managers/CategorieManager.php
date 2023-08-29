<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;
    use Model\Managers\CategorieManager;

    class CategorieManager extends Manager{

        protected $className = "Model\Entities\Categorie";
        protected $tableName = "categorie";


        public function __construct(){
            parent::connect();
        }

        public function getAllCategories()
        {
            $sql = "SELECT
            c.id_categorie,
            c.id_categorie AS idCategorie,
            c.nomCategorie,
            (SELECT COUNT(*)
                FROM sujet s
                INNER JOIN categorie c ON c.id_categorie = s.categorie_id
                WHERE s.categorie_id = idCategorie) AS nbSujets,
            (SELECT COUNT(*)
                FROM sujet s
                INNER JOIN message m ON m.sujet_id = s.id_sujet
                WHERE s.categorie_id = idCategorie) AS nbMessages
            FROM sujet s
            RIGHT JOIN categorie c ON c.id_categorie = s.categorie_id
            GROUP BY c.id_categorie";

            return $this->getMultipleResults(
                DAO::select($sql),
                $this->className
            );
        }
    }