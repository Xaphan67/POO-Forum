<?php

$users = $result["data"]['users'];

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
    <div>Gestion des utilisateurs</div>
</div>

<div class="main-content">
    <table>
        <thead>
            <tr>
                <th class="width20">Pseudo</th>
                <th class="width20 th-infos">Date d'inscription</th>
                <th class="width30 th-infos">Rôle</th>
                <th class="width30 th-infos">Banissement</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $today = new DateTime();
            foreach ($users as $user) {
                if ($user->getRoleVisiteur() != "ROLE_DELETED") {
            ?>
                    <tr>
                        <td class="no-padding">
                            <div class="visiteur-display">
                                <figure>
                                    <img class="avatar-msg" src="<?= PUBLIC_DIR ?>/img/<?= "avatars/" . $user->getAvatarVisiteur() ?>" alt="Avatar de <?= $user ?>" />
                                </figure>
                                <a href="index.php?ctrl=visiteur&action=viewProfile&id=<?= $user->getId() ?>"><?= $user ?></a>
                            </div>
                        </td>
                        <td><?= $user->getDateInscriptionVisiteur() ?></td>
                        <td>
                            <div id="role<?= $user->getId() ?>">
                                <?= $user->getRoleVisiteur() ?>
                                <button onclick="showRoleEditForm(<?= $user->getId() ?>)" type="submit" name="edit">Modifier</button>
                            </div>
                            <form class="editForm" id="editForm<?= $user->getId() ?>" action="index.php?ctrl=visiteur&action=editRole&id=<?= $user->getId() ?>" method="post">
                                <select id="edit<?= $user->getId() ?>" name="edit<?= $user->getId() ?>" required>
                                    <option value="">Veuillez sélectionner un rôle</option>
                                    <option value="ROLE_ADMIN" <?= $user->getRoleVisiteur() == "Administrateur" ? "selected" : "" ?>>Administrateur</option>
                                    <option value="ROLE_MODERATOR" <?= $user->getRoleVisiteur() == "Modérateur" ? "selected" : "" ?>>Modérateur</option>
                                    <option value="ROLE_MEMBER" <?= $user->getRoleVisiteur() == "Membre" ? "selected" : "" ?>>Membre</option>
                                </select>
                                <button type="submit" name="edit">Modifier</button>
                            </form>
                        </td>
                        <td>
                            <?php
                            if ($user->getRoleVisiteur() != "Administrateur") {
                                if ($user->getDateBanissementVisiteur() < $today) {
                            ?>
                                    <button id="banBtn<?= $user->getId() ?>" onclick="showBanForm(<?= $user->getId() ?>)" type="submit" name="ban">Bannir</button>
                                    <form class="editForm" id="banForm<?= $user->getId() ?>" action="index.php?ctrl=visiteur&action=ban&id=<?= $user->getId() ?>" method="post">
                                        <input id="ban<?= $user->getId() ?>" name="ban<?= $user->getId() ?>" type="date" required></input>
                                        <button type="submit" name="ban">Bannir</button>
                                    </form>
                                <?php
                                } else {
                                ?>
                                    Banni jusqu'au <?= $user->getDateBanissementVisiteur()->format("d/m/Y, H:i:s") ?> <a href="index.php?ctrl=visiteur&action=unban&id=<?= $user->getID() ?>">Débannir</a>
                                <?php
                                }
                            } else {
                                ?>
                                -
                            <?php
                            }
                            ?>
                        </td>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    // Affiche le formulaire d'edition du titre du rôle
    function showRoleEditForm(id) {
        const role = document.querySelector("#role" + id);
        const editForm = document.querySelector("#editForm" + id);
        if (role.style.display != "none") {
            role.style.display = "none";
            editForm.style.display = "unset";
        } else {
            role.style.display = "unset";
            editForm.style.display = "none";
        }
    }

    // Affiche le forumulaire de banissement
    function showBanForm(id) {
        const banBtn = document.querySelector("#banBtn" + id);
        const banForm = document.querySelector("#banForm" + id);
        if (banBtn.style.display != "none") {
            banBtn.style.display = "none";
            banForm.style.display = "unset";
        } else {
            banBtn.style.display = "unset";
            banForm.style.display = "none";
        }
    }
</script>