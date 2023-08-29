<?php

$categories = $result["data"]['categories'];

?>

<h1>Forum PHP</h1>

<?php
if ($categories != null)
{
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
        foreach($categories as $category ){
            ?>
            <tr>
                <td><a href="index.php?ctrl=forum&action=listTopics&id=<?=$category->getId()?>"><?=$category->getNomCategorie()?></a></td>
                <td class="cellCenter"><?=$category->getNbSujets()?></td>            
                <td class="cellCenter"><?=$category->getNbMessages()?></td>  
                <td></td>
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
    <p>Aucune catégorie !</p>
    <?php
}