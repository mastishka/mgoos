<?php
	include_once("../database/queries.php") ;
	include_once("../database/config.php") ;
	include_once("utils.php") ;
	
	echo "Please wait...<BR/>Normalizing <IMG SRC='../images/updating.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT=''/><BR/><BR/><BR/><BR/>";
	
	$objQM = new CQueryManager(CConfig::DB_AUDIO) ;
	//$objQM->NormalizeMP3MetaphoneInfo();
	$objQM->AlbumUnknow2KnownHTTP();
	
	echo "Done !!!!!!" ;
?>