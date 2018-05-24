<?php

use PHPMailer\PHPMailer\PHPMailer;

if (isset($_POST['submit'])) {
	
	include_once 'db.php';
	
	
	$email = $_POST['email'];
	$nickname = $_POST['nickname'];
	$pwd = $_POST['pwd'];
	
	// Error handlers
	// Check for empty fields
	if (empty($email) || empty($nickname) || empty($pwd)) {
		echo '<script>alert("Empty inputs...!")</script>';
		header("Location: ../signup.php?signup=empty");
		exit();
	} else {
			// Check if input characters are valid
			if (!preg_match("/^[a-zA-Z]*$/", $nickname)) {
				header("Location: ../signup_mock.php?signup=invalid");
				exit();
			} else {
				//Check if email is valid
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					header("Location: ../signup_mock.php?signup=email");
					exit();
				} else {
					$sql = "SELECT * FROM user WHERE userNickname='$nickname'";
					$result = mysqli_query($conn, $sql);
					$resultCheck = mysqli_num_rows($result);
					
					if ($resultCheck > 0) {
						header("Location: ../signup_mock.php?signup=usertaken");
						exit();
					} else {
						//Hashing the password
						$hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
						//creating activation code
						$hash = 'QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm1234567890';
						$hash = str_shuffle($hash);
						$hash = substr($hash, 0, 10);
						//Insert the user into the database
						$sql = "INSERT INTO `user` (`userId`, `userEmail`, `userPassword`, `userAddress`, `userPostalcode`, `userState`, `userContact`, `userNickname`, `userProfilepic`, `userBio`, `userGender`, `userDob`, `userOccupation`, `userRecipecount`, `userWebsite`, `userActivationCode`, `userEmailStatus`) VALUES (NULL, '$email', '$hashedPwd', NULL, '0000', NULL, NULL, '$nickname', 'img/profile-picture.png', NULL, NULL, NULL, NULL, NULL, NULL, '$hash', 'not verified');";
						mysqli_query($conn, $sql);
						
						//email user hashcode to verify his account
						
						include_once "phpmailer/PHPMailer.php";
						include_once "phpmailer/Exception.php";
						include_once "phpmailer/SMTP.php";
						
						
						//create an instance
						$mail = new phpmailer();
						
						//set a host
						$mail->Host = "smtp.gmail.com";
						
						//enable SMTP
						$mail->isSMTP();
						
						//set authentication
						$mail->SMTPAuth = true;
						
						//set login details for gmail account
						$mail->Username = "emealoperator@gmail.com";
						$mail->Password = "infs3202admin";
						
						//set type of protection
						$mail->SMTPSecure = "ssl"; //or we can use TLS
						
						//set a port
						$mail->Port = 465; //465 else 587 if TLS
						
						//set subject
						$mail->Subject = "Email Verification";
						
						$mail->isHTML = true;
						
						//set body
						$mail->Body = '
							Hello '.$nickname.',

							Please click this link to verify your account:

							http://localhost/eMeal/includes/verify.php?email='.$email.'&hash='.$hash;
						
						//set who is sending
						$mail->setFrom('emealoperator@gmail.com','Admin');
						
						//set recipient
						$mail->addAddress($email);
						
						//send an email
						if ($mail->send()){
							echo "mail is sent";
						header("Location: ../homepage.php?signup=success");}
						else {
						header("Location: ../homepage.php?signup=emailfail");}
						
						
						exit();
					}
				}
			}
	}
	
} else {
	header("Location: ../signup_mock.php");
	exit();
}