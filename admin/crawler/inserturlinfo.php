<?php

	include_once("../../lib/utils.php");
	include_once("../../getid3/getid3.php");
	include_once("../../lib/id3_info.php");
	include_once("../../database/config.php");
	function InsertIntoMp3Info(CId3Info $id3info)
	{
		$bRet = 0;
		$database="mgooscom_audio";
		$db_link_id1;
		$db_link_id1 = mysql_connect(CConfig::HOST,CConfig::USER_NAME,CConfig::PASSWORD);
		mysql_select_db($database, $db_link_id1);
		
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
		
		
		$bResult = mysql_query("insert ignore into mp3_info (id, upload_date, filepath, filesize, bitrate, duration_sec, language, status, user_id, title, artist, album, lyrics, year, genre,mood, composer, picturizedon, provider) values ('$id', SYSDATE(), '$filepath', '$filesize', '$bitrate', '$duration_sec', '$language', $status, '$userid', '$title', '$artist', '$album', '$lyrics', '$year', '$genre','$mood', '$composer', '$picturizedon', '$provider') ;",$db_link_id1) or die("Sql insert error :- ".mysql_error());

		if($bResult)
		{
			$bRet = 1;
		}
		
		return $bRet;
	}
	
	function insertinfo($url,$source)
	{
		//$database="mgooscom_audio";
		$db_link_id1;
		$db_link_id1 = mysql_connect(CConfig::HOST,CConfig::USER_NAME,CConfig::PASSWORD);
		mysql_select_db(CConfig::DB_AUDIO, $db_link_id1);
		
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
		$userid="9ba7f5c9-dc3d-2a04-bd2a-00273fd9872e";
		$provider=$source;
		
		$u_year = ucwords(strtolower($id3info['tags']['id3v2']['year']['0'])) ;
		if(empty($u_year))
		{
			$u_year = ucwords(strtolower($id3info['id3v2']['comments']['year']['0'])) ;
			if(empty($u_year))
			{
				$u_year = "Unknown" ;
			}
		}
		
		$u_gener = ucwords(strtolower($id3info['tags']['id3v2']['genre']['0'])) ;
		if(empty($u_gener) || strcasecmp($u_gener,"other") == 0)
		{
			$u_gener = ucwords(strtolower($id3info['id3v2']['comments']['content_type']['0'])) ;
			if(empty($u_gener))
			{
				$u_gener = "Unknown" ;
			}
		}
		
		$u_mood = "Unknown";
		
		$u_title = ucwords(strtolower($id3info['tags']['id3v2']['title']['0'])) ;
		if(empty($u_title))
		{
			$u_title = ucwords(strtolower($id3info['id3v2']['comments']['title']['0'])) ;
		}
		
		$u_artist = ucwords(strtolower($id3info['tags']['id3v2']['artist']['0'])) ;
		if(empty($u_artist))
		{
			$u_artist = ucwords(strtolower($id3info['id3v2']['comments']['artist']['0'])) ;
		}
		
		$u_album = ucwords(strtolower($id3info['tags']['id3v2']['album']['0'])) ;
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
		
		
		if(strcmp($u_lang,"")==0)
		{
			$u_lang="Unknown";
		}
		if(strcmp($u_title,"")==0)
		{
			$u_title="Unknown";
		}
		if(strcmp($u_artist,"")==0)
		{
			$u_artist="Unknown";
		}
		if(strcmp($u_album,"")==0)
		{
			$u_album="Unknown";
		}
		if(strcmp($u_year,"")==0)
		{
			$u_year="Unknown";
		}
		if(strcmp($u_gener,"")==0)
		{
			$u_gener="Unknown";
		}
		if(strcmp($u_mood,"")==0)
		{
			$u_mood="Unknown";
		}
		if(strcmp($u_composer,"")==0)
		{
			$u_composer="Unknown";
		}
		

		$id=Cutils::uuid();
		$headers = get_headers($url, 1);
		$array ['filesize']=$headers['Content-Length']; // size in bytes
		$array ['id']= $id;
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

		$met_id=$id;
		$met_title=Cutils::GetHindiPhonetic($u_title);
		$met_album=Cutils::GetHindiPhonetic($u_album);
		$met_artist=Cutils::GetHindiPhonetic($u_artist);
		$met_genre=Cutils::GetHindiPhonetic($u_gener);
		$met_composer=Cutils::GetHindiPhonetic($u_composer);
		$met_picturizedon=Cutils::GetHindiPhonetic("");
		$met_lyrics=Cutils::GetHindiPhonetic("");
		mysql_query("insert ignore into mp3_hphonetic_info values('$met_id','$met_title','$met_album','$met_artist','$met_genre','$met_composer','$met_picturizedon','$met_lyrics')",$db_link_id1);
		
	}
?>