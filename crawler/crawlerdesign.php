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
			$database="mgooscom_audio";
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
		$("#comet_frame").html('<iframe id="comet_iframe" src="crawlerphase1withcurl.php?asite='+encodeURI(get_radio_value())+'"></iframe>');
     },
	load_mp3status: function()
	{
		$("#comet_frame1").html('<iframe id="comet_iframe1" src="mp3statusdesign.php"></iframe>');
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
	}
   }
</script>



