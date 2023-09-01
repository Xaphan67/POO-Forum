<?php

$users = $result["data"]['users'];

?>

<h1>Liste des utilisateurs</h1>

<table>
    <thead>
        <tr>
            <th class="width60">Pseudo</th>
            <th class="width20">Date d'inscription</th>
            <th class="width20">Rôle</th>
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
                    <?= $role ?>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>