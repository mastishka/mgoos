<?php
	include_once("../lib/utils.php") ;
	include_once("../lib/id3_info.php") ;
	include_once("../database/queries.php") ;
			
	$url = CUtils::curPageURL() ;
	$query_str = parse_url($url); // will return array of url components.
	parse_str($query_str["query"]) ; // the query string will be parsed here.
	
	$objDB = new CQueryManager(CConfig::DB_AUDIO) ;
	$r_title = $objDB->GetFieldValue($id, "title") ;
?>
<HTML>
	<HEAD>
		<TITLE></TITLE>
		<SCRIPT TYPE="text/javascript" LANGUAGE="javascript">
			function OnYes()
			{
				var page = <?php echo($pg); ?> ;
				if (page == 1)
				{
					window.location = "tab_manage_aud_remove_confirm.php?id=<?php echo($id); ?>&pg=<?php echo($pg); ?>" ;
				}
				else if (page == 2)
				{
					window.location = "tab_manage_aud_remove_confirm.php?id=<?php echo($id); ?>&pg=<?php echo($pg); ?>" ;
				}
			}
			function OnNo()
			{
				var page = <?php echo($pg); ?> ;
				if (page == 1)
				{
					window.location = "tab_manage_aud_mymp3.php" ;
				}
				else if (page == 2)
				{
					window.location = "tab_manage_aud_upload.php" ;
				}
			}
		</SCRIPT>
	</HEAD>
	<BODY>
		<FIELDSET>
				<LEGEND>Please Confirm</LEGEND>
				<P>Do you really want to remove song '<?php echo($r_title); ?>' ?</P>
				<INPUT TYPE="button" ONCLICK="OnYes();" VALUE=" Yes "/>&nbsp;&nbsp;<INPUT TYPE="button" ONCLICK="OnNo();" VALUE=" No "/>
		</FIELDSET>
		<BR/>
	</BODY>
</HTML>