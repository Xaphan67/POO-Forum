<?php

$users = $result["data"]['users'];

?>

<h1>Gestion des utilisateurs</h1>

<table>
    <thead>
        <tr>
            <th class="width50">Pseudo</th>
            <th class="width20">Date d'inscription</th>
            <th class="width30">Rôle</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($users as $user) {
        ?>
            <tr>
                <td><a href="index.php?ctrl=visiteur&action=viewProfile&id=<?= $user->getId() ?>"><?= $user->getPseudoVisiteur() ?></a></td>
                <td><?= $user->getDateInscriptionVisiteur() ?></td>
                <td>
                <?php 
                    $role = $user->getRoleVisiteur();
                    if (str_contains($role, "ADMIN"))
                    {
                        $role = "Administrateur";
                    } else if (str_contains($role, "MODERATOR")) {
                        $role = "Modérateur";
                    } else {
                        $role = "Membre";
                    } ?>
                    <div id="role<?= $user->getId() ?>">
                        <?= $role ?>
                        <button onclick="showRoleEditForm(<?= $user->getId() ?>)" type="submit" name="edit">Modifier</button>
                    </div>
                    <form class ="editForm" id="editForm<?= $user->getId() ?>" action="index.php?ctrl=visiteur&action=editRole&id=<?= $user->getId() ?>" method="post">
                        <select id="edit<?= $user->getId() ?>" name="edit<?= $user->getId() ?>" required>
                            <option value="">Veuillez sélectionner un rôle</option>
                            <option value="ROLE_ADMIN" <?= $role = "Administrateur" ? "selected" : "" ?>>Administrateur</option>
                            <option value="ROLE_MODERATOR" <?= $role = "Modérateur" ? "selected" : "" ?>>Modérateur</option>
                            <option value="ROLE_MEMBER" <?= $role = "Membre" ? "selected" : "" ?>>Membre</option>
                        </select>
                        <button type="submit" name="edit">Modifier</button>
                    </form>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<script>
    // Affiche le formulaire d'edition du titre du sujet
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
</script>