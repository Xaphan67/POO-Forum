<?php

$user = $result["data"]['user'];
$messages = $result["data"]['posts'];
$nbMessages = $result["data"]['nbPosts']["nbPosts"];

?>

<h1>Profil de <?= $user->getPseudoVisiteur() ?></h1>

<p>Pseudo : <?= $user->getPseudoVisiteur() ?></p>
<p>Date d'inscription : <?= $user->getDateInscriptionVisiteur() ?></p>
<p>Rôle : <?= $user->getRoleVisiteur() ?></p>
<p>Messages : <?= $nbMessages ?></p>
<?php
    $avatarPath = "avatars/" . $user->getAvatarVisiteur();
    if (empty($avatarPath)) {
        $avatarPath = "avatar.png";
    }
?>
<img class="avatar-prf" src="<?= PUBLIC_DIR ?>/img/<?= $avatarPath ?>" alt="Avatar de <?= $user->getPseudoVisiteur() ?>" /><br>
<?php if (App\Session::getUser()) {
    if (App\Session::getUser()->getId() == $user->getId() || App\Session::isAdmin()) {
    ?>
        <button id="avatarEditBtn" onclick="showAvatarEditForm()" type="submit" name="edit">Modifier l'avatar</button>
        <div class="editForm" id="avatarForm">
            <form action="index.php?ctrl=visiteur&action=editAvatar&id=<?= $user->getId() ?>" method="post" enctype="multipart/form-data">
                <label for="avatar">Nouvel avatar : *</label>
                <input type="file" name="avatar" required>
                <button type="submit" name="submit">Modifier</button>
            </form>
            <button onclick="hideAvatarEditForm()" type="submit" name="cancel">Annuler</button>
        </div>
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
<script>
    // Affiche le formulaire d'edition de l'avatar
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