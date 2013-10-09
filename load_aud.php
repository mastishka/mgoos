<?php
	include_once("database/queries.php") ;
	include_once("database/config.php") ;
	include_once("lib/id3_info.php") ;
	include_once("lib/utils.php");
	
	// Allign last week play count feature was added on date: June 17, 2008
	// So after date: June 24, 2008 only, adjustment should begin.
	$start_align_date = "June 24, 2008" ; 
	
	$objDB = new CQueryManager(CConfig::DB_AUDIO) ;
	
	$url = CUtils::curPageURL() ;
	$query_str = parse_url($url);
	parse_str($query_str["query"]) ;
	
	if(strtotime(date("F j, Y")) > strtotime(start_align_date))
	{
		// Align Last Week play count.
		$objDB->AlignLastWeekPlayCount($id) ;
	}
	
	// Align today's play count.
	$objDB->AlignTodaysPlayCount($id) ;
	
	// Increment play count.
	$objDB->IncreasePlayCount($id) ;
	
	// Insert IP location Into mp3_play_location
	$objDB->InsertIntoMP3PlayLocation($id, $_SERVER['REMOTE_ADDR']) ;
	
	$provider = $objDB->GetFieldValue($id, "provider") ;
	
	if(strcmp($provider, "http://www.mgoos.com") == 0)
	{
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
	}
	else
	{
		$filepath = $objDB->GetFieldValue($id, "filepath") ;
		
		if($filepath != '')
		{
			// Redirect directly to mp3 location
			header("Location: ".$filepath) ;
			/*
			// We'll be outputting a mp3
			header('Content-type: audio/mpeg');
		
			// It will be called [id].mp3
			//header('Content-Disposition: attachment; filename="'.$id.'.mp3"');
			header("Content-Transfer-Encoding: binary");
			//header("Content-Length: ".@filesize($filepath));

			echo(file_get_contents($filepath, FILE_BINARY, null)) ;
			*/
		}
	}	
?>