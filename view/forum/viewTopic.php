<?php

$messages = $result["data"]['posts'];
$topic = $result["data"]['topic'];

?>
<!-- Fil d'ariane -->
<h1><a href="index.php?ctrl=forum&action=listCategories">Forum PHP</a> > <a href="index.php?ctrl=forum&action=listTopics&id=<?= $topic->getCategorie()->getId() ?>"><?= $topic->getCategorie() ?></a> > <?= $topic ?></h1>

<div> <!-- Boutons de verouillage / déverrouillage du sujet -->
    <?php
    if ($topic->getVerouilleSujet()) {
    ?>
        <a href="index.php?ctrl=forum&action=unlockTopic&id=<?= $topic->getId() ?>">Déverouiller</a>
    <?php
    } else {
    ?>
        <a href="index.php?ctrl=forum&action=lockTopic&id=<?= $topic->getId() ?>">Verouiller</a>
    <?php
    }
    ?>
</div>
<div><a href="index.php?ctrl=forum&action=deleteTopic&id=<?= $topic->getId() ?>">Supprimer</a></div>

<?php
if ($messages != null) { // Normalement, il y à toujours un message : Celui de l'auteur.
?>
    <table>
        <tbody>
            <?php
            foreach ($messages as $message) {
            ?>
                <tr>
                    <td><a href="index.php?ctrl=forum&action=viewProfile&id=<?= $message->getVisiteur()->getId() ?>"><?= $message->getVisiteur() ?></a></td>
                    <td><?= $message->getDateCreationMessage() ?></td>
                </tr>
                <tr class="main-message">
                    <?php $role = $message->getVisiteur()->getRoleVisiteur();
                    if (str_contains($role, "ADMIN"))
                    {
                        $role = "Administrateur";
                    } else if (str_contains($role, "MODERATOR")) {
                        $role = "Modérateur";
                    } else {
                        $role = "Membre";
                    } ?>
                    <td>Inscrit le <?= $message->getVisiteur()->getDateInscriptionVisiteur() ?><br><?= $role ?></td>
                    <td><?= $message->getTexteMessage() ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
<?php
} else {
?>
    <p>Aucun message !</p>
<?php
}

// Formulaire de réponse au sujet, uniquement s'il n'est pas verrouillé et qu'un visiteur est connecté
if (!$topic->getVerouilleSujet() && App\Session::getUser()) {
?>
    <form action="index.php?ctrl=forum&action=submitPost&id=<?= $topic->getId() ?>" method="post">
        <label for="reponse">Répondre : *</label>
        <textarea id="reponse" name="reponse" rows="5" required></textarea>
        <button type="submit" name="submit">Répondre</button>
    </form>
    <?php
} else {
    if (!App\Session::getUser()) {
    ?>
        <p>Connectez vous pour pouvoir répondre</p>
    <?php
    } else {
    ?>
        <p>Ce sujet est vérouillé. Vous ne pouvez pas y répondre.</p>
<?php
    }
}
