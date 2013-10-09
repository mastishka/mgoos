<?php
	include_once("database/queries.php") ;
	include_once("search_helper.php") ;
	include_once("database/config.php") ;
	include_once("lib/id3_info.php") ;
	
	$objDB = new CQueryManager(CConfig::DB_AUDIO) ;
	
	$url = CUtils::curPageURL() ;
	$query_str = parse_url($url);
	parse_str($query_str["query"]) ;
	
	// Increment play count.
	$objDB->IncreasePlayCount($id) ;
	
	$filepath = $objDB->GetFieldValue($id, "filepath") ;
	
	if($filepath != '')
	{ 
		// We'll be outputting a mp3
		header('Content-type: audio/mpeg');
	
		// It will be called [id].mp3
		//header('Content-Disposition: attachment; filename="'.$id.'.mp3"');
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: ".@filesize($filepath));
	
		// The mp3 source is in [filepath]
		CUtils::DecodeAndDumpMp3($filepath) ;
	}
?> 