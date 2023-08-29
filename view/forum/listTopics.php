<?php

$category = $result["data"]['category'];
$topics = $result["data"]['topics'];
?>

<h1><a href="index.php?ctrl=forum&action=listCategories">Forum PHP</a> > <?=$category->getNomCategorie()?></h1>

<?php
if ($topics != null)
{
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
        foreach($topics as $topic ){
            
            ?>
            <tr>
                <td><a href="index.php?ctrl=forum&action=viewTopic&id=<?=$topic->getId()?>"><?=$topic->getTitreSujet()?></a></td>
                <td><a href="index.php?ctrl=forum&action=viewProfile&id=<?=$topic->getVisiteur()->getId()?>"><?=$topic->getVisiteur()?></a></td>
                <td class="cellCenter"><?=$topic->getNbMessages()?></td>  
                <td><?=$topic->getDateCreationSujet()?></td>
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
    <p>Aucun sujet !</p>
    <?php
}