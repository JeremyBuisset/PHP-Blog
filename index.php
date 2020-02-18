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

    if (isset($_SESSION['name'])):
            //Choses si variables sessions existent
        echo '<h3>Bienvenue '.$_SESSION['name'].', vous pouvez gérer vos contenus dans votre espace personnel</h3>';

        if ($conn->connect_error):
            echo $conn->connect_error;
        else :
            /*Interact with the database for get the names of the form ID*/
            $conn->select_db($dbname);
            $sql = "SELECT * FROM `articles` LEFT JOIN `users` ON (articles.user = users.ID_user) WHERE 1";
            //echo $sql;
            $result = $conn->query($sql);
            // echo $conn->error;

            /*Loop for stocks each names in a array*/
            while ($row = $result->fetch_assoc()):
                echo utf8_encode("<h3>".$row['nom']." par ".$row['name']."<br><img src=".$row["image"]." width='256' height='256' alt='image'><br><br>".
                    $row['text'].'<br>');
            endwhile;
        endif;

    else:
        //Choses si variables sessions n'existent pas
        echo '<h3>Bienvenue sur notre blog, en tant que visiteur, vous pouvez simplement regarder nos articles</h3>';
        echo "<h3>Pour pouvoir poster et commenter des articles, vous pouvez vous s'inscrire</h3>";

        if ($conn->connect_error):
            echo $conn->connect_error;
        else :
            /*Interact with the database for get the names of the form ID*/
            $conn->select_db($dbname);
            $sql = "SELECT * FROM `articles` LEFT JOIN `users` ON (articles.user = users.ID_user) WHERE 1";
            //echo $sql;
            $result = $conn->query($sql);
            // echo $conn->error;

            /*Loop for stocks each names in a array*/
            while ($row = $result->fetch_assoc()):
                echo utf8_encode("<h3>".$row['nom']." par ".$row['name']."<br><img src=".$row["image"]." width='256' height='256' alt='image'><br><br>".
                    $row['text'].'<br>');
            endwhile;
        endif;





        endif;

        ?>


</body>
</html>

