<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;
    use Model\Managers\VisiteurManager;

    class VisiteurManager extends Manager{

        protected $className = "Model\Entities\Visiteur";
        protected $tableName = "visiteur";


        public function __construct(){
            parent::connect();
        }


    }