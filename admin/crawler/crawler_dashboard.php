<?php

	include("../../database/config.php");
	include("../../lib/utils.php");
	include("../../lib/session_manager.php");
	include("../../lib/mgoos_config.php");
	$database=CConfig::DB_ADMIN;
	$db_link_id;
	$db_link_id = mysql_connect(CConfig::HOST,CConfig::USER_NAME,CConfig::PASSWORD);
	mysql_select_db($database, $db_link_id);
	$result=mysql_query("select admin_id from administrators");
	$cur_user=CSessionManager::GetUserId();
	$flag=0;
	//echo "outside while";
	while($row=mysql_fetch_array($result))
	{
		//echo "inside while";
		if($cur_user == $row['admin_id'])
		{
			//echo "inside if statement";
			$flag=1;
		}
	}
	if($flag == 0)
	{
		//echo "inside flag check";
		$link=CMGooSConfig::MGOOS_ROOT.'/error.php';
		echo "<meta http-equiv='refresh' content='0;url=$link'>";
	}
?>


<html>
	<head>
		<title>Crawler Dash Board</title>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
	</head>
	<body>
		<fieldset>
			<legend>Generic Music crawler</legend>
			<form name ="select_site">
				<?php
					include_once("../../database/config.php");
					$database=CConfig::DB_AUDIO;
					$db_link_id;
					$db_link_id = mysql_connect(CConfig::HOST,CConfig::USER_NAME,CConfig::PASSWORD);
					mysql_select_db($database, $db_link_id);
					$links=mysql_query("select * from crawled_rooturls",$db_link_id) or die;
					
					while($row = mysql_fetch_assoc($links))
					{	
						$url=$row ['url'];
						echo "<Input type = 'Radio' Name ='site' value='".$url."'/>".$url."</br>";
					}
				?><br/>
				<div id="comet_iframe_crawler_engine_working_on"></div> <br/>
				<div id="comet_iframe_crawler_engine_stats"></div> <br/>				
				<input id="startbutton" type = 'button' onClick="this.disabled=true;document.getElementById('stopbutton').disabled=false;comet.load_crawlerstatus();" Name = 'crwlurl' VALUE = 'Start Crawling'/>
				<input id="stopbutton" type = 'button' onClick="this.disabled=true;document.getElementById('startbutton').disabled=false;comet.unload();" Name = 'stopurl' VALUE = 'Stop Crawling'/>
			</form>
			<input id="truncatebutton" type= "button" onclick="truncate();this.disabled=true;" value='Truncate crawled_nonmp3_urls '"/><br/><br/>
			<form action="../login/logout.php" method="post">
				<input type = "submit" name ="logout_button" value="logout" >
			</form>
		</fieldset>
		
		<fieldset>
			<legend>Add Website</legend>
			<form action='addrooturl.php' method ="post">
				<input type="text" name="addurl" >
				<input type = "submit" name ="addnewurl" value= "add website" />
			</form>
		</fieldset>
		
		<fieldset>
			<legend>Process Crawled Mp3s</legend>
			<form name ="process_mp3s">
				<br /><div id="content_insert"></div> <br />
				<div id="comet_frame_insert" style="display:none;visibility:invisable;"></div>
				<input id="startinsert" type="button" onClick="this.disabled=true;document.getElementById('stopinsert').disabled=false;comet.load_insertid3info();" value="Start Processing "/>
				<input id="stopinsert" type="button" onClick="this.disabled=true;document.getElementById('startinsert').disabled=false;comet.unload_insert()" value="Stop Processing "/>
				</br>
			</form>
			
		</fieldset>

		<fieldset>
			<legend>Crawler Status</legend>
			<input type = "button" name ="check_status" onClick="comet.load_mp3status();"  value= "Check URL table Status" />
			<br/><div id="comet_iframe_crawler_stats"></div><br/>
		</fieldset>

		<fieldset>
			<legend>Reconciliation</legend>
			<input type = "button" name ="reconcile" onClick="comet.load_reconciliation();"  value= "Reconcile" />
			<br/><div id="comet_iframe_crawler_reconcile"></div><br/>
		</fieldset>

		<fieldset>
			<legend>Logout</legend>
			<form action="../../login/logout.php" method="post">
			<input type = "submit" name ="logout_button" value="logout" >
			</form>
		</fieldset>

		<!-- IFrames : Start-->
		<div id="comet_iframe_crawler_engine_div" style="display:none;visibility:invisable;"></div>
		<div id="comet_iframe_crawler_db_stats_div" style="display:none;visibility:invisable;"></div>
		<div id="comet_iframe_crawler_process_mp3s_div" style="display:none;visibility:invisable;"></div>
		<div id="comet_iframe_crawler_reconcile_div" style="display:none;visibility:invisable;"></div>
		<!-- IFrames : End-->
			
	</body>
</html>

<script type="text/javascript">
	function truncate()
	{
		$("#comet_frame_truncate").html('<iframe id="comet_iframe_tuncate" src="crawler_engine.php?mode=2"></iframe>');
		//alert("In truncate function");
	}

	function get_radio_value()
	{
		var rad_val;
		var sites = document.getElementsByName('site');
		
		for (var i=0; i < sites.length; i++)
		{
			if (sites[i].checked)
			{
				rad_val = sites[i].value;
			}
		}

		return rad_val;
	}
	
	var comet =
	{
		load_crawlerstatus: function()
		{
			$("#comet_iframe_crawler_engine_div").html('<iframe id="comet_iframe_crawler_engine" src="crawler_engine.php?mode=1&asite='+encodeURI(get_radio_value())+'"></iframe>');
		},
		unload: function()
		{
			$("#comet_iframe_crawler_engine_div").html('<iframe id="comet_iframe_crawler_engine" src=""></ iframe>');
		},
		clearFrame: function()
		{
			$("#comet_iframe_crawler_engine_div").html("");
		},
		update_mp3_crawling_stats: function(result)
		{
			$("#comet_iframe_crawler_engine_stats").html(result);
		},
		update: function(result)
		{
			$("#comet_iframe_crawler_engine_working_on").html(result);
		},		
		load_mp3status: function()
		{
			$("#comet_iframe_crawler_db_stats_div").html('<iframe id="comet_iframe_crawler_db_stats" src="crawler_engine.php?mode=4"></iframe>');
		},
		update_status:function(result)
		{
			$("#comet_iframe_crawler_stats").html(result);
		},
		load_insertid3info: function()
		{
			 $("#comet_iframe_crawler_process_mp3s_div").html('<iframe id="comet_iframe_crawler_process_mp3s" src="crawler_engine.php?mode=3")></iframe>');
		},
		unload_insert: function()
		{
			$("#comet_iframe_crawler_process_mp3s_div").html('<iframe id="comet_iframe_crawler_process_mp3s" src=""></ iframe>');
		},
		update_insert: function(result)
		{
			$("#content_insert").html(result);
		},
		load_reconciliation:function()
		{
			$("#comet_iframe_crawler_reconcile_div").html('<iframe id="comet_iframe_crawler_reconcilation" src="crawler_engine.php?mode=5")></iframe>');
		},
		update_reconciliation_status:function(result)
		{
			$("#comet_iframe_crawler_reconcile").html(result);
		}

   }
</script>
