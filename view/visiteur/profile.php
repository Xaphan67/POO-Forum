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
    <div>
        Pseudo : <?= $user->getPseudoVisiteur() ?>
        <?php if (App\Session::getUser()) {
            if (App\Session::getUser()->getId() == $user->getId() || App\Session::isAdmin()) {
        ?>
                <button id="pseudoEditBtn" onclick="showPseudoEditForm()" type="submit" name="edit">Modifier mon pseudo</button>
                <div class="editForm" id="pseudoForm">
                    <form action="index.php?ctrl=visiteur&action=editPseudo&id=<?= $user->getId() ?>" method="post" enctype="multipart/form-data">
                        <label for="pseudo">Nouveau pseudo : *</label>
                        <input type="text" name="pseudo" required>
                        <button type="submit" name="submit">Modifier</button>
                    </form>
                    <button onclick="hidePseudoEditForm()" type="submit" name="cancel">Annuler</button>
                </div>
        <?php
            }
        }
        ?>
    </div>
    <?php
    if (App\Session::getUser()) {
        if (App\Session::getUser()->getId() == $user->getId()) {
    ?>
            <div>
                Email : <?= $user->getEmailVisiteur() ?>
                <button id="emailEditBtn" onclick="showEmailEditForm()" type="submit" name="edit">Modifier mon email</button>
                <div class="editForm" id="emailForm">
                    <form action="index.php?ctrl=visiteur&action=editEmail&id=<?= $user->getId() ?>" method="post" enctype="multipart/form-data">
                        <label for="email">Nouvel email : *</label>
                        <input type="text" name="email" required>
                        <button type="submit" name="submit">Modifier</button>
                    </form>
                    <button onclick="hideEmailEditForm()" type="submit" name="cancel">Annuler</button>
                </div>
            </div>
    <?php
        }
    }
    ?>
    <?php
    if (App\Session::getuser()) {
        if (App\Session::getUser()->getId() == $user->getId()) {
    ?>
            <button id="mdpEditBtn" onclick="showMdpEditForm()" type="submit" name="edit">Modifier mon mot de passe</button>
            <div class="editForm" id="mdpForm">
                <form action="index.php?ctrl=visiteur&action=editMdp&id=<?= $user->getId() ?>" method="post" enctype="multipart/form-data">
                    <label for="oldMdp">Ancien mot de passe : *</label>
                    <input type="password" name="oldMdp" required>
                    <label for="newMdp">Nouveau mot de passe : *</label>
                    <input type="password" name="newMdp" required>
                    <label for="newMdpCheck">Confirmer le nouveau mot de passe : *</label>
                    <input type="password" name="newMdpCheck" required>
                    <button type="submit" name="submit">Modifier</button>
                </form>
                <button onclick="hideMdpEditForm()" type="submit" name="cancel">Annuler</button>
            </div>
    <?php
        }
    }
    ?>
    <div>Date d'inscription : <?= $user->getDateInscriptionVisiteur() ?></div>
    <div>Rôle : <?= $user->getRoleVisiteur() ?></div>
    <div>Messages : <?= $nbMessages ?></div>
    <img class="avatar-prf" src="<?= PUBLIC_DIR ?>/img/<?= "avatars/" . $user->getAvatarVisiteur() ?>" alt="Avatar de <?= $user->getPseudoVisiteur() ?>" /><br>
    <?php if (App\Session::getUser()) {
        if (App\Session::getUser()->getId() == $user->getId() || App\Session::isAdmin()) {
    ?>
            <button id="avatarEditBtn" onclick="showAvatarEditForm()" type="submit" name="edit">Modifier mon avatar</button>
            <div class="editForm" id="avatarForm">
                <form action="index.php?ctrl=visiteur&action=editAvatar&id=<?= $user->getId() ?>" method="post" enctype="multipart/form-data">
                    <label for="avatar">Nouvel avatar : *</label>
                    <input type="file" name="avatar" required>
                    <button type="submit" name="submit">Modifier</button>
                </form>
                <button onclick="hideAvatarEditForm()" type="submit" name="cancel">Annuler</button>
            </div>
            <a href="index.php?ctrl=visiteur&action=delete&id=<?= $user->getId() ?>">Me désinscrire</a>
    <?php
        }
    }
    ?>
    <h2>Les derniers messages de <?= $user->getPseudoVisiteur() ?>:</h2>
    <?php
    if ($messages != null) {
    ?>
        <table>
            <tbody>
                <?php
                foreach ($messages as $message) {
                ?>
                    <tr>
                        <td><a href="index.php?ctrl=visiteur&action=viewProfile&id=<?= $message->getVisiteur()->getId() ?>"><?= $message->getVisiteur() ?></a></td>
                        <td>Sujet : <a href="index.php?ctrl=sujet&action=viewTopic&id=<?= $message->getSujet()->getId() ?>"><?= $message->getSujet()->getTitreSujet() ?></a></td>
                    </tr>
                    <tr class="main-message">
                        <td>
                            Créé le <?= $message->getDateCreationMessage() ?><br>
                            <?php if ($message->getDateModificationMessage() != null) {
                            ?>
                                Modifié le <?= $message->getDateModificationMessage() ?>
                            <?php
                            }
                            ?>
                        </td>
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
    ?>

</div>

<script>
    // Edition du pseudo
    function showPseudoEditForm() {
        const pseudoEditBtn = document.querySelector("#pseudoEditBtn");
        const pseudoForm = document.querySelector("#pseudoForm");
        pseudoForm.style.display = "unset";
        pseudoEditBtn.style.display = "none";
    }

    function hidePseudoEditForm() {
        const pseudoEditBtn = document.querySelector("#pseudoEditBtn");
        const pseudoForm = document.querySelector("#pseudoForm");
        pseudoForm.style.display = "none";
        pseudoEditBtn.style.display = "unset";
    }

    // Edition de l'email
    function showEmailEditForm() {
        const emailEditBtn = document.querySelector("#emailEditBtn");
        const emailForm = document.querySelector("#emailForm");
        emailForm.style.display = "unset";
        emailEditBtn.style.display = "none";
    }

    function hideEmailEditForm() {
        const emailEditBtn = document.querySelector("#emailEditBtn");
        const emailForm = document.querySelector("#emailForm");
        emailForm.style.display = "none";
        emailEditBtn.style.display = "unset";
    }

    // Edition du motde passe
    function showMdpEditForm() {
        const mdpEditBtn = document.querySelector("#mdpEditBtn");
        const mdpForm = document.querySelector("#mdpForm");
        mdpForm.style.display = "unset";
        mdpEditBtn.style.display = "none";
    }

    function hideMdpEditForm() {
        const mdpEditBtn = document.querySelector("#mdpEditBtn");
        const mdpForm = document.querySelector("#mdpForm");
        mdpForm.style.display = "none";
        mdpEditBtn.style.display = "unset";
    }

    // Edition de l'avatar
    function showAvatarEditForm() {
        const avatarEditBtn = document.querySelector("#avatarEditBtn");
        const avatarForm = document.querySelector("#avatarForm");
        avatarForm.style.display = "unset";
        avatarEditBtn.style.display = "none";
    }

    function hideAvatarEditForm() {
        const avatarEditBtn = document.querySelector("#avatarEditBtn");
        const avatarForm = document.querySelector("#avatarForm");
        avatarForm.style.display = "none";
        avatarEditBtn.style.display = "unset";
    }
</script>