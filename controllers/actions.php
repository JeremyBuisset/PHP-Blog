<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="../vues/style.css">
    <meta name="viewport" content="width=device-width, user-scalable=no">

</head>
<body>
<?php
require '../vues/header.php';
require 'connect.php';

if (isset($_GET['method'])):
    echo 'La variable existe <br>';
else:
    echo 'La variable n\'existe pas <br>';
endif;

switch ($_GET['method']):
    case "create":
        create();
        break;

    case 'delete':
        delete();
        break;

    case 'update':
        update();
        break;

    case 'loginChecks':
        loginChecks();
        break;

    case 'signinChecks':
        signinChecks();
        break;

    case 'logout':
        logout();
        break;

    default:
        echo 'Le paramètre est lié à aucun mode connu';
        break;
endswitch;

function create (){
    global $conn;
    global $dbname;
    if ($conn->connect_error):
        echo $conn->connect_error;
    else:
        $conn->select_db($dbname);

        $name =  utf8_decode($_POST['name']);
        $image = utf8_decode($_POST['image']);
        $text =  utf8_decode($_POST['text']);
        $id =  $_SESSION['id'];

        $sql = utf8_decode('INSERT INTO articles (nom, image, text, user) VALUES (?, ?, ?, ?)');
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssi',$name, $image, $text, $id);

        $stmt->execute();

        header("Refresh:2 url=../index.php");

    endif;
}

function update (){
    global $conn;
    global $dbname;
    if ($conn->connect_error):
        echo $conn->connect_error;
    else:
        $conn->select_db($dbname);

        $name =  utf8_decode($_POST['name']);
        $image = utf8_decode($_POST['image']);
        $text =  utf8_decode($_POST['text']);
        $id =  $_POST['id'];
        $sql  = "UPDATE 'articles' SET nom=$name, image=$image, text=$text WHERE ID_article=$id ";

        $result = $conn->query($sql);

        echo "L'article a bien été mis à jour'";
        header("Refresh:2 url=../index.php");

    endif;
}

function delete (){
    global $conn;
    global $dbname;
    if ($conn->connect_error):
        echo $conn->connect_error;
    else:
        $conn->select_db($dbname);
        $id =  $_POST['articles'];
        $sql = "DELETE FROM `articles` WHERE ID_article=$id";
        $result = $conn->query($sql);
        echo "L'article a été supprimé'";
        header("Refresh:2 url=../index.php");


    endif;
}

function loginChecks (){
    global $conn;
    global $dbname;
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
                $_SESSION['id'] = $row['ID_user'];
                break;
            } else {
                echo "";
            }
        }
        if (isset($_SESSION['name'],$_SESSION['password'])){
            echo "<h2>Bienvenue"." ".$_SESSION['name']."</h2>";
            header("Refresh:2 url=../index.php");
        } else {
            echo "<h2>Cet utilisateur ne figure pas dans la BDD</h2>";
            header("Refresh:2 url=../index.php");
        }
    }
}

function signinChecks(){
    global $conn;
    global $dbname;
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
        header("Refresh:2 url=../signin.php");

    else:
        $name = utf8_decode($_POST['login']);
        $password = sha1($_POST['pwd']);

        $sql = "INSERT INTO `users`(`name`, `password`) VALUES (?,?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $name, $password);


        $stmt->execute();

        echo "<h2>Bienvenue " . $_SESSION['name'] . " , vous venez de vous inscrire </h2>";
        header("Refresh:2 url=../index.php");

    endif;
}

function logout(){
    session_unset();
    session_destroy();
    ?>

    <h2>Vous venez de vous déconnecter, vous allez être redirigé vers l'accueil</h2>
    <?php header("Refresh:2 url=../index.php"); ?> <?php
}
?>

</body>
</html>





