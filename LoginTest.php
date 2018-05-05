<?php
$con = mysqli_connect('localhost','root','','emeal');
//if($con){
//    echo 'Successfully';
//}
//    else{
//        die('Error.');
//}
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];
$query = "select * from user WHERE userEmail='$username'";
$result = $con->query($query) or die($con->error);
while($row = $result->fetch_assoc()) {
    if($password == $row['userPassword']){
  echo "Correct";
    }
else {
  echo "Wrong!";
    }
}

?>
