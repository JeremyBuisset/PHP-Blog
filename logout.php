<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>SITE !</title>
    <link rel="stylesheet" href="vues/style.css">
    <meta name="viewport" content="width=device-width, user-scalable=no">

</head>
<body>
<?php
include "vues/header.php";
session_unset();
session_destroy();
?>

<h2>Vous venez de vous déconnecter, vous allez être redirigé vers l'accueil</h2>
<?php header("Refresh:2 url=index.php"); ?>
</body>
</html>
