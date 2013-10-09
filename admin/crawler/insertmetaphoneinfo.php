<?php
include_once("../../database/config.php");
include_once("../../lib/utils.php");
/*function flushHard()
	{
		// echo an extra 256 byte to the browswer - Fix for IE.
		for($i=1;$i<=256;++$i)
		{
			echo ' ';
		}
		flush();
		ob_flush();
	}*/
	if (ob_get_level() == 0) 
		ob_start();


	//$database="mgooscom_music";
	$db_link_id;
	$db_link_id = mysql_connect(CConfig::HOST,CConfig::USER_NAME,CConfig::PASSWORD);
	mysql_select_db(CConfig::DB_AUDIO, $db_link_id);
	$links=mysql_query("select * from mp3_info , mp3_hphonetic_info where ",$db_link_id);
	$num_rows = mysql_num_rows($links);
	while($row = mysql_fetch_array($links))
	{
		$id=$row['id'];
		$title=Cutils::GetHindiPhonetic($row['title']);
		$album=Cutils::GetHindiPhonetic($row['album']);
		$artist=Cutils::GetHindiPhonetic($row['artist']);
		$genre=Cutils::GetHindiPhonetic($row['genre']);
		$composer=Cutils::GetHindiPhonetic($row['composer']);
		$picturizedon=Cutils::GetHindiPhonetic($row['picturizedon']);
		$lyrics=Cutils::GetHindiPhonetic($row['lyrics']);
		mysql_query("insert ignore into mp3_metaphone_data values('$id','$title','$album','$artist','$genre','$composer','$picturizedon','$lyrics')",$db_link_id);
		echo "Info added for :".$title;
		flushHard();
	
	}
ob_end_flush();
?>
