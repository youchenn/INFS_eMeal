<?php
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];
if($username == "infs" && $password == "3202"){
  echo "Correct";
}
else {
  echo "Wrong!";
}
?>
