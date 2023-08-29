<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use model\Managers\CategorieManager;
    use Model\Managers\SujetManager;
    use Model\Managers\MessageManager;
    
    class ForumController extends AbstractController implements ControllerInterface{

        public function index() {
           $topicManager = new SujetManager();

            return [
                "view" => VIEW_DIR."forum/listTopics.php",
                "data" => [
                    "topics" => $topicManager->findAll(["dateCreationSujet", "DESC"])
                ]
            ];
        }

        public function listCategories() {
            $categoryManager = new CategorieManager();

            return [
                "view" => VIEW_DIR."forum/listCategories.php",
                "data" => [
                    "categories" => $categoryManager->getAllCategories()
                ]
            ];
        }

        public function listTopics($categoryId) {
            $categoryManager = new CategorieManager();
            $topicManager = new SujetManager();

            return [
                "view" => VIEW_DIR."forum/listTopics.php",
                "data" => [
                    "category" => $categoryManager->findOneById($categoryId),
                    "topics" => $topicManager->getAllTopicsFromCategory($categoryId)
                ]
            ];
        }
    }
