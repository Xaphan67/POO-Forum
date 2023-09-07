<?php

$user = $result["data"]['user'];
$messages = $result["data"]['posts'];
$nbMessages = $result["data"]['nbPosts']["nbPosts"];

?>

<h1>Profil de <?= $user->getPseudoVisiteur() ?></h1>

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
}
else
{
?>
    <p>Aucun message !</p>
<?php
}
?>
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