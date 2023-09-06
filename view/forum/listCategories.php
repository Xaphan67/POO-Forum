<?php

$categories = $result["data"]['categories'];

?>

<h1>Forum PHP</h1>

<?php
if ($categories != null) {
?>
    <table>
        <thead>
            <tr>
                <th class="width60">Catégorie</th>
                <th class="width10 cellCenter">Sujets</th>
                <th class="width10 cellCenter">Réponses</th>
                <th class="width20">Dernier Message</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($categories as $category) {
            ?>
                <tr>
                    <td>
                        <a id="category<?= $category->getID() ?>" href="index.php?ctrl=categorie&action=listTopics&id=<?= $category->getId() ?>"><?= $category->getNomCategorie() ?></a>
                        <?php if (App\Session::getUser() && App\Session::isAdmin())
                        {
                        ?>
                            <div class="editForm" id="editForm<?= $category->getID() ?>">
                                <form action="index.php?ctrl=categorie&action=editCategory&id=<?= $category->getId() ?>" method="post">
                                    <input id="edit<?= $category->getId() ?>" name="edit<?= $category->getId() ?>" type="text" value="<?= $category->getNomCategorie() ?>" required></input>
                                    <button type="submit" name="edit">Valider</button>
                                </form>
                                <button onclick="showEditForm(<?= $category->getId() ?>)" type="submit" name="cancel">Annuler</button>
                            </div>
                        <button id="editBtn<?= $category->getID() ?>" onclick="showEditForm(<?= $category->getId() ?>)" type="submit" name="edit">Modifier</button>
                        <a href="index.php?ctrl=categorie&action=deleteCategory&id=<?= $category->getID() ?>">Supprimer</a>
                        <?php
                        }
                        ?>
                        <br>
                        <span id="categoryDesc<?= $category->getID() ?>"><?= $category->getDescriptionCategorie() ?></span>
                        <?php if (App\Session::getUser() && App\Session::isAdmin())
                        {
                        ?>
                            <div class="editForm" id="editDescForm<?= $category->getID() ?>">
                                <form action="index.php?ctrl=categorie&action=editDescCategoryDesc&id=<?= $category->getId() ?>" method="post">
                                    <textarea id="editDesc<?= $category->getId() ?>" name="editDesc<?= $category->getId() ?>" rows="2"><?= $category->getDescriptionCategorie() ?></textarea>
                                    <button type="submit" name="editDesc">Valider</button>
                                </form>
                                <button onclick="showEditDescForm(<?= $category->getId() ?>)" type="submit" name="cancel">Annuler</button>
                            </div>
                        <button id="editDescBtn<?= $category->getID() ?>" onclick="showEditDescForm(<?= $category->getId() ?>)" type="submit" name="edit"><?= empty($category->getDescriptionCategorie()) ? "Ajouter une description" : "Modifier" ?></button>
                        <?php
                        }
                        ?>
                    </td>
                    <td class="cellCenter"><?= $category->getNbSujets() ?></td> <!-- Nombre de sujets de la catégorie -->
                    <td class="cellCenter"><?= $category->getNbMessages() - $category->getNbSujets() ?></td> <!-- Nombre de messages - nombres de sujets pour obtenir uniquement le nombre de réponses -->
                    <td><?php if ($category->getDateMessageRecent() == null) {
                        ?>
                            Aucun message
                        <?php
                        } else {
                        ?>
                            Par <a href="index.php?ctrl=visiteur&action=viewProfile&id=<?= $category->getIdVisiteurRecent() ?>"><?= $category->getPseudoVisiteurRecent() ?></a><br>Le <?= $category->getDateMessageRecent() ?>
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
<script>
    // Affiche le formulaire d'edition du nom d'une catégorie
    function showEditForm(id, cancel = false) {
        const category = document.querySelector("#category" + id);
        const editForm = document.querySelector("#editForm" + id);
        const editBtn = document.querySelector("#editBtn" + id);
        if (category.style.display != "none" && !cancel) 
        {
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
        if (categoryDesc.style.display != "none" && !cancel) 
        {
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
