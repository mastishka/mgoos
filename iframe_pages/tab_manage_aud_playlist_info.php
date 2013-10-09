<?php
	// Start session
	include_once("../lib/session_manager.php") ;
	include_once("../database/queries.php");
	$objDB = new CQueryManager(CConfig::DB_AUDIO) ;	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Untitled Document</title>
</head>

<body>

<HTML>
	<HEAD>
		<TITLE>Playlist Info</TITLE>
		<script language="javascript" type="text/javascript">
			function OnRemovePlaylistElmt(pid, id, title, pageno)
			{
				if(confirm("Are you sure you want to remove audio : "+title+" ?" ))
				{
					window.location = "tab_manage_aud_rem_pl_elm.php?pid="+pid+"&pg="+pageno+"&id="+id;
				}
			}
		</script>
	</HEAD>		
	<BODY>
		<FIELDSET>
			<?php
				include("../lib/utils.php") ;
			
				$url = CUtils::curPageURL() ;
				$query_str = parse_url($url); // will return array of url components.
				parse_str($query_str["query"]) ; // the query string will be parsed here.
				if(empty($pg))
				 {
				 	$pg = 1;
				 }
				
				$objDB-> PreparePlaylistInfo($pid,$pg);
			?>
		</FIELDSET>
	</BODY>
</HTML>
</body>
</html>

