<?php

namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\SujetManager;
use Model\Managers\MessageManager;

class SujetController extends AbstractController implements ControllerInterface
{

    // Fonction par defaut, si l'action n'a pas été trouvée
    public function index()
    {
        return [
            "view" => VIEW_DIR . "home.php",
        ];
    }

    // Affiche les messages d'un sujet
    public function viewTopic($topicId)
    {
        $topicManager = new SujetManager();
        $postManager = new MessageManager();

        return [
            "view" => VIEW_DIR . "forum/viewTopic.php",
            "meta" => "Les messages du sujet " . $topicManager->findOneById($topicId)->getTitreSujet(),
            "data" => [
                "topic" => $topicManager->findOneById($topicId), // Informations du sujet
                "posts" => $postManager->getAllPostsFromTopic($topicId), // liste des messages du sujet
                "firstId" => $topicManager->getFirstPostId($topicId) // Id du premier message du sujet
            ]
        ];
    }

    // Traite les informations et ajoute un nouveau sujet via le formulaire
    public function newTopic($categoryId)
    {
        $topicManager = new SujetManager();
        $postManager = new MessageManager();

        if (Session::getUser()) {
            if (isset($_POST['submit']) && isset($_POST["nom"]) && !empty($_POST['nom']) && isset($_POST["message"]) && !empty($_POST['message'])) { // Vérifie qu'un formulaire à été soumis et que les champs existent et ne son pas vides
                $nom = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_SPECIAL_CHARS);
                $message = filter_input(INPUT_POST, "message", FILTER_SANITIZE_SPECIAL_CHARS);
                if ($nom && $message) {
                    $userId = Session::getUser()->getId(); // Récupère l'ID du visiteur actuellement connecté
                    $newTopicId = $topicManager->add(['titreSujet' => $nom, 'visiteur_id' => $userId, 'categorie_id' => $categoryId]); // Ajoute les informations du formulaire pour le sujet en BDD, retourne l'id du sujet ajouté
                    $postManager->add(['texteMessage' => $message, 'visiteur_id' => $userId, 'sujet_id' => $newTopicId]); // Ajoute les informations du formulaire pour le 1er message du sujet    
                    Session::addFlash("success", "Sujet créé !");
                    $this->redirectTo("sujet", "viewTopic", $newTopicId); // Redicection vers la vue du sujet
                }
            }
            Session::addFlash("error", "Le " . (!$nom ? "nom du sujet" : "message") . " est invalide !");
        }

        $this->redirectTo("categorie", "listTopics", $categoryId); // Redicection vers la liste des sujets de la catégorie
    }

    // Traite les informations et modifie le sujet via le formulaire
    public function editTopic($topicId)
    {
        $topicManager = new SujetManager();
        $postManager = new MessageManager();

        if (Session::getUser() && (Session::getUser()->getId() == $topicManager->findOneById($topicId)->getVisiteur()->getId() || Session::isAdmin())) // Vérifie que le visiteur est connecté et qu'il est l'auteur du message
        {
            $firstPostId = $topicManager->getFirstPostId($topicId)["id_message"];
            if (isset($_POST['edit']) && isset($_POST["name" . $topicId]) && isset($_POST["msg" . $firstPostId]) && !empty($_POST["name" . $topicId]) && !empty($_POST["msg" . $firstPostId])) { // Vérifie qu'un formulaire à été soumis et que les champs existent et ne son pas vides
                $title = filter_input(INPUT_POST, "name" . $topicId, FILTER_SANITIZE_SPECIAL_CHARS);
                $message = filter_input(INPUT_POST, "msg" . $firstPostId, FILTER_SANITIZE_SPECIAL_CHARS);
                if ($title && $message) {
                    $topicManager->edit($topicId, $title); // Modifie le nom du sujet
                    $postManager->edit($firstPostId, $message); // modifie le 1er message du sujet
                    Session::addFlash("success", "Sujet modifié !");
                    $this->redirectTo("sujet", "viewTopic", $topicId); // Redicection vers la vue du sujet
                }
                switch (true) {
                    case !$title:
                        Session::addFlash("error", "Le titre est invalide !");
                        break;
                    case !$message:
                        Session::addFlash("error", "Le message est invalide !");
                        break;
                }
            }
        }

        $this->redirectTo("sujet", "viewTopic", $topicId); // Redicection vers la vue du sujet
    }

    // Verrouille un sujet
    public function lockTopic($topicId)
    {
        $topicManager = new SujetManager();

        if (Session::getUser() && (Session::getUser()->getId() == $topicManager->findOneById($topicId)->getVisiteur()->getId() || Session::isAdmin())) // Vérifie que le visiteur est connecté et qu'il est l'auteur du message
        {
            $topicManager->lockTopic($topicId); // Appelle la méthode du manager qui verrouille le sujet en BDD
            Session::addFlash("success", "Sujet verrouillé !");
        }

        $this->redirectTo("sujet", "viewTopic", $topicId); // Redirection vers la vue su sujet
    }

    // Déverrouile un sujet
    public function unlockTopic($topicId)
    {
        $topicManager = new SujetManager();

        if (Session::getUser() && (Session::getUser()->getId() == $topicManager->findOneById($topicId)->getVisiteur()->getId() || Session::isAdmin())) // Vérifie que le visiteur est connecté et qu'il est l'auteur du message
        {
            $topicManager->unlockTopic($topicId); // Appelle la méthode du manager qui déverrouille le sujet en BDD
            Session::addFlash("success", "Sujet déverrouillé !");
        }

        $this->redirectTo("sujet", "viewTopic", $topicId); // Redirection vers la vue su sujet
    }

    // Supprime un sujet
    public function deleteTopic($topicId)
    {
        $topicManager = new SujetManager();
        $topic = $topicManager->findOneById(($topicId)); // Récupère les informations correspondantes au sujet
        $categoryId = $topic->getCategorie()->getId(); // Récupère l'id de la catégoriue du sujet

        if (Session::getUser() && (Session::getUser()->getId() == $topicManager->findOneById($topicId)->getVisiteur()->getId() || Session::isAdmin())) // Vérifie que le visiteur est connecté et qu'il est l'auteur du message
        {
            $topicManager->delete($topicId); // Appelle la méthode du manager qui supprime le sujet en BDD
            Session::addFlash("success", "Sujet supprimé !");
        }

        $this->redirectTo("categorie", "listTopics", $categoryId); // Redirection vers la catégorie qui contenait le sujet
    }
}
