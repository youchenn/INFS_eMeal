<?php

if (isset($_POST['submit'])) {
	
	include_once 'db.php';
	
	
	$email = $_POST['email'];
	$uNickname = $_POST['nickname'];
	$pwd = $_POST['pwd'];
	
	// Error handlers
	// Check for empty fields
	if (empty($email) || empty($uNickname) || empty($pwd)) {
		header("Location: ../signup_mock.php?signup=empty");
		exit();
	} else {
			// Check if input characters are valid
			if (!preg_match("/^[a-zA-Z]*$/", $uNickname)) {
				header("Location: ../signup_mock.php?signup=invalid");
				exit();
			} else {
				//Check if email is valid
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					header("Location: ../signup_mock.php?signup=email");
					exit();
				} else {
					$sql = "SELECT * FROM user WHERE userNickname='$uNickname'";
					$result = mysqli_query($conn, $sql);
					$resultCheck = mysqli_num_rows($result);
					
					if ($resultCheck > 0) {
						header("Location: ../signup_mock.php?signup=usertaken");
						exit();
					} else {
						//Hashing the password
						$hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
						//creating activation code
						$token = 'QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm1234567890';
						$token = str_shuffle($token);
						$token = substr($token, 0, 10);
						//Insert the user into the database
						$sql = "INSERT INTO `user` (`userId`, `userEmail`, `userPassword`, `userAddress`, `userPostalcode`, `userState`, `userContact`, `userNickname`, `userProfilepic`, `userBio`, `userGender`, `userDob`, `userOccupation`, `userRecipecount`, `userWebsite`, `userActivationCode`, `userEmailStatus`) VALUES (NULL, '$email', '$hashedPwd', NULL, NULL, NULL, NULL, '$uNickname', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$token', 'not verified');";
						mysqli_query($conn, $sql);
						header("Location: ../homepage.html?signup=success");
						exit();
					}
				}
			}
	}
	
} else {
	header("Location: ../signup_mock.php");
	exit();
}