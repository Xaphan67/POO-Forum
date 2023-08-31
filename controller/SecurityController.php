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
                $pseudo = filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_SPECIAL_CHARS);
                $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
                $mdp = filter_input(INPUT_POST, "mdp", FILTER_SANITIZE_SPECIAL_CHARS);
                $mdpCheck = filter_input(INPUT_POST, "mdpCheck", FILTER_SANITIZE_SPECIAL_CHARS);
                if ($pseudo && $email && $mdp && $mdpCheck)
                {
                    if (!$visitorManager->findOneByEmail($email)) // Vérifie que l'email n'existe pas
                    {
                        if (!$visitorManager->findOneByPseudo($pseudo)) // Vérifie que le pseudo n'existe pas
                        {
                            if ($mdp == $mdpCheck) { // Vérifie que mdp et mdpCheck sont identiques
                                $visitorManager->add(['pseudoVisiteur' => $pseudo , 'mdpVisiteur' => password_hash($mdp, PASSWORD_DEFAULT), 'emailVisiteur' => $email]); // Hashe le mdp et ajoute les informations du formulaire en BDD
                                Session::addFlash("success", 'Merci ! Vous êtes désormais inscrit en tant que "$pseudo"');
                            }
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
                $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
                $mdp = filter_input(INPUT_POST, "mdp", FILTER_SANITIZE_SPECIAL_CHARS);
                $passwordHash = $visitorManager->getPasswordHash($email)["mdpVisiteur"];
                if (password_verify($mdp, $passwordHash)) { // Vérifie que le mdp saisi est valide
                    $user = $visitorManager->findOneByEmail($email);
                    Session::setUser($user);
                    Session::addFlash("success", "Bienvenue " . $user . " !");
                }
                $this->redirectTo("forum", "listCategories"); // Redirige vers la liste des catégories
            }
        } else {
            return [
                "view" => VIEW_DIR . "login.php"
            ];
        }
    }

    public function logout()
    {
        session_destroy(); // Détruit la session en cours
        $this->redirectTo("forum", "listCategories"); // Redirige vers la liste des catégories
    }
}
