<?php

	$database="ali";
	$db_link_id;
	$db_link_id = mysql_connect('localhost','root','');
	mysql_select_db($database, $db_link_id);
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
 

set_time_limit(0);
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
flushHard();
$x=0;
while(1)
{
	echo '<script type="text/javascript">parent.test.disp("'.$x.'");</script>'."\n";
	mysql_query("insert into test values ($x)",$db_link_id) or die ("Sql insert error :- ".mysql_error($db_link_id));
	flushHard();
	++$x;
	sleep(2);
}
?>