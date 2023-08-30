<?php

namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\VisiteurManager;

class SecurityController extends AbstractController implements ControllerInterface
{

    // Fonction par defaut, si l'action n'a pas été trouvée
    public function index()
    {
        return [
            "view" => VIEW_DIR . "home.php",
        ];
    }

    public function register()
    {
        if (isset($_POST['submit'])) { // Vérifie qu'un formulaire à été soumis
            $visitorManager = new VisiteurManager();
            if (isset($_POST["pseudo"]) && isset($_POST["email"]) && isset($_POST["mdp"]) && isset($_POST["mdpCheck"]) && !empty($_POST['pseudo']) && !empty($_POST['email']) && !empty($_POST['mdp']) && !empty($_POST['mdpCheck'])) { // Vérifie que les champs du formulaires existent et ne sont pas vides
                /* filtres ici */
                if (!$visitorManager->findOneByEmail($_POST["email"])) // Vérifie que l'email n'existe pas
                {
                    if (!$visitorManager->findOneByPseudo($_POST['pseudo'])) // Vérifie que le pseudo n'existe pas
                    {
                        if ($_POST["mdp"] == $_POST["mdpCheck"]) { // Vérifie que mdp et mdpCheck sont identiques
                            $visitorManager->add(['pseudoVisiteur' => $_POST["pseudo"], 'mdpVisiteur' => password_hash($_POST["mdp"], PASSWORD_DEFAULT), 'emailVisiteur' => $_POST["email"]]); // Hashe le mdp et ajoute les informations du formulaire en BDD
                        }
                    }
                }
            }
            $this->redirectTo("forum", "listCategories"); // Redirige vers la liste des catégories
        } else {
            return [
                "view" => VIEW_DIR . "register.php"
            ];
        }
    }

    public function login()
    {
        if (isset($_POST['submit'])) { // Vérifie qu'un formulaire à été soumis
            $visitorManager = new VisiteurManager();
            if (isset($_POST["email"]) && isset($_POST["mdp"]) && !empty($_POST['email']) && !empty($_POST['mdp'])) { // Vérifie que les champs du formulaires existent et ne sont pas vides
                /* filtres ici */
                $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
                $passwordHash = $visitorManager->getPasswordHash($_POST['email'])["mdpVisiteur"];
                if (password_verify($_POST['mdp'], $passwordHash)) { // Vérifie que le mdp saisi est valide
                    Session::setUser($visitorManager->findOneByEmail($email));
                }
                $this->redirectTo("forum", "listCategories"); // Redirige vers la liste des catégories
            }
        } else {
            return [
                "view" => VIEW_DIR . "login.php"
            ];
        }
    }
}
