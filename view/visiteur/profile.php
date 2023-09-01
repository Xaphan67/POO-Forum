<?php

$user = $result["data"]['user'];
$messages = $result["data"]['posts'];
$nbMessages = $result["data"]['nbPosts']["nbPosts"];

?>

<h1>Profil de <?= $user->getPseudoVisiteur() ?></h1>

<p>Pseudo : <a href="index.php?ctrl=visiteur&action=viewProfile&id=<?= $user->getId() ?>"><?= $user->getPseudoVisiteur() ?></a></p>
<p>Date d'inscription : <?= $user->getDateInscriptionVisiteur() ?></p>
<p>Rôle : 
<?php 
    $role = $user->getRoleVisiteur();
    if (str_contains($role, "ADMIN"))
    {
        $role = "Administrateur";
    } else if (str_contains($role, "MODERATOR")) {
        $role = "Modérateur";
    } else {
        $role = "Membre";
    }
?>
    <?= $role ?>
</p>
<p>Messages : <?= $nbMessages ?></p>

<h2>Les derniers messages de <?= $user->getPseudoVisiteur() ?>:</h2>


    <?php 
    if ($messages != null)
    {
    ?>
        <table>
            <tbody>
            <?php
                foreach ($messages as $message) {
                ?>
                    <tr>
                        <td><a href="index.php?ctrl=visiteur&action=viewProfile&id=<?= $message->getVisiteur()->getId() ?>"><?= $message->getVisiteur() ?></a></td>
                        <td>Sujet : <?= $message->getSujet()->getTitreSujet() ?></td>
                    </tr>
                    <tr class="main-message">
                        <td><?= $message->getDateCreationMessage() ?></td>
                        <td><?= $message->getTexteMessage() ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    <?php
    }
    else
    {
    ?>
        <p>Aucun message !</p>
    <?php
    }
    ?>
