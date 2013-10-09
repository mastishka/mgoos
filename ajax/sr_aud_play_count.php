<?php
	include_once("../lib/id3_info.php") ;
	include_once("../database/config.php") ;
	include_once("../database/queries.php") ;
	
	$aud_id 	= $_POST["aud_id"] ;
	
	$objQM = new CQueryManager(CConfig::DB_AUDIO) ;
	$bResult = $objQM->IncreasePlayCount($aud_id) ;
?>