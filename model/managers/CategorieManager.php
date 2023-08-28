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
            $sql = "SELECT c.nomCategorie, COUNT(s.id_sujet) AS nbSujets, COUNT(m.id_message) AS nbMessages
                FROM sujet s
                LEFT JOIN categorie c ON c.id_categorie = s.categorie_id
                LEFT JOIN message m ON m.id_message = s.categorie_id
                GROUP BY c.id_categorie";

            return $this->getMultipleResults(
                DAO::select($sql),
                $this->className
            );
        }
    }