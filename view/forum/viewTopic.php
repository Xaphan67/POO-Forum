<?php

$messages = $result["data"]['posts'];
$topic = $result["data"]['topic'];

?>
<!-- Fil d'ariane -->
<h1><a href="index.php?ctrl=forum&action=listCategories">Forum PHP</a> > <a href="index.php?ctrl=forum&action=listTopics&id=<?= $topic->getCategorie()->getId() ?>"><?= $topic->getCategorie() ?></a> > <?= $topic ?></h1>

<div> <!-- Boutons de verouillage / déverrouillage du sujet -->
    <?php
    if(App\Session::getUser() && App\Session::isAdmin())
    {
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
        <div><a href="index.php?ctrl=forum&action=deleteTopic&id=<?= $topic->getId() ?>">Supprimer</a></div>
    <?php
    }
    ?>
</div>


<?php
if ($messages != null) { // Normalement, il y a toujours un message : Celui de l'auteur.
?>
    <table>
        <tbody>
            <?php
            foreach ($messages as $message) {
            ?>
                <tr>
                    <td><a href="index.php?ctrl=forum&action=viewProfile&id=<?= $message->getVisiteur()->getId() ?>"><?= $message->getVisiteur() ?></a></td>
                    <td>
                        <?= $message->getDateCreationMessage() ?>
                        <?php if (App\Session::getUser()->getId() == $message->getVisiteur()->getId() || App\Session::isAdmin())
                        {
                        ?>
                            <button onclick="showEditForm(<?= $message->getID() ?>)" type="submit" name="edit">Modifier</button>
                        <?php
                        }
                        ?>
                    </td>
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
                    <td>
                        <p id="message<?= $message->getID() ?>"><?= $message->getTexteMessage() ?></p>
                        <form class ="editForm" id="editForm<?= $message->getID() ?>" action="index.php?ctrl=forum&action=editPost&id=<?= $message->getId() ?>" method="post">
                                <textarea id="edit<?= $message->getID() ?>" name="edit<?= $message->getID() ?>" rows="5" required><?= $message->getTexteMessage() ?></textarea>
                                <button type="submit" name="edit">Modifier</button>
                        </form>
                    </td>
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
?>
<script>
    // Affiche le formulaire d'edition d'un message
    function showEditForm(id) {
        const message = document.querySelector("#message" + id);
        const editForm = document.querySelector("#editForm" + id);
        if (message.style.display != "none") 
        {
            message.style.display = "none";
            editForm.style.display = "unset";
        } else {
            message.style.display = "unset";
            editForm.style.display = "none";
        }
    } 
</script>