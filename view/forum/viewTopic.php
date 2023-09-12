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
    <!-- Boutons de verouillage / déverrouillage du sujet -->
    <?php
    if (App\Session::getUser()) {
        if (App\Session::isAdmin()) {
            if ($topic->getVerouilleSujet()) {
            ?>
                <a class="topicLockActions btn" href="index.php?ctrl=sujet&action=unlockTopic&id=<?= $topic->getId() ?>" title="Déverrouiller le sujet">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" viewBox="0 0 576 512">
                        <path d="M352 144c0-44.2 35.8-80 80-80s80 35.8 80 80v48c0 17.7 14.3 32 32 32s32-14.3 32-32V144C576 64.5 511.5 0 432 0S288 64.5 288 144v48H64c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V256c0-35.3-28.7-64-64-64H352V144z"/>
                    </svg>
                </a>
            <?php
            } else {
            ?>
                <a class="topicLockActions btn" href="index.php?ctrl=sujet&action=lockTopic&id=<?= $topic->getId() ?>" title="Verrouiller le sujet">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" viewBox="0 0 448 512">
                        <path d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z"/>
                    </svg>
                </a>
            <?php
            }
            ?>
            <a class="btn" href="index.php?ctrl=sujet&action=deleteTopic&id=<?= $topic->getId() ?>" title="Supprimer le sujet">
                <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" viewBox="0 0 448 512">
                    <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                </svg>
            </a>
        <?php
        }
    }
    ?>
    
</div>

<div class="main-content">
    <?php
    if ($messages != null) { // Normalement, il y a toujours un message : Celui de l'auteur.
    ?>
        <table>
            <tbody>
                <?php
                foreach ($messages as $message) {
                    $visiteurLink = "";
                    if ($message->getVisiteur()->getRoleVisiteur() != "ROLE_DELETED") {
                        $visiteurLink .= '<a href="index.php?ctrl=visiteur&action=viewProfile&id=' . $message->getVisiteur()->getId() . '">' . $message->getVisiteur() . '</a>';
                    } else {
                        $visiteurLink .= $message->getVisiteur(); 
                    }
                    ?>
                    <tr>
                        <td rowspan="2" class="side-infos">
                            <figure>
                                <img class="avatar-msg" src="<?= PUBLIC_DIR ?>/img/<?= "avatars/" . $message->getVisiteur()->getAvatarVisiteur() ?>" alt="Avatar de <?= $message->getVisiteur() ?>" />
                            </figure>
                            <?= $visiteurLink ?>
                            <br>
                            <?= $message->getVisiteur()->getRoleVisiteur() != "ROLE_DELETED" ? $message->getVisiteur()->getRoleVisiteur() : "" ?>
                            <br>
                            <div class="side-infos-black">
                                Inscrit le <?= $message->getVisiteur()->getDateInscriptionVisiteur() ?>
                            </div>
                        </td>
                        <td class="top-infos">
                            <div class="msg-head">
                                <?php
                                if ($firstId["id_message"] == $message->getId()) {
                                    ?>
                                        <h1><?= $topic ?></h1>
                                        <div class="actions-abs">
                                            <?php 
                                            if (!$topic->getVerouilleSujet() && App\Session::getUser() && (App\Session::getUser()->getId() == $topic->getVisiteur()->getId() || App\Session::isAdmin())) {
                                            ?>
                                                <a class="btn" href="#editName<?= $topic->getID() ?>-Mod" title="Modifier le message">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" viewBox="0 0 512 512">
                                                        <path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/>
                                                    </svg>
                                                </a>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    <?php
                                }
                                if (App\Session::getUser()) {
                                    if (App\Session::getUser()->getId() == $message->getVisiteur()->getId() || App\Session::isAdmin()) {
                                        if ($firstId["id_message"] != $message->getId()) {
                                        ?>
                                        <div class="actions actions-abs">
                                            <a class="btn" href="#editMsg<?= $message->getId() ?>-Mod" title="Modifier le message">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" viewBox="0 0 512 512">
                                                    <path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/>
                                                </svg>
                                            </a>
                                            <?php
                                            }
                                            ?>
                                            <?php
                                            if ($firstId["id_message"] != $message->getId()) // Empèche la supression du premier post
                                            {
                                            ?>
                                                <a class="btn" href="index.php?ctrl=message&action=deletePost&id=<?= $message->getId() ?>" title="Supprimer le message">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" viewBox="0 0 448 512">
                                                        <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                                                    </svg>
                                                </a>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                            <div id="editName<?= $topic->getID() ?>-Mod" class="modal">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <header class="container"> 
                                            <a href="#" class="closebtn">×</a>
                                            <h2>Modifier le message</h2>
                                        </header>
                                        <div class="container">
                                            <form action="index.php?ctrl=sujet&action=editTopic&id=<?= $topic->getId() ?>" method="post">
                                                <label for="name<?= $topic->getId() ?>">Nom du sujet : *</label>    
                                                <input id="name<?= $topic->getId() ?>" name="name<?= $topic->getId() ?>" type="text" value="<?= $topic->getTitreSujet() ?>" required></input>
                                                <label for="msg<?= $message->getId() ?>">Message : *</label>    
                                                <textarea id="msg<?= $message->getId() ?>" name="msg<?= $message->getId() ?>" rows="5" required><?= $message->getTexteMessage() ?></textarea>
                                                <button class="btn btn-form" type="submit" name="edit">Modifier</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="editMsg<?= $message->getID() ?>-Mod" class="modal">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <header class="container"> 
                                            <a href="#" class="closebtn">×</a>
                                            <h2>Modifier le message</h2>
                                        </header>
                                        <div class="container">
                                            <form action="index.php?ctrl=message&action=editPost&id=<?= $message->getId() ?>" method="post">
                                                <label for="edit<?= $message->getId() ?>">Message : *</label>    
                                                <textarea id="edit<?= $message->getId() ?>" name="edit<?= $message->getId() ?>" rows="5" required><?= $message->getTexteMessage() ?></textarea>
                                                <button class="btn btn-form" type="submit" name="edit">Modifier</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            Par <?= $visiteurLink ?> > Le <?= $message->getDateCreationMessage() ?>
                            <?php if ($message->getDateModificationMessage() != null) {
                            ?>
                                - Modifié le <?= $message->getDateModificationMessage() ?>
                                <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <tr class="main-message">
                        <td>
                            <?= $message->getTexteMessage() ?>
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
    ?>

    <!-- Formulaire de réponse au sujet, uniquement s'il n'est pas verrouillé et qu'un visiteur est connecté et non banni-->
    <div class="form">
        <div class="form-head">Répondre</div>
        <?php
        if (App\Session::getUser()) {
            if (!App\Session::getUser()->isBanned()) {
                if (!$topic->getVerouilleSujet()) {
                ?>
                    <form action="index.php?ctrl=message&action=submitPost&id=<?= $topic->getId() ?>" method="post">
                        <label for="reponse">Répondre : *</label>
                        <textarea id="reponse" name="reponse" rows="5" required></textarea>
                        <button class="btn btn-form" type="submit" name="submit">Répondre</button>
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
</div>