<?php

$messages = $result["data"]['posts'];
$topic = $result["data"]['topic'];

?>
<!-- Fil d'ariane -->
<h1><a href="index.php?ctrl=categorie&action=listCategories">Forum PHP</a> > <a href="index.php?ctrl=categorie&action=listTopics&id=<?= $topic->getCategorie()->getId() ?>"><?= $topic->getCategorie() ?></a> > <?= $topic ?></h1>

<div> <!-- Boutons de verouillage / déverrouillage du sujet -->
    <?php
    if (App\Session::getUser())
    {
        if(App\Session::isAdmin())
        {
            if ($topic->getVerouilleSujet()) {
                ?>
                    <a href="index.php?ctrl=sujet&action=unlockTopic&id=<?= $topic->getId() ?>">Déverouiller</a>
                <?php
                } else {
                ?>
                    <a href="index.php?ctrl=sujet&action=lockTopic&id=<?= $topic->getId() ?>">Verouiller</a>
                <?php
                }
                ?>
            <a href="index.php?ctrl=sujet&action=deleteTopic&id=<?= $topic->getId() ?>">Supprimer</a>
        <?php
        }
        if (!$topic->getVerouilleSujet() && (App\Session::getUser()->getId() == $topic->getVisiteur()->getId() || App\Session::isAdmin()))
        {
        ?>
            <button onclick="showTopicEditForm(<?= $topic->getId() ?>)" type="submit" name="edit">Modifier le nom du sujet</button>
            <form class ="editForm" id="editTopicForm<?= $topic->getId() ?>" action="index.php?ctrl=sujet&action=editTopic&id=<?= $topic->getId() ?>" style="display: none" method="post">
                <input id="edit<?= $topic->getId() ?>" name="edit<?= $topic->getId() ?>" type="text" value="<?= $topic->getTitreSujet() ?>" required></input>
                <button type="submit" name="edit">Modifier</button>
            </form>
        <?php
        }   
    }
    ?>
</div>


<?php
if ($messages != null) { // Normalement, il y a toujours un message : Celui de l'auteur.
?>
    <table>
        <tbody>
            <?php
            $numMessage = 0;
            foreach ($messages as $message) {
                $numMessage++;
                ?>
                <tr>
                    <td class="no-padding">
                        <div class="visiteur-display">
                            <figure>
                                <img class="avatar-msg" src="<?= PUBLIC_DIR ?>/img/<?= "avatars/" . $message->getVisiteur()->getAvatarVisiteur() ?>" alt="Avatar de <?= $message->getVisiteur() ?>" />
                            </figure>
                            <?php
                            if ($message->getVisiteur()->getRoleVisiteur() != "ROLE_DELETED") {
                            ?>
                                <a href="index.php?ctrl=visiteur&action=viewProfile&id=<?= $message->getVisiteur()->getId() ?>"><?= $message->getVisiteur() ?></a>
                            <?php
                            } else {
                            ?>
                                <?= $message->getVisiteur() ?>
                            <?php
                            }
                            ?>
                        </div>
                    </td>
                    <td>
                        Créé le <?= $message->getDateCreationMessage() ?>
                        <?php if ($message->getDateModificationMessage() != null) {
                        ?>
                             - Modifié le <?= $message->getDateModificationMessage() ?>
                        <?php
                        }
                        if (App\Session::getUser())
                        {
                            if (App\Session::getUser()->getId() == $message->getVisiteur()->getId() || App\Session::isAdmin())
                            {
                            ?>
                                <button onclick="showPostEditForm(<?= $message->getId() ?>)" type="submit" name="edit">Modifier</button>
                                <?php
                                if ($numMessage > 1) // Empèche la supression du premier post
                                {
                                ?>
                                    <a href="index.php?ctrl=message&action=deletePost&id=<?= $message->getId() ?>">Supprimer</a>
                                <?php
                                }
                            }
                        }
                        ?> 
                    </td>
                </tr>
                <tr class="main-message">
                    <td>Inscrit le <?= $message->getVisiteur()->getDateInscriptionVisiteur() ?><br><?= $message->getVisiteur()->getRoleVisiteur() != "ROLE_DELETED" ? $message->getVisiteur()->getRoleVisiteur() : "" ?></td>
                    <td>
                        <p id="message<?= $message->getId() ?>"><?= $message->getTexteMessage() ?></p>
                        <form class ="editForm" id="editForm<?= $message->getId() ?>" action="index.php?ctrl=message&action=editPost&id=<?= $message->getId() ?>" method="post">
                            <textarea id="edit<?= $message->getId() ?>" name="edit<?= $message->getId() ?>" rows="5" required><?= $message->getTexteMessage() ?></textarea>
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

// Formulaire de réponse au sujet, uniquement s'il n'est pas verrouillé et qu'un visiteur est connecté et non banni
if (App\Session::getUser()) {
    if (!App\Session::getUser()->isBanned()) {
        if (!$topic->getVerouilleSujet()) {
        ?>
            <form action="index.php?ctrl=message&action=submitPost&id=<?= $topic->getId() ?>" method="post">
                <label for="reponse">Répondre : *</label>
                <textarea id="reponse" name="reponse" rows="5" required></textarea>
                <button type="submit" name="submit">Répondre</button>
            </form>
        <?php
        } else {
        ?>
            <p>Ce sujet est vérouillé. Vous ne pouvez pas y répondre.</p>
        <?php
        }
    } else {
    ?>
        <p>Vous ne pouvez pas répondre à ce sujet car vous êtes banni jusqu'au <?= App\Session::getUser()->getDateBanissementVisiteur()->format("d/m/Y") ?></p>
    <?php
    }
} else {
    ?>
    <p>Connectez vous pour pouvoir répondre</p>
    <?php
}
?>
<script>
    // Affiche le formulaire d'edition d'un message
    function showPostEditForm(id) {
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

    // Affiche le formulaire d'edition du titre du sujet
    function showTopicEditForm(id) {
        const editForm = document.querySelector("#editTopicForm" + id);
        if (editForm.style.display == "none") 
        {
            editForm.style.display = "unset";
        } else {
            editForm.style.display = "none";
        }
    }
</script>