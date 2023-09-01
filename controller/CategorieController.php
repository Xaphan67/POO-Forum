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
                $this->redirectTo("categorie", "listCategories"); // Redirection vers la liste des catégories
            }
        }
        Session::addFlash("error", "Le nom est invalide !");

        $this->redirectTo("categorie", "listCategories"); // Redirection vers la liste des catégories
    }

    // Supprime une catégorie
    public function deleteCategory($categoryId)
    {
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
            "data" => [
                "category" => $categoryManager->findOneById($categoryId), // Informations sur la catégorie
                "topics" => $topicManager->getAllTopicsFromCategory($categoryId) // Liste des sujets de la catégorie
            ]
        ];
    }
}
