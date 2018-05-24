<?php

session_start();

if (isset($_POST['submit'])) {
	
	include 'db.php';
	
	$uid = mysqli_real_escape_string($conn, $_POST['uid']);
	$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
	
	//Error handlers
	//Check if inputs are empty
	if (empty($uid) || empty($pwd)) {
		header("Location: ../LoginTest.php?login=empty");
		exit();
	} 
	else {
		$query = "SELECT * FROM user WHERE userNickname='$uid' OR userEmail='$uid'";
		$result = mysqli_query($conn, $query);
		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_array($result))
			{
                $user_id = $row["userId"];
                $user_nickname = $row["userNickname"];
				if($row["userEmailStatus"] == 'verified'){
					if(password_verify($pwd, $row["userPassword"])){
						//return true;
                        $_SESSION['user'] = $user_nickname;
                        $_SESSION['userId'] = $user_id;
						header("Location: ../homepage.php?login=success");
					}
					else{
						//return false
						header("Location: ../signup_mock.php?signup=wrongpwd");
					}
				}
				else if ($row["userEmailStatus"] == 'not verified'){
					//ask to verify
					header("Location: ../signup_mock.php?signup=unverifiedemail");
				}
			}
		} else {
			header("Location: ../LoginTest.php?login=error");
			
	}

}
}