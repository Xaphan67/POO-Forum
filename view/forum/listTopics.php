<?php

$topics = $result["data"]['topics'];
    
?>

<h1>Liste des sujets</h1>

<?php
if ($topics != null)
{
    foreach($topics as $topic ){

        ?>
        <p><?=$topic->getTitle()?></p>
        <?php
    }
}
else
{
    ?>
    <p>Aucun sujet !</p>
    <?php
}