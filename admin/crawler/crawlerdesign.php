<?php
	/*include("../../database/config.php");
	include("../../lib/utils.php");
	include("../../lib/session_manager.php");
	$database=CConfig::DB_ADMIN;
	$db_link_id;
	$db_link_id = mysql_connect(CConfig::HOST,CConfig::USER_NAME,CConfig::PASSWORD);
	mysql_select_db($database, $db_link_id);
	$result=mysql_query("select admin_id from administrators");
	$cur_user=CSessionManager::GetUserId();
	$flag=0;
	echo "outside while";
	while($row=mysql_fetch_array($result))
	{
		echo "inside while";
		if($cur_user == $row['admin_id'])
		{
			echo "inside if statement";
			$flag=1;
		}
	}
	if($flag == 0)
	{
		echo "inside flag check";
		header("Location: http://localhost/mgooscom/crawler/error.php");
	}
*/

?>
<html>
	<head>
		<title>Crawler Dash Board</title>
		<!--<script language='javascript' src='js/ajax.js'></script>-->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>

		<!--
			<script language="JavaScript" type="text/javascript">
			function CrawlSite()
			{
				var poststr = "site=" + encodeURI( get_radio_value() );
				
				alert(poststr) ;
				AJAX.MakePostRequest("crawlerphase1withcurl.php", poststr, CallBack_CrawlSite);
			}

			function CallBack_CrawlSite()
			{
				var contents = AJAX.GetContents() ;
				//alert(contents) ;
				if(contents != false)
				{
					alert(contents) ;
				}
			}

			</script>
		-->
	</head>
	<body>
		<h1> Generic Music crawler </h1>
		<FORM name ="select_site">
		<?php
			include_once("../database/config.php");
			$database=CConfig::DB_AUDIO;
			$db_link_id;
			$db_link_id = mysql_connect(CConfig::HOST,CConfig::USER_NAME,CConfig::PASSWORD);
			mysql_select_db($database, $db_link_id);
			$links=mysql_query("select * from crawled_rooturls",$db_link_id) or die;
			
			while($row = mysql_fetch_assoc($links))
			{	
				$url=$row ['url'];
				echo "<Input type = 'Radio' Name ='site' value= '".$url."'/>".$url."</br>";
			}
		?>
		
		<div id="comet_frame_truncate" style="display:none;visablity:invisable;"></div>
		</br>
		<input id="truncatebutton" type= "button" onclick="truncate();" value='Truncate crawled_nonmp3_urls '">
		<input id="startbutton" type = 'button' onClick="this.disabled=true;document.getElementById('stopbutton').disabled=false;comet.load_crawlerstatus();" Name = 'crwlurl' VALUE = 'Start Crawling'/>
		<input id="stopbutton" type = 'button' onClick="this.disabled=true;document.getElementById('startbutton').disabled=false;comet.unload();" Name = 'stopurl' VALUE = 'Stop Crawling'/>
		
		
		</form>
		
		<form action='addrooturl.php' method ="post">
			<input type="text" name="addurl" >
			<input type = "submit" name ="addnewurl" value= "add website" />
		</form>
		
			
		
		<div id="comet_frame" style="display:none;visablity:invisable;"></div>
		<div id="content"></div> <br />
		<div id="content1"></div> <br />
			
		<input type = "button" name ="check_status" onClick="comet.load_mp3status();"  value= "Check URL table Status" />
		<div id="comet_frame1" style="display:none;visablity:invisable;"></div>
		<br /><div id="content2"></div><br />	
		<form action="../login/logout.php" method="post">
		<input type = "submit" name ="logout_button" value="logout" >
		</br>
		<div id="content3"></div> <br />
		</form>
	</body>
</html>

<script type="text/javascript">
 
	/*function check_box()
	{
		var a="asdfgh";
		if(document.select_site.truncate.checked == true)
		{
			return a;
		}
	}*/

	function truncate()
	{
		$("#comet_frame_truncate").html('<iframe id="comet_iframe" src="crawlerphase1withcurl.php?mode=2"></iframe>');
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
	/*function check_mode()
	{
		if(get_radio_value())
		{
			return 1;
		}
		else if(checkbox_truncate() == 1)
		{
			return 2;
		}
		
	}*/
	var comet =
	{
    load_crawlerstatus: function()
     {
		$("#comet_frame").html('<iframe id="comet_iframe" src="crawlerphase1withcurl.php?mode=1&asite='+encodeURI(get_radio_value())+'"></iframe>');
		/*if(checkbox_truncate())
		$("#comet_frame_truncate").html('<iframe id="comet_iframe_truncate" src="truncate.php"></iframe>');*/
     },
	load_mp3status: function()
	{
		$("#comet_frame1").html('<iframe id="comet_iframe1" src="crawlerphase1withcurl.php?mode=4"></iframe>');
	 },
    unload: function()
     {
		$("#comet_frame").html('<iframe id="comet_iframe" src=""></ iframe>');
     },
    clearFrame: function()
     {
		$("#comet_iframe").html("");
     },
    update: function(result)
     {
		$("#content").html(result);
     },
	update_mp3: function(result)
	{
		$("#content1").html(result);
	},
	update_status:function(result)
	{
		$("#content2").html(result);
	},
	update_truncate:function(result)
	{
		$("#content3").html(result);
	}
   }
</script>



