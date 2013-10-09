<?php
	include_once("../database/config.php");
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
	$res=mysql_query("insert into citation_request values ('$id','$title','$album','$artist','$genre','$language','$composer','$pict','$year')",$db_link_id) or die("Could not query: " . mysql_error());
	mysql_close($db_link_id);
?>