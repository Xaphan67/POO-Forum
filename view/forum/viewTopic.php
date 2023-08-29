<?php

$messages = $result["data"]['posts'];
$topic = $result["data"]['topic'];

?>

<h1><a href="index.php?ctrl=forum&action=listCategories">Forum PHP</a> > <a href="index.php?ctrl=forum&action=listTopics&id=<?=$topic->getCategorie()->getId()?>"><?=$topic->getCategorie()?></a> > <?=$topic?></h1>

<?php
if ($messages != null)
{
    ?>
    <table>
        <tbody>
        <?php
        foreach($messages as $message ){
            ?>
            <tr>
                <td><a href="index.php?ctrl=forum&action=viewProfile&id=<?=$message->getVisiteur()->getId()?>"><?=$message->getVisiteur()?></a></td>
                <td><?=$message->getDateCreationMessage()?></td>
            </tr>
            <tr class ="main-message">
                <td>Inscrit le <?=$message->getVisiteur()->getDateInscriptionVisiteur()?><br><?=$message->getVisiteur()->getRoleVisiteur()?></td>
                <td><?=$message->getTexteMessage()?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    <?php
}
else
{
    ?>
    <p>Aucun message !</p>
    <?php
}
?>

<form action="index.php?ctrl=forum&action=submitPost&id=<?=$topic->getId()?>" method="post">
    <label for="reponse">Répondre : *</label>
    <textarea id="reponse" name="reponse" rows="5" required></textarea>
    <button type="submit" name="submit">Répondre</button>
</form>