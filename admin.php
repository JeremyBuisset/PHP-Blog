<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Blog PHP</title>
    <link rel="stylesheet" href="vues/style.css">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">

</head>
<body>
    <?php
    require "vues/header.php";
    require "controllers/connect.php";
    ?>

    <h3>Créer un article</h3>
    <div class="forms">
        <form class="test" action="controllers/actions.php?method=create" method="post">
            <label for="name">Nom de votre article : </label>
            <input type='text' id="name" name="name">
            <label for="image">Lien de votre image : </label>
            <input type='text' id="image" name="image">
            <label for="text">Texte associé à votre article: </label>
            <textarea id="text" name="text"></textarea>
            <input type="submit" value="Soumettre">
        </form>
    </div>



    <h3>Mettre à jour un article</h3>
    <div class="forms">
        <h4>Choisissez votre article : </h4>
        <form action="vues/actionUpdate.php" method="post">
            <select id="articles" name="articles">
                <?php
                if ($conn->connect_error):
                    echo $conn->connect_error;
                else:
                    $conn->select_db($dbname);
                    $id = $_SESSION['id'];
                    $sql = "SELECT * FROM `articles` WHERE user = $id";
                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()):
                        $id = $row['ID_article'];
                        echo utf8_encode("<option value='$id'>".$row['nom']."</option>");
                    endwhile;

                endif; ?>
            </select>
            <input type="submit" value="Soumission">
        </form>
    </div>

    <h3>Supprimer un article</h3>
    <h4>Attention ! La suppression d'un article est définitive !</h4>
    <div class="forms">
        <h4>Choisissez votre article : </h4>
        <form action="controllers/actions.php?method=delete" method="post">
            <select id="articles" name="articles">
                <?php
                if ($conn->connect_error):
                    echo $conn->connect_error;
                else:
                    $conn->select_db($dbname);
                    $id = $_SESSION['id'];
                    $sql = "SELECT * FROM `articles` WHERE user = $id";
                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()):
                        $id = $row['ID_article'];
                        echo utf8_encode("<option value='$id'>".$row['nom']."</option>");
                    endwhile;

                endif; ?>
            </select>
            <input type="submit" value="Soumission">
        </form>
    </div>
</body>
</html>
