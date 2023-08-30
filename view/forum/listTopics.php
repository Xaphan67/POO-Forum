<?php

$category = $result["data"]['category'];
$topics = $result["data"]['topics'];

?>

<h1><a href="index.php?ctrl=forum&action=listCategories">Forum PHP</a> > <?= $category->getNomCategorie() ?></h1>

<?php
if ($topics != null) {
?>
    <table>
        <thead>
            <tr>
                <th class="width50">Sujet</th>
                <th class="width20">Auteur</th>
                <th class="width10 cellCenter">Réponses</th>
                <th class="width20">Dernier Message</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($topics as $topic) {
            ?>
                <tr>
                    <td>
                        <?php
                        if ($topic->getVerouilleSujet()) {
                        ?>
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                                <path d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z" />
                            </svg>
                        <?php
                        }
                        ?>
                        <a href="index.php?ctrl=forum&action=viewTopic&id=<?= $topic->getId() ?>"><?= $topic->getTitreSujet() ?></a>
                    </td>
                    <td><a href="index.php?ctrl=forum&action=viewProfile&id=<?= $topic->getVisiteur()->getId() ?>"><?= $topic->getVisiteur() ?></a></td>
                    <td class="cellCenter"><?= max(0, $topic->getNbMessages() - 1) ?></td>
                    <td><?= $topic->getDateCreationSujet() ?></td>
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

<p>Créer un nouveau sujet :</p>
<form action="index.php?ctrl=forum&action=newTopic&id=<?= $category->getId() ?>" method="post">
    <label for="nom">Nom du sujet : *</label>
    <input type=text name="nom" required>
    <label for="message">Message : *</label>
    <textarea id="message" name="message" rows="5" required></textarea>
    <button type="submit" name="submit">Répondre</button>
</form>