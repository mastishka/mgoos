<?php
    include("database/config.php");
    include("lib/utils.php");
    include("lib/session_manager.php");
	include("lib/mgoos_config.php");
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
		$link=CMGooSConfig::MGOOS_ROOT.'/error.php';
               echo "<meta http-equiv='refresh' content='0;url=$link'>";
    }
?>

<html>
<head>
<script src="js/ajax.js" type="text/javascript"></script>
<script src="js/swfobject.js" type="text/javascript"></script>
<script src="js/ep_player.js" type="text/javascript"></script>

</head>
<body>
<table><tr><td width='1300'>
<IFRAME Width="100%" HEIGHT="600" SRC="citation_confirm.php" SCROLLING="YES"> </IFRAME>
</td>
<td>
	<table>
	<tr>
	<td>
	<div id="ep_container1">To view the MGooS MP3 Player please update your <a href="http://www.adobe.com/go/getflashplayer/" target="_blank">Flash Player</a>.</div>
		
		<script type="text/javascript" defer="defer">
			
			////////////////////////////////////////////////////////////////////////////
			var flashvars = {};
			flashvars.skin 		= 'skins/nobius_mk2/skin.xml';
			flashvars.playlist 	= 'playlist.xml';
			flashvars.autoplay 	= 'false';
			flashvars.volume 	= '80';
			flashvars.shuffle 	= 'false';
			flashvars.key 		= 'DOLR9TXUDSFOFMXO30EU';
			
			////////////////////////////////////////////////////////////////////////////
			var params = {};
			params.allowScriptAccess = 'always';
			
			////////////////////////////////////////////////////////////////////////////
			var attributes = {};
			attributes.id = 'ep_player1';
			
			////////////////////////////////////////////////////////////////////////////
			swfobject.embedSWF(
				'swf/ep_player.swf', 			// the location of the swf file
				'ep_container1', 			// the id of the div to print the player in 
				'300', '400', 				// the width and height of the player
				'10.0.0',					// the required flash version 
				false,						// we've disabled express-install to keep it simple
				flashvars,
				params,
				attributes
			);
		</script>
	</td>
	</tr>
	<tr align="center">
	<td>
		<form action="login/logout.php" method="post">
		<input type = "submit" name ="logout_button" value="logout" >
		</form>
	</td>
	</tr>
	</table>
</td>
</tr>
</table>
</body>
</html>