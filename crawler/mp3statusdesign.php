<?php
include_once("../database/config.php");
	function flushHard()
	{
		// echo an extra 256 byte to the browswer - Fix for IE.
		for($i=1;$i<=256;++$i)
		{
			echo ' ';
		}
		flush();
		ob_flush();
	}
	
	//set_time_limit(0);
	header("Cache-Control: no-cache, must-revalidate");
	//flushHard();
	$database="mgooscom_audio";
	$db_link_id=mysql_connect(CConfig::HOST,CConfig::USER_NAME,CConfig::PASSWORD);
	mysql_select_db($database,$db_link_id);
	$links=mysql_query("select count(*) as count from crawled_mp3_urls where status =0",$db_link_id);
	$links1=mysql_query("select count(*) as count from crawled_nonmp3_urls where status =0",$db_link_id);
	while($row = mysql_fetch_assoc($links) )
	{
		$a=mysql_real_escape_string($row['count']);
	}
	while($row1 = mysql_fetch_assoc($links1))
	{
		$b=mysql_real_escape_string($row1['count']);
	}
	echo '<script type="text/javascript">parent.comet.update_status("MP3 not processed : '.$a.', Non-MP3 not processed : '.$b.'");</script>'."\n";
	flushHard();
?>