<?php

namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\VisiteurManager;
use model\Managers\CategorieManager;

class HomeController extends AbstractController implements ControllerInterface
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



    public function users()
    {
        $this->restrictTo("ROLE_USER");

        $manager = new VisiteurManager();
        $users = $manager->findAll(['registerdate', 'DESC']);

        return [
            "view" => VIEW_DIR . "security/users.php",
            "data" => [
                "users" => $users
            ]
        ];
    }

    public function forumRules()
    {

        return [
            "view" => VIEW_DIR . "rules.php"
        ];
    }

    /*public function ajax(){
            $nb = $_GET['nb'];
            $nb++;
            include(VIEW_DIR."ajax.php");
        }*/
}
