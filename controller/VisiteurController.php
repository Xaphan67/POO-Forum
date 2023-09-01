<?php

namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\VisiteurManager;
use model\Managers\CategorieManager;
use model\Managers\MessageManager;

class VisiteurController extends AbstractController implements ControllerInterface
{

    // Par defaut : Affiche l'index du forum (la liste des catégories)
    public function index()
    {
        $categoryManager = new CategorieManager();

        return [
            "view" => VIEW_DIR . "forum/listCategories.php",
            "data" => [
                "categories" => $categoryManager->getAllCategories() // Informations relatives aux catégories (Noms, nombre sujets et réponses etc...)
            ]
        ];
    }

    // Affiche la liste des visiteurs enregistrés
    public function users()
    {
        $this->restrictTo("ROLE_ADMIN"); // Seul l'admin peut voir la page -> redirige vers le formulaire de login sinon

        $VisitorManager = new VisiteurManager();
        $users = $VisitorManager->findAll(['dateInscriptionVisiteur', 'DESC']);

        return [
            "view" => VIEW_DIR . "visiteur/users.php",
            "data" => [
                "users" => $users
            ]
        ];
    }

    // Affiche le profil d'un visiteur
    public function viewProfile($id)
    {
        $VisitorManager = new VisiteurManager();
        $postManager = new MessageManager();

        return [
            "view" => VIEW_DIR . "visiteur/profile.php",
            "data" => [
                "user" => $VisitorManager->findOneById($id),
                "posts" => $postManager->getLastPostsFromVisitor($id),
                "nbPosts" => $postManager->getTotalPostsFromVisitor($id)
            ]
        ];
    }
}