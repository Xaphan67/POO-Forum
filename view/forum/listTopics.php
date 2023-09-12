<?php

$category = $result["data"]['category'];
$topics = $result["data"]['topics'];

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
    <div><?= $category->getNomCategorie() ?></div>
</div>

<div class="main-content">
    <?php
    if ($topics != null) {
    ?>
        <table>
            <thead>
                <tr>
                    <th class="width50">Sujet</th>
                    <th class="width20 th-infos">Auteur</th>
                    <th class="width10 cellCenter th-infos">Réponses</th>
                    <th class="width20 th-infos ">Dernier Message</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($topics as $topic) {
                ?>
                    <tr>
                        <td> <!-- Lien vers le sujet, avec icône de cadenas si le sujet est verrouillé -->
                            <div class="topicName">
                                <div class="topicIcon">
                                    <svg width="50px" height="50px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6 8h12v1H6zm0 4h9v-1H6zm16-6.25v8.5A2.753 2.753 0 0 1 19.25 17h-7.087L6 21.481V17H4.75A2.753 2.753 0 0 1 2 14.25v-8.5A2.753 2.753 0 0 1 4.75 3h14.5A2.753 2.753 0 0 1 22 5.75zm-1 0A1.752 1.752 0 0 0 19.25 4H4.75A1.752 1.752 0 0 0 3 5.75v8.5A1.752 1.752 0 0 0 4.75 16H7v3.519L11.837 16h7.413A1.752 1.752 0 0 0 21 14.25z"/><path fill="none" d="M0 0h24v24H0z"/>
                                    </svg>
                                    <?php
                                    if ($topic->getVerouilleSujet()) {
                                    ?>
                                        <svg class="lock" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                                            <path d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z" />
                                        </svg>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <a href="index.php?ctrl=sujet&action=viewTopic&id=<?= $topic->getId() ?>"><?= $topic->getTitreSujet() ?></a>
                            </div>
                            <div class="esponsive-msg">
                                Dernier message par
                                <?php
                                if ($topic->getRoleVisiteurRecent() != "ROLE_DELETED") {
                                ?>
                                    <a href="index.php?ctrl=visiteur&action=viewProfile&id=<?= $topic->getIdVisiteurRecent() ?>"><?= $topic->getPseudoVisiteurRecent() ?></a>
                                <?php
                                } else {
                                ?>
                                    <?= $topic->getPseudoVisiteurRecent() ?>
                                <?php
                                }
                                ?>
                                <br>Le <?= $topic->getDateMessageRecent() ?>
                                <br>
                                Réponses : <?= max(0, $topic->getNbMessages() - 1) ?>
                            </div>
                        </td>
                        <td class="responsive-table-hide">
                            <div class="visiteur-display">
                                <figure>
                                    <img class="avatar-msg" src="<?= PUBLIC_DIR ?>/img/<?= "avatars/" . $topic->getVisiteur()->getAvatarVisiteur() ?>" alt="Avatar de <?= $topic->getVisiteur() ?>" />
                                </figure>
                                <?php
                                if ($topic->getVisiteur()->getRoleVisiteur() != "ROLE_DELETED") {
                                ?>
                                    <a href="index.php?ctrl=visiteur&action=viewProfile&id=<?= $topic->getVisiteur()->getId() ?>"><?= $topic->getVisiteur() ?></a>
                                <?php
                                } else {
                                ?>
                                    <?= $topic->getVisiteur() ?>
                                <?php
                                }
                                ?>
                            </div>
                        </td>
                        <td class="cellCenter responsive-table-hide"><?= max(0, $topic->getNbMessages() - 1) ?></td> <!-- Nombre de messages dans le sujet, -1 pour ne compter que les réponses -->
                        <td class="responsive-table-hide">Par
                            <?php
                            if ($topic->getRoleVisiteurRecent() != "ROLE_DELETED") {
                            ?>
                                <a href="index.php?ctrl=visiteur&action=viewProfile&id=<?= $topic->getIdVisiteurRecent() ?>"><?= $topic->getPseudoVisiteurRecent() ?></a>
                            <?php
                            } else {
                            ?>
                                <?= $topic->getPseudoVisiteurRecent() ?>
                            <?php
                            }
                            ?>
                            <br>Le <?= $topic->getDateMessageRecent() ?>
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
        <p>Aucun sujet !</p>
        <?php
    }
    ?>


     <!--Formulaire de création d'un nouveau sujet, uniquement si un visiteur est connecté et non banni-->
    <div class="form">
        <div class="form-head">Créer un nouveau sujet</div>
        <?php
        if (App\Session::getUser()) {
            if (!App\Session::getUser()->isBanned()) {
            ?>
            <form action="index.php?ctrl=sujet&action=newTopic&id=<?= $category->getId() ?>" method="post">
                <label for="nom">Nom du sujet : *</label>
                <input type=text id="nom" name="nom" required>
                <label for="message">Message : *</label>
                <textarea id="message" name="message" rows="5" required></textarea>
                <button class="btn btn-form" type="submit" name="submit">Créer un sujet</button>
            </form>
            <?php
            } else {
            ?>
                <p>Vous ne pouvez pas poster un nouveau message car vous êtes banni jusqu'au <?= App\Session::getUser()->getDateBanissementVisiteur()->format("d/m/Y") ?></p>
            <?php
            }
        } else {
        ?>
        <p>Connectez vous pour pouvoir poster un nouveau sujet</p>
    <?php
    }
    ?>
    </div>
</div>