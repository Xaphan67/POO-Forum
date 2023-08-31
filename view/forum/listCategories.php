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
                    <td><a href="index.php?ctrl=forum&action=listTopics&id=<?= $category->getId() ?>"><?= $category->getNomCategorie() ?></a></td>
                    <td class="cellCenter"><?= $category->getNbSujets() ?></td> <!-- Nombre de sujets de la catégorie -->
                    <td class="cellCenter"><?= $category->getNbMessages() - $category->getNbSujets() ?></td> <!-- Nombre de messages - nombres de sujets pour obtenir uniquement le nombre de réponses -->
                    <td><?= $category->getDateMessageRecent() == null ? "Aucun message" : $category->getDateMessageRecent() ?></td>
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
    <form action="index.php?ctrl=forum&action=listCategories" method="post">
        <label for="nom">Nom de la catégorie : *</label>
        <input type=text name="nom" required>
        <button type="submit" name="submit">Créer</button>
    </form>
<?php
}
?>
