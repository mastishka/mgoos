<?php
	// Start session
	include_once("../lib/session_manager.php") ;
	include_once("../database/queries.php");
	include_once("../lib/utils.php");
	$objDB = new CQueryManager(CConfig::DB_AUDIO) ;	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
	<HEAD>
		<TITLE>Playlist</TITLE>
		<script language="javascript" type="text/javascript">
		function OnRemoveBookmark(id, pageno, title)
		{
			if(confirm("Are you sure you want to remove bookmark: "+title+" ?" ))
			{
				window.location = "tab_manage_aud_rem_bm.php?id="+id+"&pg="+pageno;
			}
		}
		
		</script>
	</HEAD>		
	<BODY>
		<FIELDSET>
			<LEGEND>My Playlists</LEGEND>
			<?php
			$url = CUtils::curPageURL() ;
			$query_str = parse_url($url); // will return array of url components.
			parse_str($query_str["query"]) ; // the query string will be parsed here.
			if(empty($pg))
			{
			 $pg = 1;
			}
			$objDB->PrepareBookMarksInfo(CSessionManager::GetUserId(),$pg);
			?>
		</FIELDSET>
	</BODY>
</HTML>