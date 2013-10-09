<?php
	include_once("../database/config.php");
	$id = $_POST["id"];
	$title = $_POST["title"];
	$database1 = "mgooscom_audio";
	$db_link_id1 = mysql_connect(CConfig::HOST, CConfig::USER_NAME , CConfig::PASSWORD) or die("Could not connect: " . mysql_error());
	
	mysql_select_db($database1, $db_link_id1);
	
	$sec = mysql_query("select duration_sec from mp3_info where id like '".$id."'",$db_link_id1) or die("Could not query: " . mysql_error());
	$m = mysql_query("select max(time_stamp) as t from radio_playlist",$db_link_id1) or die("Could not query: " . mysql_error());
	$mrow = mysql_fetch_object($m);
	$query = "select SYSDATE() as s";
	$now = mysql_query($query,$db_link_id1);
	$nrow = mysql_fetch_object($now);
	echo $nrow->s;
	$row = mysql_fetch_object($sec);
	if(($row->duration_sec) > 10)
	{

	}
	else
		$row->duration_sec = 300;
	
	if($nrow->s < $mrow->t)
	{
		$query = "insert ignore into radio_playlist values ('".$id."','".$title."',TIMESTAMPADD(SECOND,".$row->duration_sec.",'".$mrow->t."'))";
		//echo $query;
		mysql_query($query,$db_link_id1) or die("Could not query: " . mysql_error());
		
		
	}
	else
	{
		$query = "insert ignore into radio_playlist values ('".$id."','".$title."',TIMESTAMPADD(SECOND,".$row->duration_sec.",SYSDATE()))";
		//echo $query;
		mysql_query($query,$db_link_id1) or die("Could not query: " . mysql_error());
	}

	if(mysql_affected_rows($db_link_id1)>0)
	{
		mysql_close($db_link_id1);
		$database2 = "mgooscom_analytics";
		$db_link_id2 = mysql_connect(CConfig::HOST, CConfig::USER_NAME , CConfig::PASSWORD) or die("Could not connect: " . mysql_error());
		mysql_select_db($database2, $db_link_id2);
		$query = "insert into radio_analytics values ('".$id."','".$title."')";
		//echo $query;
		mysql_query($query,$db_link_id2) or die("Could not query: " . mysql_error());
	}
?>