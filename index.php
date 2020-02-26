<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Blog PHP</title>
    <link rel="stylesheet" href="vues/style.css">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Merriweather&display=swap" rel="stylesheet">

</head>
<body>
    <?php
    require "vues/header.php";
    require "controllers/connect.php";

    if (isset($_SESSION['name'])):
        ?>
        <div class="notifs">
            <p>Bienvenue <?=$_SESSION['name'] ?> (<?=$_SESSION['id'] ?>)</p>
            <p>Vous pouvez créer vos articles dans votre espace personnel</p>
        </div>

        <?php
        else:
         ?>
            <div class="notifs">
                <p>Bienvenue sur notre blog, en tant que visiteur, vous pouvez regarder nos articles.</p>
                <p>Pour pouvoir créer vos propres articles, vous pouvez vous s'inscrire, c'est gratuit.</p>
            </div>
        <?php
    endif;

    if ($conn->connect_error):
        echo $conn->connect_error;
    else:
        $conn->select_db($dbname);
        $sql = "SELECT * FROM `articles` LEFT JOIN `users` ON (articles.user = users.ID_user) WHERE 1";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()):
            $id = $row['ID_article'];
            ?>
            <div class="articles">
                <div class="artTitle">
                    <p><?=utf8_encode($row['nom']) ?> par <?=utf8_encode($row['name']) ?></p>
                </div>
                <div class="artImages">
                    <?php if ($row['image'] == null):
                        ?> <p></p> <?php
                        else: ?>
                            <img src="<?=$row['image'] ?>" alt='image'"> <?php
                       endif; ?>

                </div>
                <div class="artText">
                    <p><?=utf8_encode($row['text']) ?> </p>
                </div>
                <div class="comments">
                    <h3>Commentaires</h3> <?php
                    $sql2 = "SELECT * FROM `commentaires` LEFT JOIN  `articles` ON (commentaires.article_ID = articles.ID_article) LEFT JOIN  
                    `users` ON (commentaires.userID = users.ID_user) WHERE article_ID = $id";
                    $result2 = $conn->query($sql2);
                    while ($row = $result2->fetch_assoc()): ?>
                        <p><?=utf8_encode($row['name']) ?> : <?=utf8_encode($row['comments']) ?></p>

                        <?php
                    endwhile;


                ?>
                </div>
            </div>
            <?php

        endwhile;
    endif;
    ?>

</body>
</html>