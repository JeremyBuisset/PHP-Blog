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

    <div class="notifs">
        <p>Créer un article</p>
    </div>

    <div class="forms">
        <form class='test' action="upload.php" method="post" enctype="multipart/form-data">
            <label for="title">Nom de votre article</label>
            <input type="text" id="title" name="title">
            <label for="fileToUpload">Image de votre article</label>
            <input type="file" name="fileToUpload" id="fileToUpload">
            <label for="text">Texte de votre article</label>
            <textarea id="text" name="text"></textarea>
            <input type="submit" value="Soumettre" name="submit">
        </form>
    </div>

    <div class="notifs">
        <p>Créer un commentaire</p>
    </div>

    <div class="forms">
        <form class='test' action="controllers/actions.php?method=commentCreate" method="post">
            <label for="articles">Article à commenter</label>
            <select id="articles" name="articles">
                <?php
                if ($conn->connect_error):
                    echo $conn->connect_error;
                else:
                    $conn->select_db($dbname);
                    $id = $_SESSION['id'];
                    $sql = "SELECT * FROM `articles` WHERE 1";
                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()):
                        $id = $row['ID_article'];
                        echo utf8_encode("<option value='$id'>".$row['nom']."</option>");
                    endwhile;

                endif; ?>
            </select>
            <label for="title">Texte de votre commentaire</label>
            <textarea id="text" name="text"></textarea>
            <input type="submit" value="Soumettre" name="submit">
        </form>
    </div>


    <div class="notifs">
        <p>Mettre à jour un article</p>
    </div>
    <div class="forms">
        <h4>Choisissez votre article : </h4>
        <form class='test' action="vues/actionUpdate.php" method="post">
            <select id="article" name="articles">
                <?php
                if ($conn->connect_error):
                    echo $conn->connect_error;
                else:
                    $conn->select_db($dbname);
                    $id = $_SESSION['id'];
                    if ($_SESSION['admin'] === true):
                        $sql = "SELECT * FROM `articles` WHERE 1";
                    else:
                        $sql = "SELECT * FROM `articles` WHERE user = $id";
                    endif;

                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()):
                        $id = $row['ID_article'];
                        echo utf8_encode("<option value='$id'>".$row['nom']."</option>");
                    endwhile;

                endif; ?>
            </select>
            <input type="submit" value="Soumettre">
        </form>
    </div>

    <div class="notifs">
        <p>Supprimer un article</p>
    </div>
    <h4>Attention ! La suppression d'un article est définitive !</h4>
    <div class="forms">
        <h4>Choisissez votre article : </h4>
        <form class='test' action="controllers/actions.php?method=delete" method="post">
            <select id="articles" name="articles">
                <?php
                if ($conn->connect_error):
                    echo $conn->connect_error;
                else:
                    $conn->select_db($dbname);
                    $id = $_SESSION['id'];
                    if ($_SESSION['admin'] === true):
                        $sql = "SELECT * FROM `articles` WHERE 1";
                    else:
                        $sql = "SELECT * FROM `articles` WHERE user = $id";
                    endif;

                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()):
                        $id = $row['ID_article'];
                        echo utf8_encode("<option value='$id'>".$row['nom']."</option>");
                    endwhile;

                endif; ?>
            </select>
            <input type="submit" value="Soumettre">
        </form>
    </div>

    <div class="notifs">
    <p>Supprimer un commentaire</p>
    </div>
    <h4>Attention ! La suppression d'un commentaire est définitive !</h4>
    <div class="forms">
        <h4>Choisissez votre article : </h4>
        <form class='test' action="controllers/actions.php?method=commentDelete" method="post">
            <select id="articles" name="articles">
                <?php
                if ($conn->connect_error):
                    echo $conn->connect_error;
                else:
                    $conn->select_db($dbname);
                    $id = $_SESSION['id'];
                    if ($_SESSION['admin'] === true):
                        $sql = "SELECT * FROM `commentaires` LEFT JOIN `users` ON (commentaires.userID = users.ID_user) WHERE 1";
                    else:
                        $sql = "SELECT * FROM `commentaires` LEFT JOIN `users` ON (commentaires.userID = users.ID_user) WHERE userID = $id";
                    endif;

                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()):
                        $id = $row['commentaire_ID'];
                        echo utf8_encode("<option value='$id'>".$row['comments']."</option>");
                    endwhile;

                endif; ?>
            </select>
            <input type="submit" value="Soumettre">
        </form>
    </div>
</body>
</html>
