<?php
		$database="ali";
		$db_link_id;
		$db_link_id = mysql_connect('localhost','root','');
		mysql_select_db($database, $db_link_id);
		$links=mysql_query("select * from rooturls",$db_link_id);
		
		while($row = mysql_fetch_assoc($links))
		{	
			$url=$row ['url'];
			echo "<Input type = 'Radio' Name ='site' value= '".$url."'/>".$url."</br>";
		}
	?>