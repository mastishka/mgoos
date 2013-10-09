<?php
	include_once("../lib/session_manager.php") ;
	include_once("../lib/email.php") ;
	include_once("../lib/utils.php") ;
	include_once("../database/config.php") ;
	include_once("../database/queries.php") ;
	
	$pid 	= $_POST["pid"] ;
	$playlist_id_list    = "" ;
	$playlist_title_list = "" ;
	
	$objQM = new CQueryManager(CConfig::DB_AUDIO) ;
	$bResult = $objQM->GetPlaylistInfo($pid, $playlist_id_list, $playlist_title_list) ;
?>
{"result": 
	{"bResult": <?php echo($bResult); ?>,
	 "playlist_id_list": "<?php echo($playlist_id_list); ?>",
	 "playlist_title_list": "<?php echo($playlist_title_list); ?>"
	}
}