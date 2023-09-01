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

        if (isset($_POST['submit'])) { // Vérifie qu'un formulaire à été soumis
            if (isset($_POST["nom"]) && !empty($_POST['nom'])) { // Vérifie que les champs du formulaires existent et ne sont pas vides
                $nom = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_SPECIAL_CHARS);
                if ($nom)
                {
                    $categoryManager->add(['nomCategorie' => $nom]); // Ajoute les informations du formulaire pour la catégorie en BDD 
                    Session::addFlash("success", "Catégorie ajoutée !");
                }
            }
            else
            {
                Session::addFlash("error", "Le nom est invalide !");
            }
        }
        
        return [
            "view" => VIEW_DIR . "forum/listCategories.php",
            "data" => [
                "categories" => $categoryManager->getAllCategories() // Informations relatives aux catégories (Noms, nombre sujets et réponses etc...)
            ]
        ]; 
    }

    // Traite les informations et modifie le nom d'une catégorie via le formulaire
    public function editCategory($categoryId)
    {
        $categoryManager = new CategorieManager();

        if (isset($_POST['edit']) && isset($_POST['edit' . $categoryId]) && !empty($_POST['edit' . $categoryId])) { // Vérifie qu'un formulaire à été soumis et que les champs existent et ne son pas vides
            $nom = filter_input(INPUT_POST, "edit" . $categoryId, FILTER_SANITIZE_SPECIAL_CHARS);
            if ($nom)
            {
                $categoryManager->edit($categoryId, $nom); // Ajoute les informations du formulaire en BDD
                Session::addFlash("success", "Catégorie modifiée !");
                $this->redirectTo("forum", "listCategories"); // Redirection vers la liste des catégories
            }
        }
        Session::addFlash("error", "Le nom est invalide !");

        $this->redirectTo("forum", "listCategories"); // Redirection vers la liste des catégories
    }

    // Supprime une catégorie
    public function deleteCategory($categoryId)
    {
        $categoryManager = new CategorieManager();

        $categoryManager->delete($categoryId); // Appelle la méthode du manager qui supprime la catégorie
        Session::addFlash("success", "Catégorie supprimée !");

        $this->redirectTo("forum", "listCategories"); // Redirection vers la liste des catégories
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

    // Traite les informations et ajoute un noveau message à un sujet via le formulaire
    public function submitPost($topicId)
    {
        $postManager = new MessageManager();

        if (isset($_POST['submit']) && isset($_POST["reponse"]) && !empty($_POST['reponse'])) { // Vérifie qu'un formulaire à été soumis et que les champs existent et ne son pas vides
            $reponse = filter_input(INPUT_POST, "reponse", FILTER_SANITIZE_SPECIAL_CHARS);
            if ($reponse)
            {
                $userId = Session::getUser()->getId(); // Récupère l'ID du visiteur actuellement connecté
                $postManager->add(['texteMessage' => $reponse, 'visiteur_id' => $userId, 'sujet_id' => $topicId]); // Ajoute les informations du formulaire en BDD
                Session::addFlash("success", "Message ajouté !");
                $this->redirectTo("forum", "viewTopic", $topicId); // Redirection vers la vue du sujet
            }
        }
        Session::addFlash("error", "Le message est invalide !");

        $this->redirectTo("forum", "viewTopic", $topicId); // Redirection vers la vue du sujet
    }

    // Traite les informations et modifie un message via le formulaire
    public function editPost($postId)
    {
        $postManager = new MessageManager();
        $topicId = $postManager->findOneById(($postId))->getSujet()->getId(); // Récupère l'id du sujet du message

        if (isset($_POST['edit']) && isset($_POST['edit' . $postId]) && !empty($_POST['edit' . $postId])) { // Vérifie qu'un formulaire à été soumis et que les champs existent et ne son pas vides
            $message = filter_input(INPUT_POST, "edit" . $postId, FILTER_SANITIZE_SPECIAL_CHARS);
            if ($message)
            {
                $postManager->edit($postId, $message); // Ajoute les informations du formulaire en BDD
                Session::addFlash("success", "Message modifié !");
                $this->redirectTo("forum", "viewTopic", $topicId); // Redirection vers la vue du sujet
            }
        }
        Session::addFlash("error", "Le message est invalide !");

        $this->redirectTo("forum", "viewTopic", $topicId); // Redirection vers la vue du sujet
    }

    // Supprime un message
    public function deletePost($postId)
    {
        $postManager = new MessageManager();
        $topicId = $postManager->findOneById(($postId))->getSujet()->getId(); // Récupère l'id du sujet du message

        $postManager->delete($postId);
        Session::addFlash("success", "Message supprimé !");

        $this->redirectTo("forum", "viewTopic", $topicId); // Redirection vers la vue du sujet
    }

    // Traite les informations et ajoute un nouveau sujet via le formulaire
    public function newTopic($categoryId)
    {
        $topicManager = new SujetManager();
        $postManager = new MessageManager();

        if (isset($_POST['submit']) && isset($_POST["nom"]) && !empty($_POST['nom']) && isset($_POST["message"]) && !empty($_POST['message'])) { // Vérifie qu'un formulaire à été soumis et que les champs existent et ne son pas vides
            $nom = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_SPECIAL_CHARS);
            $message = filter_input(INPUT_POST, "message", FILTER_SANITIZE_SPECIAL_CHARS);
            if ($nom && $message)
            {
                $userId = Session::getUser()->getId(); // Récupère l'ID du visiteur actuellement connecté
                $newTopicId = $topicManager->add(['titreSujet' => $nom, 'visiteur_id' => $userId, 'categorie_id' => $categoryId]); // Ajoute les informations du formulaire pour le sujet en BDD, retourne l'id du sujet ajouté
                $postManager->add(['texteMessage' => $message, 'visiteur_id' => $userId, 'sujet_id' => $newTopicId]); // Ajoute les informations du formulaire pour le 1er message du sujet    
                Session::addFlash("success", "Sujet créé !");
                $this->redirectTo("forum", "viewTopic", $newTopicId); // Redicection vers la vue du sujet
            }
        }
        Session::addFlash("error", "Le " . (!$nom ? "nom du sujet" : "message") . " est invalide !");

        $this->redirectTo("forum", "listTopics", $categoryId); // Redicection vers la liste des sujets de la catégorie
    }

    // Traite les informations et modifie le titre du sujet via le formulaire
    public function editTopic($topicId)
    {
        $topicManager = new SujetManager();

        if (isset($_POST['edit']) && isset($_POST["edit" . $topicId]) && !empty($_POST["edit" . $topicId])) { // Vérifie qu'un formulaire à été soumis et que les champs existent et ne son pas vides
           
            $title = filter_input(INPUT_POST, "edit" . $topicId, FILTER_SANITIZE_SPECIAL_CHARS);
            if ($title)
            {
                $topicManager->edit($topicId, $title); // Ajoute les informations du formulaire pour le 1er message du sujet
                Session::addFlash("success", "Titre du sujet modifié !");
                $this->redirectTo("forum", "viewTopic", $topicId); // Redicection vers la vue du sujet
            }
            Session::addFlash("error", "Le titre du sujet est invalide !");
        }

        $this->redirectTo("forum", "viewTopic", $topicId); // Redicection vers la vue du sujet
    }

    // Verrouille un sujet
    public function lockTopic($topicId)
    {
        $topicManager = new SujetManager();

        $topicManager->lockTopic($topicId); // Appelle la méthode du manager qui verrouille le sujet en BDD
        Session::addFlash("success", "Sujet verrouillé !");

        $this->redirectTo("forum", "viewTopic", $topicId); // Redirection vers la vue su sujet
    }

    // Déverrouile un sujet
    public function unlockTopic($topicId)
    {
        $topicManager = new SujetManager();

        $topicManager->unlockTopic($topicId); // Appelle la méthode du manager qui déverrouille le sujet en BDD
        Session::addFlash("success", "Sujet déverrouillé !");

        $this->redirectTo("forum", "viewTopic", $topicId); // Redirection vers la vue su sujet
    }

    // Supprime un sujet
    public function deleteTopic($topicId)
    {
        $topicManager = new SujetManager();

        $topic = $topicManager->findOneById(($topicId)); // Récupère les informations correspondantes au sujet
        $categoryId = $topic->getCategorie()->getId(); // Récupère l'id de la catégoriue du sujet
        $topicManager->delete($topicId); // Appelle la méthode du manager qui supprime le sujet en BDD
        Session::addFlash("success", "Sujet supprimé !");

        $this->redirectTo("forum", "listTopics", $categoryId); // Redirection vers la catégorie qui contenait le sujet
    }
}
