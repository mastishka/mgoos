<?php
	include_once("../lib/user_manager.php");
	include_once("../lib/utils.php");
	include_once("../database/config.php");

	$email= $_POST['email'];
	$pasword= $_POST['password'];
	$UserM  = new CUserManager();
	$result = $UserM->UpdatePassword($email,$pasword);

	if ($result)
	{
		CUtils::Redirect("register-success.php?umail=".urlencode($email));
		exit();
	}
	else
	{
		printf("Dear User Your password change process is fail please Re-Enter the Password");
	
		include("forgot.php");
	}
?>

		
	