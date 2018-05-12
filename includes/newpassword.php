<?php
/* The password reset form, the link to this page is included
   from the forgot.php email message
*/
require 'db.php';
session_start();

if (isset($_POST['submit'])) {
// Make sure email and hash variables aren't empty
include 'db.php';

	if( isset($_POST['email']) && !empty($_POST['email']) AND isset($_POST['hash']) && !empty($_POST['hash']) )
	{
		if ($_POST['newpassword'] == $_POST['confirmpassword']){
			
		$email = $_POST["email"];
		$hash = $_POST["hash"];
		$pwd = mysqli_real_escape_string($conn, $_POST['confirmpassword']);
		

		// Make sure user email with matching hash exist
		//$result = $mysqli->query("SELECT * FROM users WHERE email='$email' AND hash='$hash'");
		$query = "SELECT * FROM user WHERE userEmail='$email'";
		$result = mysqli_query($conn, $query);

		//if (mysqli_num_rows($result) == 0 )
		//{ 
		 //   $_SESSION['message'] = "You have entered invalid URL for password reset!";
		 //   header("Location: ../newpassword.html?wrong=url");
		//} 
		//else {
			$hashedpwd = password_hash($pwd, PASSWORD_DEFAULT);
			$query1 = "UPDATE user SET userPassword ='$hashedpwd' WHERE userEmail='$email', userActivationCode='$hash'";
			$result1 =mysqli_query($conn, $query1);
			header("Location: ../newpassword.html?passwordupdated");
			
		//}
			
		}
		else {
			header("Location: ../newpassword.html?passwordmismatch");
		}

		
	}
	else {
		
		header("Location: ../newpassword.html?invalidurl");
		
	}
}
?>