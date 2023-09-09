<?php

$messages = $result["data"]['posts'];
$topic = $result["data"]['topic'];
$firstId = $result["data"]['firstId'];

?>

<!-- Fil d'ariane -->
<div class="ariane">
    <a href="index.php?ctrl=categorie&action=listCategories">
        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
            <path d="M543.8 287.6c17 0 32-14 32-32.1c1-9-3-17-11-24L512 185V64c0-17.7-14.3-32-32-32H448c-17.7 0-32 14.3-32 32v36.7L309.5 7c-6-5-14-7-21-7s-15 1-22 8L10 231.5c-7 7-10 15-10 24c0 18 14 32.1 32 32.1h32v69.7c-.1 .9-.1 1.8-.1 2.8V472c0 22.1 17.9 40 40 40h16c1.2 0 2.4-.1 3.6-.2c1.5 .1 3 .2 4.5 .2H160h24c22.1 0 40-17.9 40-40V448 384c0-17.7 14.3-32 32-32h64c17.7 0 32 14.3 32 32v64 24c0 22.1 17.9 40 40 40h24 32.5c1.4 0 2.8 0 4.2-.1c1.1 .1 2.2 .1 3.3 .1h16c22.1 0 40-17.9 40-40V455.8c.3-2.6 .5-5.3 .5-8.1l-.7-160.2h32z" />
        </svg>
        Index du forum
    </a>
    <div>></div>
    <a href="index.php?ctrl=categorie&action=listTopics&id=<?= $topic->getCategorie()->getId() ?>"><?= $topic->getCategorie() ?></a>
    <div>></div>
    <div><?= $topic ?></div>
</div>

<div class="main-content">
    <div> <!-- Boutons de verouillage / déverrouillage du sujet -->
        <?php
        if (App\Session::getUser()) {
            if (App\Session::isAdmin()) {
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
            if (!$topic->getVerouilleSujet() && (App\Session::getUser()->getId() == $topic->getVisiteur()->getId() || App\Session::isAdmin())) {
            ?>
                <button onclick="showTopicEditForm(<?= $topic->getId() ?>)" type="submit" name="edit">Modifier le nom du sujet</button>
                <form class="editForm" id="editTopicForm<?= $topic->getId() ?>" action="index.php?ctrl=sujet&action=editTopic&id=<?= $topic->getId() ?>" style="display: none" method="post">
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
                foreach ($messages as $message) {
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
                            if (App\Session::getUser()) {
                                if (App\Session::getUser()->getId() == $message->getVisiteur()->getId() || App\Session::isAdmin()) {
                                ?>
                                    <button onclick="showPostEditForm(<?= $message->getId() ?>)" type="submit" name="edit">Modifier</button>
                                    <?php
                                    if ($firstId["id_message"] != $message->getId()) // Empèche la supression du premier post
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
                            <form class="editForm" id="editForm<?= $message->getId() ?>" action="index.php?ctrl=message&action=editPost&id=<?= $message->getId() ?>" method="post">
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
</div>

<script>
    // Affiche le formulaire d'edition d'un message
    function showPostEditForm(id) {
        const message = document.querySelector("#message" + id);
        const editForm = document.querySelector("#editForm" + id);
        if (message.style.display != "none") {
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
        if (editForm.style.display == "none") {
            editForm.style.display = "unset";
        } else {
            editForm.style.display = "none";
        }
    }
</script>