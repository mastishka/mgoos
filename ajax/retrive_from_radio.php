<?php
include_once("../database/config.php");
$db_link_id ;
$database = "mgooscom_audio";
$db_link_id = mysql_connect(CConfig::HOST, CConfig::USER_NAME , CConfig::PASSWORD) or die("Could not connect: " . mysql_error());
mysql_select_db($database, $db_link_id);
mysql_query("delete from radio_playlist where time_stamp < SYSDATE()",$db_link_id) or die("Could not query: " . mysql_error());
$res = mysql_query("SELECT * FROM radio_playlist where time_stamp = (SELECT min(time_stamp) FROM radio_playlist where time_stamp > SYSDATE())",$db_link_id) or die("Could not query: " . mysql_error());
$rrow = mysql_fetch_object($res);
?>
{"result": 
	{"bResult": <?php echo("true"); ?>,
	 "id": "<?php echo $rrow->id; ?>",
	 "title": "<?php echo $rrow->title; ?>"
	}
}