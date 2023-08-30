<?php

namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use model\Managers\CategorieManager;
use Model\Managers\SujetManager;
use Model\Managers\MessageManager;

class ForumController extends AbstractController implements ControllerInterface
{

    public function index()
    {
        $topicManager = new SujetManager();

        return [
            "view" => VIEW_DIR . "forum/listTopics.php",
            "data" => [
                "topics" => $topicManager->findAll(["dateCreationSujet", "DESC"])
            ]
        ];
    }

    public function listCategories()
    {
        $categoryManager = new CategorieManager();

        return [
            "view" => VIEW_DIR . "forum/listCategories.php",
            "data" => [
                "categories" => $categoryManager->getAllCategories()
            ]
        ];
    }

    public function listTopics($categoryId)
    {
        $categoryManager = new CategorieManager();
        $topicManager = new SujetManager();

        return [
            "view" => VIEW_DIR . "forum/listTopics.php",
            "data" => [
                "category" => $categoryManager->findOneById($categoryId),
                "topics" => $topicManager->getAllTopicsFromCategory($categoryId)
            ]
        ];
    }

    public function viewTopic($topicId)
    {
        $topicManager = new SujetManager();
        $postManager = new MessageManager();

        return [
            "view" => VIEW_DIR . "forum/viewTopic.php",
            "data" => [
                "topic" => $topicManager->findOneById($topicId),
                "posts" => $postManager->getAllPostsFromTopic($topicId)
            ]
        ];
    }

    public function submitPost($topicId)
    {
        $postManager = new MessageManager();

        if (isset($_POST['submit'])) {
            if (isset($_POST["reponse"]) && !empty($_POST['reponse'])) {
                /* filtres ici */
                $postManager->add(['texteMessage' => $_POST["reponse"], 'visiteur_id' => 1, 'sujet_id' => $topicId]);
            }
        }

        $this->redirectTo("forum", "viewTopic", $topicId);
    }

    public function newTopic($categoryId)
    {
        $topicManager = new SujetManager();
        $postManager = new MessageManager();

        if (isset($_POST['submit'])) {
            if (isset($_POST["nom"]) && !empty($_POST['nom']) && isset($_POST["message"]) && !empty($_POST['message'])) {
                /* filtres ici */
                $newTopicId = $topicManager->add(['titreSujet' => $_POST["nom"], 'visiteur_id' => 1, 'categorie_id' => $categoryId]);
                $postManager->add(['texteMessage' => $_POST["message"], 'visiteur_id' => 1, 'sujet_id' => $newTopicId]);
            }
        }

        $this->redirectTo("forum", "viewTopic", $newTopicId);
    }

    public function lockTopic($topicId)
    {
        $topicManager = new SujetManager();

        $topicManager->lockTopic($topicId);

        $this->redirectTo("forum", "viewTopic", $topicId);
    }

    public function unlockTopic($topicId)
    {
        $topicManager = new SujetManager();

        $topicManager->unlockTopic($topicId);

        $this->redirectTo("forum", "viewTopic", $topicId);
    }
}
