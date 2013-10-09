<?php
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
 

$x = 0;
while(1)
 {
  if($x == 10)
   {
    echo '<script type="text/javascript">parent.comet.clearFrame();</script>'."\n";
   }
  else
   {
    echo '<script type="text/javascript">parent.comet.timer("'.date('H:i:s').'");</script>'."\n";
   }
  flushHard();
  ++$x;
  sleep(1);
 }
?>