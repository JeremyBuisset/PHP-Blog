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
include 'vues/header.php';
include 'controllers/connect.php';
$name = $_POST['login'];
$password = $_POST['pwd'];
$exists = false;



if ($conn->connect_error):
    echo $conn->connect_error;
else :
    /*Interact with the database for get the names of the form ID*/
    $conn->select_db($dbname);
    $sql = "SELECT * FROM `users` WHERE 1";
    //echo $sql;
    $result = $conn->query($sql);
    // echo $conn->error;

    /*Loop for stocks each names in a array*/
    while ($row = $result->fetch_assoc()):
        if ($row['name'] == $_POST['login']):
            $exists = true;
            break;
        else:
            $_SESSION['name'] = $_POST['login'];
            $_SESSION['password'] = sha1($_POST['pwd']);


        endif;
    endwhile;
endif;


if ($exists === true):
    echo "<h2>Un utilisateur du même nom existe déjà dans nos données</h2>";
    header("Refresh:2 url=signin.php");

else:
    $name = utf8_decode($_POST['login']);
    $password = sha1($_POST['pwd']);

    $sql = "INSERT INTO `users`(`name`, `password`) VALUES (?,?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $name, $password);


    $stmt->execute();

    echo "<h2>Bienvenue ".$_SESSION['name']." , vous venez de vous inscrire </h2>";
    header("Refresh:2 url=index.php");

endif;

?>
</body>
</html>