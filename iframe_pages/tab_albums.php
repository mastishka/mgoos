<?php
	// Start session
	include_once("../lib/session_manager.php") ;
	include_once("../lib/mgoos_config.php") ;
	include_once("../lib/utils.php") ;
					
	$url = CUtils::curPageURL() ;
	$query_str = parse_url($url);
	
	if(array_key_exists("query",$query_str))
	{
		parse_str($query_str["query"]) ;
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
	<HEAD>
		<TITLE>Album</TITLE>
		<LINK REL="stylesheet" TYPE="text/css" HREF="./css/mgoos.css" />
		<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
		<script type="text/javascript">
			function GetAlphabet()
			{
				<?php printf("return '%s' ;", $alb_strt) ; ?>
			}
		</script>
	</HEAD>
	<BODY>
		<script type="text/javascript">
			var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
			document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
			</script>
			<script type="text/javascript">
			try {
			var pageTracker = _gat._getTracker("UA-2246912-10");
			pageTracker._trackPageview();
			} catch(err) {}
		</script>
		
		<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
			<TR ALIGN="CENTER">
				<TD>
					<?php
						include_once("../database/queries.php") ;
						include_once("../database/config.php") ;
						
						$objQM = new CQueryManager(CConfig::DB_AUDIO) ;
						$objQM->ListAlphabet($alb_strt, 3, true) ;
					?>
				</TD>
			</TR>
		</TABLE>
	</BODY>
</HTML>
