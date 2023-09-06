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

    // Modifie l'avatar d'un utilisateur
    public function editAvatar($visitorId)
    {
        $VisitorManager = new VisiteurManager();

        if (isset($_POST['submit']) && isset($_FILES["avatar"]) && !empty($_FILES["avatar"])) { // Vérifie qu'un formulaire à été soumis et que les champs existent et ne son pas vides
            $tmpName = $_FILES['avatar']['tmp_name'];
            $filename = $_FILES['avatar']['name'];
            $size = $_FILES['avatar']['size'];
            $error = $_FILES['avatar']['error'];

            $tabExtension = explode('.', $filename); // Sépare le nom du fichier et son extension
            $extension = strtolower(end($tabExtension)); // Stock l'extension

            //Tableau des extensions acceptées
            $extensions = ['jpg', 'png', 'jpeg', 'gif'];

            // Taille maximale acceptée (en bytes)
            $maxSize = 400000;

            // Vérifie que l'extension et la taille sont accepté
            if (in_array($extension, $extensions) && $size <= $maxSize && $error == 0) {
                $uniqueName = uniqid('', true);
                $file = $uniqueName . "." . $extension;
                $oldAvatar = $VisitorManager->findOneById($visitorId)->getAvatarVisiteur();
                unlink(PUBLIC_DIR ."/img/avatars/" . $oldAvatar); // Supprime l'ancien avatar
                $upload = move_uploaded_file($tmpName, PUBLIC_DIR ."/img/avatars/" . $file); // Upload le fichier dans le dossier upload
                $VisitorManager->editAvatar($visitorId, $file); // Appelle la méthode du manager qui modifie le visiteur en BDD
                Session::addFlash("success", "Avatar modifié !");
                $this->redirectTo("visiteur", "viewProfile", $visitorId); // Redicection vers le profile du visiteur
            }
        }
        Session::addFlash("error", "L'avatar est invalide !"); 

        $this->redirectTo("visiteur", "viewProfile", $visitorId); // Redicection vers le profile du visiteur
    }

    // Modifie le rôle d'un visiteur
    public function editRole($visitorId)
    {
        $this->restrictTo("ROLE_ADMIN"); // Seul l'admin peut voir la page -> redirige vers le formulaire de login sinon

        $VisitorManager = new VisiteurManager();

        if (isset($_POST['edit']) && isset($_POST["edit" . $visitorId]) && !empty($_POST["edit" . $visitorId])) { // Vérifie qu'un formulaire à été soumis et que les champs existent et ne son pas vides
            $role = filter_input(INPUT_POST, "edit" . $visitorId, FILTER_SANITIZE_SPECIAL_CHARS);
            if ($role)
            {
                $VisitorManager->edit($visitorId, $role); // Appelle la méthode du manager qui modifie le visiteur en BDD
                Session::addFlash("success", "Rôle modifié !");
                $this->redirectTo("visiteur", "users"); // Redicection vers la gestion des visiteurs
            }
        }
        Session::addFlash("error", "Le rôle est invalide !"); 

        $this->redirectTo("visiteur", "users"); // Redicection vers la gestion des visiteurs
    }

    // Supprime un visiteur

    public function delete($visitorId)
    {
        if (Session::getUser() && Session::getUser()->getId() == $visitorId) // Vérifie que l'utilisateur qui essaie de se supprimer est actuellement connecté
        {
            $VisitorManager = new VisiteurManager();

            $VisitorManager->delete($visitorId);
            session_destroy(); // Détruit la session en cours
        }

        $this->redirectTo("categoerie", "listCategories"); // Redicection vers la liste des catégories
    }

    // Bannis un visiteur
    public function ban($visitorId)
    {
        $this->restrictTo("ROLE_ADMIN"); // Seul l'admin peut voir la page -> redirige vers le formulaire de login sinon

        $VisitorManager = new VisiteurManager();

        if (isset($_POST['ban']) && isset($_POST["ban" . $visitorId]) && !empty($_POST["ban" . $visitorId])) { // Vérifie qu'un formulaire à été soumis et que les champs existent et ne son pas vides
            $date = new \DateTime($_POST["ban" . $visitorId]);
            $today = new \DateTime();
            if ($date > $today)
            {
                $date = $date->format("Y-m-d H:i:s");
                if ($date)
                {
                    $VisitorManager->ban($visitorId, $date); // Appelle la méthode du manager qui modifie le visiteur en BDD
                    Session::addFlash("success", "Visiteur banni jusqu'au $date !");  
                    $this->redirectTo("visiteur", "users"); // Redicection vers la gestion des visiteurs  
                }
                Session::addFlash("error", "La date est invalide !"); 
                $this->redirectTo("visiteur", "users"); // Redicection vers la gestion des visiteurs
            }
        }
        Session::addFlash("error", "La date doit être supérieure à la date actuelle !"); 

        $this->redirectTo("visiteur", "users"); // Redicection vers la gestion des visiteurs
    }

    // Débannis un visiteur
    public function unban($visitorId)
    {
        $this->restrictTo("ROLE_ADMIN"); // Seul l'admin peut voir la page -> redirige vers le formulaire de login sinon

        $VisitorManager = new VisiteurManager();

        $VisitorManager->unban($visitorId); // Appelle la méthode du manager qui modifie le visiteur en BDD
        Session::addFlash("success", "l'utilisateur n'est plus banni !");  

        $this->redirectTo("visiteur", "users"); // Redicection vers la gestion des visiteurs
    }
}