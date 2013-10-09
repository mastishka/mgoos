<?php
	// -------------------------------------------
	// Start session
	// -------------------------------------------
	include_once("../lib/session_manager.php") ;
	// -------------------------------------------
	
	include_once("../getid3/getid3.php");
	include_once("../database/queries.php");
	include_once("../lib/utils.php");
	
	$MAX_LIMIT = 600;
	$MAX_DIR = 1000;
	    
	// Check the upload
	if (!isset($_FILES['Filedata']) || !is_uploaded_file($_FILES['Filedata']['tmp_name']) || $_FILES['Filedata']['error'] != 0) 
	{
		echo ("Invalid File") ;
		//echo ("Invalid File, Temp Name: ".$_FILES['Filedata']['tmp_name']." Error: ".$_FILES['Filedata']['error']."<BR/>");
		
		/*echo ("<pre>");
		print_r ($_FILES);
		echo ("</pre>");*/
		
		exit(0);
	}
	
	//Debug Code
	//echo ("Exiting...");
	//exit(0);
	
	$uuid = CUtils::uuid();		
	for($i = 0; $i < $MAX_DIR; $i++)
	{
		if($i==0)
			$uploaddir = getcwd().'/temp/';/*for first level*/
		else
			$uploaddir = getcwd().'/temp'.$i. '/';
		if(!file_exists($uploaddir))		
			mkdir($uploaddir,0777);			
		$count = count(glob($uploaddir. "*"));
		if($count < $MAX_LIMIT)
		   break;		
	}
	$uploadfile = $uploaddir.$uuid;

	if (!move_uploaded_file($_FILES['Filedata']['tmp_name'], $uploadfile)) 
	{
		header("HTTP/1.1 500 Internal Server Error");
		//echo "could not create mp3 handle";
		exit(0);
	}
	
	$obj = new getid3();
	$id3info = $obj->analyze($uploadfile);
	
	/*echo("<PRE>") ;
	print_r($id3info['id3v2']['comments']['band']) ;
	echo("</PRE>") ;*/
	
	// Encode Mp3 File.
	CUtils::EncodeMp3($uploadfile);
	
	$filepath = $id3info['filenamepath'] ;
	$filesize = $id3info['filesize'] ;
	$bitrate = $id3info['audio']['bitrate'] / 1000 ; // Its in bps, convert it to kbps by dividing it to 1000.
	$duration_sec = $id3info['playtime_seconds'] ;
	$user_id = CSessionManager::GetUserId() ;
	
	$u_year = ucwords(strtolower($id3info['tags']['id3v1']['year']['0'])) ;
	if(empty($u_year))
	{
		$u_year = ucwords(strtolower($id3info['id3v2']['comments']['year']['0'])) ;
		if(empty($u_year))
		{
			$u_year = "Unknown" ;
		}
	}
	
	$u_gener = ucwords(strtolower($id3info['tags']['id3v1']['genre']['0'])) ;
	if(empty($u_gener) || strcasecmp($u_gener,"other") == 0)
	{
		$u_gener = ucwords(strtolower($id3info['id3v2']['comments']['content_type']['0'])) ;
		if(empty($u_gener))
		{
			$u_gener = "Unknown" ;
		}
	}
	
	$u_mood = "Unknown";
	
	$u_title = ucwords(strtolower($id3info['tags']['id3v1']['title']['0'])) ;
	if(empty($u_title))
	{
		$u_title = ucwords(strtolower($id3info['id3v2']['comments']['title']['0'])) ;
	}
	
	$u_artist = ucwords(strtolower($id3info['tags']['id3v1']['artist']['0'])) ;
	if(empty($u_artist))
	{
		$u_artist = ucwords(strtolower($id3info['id3v2']['comments']['artist']['0'])) ;
	}
	
	$u_album = ucwords(strtolower($id3info['tags']['id3v1']['album']['0'])) ;
	if(empty($u_album))
	{
		$u_album = ucwords(strtolower($id3info['id3v2']['comments']['album']['0'])) ;
	}
	
	$u_lang = ucwords(strtolower($id3info['id3v2']['COMM']['0']['languagename'])) ;
	if(empty($u_lang))
	{
		$u_lang = ucwords(strtolower($id3info['id3v2']['COMM']['1']['languagename'])) ;
		if(empty($u_lang))
		{
			$u_lang = "Hindi" ;
		}
	}
	
	$u_band = ucwords(strtolower($id3info['id3v2']['comments']['band']['0'])) ;
	if(empty($u_band))
	{
		$u_band = "Unknown" ;
	}
	
	$objDB = new CQueryManager(CConfig::DB_ADMIN) ;
	
	$objDB->InsertIntoAdminMP3Info($uuid, $filesize,
									$bitrate, $duration_sec,
									$u_year,  $u_gener, $u_mood,
									$u_title, $u_artist,
									$u_album, $u_lang) ;
?>
