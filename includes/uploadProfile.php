<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "emeal");

$nickname = $_SESSION['user'];
$query = "SELECT * FROM user WHERE userNickname = '$nickname'";
$result = mysqli_query($connect,$query);
$row = mysqli_fetch_array($result);
$id = $row['userId'];
$profileimg = $row['userProfilepic'];
$gender = $row['userGender'];

if (isset($_POST["submit"])){
    include 'db.php';
    
    if (!empty($_FILES['imageUpload']['tmp_name'])){
        $imagename = $_FILES['imageUpload']['name'];
        $imagetmpname = $_FILES['imageUpload']['tmp_name'];
        $target_folder = "../uploadImage/profileUpload/";
        $target_file = $target_folder . basename($imagename);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $imgname = $nickname.'.'.$imageFileType;
        rename($imagename,$imgname);
        $path = "uploadImage/profileUpload/".$imgname;
        move_uploaded_file($imagetmpname, $target_folder.$imgname);
    }else{
        $path = $profileimg;
    }
    
    if(empty($_POST['dob'])){
        date_default_timezone_set('Australia/Brisbane');
        $dob = date('Y-m-d');
    }else{
        $dob = $_POST['dob'];
    }
        
        $gender = $_POST['gender'];
        $contact = $_POST['contact'];
        $address = $_POST['address'];
        $postalcode = $_POST['postalcode'];
        $state = $_POST['state'];
        $occupation = $_POST['occupation'];
    
        $sql = "UPDATE `user` SET `userProfilepic` = '$path', `userGender` = '$gender', `userDob` = '$dob', `userContact` = '$contact', `userAddress` = '$address', `userPostalcode` = '$postalcode', `userState` = '$state', `userOccupation` = '$occupation' WHERE `user`.`userId` = '$id'";
    
        mysqli_query($connect, $sql);
        header("Location:../userProfile.php");
}
?>