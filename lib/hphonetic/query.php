<?php
include("utils.php");
$con = mysql_connect("localhost", "mgooscom_ritesh", "ritesh");
$database = "mgooscom_audio" ;
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

$db_selected = mysql_select_db($database,$con);
$sql = "select language, id, title, artist, album, lyrics, genre, composer, picturizedon from mp3_info";
//$delete = "delete * from mp3_hphonetic_info";
//$dummy = mysql_query($delete,$con);
$result = mysql_query($sql,$con) or die("Select Error: ".mysql_error());

while ($row = mysql_fetch_object($result))
  {
	$id = $row->id;
	//if($row->language=="Hindi")
	
		//echo "$row->title\n";
	
		$title = CUtils::GetHindiPhonetic($row->title);
		$artist = CUtils::GetHindiPhonetic($row->artist);
		$album = CUtils::GetHindiPhonetic($row->album);
		$lyrics = CUtils::GetHindiPhonetic($row->lyrics);
		$genre = CUtils::GetHindiPhonetic($row->genre);
		$composer = CUtils::GetHindiPhonetic($row->composer);
		$picturizedon = CUtils::GetHindiPhonetic($row->picturizedon);
	
	/*else 
	{
		$title = CUtils::GetMetaphone($row->title);
		$artist = CUtils::GetMetaphone($row->artist);
		$album = CUtils::GetMetaphone($row->album);
		$lyrics = CUtils::GetMetaphone($row->lyrics);
		$genre = CUtils::GetMetaphone($row->genre);
		$composer = CUtils::GetMetaphone($row->composer);
		$picturizedon = CUtils::GetMetaphone($row->picturizedon);
	}*/
		
	mysql_query("insert into mp3_hphonetic_info values ('".$id."','".$title."','".$album."','".$artist."','".$genre."','".$composer."','".$picturizedon."','".$lyrics."')") or die("Insert Error: ".mysql_error());
	
}

mysql_close($con);
?>