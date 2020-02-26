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

    case 'commentCreate':
        commentCreate();
        break;

    case 'commentDelete':
        commentDelete();
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
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "";
            $uploadOk = 1;
        } else {
            echo "<div class=\"notifs\"><p>Votre fichier n'est pas une image</p></div>";
            $uploadOk = 0;
        }
    }
// Check if file already exists
    if (file_exists($target_file)) {
        echo "<div class=\"notifs\"><p>Votre image existe déjà dans nos données</p></div>";
        $uploadOk = 0;
    }
// Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "<div class=\"notifs\"><p>Votre image dépasse la taille autorisée/p></div>";
        $uploadOk = 0;
    }
// Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        echo "<div class=\"notifs\"><p>Seules les extensions suivantes sont autorisées : JPG, JPEG, PNG & GIF</p></div>";
        $uploadOk = 0;
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "<div class=\"notifs\"><p>Votre fichier n'a pas pû être envoyé ...</p></div>";
        header("Refresh:2 url=index.php");
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

            //header("Refresh:2 url=admin.php");

            $name= $_POST['title'];
            $image= $target_file;
            $text = $_POST['text'];

            if ($conn->connect_error):
                echo $conn->connect_error;
            else:
                $conn->select_db($dbname);

                $id =  $_SESSION['id'];

                $sql = utf8_decode('INSERT INTO articles (nom, image, text, user) VALUES (?, ?, ?, ?)');
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('sssi',$name, $image, $text, $id);

                $stmt->execute();
                ?><div class="notifs"><p>Votre article a bien été créee</p></div><?php

                header("Refresh:2 url=index.php");
            endif;
        } else {
            echo "";
        }
    }
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

        $sql  = utf8_decode("UPDATE articles SET nom='$name', image='$image', text='$text' WHERE ID_article=$id");

        $conn->query($sql);

        echo "<div class=\"notifs\"><p>L'article a bien été mis à jour\"</p></div>";
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

        $sql2 = "DELETE FROM `commentaires` WHERE article_ID=$id";
        $result = $conn->query($sql2);

        echo "<div class=\"notifs\"><p>L'article et ses commentaires associés ont bien été supprimés</p></div>";
        header("Refresh:2 url=../index.php");


    endif;
}

function commentDelete (){
    global $conn;
    global $dbname;
    if ($conn->connect_error):
        echo $conn->connect_error;
    else:
        $conn->select_db($dbname);
        $id =  $_POST['articles'];
        $sql = "DELETE FROM `commentaires` WHERE commentaire_ID=$id";
        $result = $conn->query($sql);
        echo "<div class=\"notifs\"><p>Le commentaire a bien été supprimé</p></div>";
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
            if($row['name'] == utf8_decode($_POST['login']) && $row['password'] == sha1($_POST['pwd'])){
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

        if ($_SESSION['name'] === 'Yoshi'):
            $_SESSION['admin'] = true;
        else:
            $_SESSION['admin'] = false;
        endif;
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
                $_SESSION['id'] = $row['ID_user'];


            endif;
        endwhile;
    endif;

    if ($_SESSION['name'] === 'Yoshi'):
        $_SESSION['admin'] = true;
    else:
        $_SESSION['admin'] = false;
    endif;

    if ($exists === true):
        echo " <div class=\"notifs\"> <p>Un utilisateur du même nom existe déjà dans nos données</p> </div>";
        header("Refresh:2 url=../log&signIn.php?action=signin");

    else:
        $name = utf8_decode($_POST['login']);
        $password = sha1($_POST['pwd']);

        $sql = "INSERT INTO `users`(`name`, `password`) VALUES (?,?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $name, $password);


        $stmt->execute();

        echo "<div class=\"notifs\"> <p>Bienvenue " . $_SESSION['name'] . " , vous venez de vous inscrire</p> </div>";

        header("Refresh:2 url=../index.php");

    endif;
}

function logout(){
    session_unset();
    session_destroy();
    ?>

    <div class="notifs"><p>Vous venez de vous déconnecter, vous allez être redirigé vers l'accueil</p></div>
    <?php header("Refresh:2 url=../index.php"); ?> <?php
}

function commentCreate()
{
    global $conn;
    global $dbname;

    if ($conn->connect_error):
        echo $conn->connect_error;
    else:
        $conn->select_db($dbname);

        $id = $_SESSION['id'];
        $text =  utf8_decode($_POST['text']);

        $idArticle =  $_POST['articles'];


        $sql = utf8_decode('INSERT INTO commentaires (comments, article_ID, userID) VALUES (?, ?, ?)');
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sii', $text, $idArticle, $id);

        $stmt->execute();

        echo "<div class='notifs'><p>Votre commentaire a bien été posté.</p></div>";

        header("Refresh:2 url=../index.php");

    endif;
}
?>

</body>
</html>





