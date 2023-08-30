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

    // Fonction par defaut, si l'action n'a pas été trouvée
    public function index()
    {
        return [
            "view" => VIEW_DIR . "home.php",
        ];
    }

    // Affiche la liste des catégories du forum
    public function listCategories()
    {
        $categoryManager = new CategorieManager();

        return [
            "view" => VIEW_DIR . "forum/listCategories.php",
            "data" => [
                "categories" => $categoryManager->getAllCategories() // Informations relatives aux catégories (Noms, nombre sujets et réponses etc...)
            ]
        ];
    }

    // Affiche la liste des sujets d'une catégrie du forum
    public function listTopics($categoryId)
    {
        $categoryManager = new CategorieManager();
        $topicManager = new SujetManager();

        return [
            "view" => VIEW_DIR . "forum/listTopics.php",
            "data" => [
                "category" => $categoryManager->findOneById($categoryId), // Informations sur la catégorie
                "topics" => $topicManager->getAllTopicsFromCategory($categoryId) // Liste des sujets de la catégorie
            ]
        ];
    }

    // Affiche les messages d'un sujet
    public function viewTopic($topicId)
    {
        $topicManager = new SujetManager();
        $postManager = new MessageManager();

        return [
            "view" => VIEW_DIR . "forum/viewTopic.php",
            "data" => [
                "topic" => $topicManager->findOneById($topicId), // Informations du sujet
                "posts" => $postManager->getAllPostsFromTopic($topicId) // liste des messages du sujet
            ]
        ];
    }

    // Traite les informations et ajoute un noveau message à un sujet via le forumaire
    public function submitPost($topicId)
    {
        $postManager = new MessageManager();

        if (isset($_POST['submit'])) { // Vérifie qu'un formulaire à été soumis
            if (isset($_POST["reponse"]) && !empty($_POST['reponse'])) { // Vérifie que les champs du formulaires existent et ne sont pas vides
                /* filtres ici */
                $postManager->add(['texteMessage' => $_POST["reponse"], 'visiteur_id' => 1, 'sujet_id' => $topicId]); // Ajoute les informations du formulaire en BDD
            }
        }

        $this->redirectTo("forum", "viewTopic", $topicId); // Redirection vers la vue du sujet
    }

    // Traite les informations et ajoute un nouveau sujet via le formulaire
    public function newTopic($categoryId)
    {
        $topicManager = new SujetManager();
        $postManager = new MessageManager();

        if (isset($_POST['submit'])) { // Vérifie qu'un formulaire à été soumis
            if (isset($_POST["nom"]) && !empty($_POST['nom']) && isset($_POST["message"]) && !empty($_POST['message'])) { // Vérifie que les champs du formulaires existent et ne sont pas vides
                /* filtres ici */
                $newTopicId = $topicManager->add(['titreSujet' => $_POST["nom"], 'visiteur_id' => 1, 'categorie_id' => $categoryId]); // Ajoute les informations du formulaire pour le sujet en BDD, retourne l'id du sujet ajouté
                $postManager->add(['texteMessage' => $_POST["message"], 'visiteur_id' => 1, 'sujet_id' => $newTopicId]); // Ajoute les informations du formulaire pour le 1er message du sujet
            }
        }

        $this->redirectTo("forum", "viewTopic", $newTopicId); // Redicection vers la vue du sujet
    }

    // Verrouille un sujet
    public function lockTopic($topicId)
    {
        $topicManager = new SujetManager();

        $topicManager->lockTopic($topicId); // Appelle la méthode du manager qui verrouille le sujet en BDD

        $this->redirectTo("forum", "viewTopic", $topicId); // Redirection vers la vue su sujet
    }

    // Déverrouile un sujet
    public function unlockTopic($topicId)
    {
        $topicManager = new SujetManager();

        $topicManager->unlockTopic($topicId); // Appelle la méthode du manager qui déverrouille le sujet en BDD

        $this->redirectTo("forum", "viewTopic", $topicId); // Redirection vers la vue su sujet
    }

    // Supprime un sujet
    public function deleteTopic($topicId)
    {
        $topicManager = new SujetManager();

        $topic = $topicManager->findOneById(($topicId)); // Récupère les informations correspondantes au sujet
        $categoryId = $topic->getCategorie()->getId(); // Récupère l'id de la catégoriue du sujet
        $topicManager->deleteTopic($topicId); // Appelle la méthode du manager qui supprime le sujet en BDD

        $this->redirectTo("forum", "listTopics", $categoryId); // Redirection vers la catégorie qui contenait le sujet
    }
}
