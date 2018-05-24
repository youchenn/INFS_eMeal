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
		echo '<!DOCTYPE html>
		<html>
		<head>
			<meta charset="utf-8" />
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<title>Page Title</title>
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet">
			<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
			<link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
			<script type="text/javascript" src="https://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5ab88174f9a49214"></script>
			<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
			
			
		</head>
		<body>
		
			<form action="http://localhost/eMealv2/shoppinggeneralv2.php" method="post">
				<p>Your account has been verified.</p>
				<button type="submit">Continue shopping</button>
			</form>

		</body>
		</html>';
		
	}
	
	//}
			
	}
else {
		
	header("Location: ../newpassword.html?invalidurl");
		
}
?>