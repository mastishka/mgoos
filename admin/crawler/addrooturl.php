<?php
		include('../../lib/utils.php');
		include('../../database/config.php');
		$database="mgooscom_audio";
		$db_link_id;
		$db_link_id = mysql_connect(CConfig::HOST,CConfig::USER_NAME,CConfig::PASSWORD);
		mysql_select_db($database, $db_link_id);
		if(isset($_POST['addurl']))
		{
			//echo " test <br/>";
			$new = $_POST['addurl'];
			mysql_query('insert ignore into crawled_rooturls values ("'.mysql_real_escape_string($new).'")',$db_link_id) or die("Get RootUrl Error: ".mysql_error($db_link_id));
		}

		CUtils::Redirect("crawler_dashboard.php");
?>