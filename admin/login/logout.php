<?php
	include_once("../lib/session_manager.php") ;
	include_once("../lib/utils.php") ;
	include_once("../database/config.php") ;
	include_once("../lib/user_manager.php") ;
	
	// Set User offline.
	$objQM = new CUserManager(CConfig::DB_AUDIO) ;
	$objQM->ResetOnline(CSessionManager::GetUserId()) ;
	
	//echo(CSessionManager::GetUserId()) ;
	
	// Logout.
	CSessionManager::Logout() ;
	
	// Redirect to Home Page.
	CUtils::Redirect("../index.php") ;
?>