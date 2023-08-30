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
                $emailExist = $visitorManager->checkIfEmailExist($_POST["email"])["emailCheck"] == 1; // Vérifie si l'email existe déja (valeur = 1). Si oui, emailExist = true
                $pseudoExist = $visitorManager->checkIfPseudoExist($_POST["pseudo"])["pseudoCheck"] == 1; // Vérifie si le pseudo existe déja (valeur = 1). Si oui, pseudoExist = true
                if (!$emailExist && !$pseudoExist && $_POST["mdp"] == $_POST["mdpCheck"]) { // Vérifie que mdp et mdpCheck sont identiques
                    $visitorManager->add(['pseudoVisiteur' => $_POST["pseudo"], 'mdpVisiteur' => password_hash($_POST["mdp"], PASSWORD_DEFAULT), 'emailVisiteur' => $_POST["email"]]); // Hashe le mdp et ajoute les informations du formulaire en BDD
                }
            }
            $this->redirectTo("forum", "listCategories"); // Redirige vers la liste des catégories
        } else {
            return [
                "view" => VIEW_DIR . "register.php"
            ];
        }
    }
}
