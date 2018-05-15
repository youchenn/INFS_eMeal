<?php 
/* Reset your password form, sends reset.php password link */
require 'db.php';
session_start();
use PHPMailer\PHPMailer\PHPMailer;


// Check if form submitted with method="post"
if (isset($_POST['reset'])) 
{   
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$query = "SELECT * FROM user WHERE userEmail='$email'";
	$result = mysqli_query($conn, $query);
	

    if ( $result->num_rows == 0 ) // User doesn't exist
    { 
        $_SESSION['message'] = "User with that email doesn't exist!";
        header("Location: ../resetpassword.php?userdontexist");
    }
    else { // User exists (num_rows != 0)
		

        $user = $result->fetch_assoc(); // $user becomes array with user data
        
        $email = $user['userEmail'];
        $hash = $user['userActivationCode'];
        $nickname = $user['userNickname'];

        // Session message to display on success.php
        //$_SESSION['message'] = "<p>Please check your email <span>$email</span>"
        //. " for a confirmation link to complete your password reset!</p>";

        // Send registration confirmation link (reset.php)
        //$to      = $email;
        //$subject = 'Password Reset Link ( clevertechie.com )';
        //$message_body = '
        //Hello '.$nickname.',

        //You have requested password reset!

        //Please click this link to reset your password:

        //http://localhost/login-system/reset.php?email='.$email.'&hash='.$hash;  

        //mail($to, $subject, $message_body);

        //header("Location: ../resetpassword.html?resetemail=sent");
		
		//include PHPmailerload
	
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
	$mail->Username = "piggyzen@gmail.com";
	$mail->Password = "tsumaki1995";
	
	//set type of protection
	$mail->SMTPSecure = "ssl"; //or we can use TLS
	
	//set a port
	$mail->Port = 465; //465 else 587 if TLS
	
	//set subject
	$mail->Subject = "test email";
	
	$mail->isHTML = true;
	
	//set body
	$mail->Body = '
        Hello '.$nickname.',

        You have requested password reset!

        Please click this link to reset your password:

        http://localhost/eMeal/newpassword.php?email='.$email.'&hash='.$hash;
	
	//set who is sending
	$mail->setFrom('piggyzen@gmail.com','YC');
	
	//set recipient
	$mail->addAddress($email);
	
	//send an email
	if ($mail->send()){
		echo "mail is sent";
	header("Location: ../passwordReset.html?resetemail=sent");}
	else {
	echo "sending failed";}
  }
}
?>