<?php

$categories = $result["data"]['categories'];
    
?>

<h1>Liste des catégories</h1>

<?php
if ($categories != null)
{
    ?>
    <table>
        <thead>
            <tr>
                <th>Catégorie</th>
                <th>Sujets</th>
                <th>Réponses</th>
                <th>Dernier Message</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach($categories as $category ){

            ?>
            <tr>
                <td><?=$category->getNomCategorie()?></td>
                <td><?=$category->getNbSujets()?></td>            
                <td><?=$category->getNbMessages()?></td>  
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