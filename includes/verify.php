<?php
/* The password reset form, the link to this page is included
   from the forgot.php email message
*/
require 'db.php';
session_start();
// Make sure email and hash variables aren't empty
include 'db.php';
if( isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']) )
{
	
		
	$email = $_GET["email"];
	$hash = $_GET["hash"];
	//$pwd = mysqli_real_escape_string($conn, $_POST['confirmpassword']);
		
	// Make sure user email with matching hash exist
	//$result = $mysqli->query("SELECT * FROM users WHERE email='$email' AND hash='$hash'");
	$query = "SELECT * FROM user WHERE userEmail='$email' AND userActivationCode='$hash'";
	$result = mysqli_query($conn, $query);
	if ( $result->num_rows == 0 ) // User doesn't exist
    { 
        $_SESSION['message'] = "User with that email doesn't exist!";
        echo "invalid url used";
    }
	else {
		$queryverify = "UPDATE `user` SET userEmailStatus= 'verified' WHERE userEmail = '$email' AND userActivationCode = '$hash';";
		$resultverify = mysqli_query($conn, $queryverify);
		echo "Account has been verified! Please proceed to login!";
		
	}
	
	//}
			
	}
else {
		
	header("Location: ../newpassword.html?invalidurl");
		
}
?>