<?php

$categories = $result["data"]['categories'];

?>

<!-- Fil d'ariane -->
<div class="ariane">
    <a href="index.php?ctrl=categorie&action=listCategories">
        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
            <path d="M543.8 287.6c17 0 32-14 32-32.1c1-9-3-17-11-24L512 185V64c0-17.7-14.3-32-32-32H448c-17.7 0-32 14.3-32 32v36.7L309.5 7c-6-5-14-7-21-7s-15 1-22 8L10 231.5c-7 7-10 15-10 24c0 18 14 32.1 32 32.1h32v69.7c-.1 .9-.1 1.8-.1 2.8V472c0 22.1 17.9 40 40 40h16c1.2 0 2.4-.1 3.6-.2c1.5 .1 3 .2 4.5 .2H160h24c22.1 0 40-17.9 40-40V448 384c0-17.7 14.3-32 32-32h64c17.7 0 32 14.3 32 32v64 24c0 22.1 17.9 40 40 40h24 32.5c1.4 0 2.8 0 4.2-.1c1.1 .1 2.2 .1 3.3 .1h16c22.1 0 40-17.9 40-40V455.8c.3-2.6 .5-5.3 .5-8.1l-.7-160.2h32z" />
        </svg>
        Index du forum
    </a>
</div>

<div class="main-content">
    <?php
    if ($categories != null) {
    ?>
        <table>
            <thead>
                <tr>
                    <th class="width60">Catégorie</th>
                    <th class="width10 cellCenter th-infos">Sujets</th>
                    <th class="width10 cellCenter th-infos">Réponses</th>
                    <th class="width20 th-infos">Dernier Message</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($categories as $category) {
                ?>
                    <tr>
                        <td>
                            <div class="table-cat">
                                <svg width="50px" height="50px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 8h12v1H6zm0 4h9v-1H6zm16-6.25v8.5A2.753 2.753 0 0 1 19.25 17h-7.087L6 21.481V17H4.75A2.753 2.753 0 0 1 2 14.25v-8.5A2.753 2.753 0 0 1 4.75 3h14.5A2.753 2.753 0 0 1 22 5.75zm-1 0A1.752 1.752 0 0 0 19.25 4H4.75A1.752 1.752 0 0 0 3 5.75v8.5A1.752 1.752 0 0 0 4.75 16H7v3.519L11.837 16h7.413A1.752 1.752 0 0 0 21 14.25z"/><path fill="none" d="M0 0h24v24H0z"/>
                                </svg>
                                <div>
                                    <a id="category<?= $category->getID() ?>" href="index.php?ctrl=categorie&action=listTopics&id=<?= $category->getId() ?>"><?= $category->getNomCategorie() ?></a>
                                    <?php if (App\Session::getUser() && App\Session::isAdmin()) {
                                    ?>
                                        <div class="editForm" id="editForm<?= $category->getID() ?>">
                                            <form action="index.php?ctrl=categorie&action=editCategory&id=<?= $category->getId() ?>" method="post">
                                                <input id="edit<?= $category->getId() ?>" name="edit<?= $category->getId() ?>" type="text" value="<?= $category->getNomCategorie() ?>" required></input>
                                                <button type="submit" name="edit">Valider</button>
                                            </form>
                                            <button onclick="showEditForm(<?= $category->getId() ?>)" type="submit" name="cancel">Annuler</button>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <br>
                                    <span id="categoryDesc<?= $category->getID() ?>" class="cat-description"><?= $category->getDescriptionCategorie() ?></span>
                                    <?php if (App\Session::getUser() && App\Session::isAdmin()) {
                                    ?>
                                        <div class="editForm" id="editDescForm<?= $category->getID() ?>">
                                            <form action="index.php?ctrl=categorie&action=editDescCategoryDesc&id=<?= $category->getId() ?>" method="post">
                                                <textarea id="editDesc<?= $category->getId() ?>" name="editDesc<?= $category->getId() ?>" rows="2"><?= $category->getDescriptionCategorie() ?></textarea>
                                                <button type="submit" name="editDesc">Valider</button>
                                            </form>
                                            <button onclick="showEditDescForm(<?= $category->getId() ?>)" type="submit" name="cancel">Annuler</button>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <?php if (App\Session::getUser() && App\Session::isAdmin()) {
                                ?>
                                <div class="actions">
                                    <button class="btn" id="editBtn<?= $category->getID() ?>" onclick="showEditForm(<?= $category->getId() ?>)" type="submit" name="edit" title="Modifier le nom de la catégorie">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="1.9em" viewBox="0 0 448 512">
                                            <path d="M0 80V229.5c0 17 6.7 33.3 18.7 45.3l176 176c25 25 65.5 25 90.5 0L418.7 317.3c25-25 25-65.5 0-90.5l-176-176c-12-12-28.3-18.7-45.3-18.7H48C21.5 32 0 53.5 0 80zm112 32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/>
                                        </svg>
                                    </button>
                                    <button class="btn" id="editDescBtn<?= $category->getID() ?>" onclick="showEditDescForm(<?= $category->getId() ?>)" type="submit" name="edit" title="Modifier la description de la catégorie">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="1.7em" viewBox="0 0 512 512">
                                            <path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/>
                                        </svg>
                                    </button>
                                    <a class="btn" href="index.php?ctrl=categorie&action=deleteCategory&id=<?= $category->getID() ?>" title="Supprimer la catégorie">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" viewBox="0 0 448 512">
                                            <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                                        </svg>
                                    </a>
                                </div>
                                <?php
                                }
                                ?>
                            </div>
                        </td>
                        <td class="cellCenter"><?= $category->getNbSujets() ?></td> <!-- Nombre de sujets de la catégorie -->
                        <td class="cellCenter"><?= $category->getNbMessages() - $category->getNbSujets() ?></td> <!-- Nombre de messages - nombres de sujets pour obtenir uniquement le nombre de réponses -->
                        <td><?php if ($category->getDateMessageRecent() == null) {
                            ?>
                                Aucun message
                            <?php
                            } else {
                            ?>
                                Par
                                <?php
                                if ($category->getRoleVisiteurRecent() != "ROLE_DELETED") {
                                ?>
                                    <a href="index.php?ctrl=visiteur&action=viewProfile&id=<?= $category->getIdVisiteurRecent() ?>"><?= $category->getPseudoVisiteurRecent() ?></a>
                                <?php
                                } else {
                                ?>
                                    <?= $category->getPseudoVisiteurRecent() ?>
                                <?php
                                }
                                ?>
                                <br>Le <?= $category->getDateMessageRecent() ?>
                            <?php
                            }
                            ?>
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
        <p>Aucune catégorie !</p>
    <?php
    }

    if (App\Session::getUser() && App\Session::isAdmin()) {
    ?>
        <p>Créer une nouvelle catégorie :</p>
        <form action="index.php?ctrl=categorie&action=listCategories" method="post">
            <label for="nom">Nom de la catégorie : *</label>
            <input type=text name="nom" required>
            <label for="description">Description :</label>
            <textarea id="description" name="description" rows="5"></textarea>
            <button type="submit" name="submit">Créer</button>
        </form>
    <?php
    }
    ?>
</div>

<script>
    // Affiche le formulaire d'edition du nom d'une catégorie
    function showEditForm(id, cancel = false) {
        const category = document.querySelector("#category" + id);
        const editForm = document.querySelector("#editForm" + id);
        const editBtn = document.querySelector("#editBtn" + id);
        if (category.style.display != "none" && !cancel) {
            category.style.display = "none";
            editForm.style.display = "unset";
            editBtn.style.display = "none";
        } else {
            category.style.display = "unset";
            editForm.style.display = "none";
            editBtn.style.display = "unset";
        }
    }

    // Affiche le formulaire d'edition de la description d'une catégorie
    function showEditDescForm(id, cancel = false) {
        const categoryDesc = document.querySelector("#categoryDesc" + id);
        const editDescForm = document.querySelector("#editDescForm" + id);
        const editDescBtn = document.querySelector("#editDescBtn" + id);
        if (categoryDesc.style.display != "none" && !cancel) {
            categoryDesc.style.display = "none";
            editDescForm.style.display = "unset";
            editDescBtn.style.display = "none";
        } else {
            categoryDesc.style.display = "unset";
            editDescForm.style.display = "none";
            editDescBtn.style.display = "unset";
        }
    }
</script>