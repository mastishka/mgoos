<?php
	include_once("../database/config.php");
	include_once("../lib/utils.php");
	$id = $_POST["id"];
	$title = $_POST["title"];
	$album = $_POST["album"];
	$artist = $_POST["artist"];
	$genre = $_POST["genre"];
	$language = $_POST["language"];
	$composer = $_POST["composer"];
	$pict = $_POST["pict"];
	$year = $_POST["year"];
	$database = "mgooscom_audio";
	$db_link_id = mysql_connect(CConfig::HOST, CConfig::USER_NAME , CConfig::PASSWORD) or die("Could not connect: " . mysql_error());
	
	mysql_select_db($database, $db_link_id);
	if(!empty($title))
	{
		$res=mysql_query("update mp3_info set title='$title' where id='$id'",$db_link_id) or die("mp3_info update error: " . mysql_error());
		$met_title=CUtils::GetHindiPhonetic($title);
		$met_res=mysql_query("update mp3_hphonetic_info set title='$met_title' where id='$id'",$db_link_id) or die("mp3_hphonetic_info update error: " . mysql_error());
	}
	if(!empty($album))
	{
		$res=mysql_query("update mp3_info set album='$album' where id='$id'",$db_link_id) or die("mp3_info update error: " . mysql_error());
		$met_album=CUtils::GetHindiPhonetic($album);
		$met_res=mysql_query("update mp3_hphonetic_info set album='$met_album' where id='$id'",$db_link_id) or die("mp3_hphonetic_info update error: " . mysql_error());
	}
	if(!empty($artist))
	{
		$res=mysql_query("update mp3_info set artist='$artist' where id='$id'",$db_link_id) or die("mp3_info update error: " . mysql_error());
		$met_artist=CUtils::GetHindiPhonetic($artist);
		$met_res=mysql_query("update mp3_hphonetic_info set artist='$met_artist' where id='$id'",$db_link_id) or die("mp3_hphonetic_info update error: " . mysql_error());
	}
	if(!empty($genre))
	{
		$res=mysql_query("update mp3_info set genre='$genre' where id='$id'",$db_link_id) or die("mp3_info update error: " . mysql_error());
		$met_genre=CUtils::GetHindiPhonetic($genre);
		$met_res=mysql_query("update mp3_hphonetic_info set genre='$met_genre' where id='$id'",$db_link_id) or die("mp3_hphonetic_info update error: " . mysql_error());
	}
	if(!empty($language))
	{
		$res=mysql_query("update mp3_info set language='$language' where id='$id'",$db_link_id) or die("mp3_info update error: " . mysql_error());
	}
	if(!empty($composer))
	{
		$res=mysql_query("update mp3_info set composer='$composer' where id='$id'",$db_link_id) or die("mp3_info update error: " . mysql_error());
		$met_composer=CUtils::GetHindiPhonetic($composer);
		$met_res=mysql_query("update mp3_hphonetic_info set composer='$met_composer' where id='$id'",$db_link_id) or die("mp3_hphonetic_info update error: " . mysql_error());
	}
	if(!empty($pict))
	{
		$res=mysql_query("update mp3_info set picturizedon='$pict' where id='$id'",$db_link_id) or die("mp3_info update error: " . mysql_error());
		$met_pict=CUtils::GetHindiPhonetic($pict);
		$met_res=mysql_query("update mp3_hphonetic_info set picturizedon='$met_pict' where id='$id'",$db_link_id) or die("mp3_hphonetic_info update error: " . mysql_error());
	}
	if(!empty($year))
	{
		$res=mysql_query("update mp3_info set year='$year' where id='$id'",$db_link_id) or die("mp3_info update error: " . mysql_error());
	}
	$end=mysql_query("delete from citation_request where songid='$id'",$db_link_id) or die("delete from citation_request error: " . mysql_error());
	mysql_close($db_link_id);
?>