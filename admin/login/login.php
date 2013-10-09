<?php
	include_once("../lib/session_manager.php") ;
	//include_once("../../database/config.php") ;
	include_once("../lib/utils.php") ;
	//include_once("../lib/user_manager.php");
	include_once("../lib/admin_manager.php");
	
	
	$email = strtolower($_POST['email']) ;
	$pass = $_POST['password'] ;
	
	$bUserExist = "false" ;
	$bPassVerified = "false" ;
	$user = "" ;
	$status = 9 ;
	
	//Sanitize the value received from login field
	//to prevent SQL Injection
	if(!get_magic_quotes_gpc())
	{
		$user = mysql_real_escape_string($email) ;
	}
	else
	{
		$user = $email ;
	}
	
	
	/*$objUM = new CUserManager();
	$result = $objUM->VerifyUser($email, $pass);
	if($result ==2 )
	{
		//Login Successful
		session_regenerate_id() ;
		
		$objUser = $objUM->GetUserByEmail($email) ;
		CSessionManager::SetUserId($objUser->GetUserID()) ;
		CSessionManager::SetEmailId($email);
		CSessionManager::SetLoggedIn(true) ;
		CSessionManager::SetReferredFrom(CSessionManager::REF_FROM_MY_MGOOG_PHP);
		$bUserVerified = "true" ;
		$status = $member['reg_status'] ;
		// To set user is online
		$objUM->SetOnline($objUser->GetUserID());//online
		session_write_close() ;
		CUtils::Redirect("pre_login.php");
		$flag=1;
	}
	else if($result ==1)
	{
       	CSessionManager::SetErrorType(1);
		CSessionManager::SetErrorMsg("Activation pending, please check your following e-mail: ".$email);
		CSessionManager::SetReferredFrom(CSessionManager::REF_FROM_MY_MGOOG_PHP);
		CUtils::Redirect("login_form.php");
		$flag=1;
	}
	else if($result ==0)
	{
		CSessionManager::SetErrorType(2);
		CSessionManager::SetErrorMsg("E-mail and password mismatch.");
		CSessionManager::SetReferredFrom(CSessionManager::REF_FROM_MY_MGOOG_PHP);	    
		CUtils::Redirect("login_form.php");
		$flag=0;
	}*/

	
		$objAdmin= new CAdminManager();
		$result_admin= $objAdmin->VerifyAdmin($email, $pass);
	
	//Check whether the query was successful or not
		if($result_admin == 2)
		{
			$objAd = $objAdmin->GetAdminByEmail($email) ;
			CSessionManager::SetUserId($objAd->GetAdminID()) ;
			CSessionManager::SetEmailId($email);
			CSessionManager::SetLoggedIn(true) ;
			$bUserVerified = "true" ;
			CSessionManager::SetReferredFrom(CSessionManager::REF_FROM_MY_MGOOG_PHP);
			Cutils::Redirect("pre_admin_login.php");
		}
		else if($result_admin == 0)
		{
			CSessionManager::SetErrorType(2);
			CSessionManager::SetErrorMsg("E-mail and password mismatch.");
			CSessionManager::SetReferredFrom(CSessionManager::REF_FROM_MY_MGOOG_PHP);	    
			CUtils::Redirect("login_form.php");
		}
	
		
	
	
	
?>