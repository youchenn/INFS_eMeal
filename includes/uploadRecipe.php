<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "emeal");

if (isset($_POST["submit"])){
    include 'db.php';
    
    $nickname = $_SESSION['user'];
    $query = "SELECT * FROM user WHERE userNickname = '$nickname'";
    $result = mysqli_query($connect,$query);
    $row = mysqli_fetch_array($result);
    $userid = $row['userId'];

    $recipename = $_POST['recipename'];
    $date = date('Y-m-d');
    $size = $_POST['size'];
    $category = $_POST['category'];
    $purpose = $_POST['purpose'];
    $detail = $_POST['detail'];
    
    $imagename = $_FILES['imageUpload']['name'];
    $imagetmpname = $_FILES['imageUpload']['tmp_name'];
    $target_folder = "../uploadImage/recipeUpload/";
    move_uploaded_file($imagetmpname, $target_folder.$imagename);
    
    if (empty($recipename)|| empty($detail)|| $_POST['size']=='NULL'|| $_POST['category']=='NULL'|| $_POST['purpose']=='NULL'){
        echo 'Empty inputs!';
        exit();  
    }else{
    
    $sql = "INSERT INTO `recipe` (`recipeId`, `recipeName`, `recipeTime`, `recipeContent`, `recipeCategory`, `recipeSize`, `userId`, `Purpose`, `img`) VALUES (NULL, '$recipename', '$date', '$detail', '$category', '$size', '$userid', '$purpose', '$imagename')";
    
    mysqli_query($connect, $sql);
    $recipeId = mysqli_insert_id($connect);
    
    }
}
?>