<?php
	//Start session
	include_once("../lib/session_manager.php");
	include_once("../database/config.php");
	include_once("../lib/user_manager.php");
	include_once("../lib/utils.php");
	
	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) 
	{
		if(!get_magic_quotes_gpc()) 
		{
			$str = @trim(mysql_real_escape_string($str));
		}
		else 
		{
			return @trim($str);
		}
	}
	
	//Sanitize the POST values
	$fname		= clean($_POST['FNAME']);
	$lname		= clean($_POST['LNAME']);
	$email		= clean($_POST['EMAIL']);
	$password	= $_POST['PASSWORD'];
	$cpassword	= $_POST['CPASSWORD'];
	$gender		= clean($_POST['GENDER']);
	$city		= clean($_POST['CITY']);
	$state		= clean($_POST['STATE']);
	$country	= clean($_POST['COUNTRY']);
	$year		= clean($_POST['BIRTHYEAR']);
	$day		= clean($_POST['DAY']);
	$month		= clean($_POST['MONTH']);
	$question	= clean($_POST['QUESTION']);	
	$security_answer	= clean($_POST['ANSWER']);
	
	$dob	= sprintf("%s-%s-%s",$year,$month,$day);
	
	//Check for duplicate Mgoos-login ID
	$objUM = new CUserManager();
	$result = $objUM->GetFieldValueByEmail($email,CUser::FIELD_EMAIL);

    $val = strcmp(strtolower($result), strtolower($email)); 
	
	if($val==0) 
	{
		CSessionManager::SetErrorMsg("Email-ID already in use.");
		CUtils::Redirect("register.php");				
		exit();
	}
	else
	{
		$objUser = new CUser();
		//----------------Add Mgoos-User------------------------
		$objUser->SetFirstName(ucwords(strtolower($fname)));
		$objUser->SetLastName(ucwords(strtolower($lname)));
		$objUser->SetPassword($password);
		$objUser->SetEmail(strtolower($email)); //only E-mail in lower case
		$objUser->SetGender($gender);
		$objUser->SetCity(ucwords(strtolower($city)));
		$objUser->SetState(ucwords(strtolower($state)));
		$objUser->SetCountry(ucwords(strtolower($country)));
		$objUser->SetDOB($dob);
		$objUser->SetSecQues(ucwords(strtolower($question)));
		$objUser->SetSecAns(ucwords(strtolower($security_answer)));

		$result = $objUM->AddUser($objUser);
			
		//Check whether the query was successful or not
		if($result) 
		{
			CSessionManager::Logout() ;
			CUtils::Redirect("register-success.php?umail=".urlencode($email));
					
			exit();
		}
		else 
		{
			//die("Query failed: ".mysql_error());
			CSessionManager::SetErrorMsg("Dear user,<BR/><BR/> Your registration process had been failed, please re-fill the form.");
			CUtils::Redirect("register.php");
			exit();
		}
	}
	CSessionManager::Logout() ;
?>