<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>SITE !</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Merriweather&display=swap" rel="stylesheet">

</head>
<body>
<header>
    <div><a href="index.php">Blog PHP</a></div>
    <div id="bar"></div>

    <?php
    session_start();
    if (isset($_SESSION['name'])):
        //Choses si variables sessions existent
        if ($_SESSION['admin'] === true):
            echo '<a href="admin.php">ESPACE ADMINISTRATEUR</a>';
            echo '<a href="controllers/actions.php?method=logout">DÉCONNEXION</a>';
        else:
            echo '<a href="admin.php">ESPACE PERSONNEL</a>';
            echo '<a href="controllers/actions.php?method=logout">DÉCONNEXION</a>';

        endif;

    else:
        //Choses si variables sessions n'existent pas
        echo '<a href="log&signIn.php?action=login">CONNEXION</a>';
        echo '<a href="log&signIn.php?action=signin">INSCRIPTION</a>';

    endif;

    ?>
</header>

</body>
</html>