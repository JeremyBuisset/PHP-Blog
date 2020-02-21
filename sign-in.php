<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>SITE !</title>
    <link rel="stylesheet" href="vues/style.css">
    <meta name="viewport" content="width=device-width, user-scalable=no">

</head>
<body>
<?php include "vues/header.php" ?>

<h2>Formulaire d'inscription</h2>
<form action="controllers/actions.php?method=signinChecks" method="post">
    <label for="login">Votre nom :</label>
    <input type="text" id="login" name="login">
    <br />
    <label for="pass">Votre mot de passe : </label>
    <input id="pass" type="password" name="pwd"><br />
    <input type="submit" value="Inscription">
</form>
</body>
</html>