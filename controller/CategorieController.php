<?php

namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use model\Managers\CategorieManager;
use Model\Managers\SujetManager;

class CategorieController extends AbstractController implements ControllerInterface
{

    // Fonction par defaut, si l'action n'a pas été trouvée
    public function index()
    {
        return [
            "view" => VIEW_DIR . "home.php",
            "meta" => "Les catgégories de FORUM PHP"
        ];
    }

    // Affiche la liste des catégories du forum
    public function listCategories()
    {
        $categoryManager = new CategorieManager();

        if (isset($_POST['submit'])) { // Vérifie qu'un formulaire à été soumis

            $this->restrictTo("ROLE_ADMIN"); // Seul l'admin peut avoir accès -> redirige vers le formulaire de login sinon

            if (isset($_POST["nom"]) && !empty($_POST['nom'])) { // Vérifie que les champs du formulaires existent et ne sont pas vides
                $nom = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_SPECIAL_CHARS);
                $description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_SPECIAL_CHARS);
                if ($nom && $description !== false) {
                    $categoryManager->add(['nomCategorie' => $nom, "descriptionCategorie" => $description]); // Ajoute les informations du formulaire pour la catégorie en BDD 
                    Session::addFlash("success", "Catégorie ajoutée !");
                }
            } else {
                Session::addFlash("error", "Le nom est invalide !");
            }
        }

        return [
            "view" => VIEW_DIR . "forum/listCategories.php",
            "meta" => "Les catégories de FORUM PHP",
            "data" => [
                "categories" => $categoryManager->getAllCategories() // Informations relatives aux catégories (Noms, nombre sujets et réponses etc...)
            ]
        ];
    }

    // Traite les informations et modifie la catégorie via le formulaire
    public function editCategory($categoryId)
    {
        $this->restrictTo("ROLE_ADMIN"); // Seul l'admin peut avoir accès -> redirige vers le formulaire de login sinon

        $categoryManager = new CategorieManager();

        if (isset($_POST['edit']) && isset($_POST['name' . $categoryId]) && isset($_POST['desc' . $categoryId]) && !empty($_POST['name' . $categoryId]) && !empty($_POST['desc' . $categoryId])) { // Vérifie qu'un formulaire à été soumis et que les champs existent et ne son pas vides
            $nom = filter_input(INPUT_POST, "name" . $categoryId, FILTER_SANITIZE_SPECIAL_CHARS);
            $description = filter_input(INPUT_POST, "desc" . $categoryId, FILTER_SANITIZE_SPECIAL_CHARS);
            if ($nom && $description) {
                $categoryManager->edit($categoryId, $nom, $description); // Ajoute les informations du formulaire en BDD
                Session::addFlash("success", "Catégorie modifié !");
                $this->redirectTo("categorie", "listCategories"); // Redirection vers la liste des catégories
            } else {
                switch(true) {
                    case !$nom:
                        Session::addFlash("error", "Le nom est invalide !");
                        break;
                    case !$description:
                        Session::addFlash("error", "La description est invalide !");
                        break;
                }
            }
        }

        $this->redirectTo("categorie", "listCategories"); // Redirection vers la liste des catégories
    }

    // Supprime une catégorie
    public function deleteCategory($categoryId)
    {
        $this->restrictTo("ROLE_ADMIN"); // Seul l'admin peut avoir accès -> redirige vers le formulaire de login sinon

        $categoryManager = new CategorieManager();

        $categoryManager->delete($categoryId); // Appelle la méthode du manager qui supprime la catégorie
        Session::addFlash("success", "Catégorie supprimée !");

        $this->redirectTo("categorie", "listCategories"); // Redirection vers la liste des catégories
    }

    // Affiche la liste des sujets d'une catégrie du forum
    public function listTopics($categoryId)
    {
        $categoryManager = new CategorieManager();
        $topicManager = new SujetManager();

        return [
            "view" => VIEW_DIR . "forum/listTopics.php",
            "meta" => "Tous les sujets de la catégorie " . $categoryManager->findOneById($categoryId)->getNomCategorie(),
            "data" => [
                "category" => $categoryManager->findOneById($categoryId), // Informations sur la catégorie
                "topics" => $topicManager->getAllTopicsFromCategory($categoryId) // Liste des sujets de la catégorie
            ]
        ];
    }
}
