<?php

namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\MessageManager;
use Model\Managers\SujetManager;

class MessageController extends AbstractController implements ControllerInterface
{

    // Fonction par defaut, si l'action n'a pas été trouvée
    public function index()
    {
        return [
            "view" => VIEW_DIR . "home.php",
            "meta" => "Les catgégories de FORUM PHP"
        ];
    }

    // Traite les informations et ajoute un nouveau message à un sujet via le formulaire
    public function submitPost($topicId)
    {
        $postManager = new MessageManager();

        if (Session::getUser()) // Vérifie que le visiteur est connecté
        {
            if (isset($_POST['submit']) && isset($_POST["reponse"]) && !empty($_POST['reponse'])) { // Vérifie qu'un formulaire à été soumis et que les champs existent et ne son pas vides
                $reponse = filter_input(INPUT_POST, "reponse", FILTER_SANITIZE_SPECIAL_CHARS);
                if ($reponse) {
                    $userId = Session::getUser()->getId(); // Récupère l'ID du visiteur actuellement connecté
                    $postManager->add(['texteMessage' => $reponse, 'visiteur_id' => $userId, 'sujet_id' => $topicId]); // Ajoute les informations du formulaire en BDD
                    Session::addFlash("success", "Message ajouté !");
                    $this->redirectTo("sujet", "viewTopic", $topicId); // Redirection vers la vue du sujet
                }
            }
            Session::addFlash("error", "Le message est invalide !");
        }

        $this->redirectTo("sujet", "viewTopic", $topicId); // Redirection vers la vue du sujet
    }

    // Modifie un message via le formulaire
    public function editPost($postId)
    {
        $postManager = new MessageManager();
        $topicId = $postManager->findOneById(($postId))->getSujet()->getId(); // Récupère l'id du sujet du message

        if (Session::getUser() && (Session::getUser()->getId() == $postManager->findOneById($postId)->getVisiteur()->getId() || Session::isAdmin())) // Vérifie que le visiteur est connecté et qu'il est l'auteur du message
        {
            if (isset($_POST['edit']) && isset($_POST['edit' . $postId]) && !empty($_POST['edit' . $postId])) { // Vérifie qu'un formulaire à été soumis et que les champs existent et ne son pas vides
                $message = filter_input(INPUT_POST, "edit" . $postId, FILTER_SANITIZE_SPECIAL_CHARS);
                if ($message) {
                    $postManager->edit($postId, $message); // Ajoute les informations du formulaire en BDD
                    Session::addFlash("success", "Message modifié !");
                    $this->redirectTo("sujet", "viewTopic", $topicId); // Redirection vers la vue du sujet
                }
            }
            Session::addFlash("error", "Le message est invalide !");
        }

        $this->redirectTo("sujet", "viewTopic", $topicId); // Redirection vers la vue du sujet
    }

    // Supprime un message
    public function deletePost($postId)
    {
        $postManager = new MessageManager();
        $topicManager = new SujetManager();

        $topicId = $postManager->findOneById($postId)->getSujet()->getId(); // Récupère l'id du sujet du message
        $firstPostId = $topicManager->getFirstPostId($topicId); // Récupère l'id du premier message du sujet

        if ($postId != $firstPostId["id_message"] && Session::getUser() && (Session::getUser()->getId() == $postManager->findOneById($postId)->getVisiteur()->getId() || Session::isAdmin())) // Vérifie que le message n'est pas le premier du sujet, que le visiteur est connecté et qu'il est l'auteur du message
        {
            $postManager->delete($postId);
            Session::addFlash("success", "Message supprimé !");
        }

        $this->redirectTo("sujet", "viewTopic", $topicId); // Redirection vers la vue du sujet 
    }
}
