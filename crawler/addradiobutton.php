<?php
		$database="ali";
		$db_link_id;
		$db_link_id = mysql_connect('localhost','root','');
		mysql_select_db($database, $db_link_id);
		if(isset($_POST['addnew']))
		{
			$new=$_POST['addurl'];
			mysql_query('insert ignore into rooturls values ('$new')',$db_link_id);
		}
		include('radiodisplay.php'); 
		
?>