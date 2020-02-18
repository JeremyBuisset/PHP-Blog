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
    include "controllers/connect.php";
    /*Check if the connexion works*/

    if ($conn->connect_error) {
        echo $conn->connect_error;
    } else {
        /*Interact with the database for get the names of the form ID*/
        $conn->select_db($dbname);
        $sql = "SELECT * FROM `users` WHERE 1";
        //echo $sql;
        $result = $conn->query($sql);
        // echo $conn->error;

        /*Loop for stocks each names in a array*/
        while ($row = $result->fetch_assoc()) {
            if($row['name'] == $_POST['login'] && $row['password'] == sha1($_POST['pwd'])){
                $_SESSION['name'] = $_POST['login'];
                $_SESSION['password'] = $_POST['pwd'];
                break;
            } else {
                echo "";
            }
        }
        if (isset($_SESSION['name'],$_SESSION['password'])){
            echo "<h2>Bienvenue"." ".$_SESSION['name']."</h2>";
            header("Refresh:2 url=index.php");
        } else {
            echo "<h2>Cet utilisateur ne figure pas dans la BDD</h2>";
            header("Refresh:2 url=index.php");
        }
    }


    ?>






</body>
</html>