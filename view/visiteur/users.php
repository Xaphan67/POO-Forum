<?php

$users = $result["data"]['users'];

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
        <div class="pathPart">> Gestion des utilisateurs</div>
    </div>
</div>

<div class="main-content">
    <table>
        <thead>
            <tr>
                <th class="width20">Pseudo</th>
                <th class="width20 th-infos responsive-table-hide">Inscription</th>
                <th class="width30 th-infos">Rôle</th>
                <th class="width30 th-infos">Bannissement</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $today = new DateTime();
            foreach ($users as $user) {
                if ($user->getRoleVisiteur() != "ROLE_DELETED") {
            ?>
                    <tr>
                        <td>
                            <div class="visiteur-display">
                                <figure>
                                    <img class="avatar-msg" src="<?= PUBLIC_DIR ?>/img/<?= "avatars/" . $user->getAvatarVisiteur() ?>" alt="Avatar de <?= $user ?>" />
                                </figure>
                                <a href="index.php?ctrl=visiteur&action=viewProfile&id=<?= $user->getId() ?>"><?= $user ?></a>
                            </div>
                        </td>
                        <td class="responsive-table-hide">
                            <?= $user->getDateInscriptionVisiteur() ?>
                        </td>
                        <td>
                            <div class="roleForm" id="role<?= $user->getId() ?>">
                                <?= $user->getRoleVisiteur() ?>
                                <a class="btn" href="#role<?= $user->getId() ?>-Mod" title="Modifier le rôle">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" viewBox="0 0 512 512">
                                        <path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z" />
                                    </svg>
                                </a>
                            </div>
                            <div id="role<?= $user->getId() ?>-Mod" class="modal">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <header class="container">
                                            <a href="#" class="closebtn">×</a>
                                            <h3>Modifier le rôle</h2>
                                        </header>
                                        <div class="container">
                                            <p>Sélectionnee le nouveau rôle pour cet utilisateur</p>
                                            <form action="index.php?ctrl=visiteur&action=editRole&id=<?= $user->getId() ?>" method="post">
                                                <label for="edit<?= $user->getId() ?>">Rôle : *</label>
                                                <select id="edit<?= $user->getId() ?>" name="edit<?= $user->getId() ?>" required>
                                                    <option value="">Veuillez sélectionner un rôle</option>
                                                    <option value="ROLE_ADMIN" <?= $user->getRoleVisiteur() == "Administrateur" ? "selected" : "" ?>>Administrateur</option>
                                                    <option value="ROLE_MODERATOR" <?= $user->getRoleVisiteur() == "Modérateur" ? "selected" : "" ?>>Modérateur</option>
                                                    <option value="ROLE_MEMBER" <?= $user->getRoleVisiteur() == "Membre" ? "selected" : "" ?>>Membre</option>
                                                </select>
                                                <button class="btn btn-form" type="submit" name="edit">Modifier</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="cellCenter-responsive">
                            <?php
                            if ($user->getRoleVisiteur() != "Administrateur") {
                                if ($user->getDateBanissementVisiteur() < $today) {
                            ?>
                                    <a class="btn btn-form responsive-hide" id="banBtn<?= $user->getId() ?>" href="#ban<?= $user->getId() ?>-Mod">Bannir</a>
                                    <a class="btn responsive-show" id="banBtn<?= $user->getId() ?>" href="#ban<?= $user->getId() ?>-Mod" title="Bannir l'utilisateur">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" viewBox="0 0 512 512">
                                            <path d="M318.6 9.4c-12.5-12.5-32.8-12.5-45.3 0l-120 120c-12.5 12.5-12.5 32.8 0 45.3l16 16c12.5 12.5 32.8 12.5 45.3 0l4-4L325.4 293.4l-4 4c-12.5 12.5-12.5 32.8 0 45.3l16 16c12.5 12.5 32.8 12.5 45.3 0l120-120c12.5-12.5 12.5-32.8 0-45.3l-16-16c-12.5-12.5-32.8-12.5-45.3 0l-4 4L330.6 74.6l4-4c12.5-12.5 12.5-32.8 0-45.3l-16-16zm-152 288c-12.5-12.5-32.8-12.5-45.3 0l-112 112c-12.5 12.5-12.5 32.8 0 45.3l48 48c12.5 12.5 32.8 12.5 45.3 0l112-112c12.5-12.5 12.5-32.8 0-45.3l-1.4-1.4L272 285.3 226.7 240 168 298.7l-1.4-1.4z" />
                                        </svg>
                                    </a>
                                    <div id="ban<?= $user->getId() ?>-Mod" class="modal">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <header class="container">
                                                    <a href="#" class="closebtn">×</a>
                                                    <h3>Bannir l'utilisateur</h2>
                                                </header>
                                                <div class="container">
                                                    <p>Sélectionnee la date de fin du bannissement de cet utilisateur</p>
                                                    <form action="index.php?ctrl=visiteur&action=ban&id=<?= $user->getId() ?>" method="post">
                                                        <label for="ban<?= $user->getId() ?>">Date : *</label>
                                                        <input id="ban<?= $user->getId() ?>" name="ban<?= $user->getId() ?>" type="date" required></input>
                                                        <button class="btn btn-form" type="submit" name="ban">Bannir</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div class="responsive-hide ban">
                                        Banni jusqu'au <?= $user->getDateBanissementVisiteur()->format("d/m/Y") ?> <a class="btn btn-small" href="index.php?ctrl=visiteur&action=unban&id=<?= $user->getID() ?>">Débannir</a>
                                    </div>
                                    <div class="responsive-show">
                                        <a class="btn" href="index.php?ctrl=visiteur&action=unban&id=<?= $user->getID() ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="1.4em" viewBox="0 0 384 512">
                                                <path d="M214.6 41.4c-12.5-12.5-32.8-12.5-45.3 0l-160 160c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 141.2V448c0 17.7 14.3 32 32 32s32-14.3 32-32V141.2L329.4 246.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-160-160z" />
                                            </svg>
                                        </a>
                                    </div>
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