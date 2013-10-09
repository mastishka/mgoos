<?php
	include_once("../lib/session_manager.php") ;
	include_once("../lib/email.php") ;
	include_once("../lib/utils.php") ;
	include_once("../database/config.php") ;
	include_once("../database/queries.php") ;
	
	$pl_name 	= $_POST["pl_name"] ;
	$comments	= $_POST["comments"] ;
	$playlist	= $_POST["playlist"] ;
	$bOverwrite = $_POST["overwrite"] ;
	$err_msg	= "Unknown" ;
	
	$objQM = new CQueryManager(CConfig::DB_AUDIO) ;
	$bResult = $objQM->AddPlaylist(CSessionManager::GetUserId(), $pl_name, $comments, $playlist, $bOverwrite, $err_msg) ;
?>
{"result": 
	{"bResult": <?php echo($bResult); ?>,
	 "szErrMsg": "<?php echo($err_msg); ?>",
	 "szPLName": "<?php echo($pl_name); ?>",
	 "bOverwrite": <?php echo($bOverwrite); ?>
	}
}