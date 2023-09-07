<?php

$users = $result["data"]['users'];

?>

<h1>Gestion des utilisateurs</h1>

<table>
    <thead>
        <tr>
            <th class="width20">Pseudo</th>
            <th class="width20">Date d'inscription</th>
            <th class="width30">Rôle</th>
            <th class="width30">Banissement</th>
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
                        <form class ="editForm" id="editForm<?= $user->getId() ?>" action="index.php?ctrl=visiteur&action=editRole&id=<?= $user->getId() ?>" method="post">
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
                        if ($user->getRoleVisiteur() != "Administrateur")
                        {
                            if ($user->getDateBanissementVisiteur() < $today)
                            {
                                ?>
                                <button id="banBtn<?= $user->getId() ?>" onclick="showBanForm(<?= $user->getId() ?>)" type="submit" name="ban">Bannir</button>
                                <form class ="editForm" id="banForm<?= $user->getId() ?>" action="index.php?ctrl=visiteur&action=ban&id=<?= $user->getId() ?>" method="post">
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
<script>
    // Affiche le formulaire d'edition du titre du rôle
    function showRoleEditForm(id) {
        const role = document.querySelector("#role" + id);
        const editForm = document.querySelector("#editForm" + id);
        if (role.style.display != "none") 
        {
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
        if (banBtn.style.display != "none") 
        {
            banBtn.style.display = "none";
            banForm.style.display = "unset";
        } else {
            banBtn.style.display = "unset";
            banForm.style.display = "none";
        }
    }
</script>