<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="vues/style.css">
    <meta name="viewport" content="width=device-width, user-scalable=no">

</head>
<body>

<?php
require 'vues/header.php';

switch ($_GET['action']):
    case "signin":
    ?>
        <div class="notifs">
            <p>Formulaire d'inscription</p>
        </div>
        <form class='test' action="controllers/actions.php?method=signinChecks" method="post">
            <label for="login">Votre nom :</label>
            <input type="text" id="login" name="login">
            <br />
            <label for="pass">Votre mot de passe : </label>
            <input id="pass" type="password" name="pwd"><br />
            <input type="submit" value="Inscription">
        </form> <?php

        break;

    case 'login': ?>

        <div class="notifs">
            <p>Connexion</p>
        </div>

        <form class='test' action="controllers/actions.php?method=loginChecks" method="post">
            <label for="login">Votre nom :</label>
            <input type="text" id="login" name="login">
            <br />
            <label for="pass">Votre mot de passe : </label>
            <input id="pass" type="password" name="pwd"><br />
            <input type="submit" value="Connexion">
        </form> <?php
        break;

    default:
        echo 'Le paramètre est lié à aucun mode connu';
        break;
endswitch;

?>

</body>
</html>