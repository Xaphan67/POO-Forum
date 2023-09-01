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
                if ($pseudo && $email && $mdp && $mdpCheck && !$visitorManager->findOneByEmail($email) && !$visitorManager->findOneByPseudo($pseudo) && ($mdp == $mdpCheck))
                {
                    $visitorManager->add(['pseudoVisiteur' => $pseudo , 'mdpVisiteur' => password_hash($mdp, PASSWORD_DEFAULT), 'emailVisiteur' => $email]); // Hashe le mdp et ajoute les informations du formulaire en BDD
                    Session::addFlash("success", 'Merci ! Vous êtes désormais inscrit en tant que "$pseudo"');
                    $this->redirectTo("forum", "listCategories"); // Redirige vers la liste des catégories
                }
                switch (true) { // Affiche une erreur via un message en fonction du probleme
                    case !$pseudo:
                        Session::addFlash("error", "Le pseudonyme est invalide !");
                        break;
                    case !$email:
                        Session::addFlash("error", "L'adresse e-mail est invalide !");
                        break;
                    case !$mdp:
                        Session::addFlash("error", "Le mot de passe est invalide !");
                        break;
                    case !$mdpCheck:
                        Session::addFlash("error", "Le mot de passe est invalide !");
                        break;
                    case $visitorManager->findOneByEmail($email):
                        Session::addFlash("error", "Cette adresse e-mail est déjà utilisée !");
                        break;
                    case $visitorManager->findOneByPseudo($pseudo):
                        Session::addFlash("error", "Ce pseudonyme est déjà utilisé !");
                        break;
                    case $mdp == $mdpCheck:
                        Session::addFlash("error", "Les mots de passe ne correspondent pas !");
                        break;
                }
                $this->redirectTo("security", "register"); // Redirige vers le formulaire d'inscription
            }
            Session::addFlash("error", "Au moins un champ du formulaire est invalide !");
            $this->redirectTo("security", "register"); // Redirige vers le formulaire d'inscription
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
                if ($email && $mdp && password_verify($mdp, $passwordHash)) { // Vérifie les champs et que le mdp saisi est valide
                    $user = $visitorManager->findOneByEmail($email);
                    Session::setUser($user);
                    Session::addFlash("success", "Bienvenue " . $user . " !");
                    $this->redirectTo("forum", "listCategories"); // Redirige vers la liste des catégories
                }
                switch (true) { // Affiche une erreur via un message en fonction du probleme
                    case !$email:
                        Session::addFlash("error", "L'adresse e-mail est invalide !");
                        break;
                    case !$mdp:
                        Session::addFlash("error", "Le mot de passe est invalide !");
                        break;
                    case !password_verify($mdp, $passwordHash):
                        Session::addFlash("error", "Le mot de passe est incorect !");
                        break;
                }
                $this->redirectTo("security", "login"); // Redirige vers la liste des catégories
            }
            Session::addFlash("error", "Au moins un champ du formulaire est invalide !");
            $this->redirectTo("security", "login"); // Redirige vers la liste des catégories
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
