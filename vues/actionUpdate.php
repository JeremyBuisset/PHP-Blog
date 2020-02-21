<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, user-scalable=no">

</head>
<body>

<?php
require 'header.php';
require '../controllers/connect.php';

$id = $_POST['articles']; ?>

    <h3>Mettre à jour un article</h3>
    <div class="forms">
        <?php
            if ($conn->connect_error):
                echo $conn->connect_error;
            else:
                $conn->select_db($dbname);
                $sql = "SELECT * FROM `articles` WHERE ID_article=$id";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()): ?>
                    <form class="test" action="../controllers/actions.php?method=update" method="post">
                        <label for="name">Nom de votre article : </label>
                        <input type='text' id="name" name="name" value=<?=$row['nom'] ?>>
                        <label for="image">Lien de votre image : </label>
                        <input type='text' id="image" name="image" value=<?=$row['image'] ?>>
                        <label for="text">Texte associé à votre article: </label>
                        <textarea id="text" name="text"><?=$row['text'] ?></textarea>
                        <input type="hidden" name="id" value=<?=$id ?>>
                        <input type="submit" value="Soumettre">
                    </form>

                <?php
                endwhile;


            endif;
        ?>



    </div>


</body>
</html>
