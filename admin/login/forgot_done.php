<?php
	include_once("lib/user_manager.php");
	include_once("lib/utils.php");
	include_once("lib/email.php");
	include_once("database/config.php");

	$email= "vimal_scs@yahoo.co.in";//$_POST['email'];
	$pasword= $_POST['password'];

	$UserM  = new  CUserManager;
	$result = $UserM->UpdatePassword($email,$pasword);

	if ($result)
	{
		 $em  = new  EMail;
		 $to =$email;
		 $subject = "To Activate My MGooS!" ;
		$msg = "Please click on link http://www.mgoos.com/activate.php?secid=".md5($email)." to activate My MGoos";
		
		$from = "From: no_reply@mgoos.com";
		header("location: register-success.php");
		exit();
	}
	else
	{
		printf("Dear User Your password change process is fail please Re-Enter the Password");
		
		include("forgot.php");
	}
?>

		
	