<?php

$user = $result["data"]['user'];
$messages = $result["data"]['posts'];
$nbMessages = $result["data"]['nbPosts']["nbPosts"];

?>

<!-- Fil d'ariane -->
<div class="ariane">
    <div class="arianePath">
        <a class="pathPart" href="index.php?ctrl=categorie&action=listCategories">
            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                <path d="M543.8 287.6c17 0 32-14 32-32.1c1-9-3-17-11-24L512 185V64c0-17.7-14.3-32-32-32H448c-17.7 0-32 14.3-32 32v36.7L309.5 7c-6-5-14-7-21-7s-15 1-22 8L10 231.5c-7 7-10 15-10 24c0 18 14 32.1 32 32.1h32v69.7c-.1 .9-.1 1.8-.1 2.8V472c0 22.1 17.9 40 40 40h16c1.2 0 2.4-.1 3.6-.2c1.5 .1 3 .2 4.5 .2H160h24c22.1 0 40-17.9 40-40V448 384c0-17.7 14.3-32 32-32h64c17.7 0 32 14.3 32 32v64 24c0 22.1 17.9 40 40 40h24 32.5c1.4 0 2.8 0 4.2-.1c1.1 .1 2.2 .1 3.3 .1h16c22.1 0 40-17.9 40-40V455.8c.3-2.6 .5-5.3 .5-8.1l-.7-160.2h32z" />
            </svg>
            Index du forum
        </a>
        <div class="pathPart">> Profil de <?= $user->getPseudoVisiteur() ?></div>
    </div>
</div>

<div class="main-content">
    <div class="prf-responsive">
        <div class="profil">
            <div class="prf-Infos">
                <img class="avatar-prf" src="<?= PUBLIC_DIR ?>/img/<?= "avatars/" . $user->getAvatarVisiteur() ?>" alt="Avatar de <?= $user->getPseudoVisiteur() ?>" /><br>
                <?= $user->getPseudoVisiteur() ?>
                <br>
                <?= $user->getRoleVisiteur() ?>
                <?php
                if (App\Session::getUser()) {
                    if (App\Session::getUser()->getId() == $user->getId()) {
                ?>
                        <br>
                        <?= $user->getEmailVisiteur() ?>
                <?php
                    }
                }
                ?>
                <div class="side-infos-black">
                    Messages : <?= $nbMessages ?>
                    <br>
                    Inscrit le : <?= $user->getDateInscriptionVisiteur() ?>
                </div>
            </div>
            <?php if (App\Session::getUser()) {
                if (App\Session::getUser()->getId() == $user->getId() || App\Session::isAdmin()) {
            ?>
                    <a class="btn btn-large" href="#editPseudo-Mod">Modifier mon pseudo</a>
                    <a class="btn btn-large" href="#editEmail-Mod">Modifier mon email</a>
                    <a class="btn btn-large" href="#editAvatar-Mod">Modifier mon avatar</a>
                <?php
                }
            }
            if (App\Session::getuser()) {
                if (App\Session::getUser()->getId() == $user->getId()) {
                ?>
                    <a class="btn btn-large" href="#editMdp-Mod">Modifier mon mot de passe</a>
                    <a class="btn btn-large" href="index.php?ctrl=visiteur&action=delete&id=<?= $user->getId() ?>">Me désinscrire</a>
            <?php
                }
            }
            ?>
            <div id="editPseudo-Mod" class="modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <header class="container">
                            <a href="#" class="closebtn">×</a>
                            <h3>Modifier le pseudonyme</h2>
                        </header>
                        <div class="container">
                            <form action="index.php?ctrl=visiteur&action=editPseudo&id=<?= $user->getId() ?>" method="post" enctype="multipart/form-data">
                                <label for="pseudo">Nouveau pseudo : *</label>
                                <input type="text" name="pseudo" required>
                                <button class="btn btn-form" type="submit" name="submit">Modifier</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="editEmail-Mod" class="modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <header class="container">
                            <a href="#" class="closebtn">×</a>
                            <h3>Modifier l'email</h2>
                        </header>
                        <div class="container">
                            <form action="index.php?ctrl=visiteur&action=editEmail&id=<?= $user->getId() ?>" method="post" enctype="multipart/form-data">
                                <label for="email">Nouvel email : *</label>
                                <input type="text" name="email" required>
                                <button class="btn btn-form" type="submit" name="submit">Modifier</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="editAvatar-Mod" class="modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <header class="container">
                            <a href="#" class="closebtn">×</a>
                            <h3>Modifier l'avatar</h2>
                        </header>
                        <div class="container">
                            <form action="index.php?ctrl=visiteur&action=editAvatar&id=<?= $user->getId() ?>" method="post" enctype="multipart/form-data">
                                <label for="avatar">Nouvel avatar : *</label>
                                <input type="file" name="avatar" required>
                                <button class="btn btn-form" type="submit" name="submit">Modifier</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="editMdp-Mod" class="modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <header class="container">
                            <a href="#" class="closebtn">×</a>
                            <h3>Modifier le mot de passe</h2>
                        </header>
                        <div class="container">
                            <form action="index.php?ctrl=visiteur&action=editMdp&id=<?= $user->getId() ?>" method="post" enctype="multipart/form-data">
                                <label for="oldMdp">Ancien mot de passe : *</label>
                                <input type="password" name="oldMdp" required>
                                <label for="newMdp">Nouveau mot de passe : *</label>
                                <input type="password" name="newMdp" required>
                                <label for="newMdpCheck">Confirmer le nouveau mot de passe : *</label>
                                <input type="password" name="newMdpCheck" required>
                                <button class="btn btn-form" type="submit" name="edit">Modifier</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="lastMsgs">
            <h2>Les derniers messages de <?= $user->getPseudoVisiteur() ?> :</h2>
            <?php
            if ($messages != null) {
            ?>
                <?php
                foreach ($messages as $message) {
                ?>
                    <div class="message-display message-display-prf">
                        <div class="side-msg">
                            <div class="top-infos prf-msgInfos">
                                <div class="prf-msgTopic">
                                    Sujet : <a href="index.php?ctrl=sujet&action=viewTopic&id=<?= $message->getSujet()->getId() ?>"><?= $message->getSujet()->getTitreSujet() ?></a>
                                </div>
                                <div class="msgUserInfos">
                                    <div>
                                        > Le <?= $message->getDateCreationMessage() ?>
                                    </div>
                                    <?php if ($message->getDateModificationMessage() != null) {
                                    ?>
                                        <div>
                                            - Modifié le <?= $message->getDateModificationMessage() ?>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="main-message">
                                <?= $message->getTexteMessage() ?>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>


            <?php
            } else {
            ?>
                <p>Aucun message !</p>
            <?php
            }
            ?>
        </div>
    </div>
</div>