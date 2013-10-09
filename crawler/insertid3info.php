<?php

	include_once("../getid3/getid3.php");
	include_once("../lib/id3_info.php");
	include_once("../database/config.php");
	$userid="9ba7f5c9-dc3d-2a04-bd2a-00273fd9872e";
	$database="mgooscom_music";
	$db_link_id12 = mysql_connect(CConfig::HOST,CConfig::USER_NAME,CConfig::PASSWORD);
	mysql_select_db($database, $db_link_id12);
	if (ob_get_level() == 0) 
		ob_start();
	function uuid() 
	{
		// The field names refer to RFC 4122 section 4.1.2
		
		return sprintf('%04x%04x-%04x-%03x4-%04x-%04x%04x%04x',
			mt_rand(0, 65535), mt_rand(0, 65535), // 32 bits for "time_low"
			mt_rand(0, 65535), // 16 bits for "time_mid"
			mt_rand(0, 4095),  // 12 bits before the 0100 of (version) 4 for "time_hi_and_version"
			bindec(substr_replace(sprintf('%016b', mt_rand(0, 65535)), '01', 6, 2)),
				// 8 bits, the last two of which (positions 6 and 7) are 01, for "clk_seq_hi_res"
				// (hence, the 2nd hex digit after the 3rd hyphen can only be 1, 5, 9 or d)
				// 8 bits for "clk_seq_low"
			mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535) // 48 bits for "node" 
			); 
	}
	
	function InsertIntoMp3Info(CId3Info $id3info)
	{
		
		
		$id 			= mysql_escape_string($id3info->GetID()) ;
		$filepath 		= mysql_escape_string($id3info->GetFilePath()) ;
		$filesize 		= mysql_escape_string($id3info->GetFileSize()) ;
		$bitrate 		= mysql_escape_string($id3info->GetBitRate()) ;
		$duration_sec 	= mysql_escape_string($id3info->GetDurationSec()) ;
		$language		= mysql_escape_string($id3info->GetLanguage()) ;
		$status		 	= mysql_escape_string($id3info->GetStatus()) ; // 0 : Private, 1 : Public, 2: Issued Private
		$userid 		= mysql_escape_string($id3info->GetUserId()) ;
		$title 			= mysql_escape_string($id3info->GetTitle()) ;
		$artist 		= mysql_escape_string($id3info->GetArtist()) ;
		$album 			= mysql_escape_string($id3info->GetAlbum()) ;
		$lyrics 		= mysql_escape_string($id3info->GetLyrics()) ;
		$year 			= mysql_escape_string($id3info->GetYear()) ;
		$genre 			= mysql_escape_string($id3info->GetGenre()) ;
		$mood			= mysql_escape_string($id3info->GetMood()) ;
		$composer 		= mysql_escape_string($id3info->GetComposer()) ;
		$picturizedon 	= mysql_escape_string($id3info->GetPicturizedOn()) ;
		$provider		= mysql_escape_string($id3info->GetProvider()) ;

		$bResult = mysql_query("insert ignore into mp3_data (id, upload_date, filepath, filesize, bitrate, duration_sec, language, status, user_id, title, artist, album, lyrics, year, genre,mood, composer, picturizedon, provider) values ('$id', SYSDATE(), '$filepath', '$filesize', '$bitrate', '$duration_sec', '$language', $status, '$userid', '$title', '$artist', '$album', '$lyrics', '$year', '$genre','$mood', '$composer', '$picturizedon', '$provider') ;") or die("Sql insert error :- ".mysql_error());
	}
	
	
	$links=mysql_query("select * from mp3 where satus=0",$db_link_id12) or die("Sql select error :- ".mysql_error($db_link_id12));	
	$num_rows = mysql_num_rows($links);
	while($row = mysql_fetch_assoc($links))
	{
		$url=$row['url'];
		mysql_query("update mp3 set satus= 1 where url like '$url' ",$db_link_id12) or die("Sql update error :- ".mysql_error($db_link_id12));
		$file=fopen($url,"rb");
		$data=fread($file, 8192);
		fclose($file);
		$local_filename="remote_".implode("_",microtime()).".mp3";
		$file=fopen($local_filename,"wb");
		fwrite($file,$data);
		unset($data);
		fclose($file); 

		$obj = new getid3();
		$id3info = $obj->analyze($local_filename);
		unlink($local_filename); 
		
		$filenamepath = $url; //$id3info['filenamepath'] ;
		//$filesize = $id3info['filesize'] ;
		$bitrate = $id3info['audio']['bitrate'] / 1000 ; // Its in bps, convert it to kbps by dividing it to 1000.
		$duration_sec = $id3info['playtime_seconds'] ;
		//$user_id = CSessionManager::GetUserId() ;
		
		$provider=$row['source'];
		
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
		$u_composer = ucwords(strtolower($id3info['tag']['id3v2']['composer']['0'])); 
		if(empty($u_composer))
		{
			$u_composer=$id3info['id3v2']['comments']['composer']['0'];
		}
		
		$headers = get_headers($url, 1);
		
		$array ['filesize']=$headers['Content-Length']; // size in bytes
		$array ['id']= uuid();
		$array ['filepath']=$filenamepath;
		$array ['bitrate']=$bitrate;
		$array ['duration_sec']=$duration_sec;
		$array ['year']=$u_year;
		$array ['genre']=$u_gener;
		$array ['mood']=$u_mood;
		$array ['title']=$u_title;
		$array ['artist']=$u_artist;
		$array ['album']=$u_album;
		$array ['language']=$u_lang;
		//$array ['band']=$u_band;
		$array ['user_id']=$userid;
		$array ['composer']=$u_composer;
		$array ['provider']=$provider;
		$array ['lyrics']="";
		$array ['status']=1;
		$array ['picturizedon']="";

		
		$id3info_obj = new CId3Info($array);
		
		InsertIntoMp3Info($id3info_obj);
		echo "<pre>";
		echo "added info of:- ".$row['url']; 
		echo "</pre>";
		ob_flush();
		flush();
	}
	
ob_end_flush();
?>