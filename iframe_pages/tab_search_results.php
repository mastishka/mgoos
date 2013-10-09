<?php
	// Start session
	include_once("../lib/session_manager.php") ;
	include_once("../database/config.php") ;
	include_once("../database/queries.php") ;
	include_once("../database/search_helper.php") ;
	include_once("../lib/utils.php");
	
	$objDB = new CSearchHelper(CConfig::DB_AUDIO) ;
	
	$url = CUtils::curPageURL() ;
	$query_str = parse_url($url);
	parse_str($query_str["query"]) ;
	
	$feature_type = -1;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
	<HEAD>
		<TITLE> Search Results </TITLE>
		<META NAME="Generator" CONTENT="EditPlus">
		<META NAME="Author" CONTENT="">
		<META NAME="Keywords" CONTENT="">
		<META NAME="Description" CONTENT="">
		<SCRIPT SRC="../js/ajax.js" LANGUAGE="JAVASCRIPT" type="text/javascript"></SCRIPT>
		<SCRIPT SRC="../js/tb_sr_res.js" LANGUAGE="JAVASCRIPT" type="text/javascript"></SCRIPT>
		<link rel='stylesheet' href='../css/ui-lightness/ui.theme.css' type='text/css' media='all' />
		<link rel='stylesheet' href='../css/ui-lightness/jquery-ui.css' type='text/css' />
		<link rel='stylesheet' href='../css/callout.css' type='text/css' />
		<script src='../js/jquery.min.js' type='text/javascript'></script>
		<script src='../js/jquery.callout.js' type='text/javascript'></script>
		<script src='../js/ajax.js' type='text/javascript'></script>
	</HEAD>
	<BODY >
		<?php
			//Place javascript code to update parent's search result information.
			echo ("\n<SCRIPT LANGUAGE=\"JavaScript\" TYPE=\"TEXT/JAVASCRIPT\">\n") ;
			printf ("TSR.queryStr = \"%s\";\n", $qry) ;
			printf ("TSR.curPage = \"%s\";\n", $pg) ;
			printf ("TSR.ext = \"%s\";\n", $ext) ;
			printf ("TSR.strict = \"%d\";\n", $strict) ;
			echo ("TSR.CheckForParent();\n") ;
			echo ("</SCRIPT>") ;
		?>
		<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
		</script>
		<script type="text/javascript">
			_uacct = "UA-2246912-1";
			urchinTracker();
		</script>
		<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
			<TR WIDTH="100%">
				<!-- PHP code [Start]-->
				<!-- Based upon the page ID (pg=1) return results in sequence -->
				<!-- select title, album, artist, lyrics, url from [table] where [field] like %[search string (+ removed)]%-->
				<!-- PHP code [End]-->
				<TD VALIGN="TOP">
					<?php
						//print_r($HTTP_SESSION_VARS) ;
						/*if($_SESSION["LOGGED_IN"] == true)
						{
							echo("Hi Manish ".session_id()) ;
						}*/

						$recordFound = 0 ;
						if(isset($loadpop))
						{
							$feature_type = 1;
							//echo($feature_type);// all time popular has feature type = 1;
							$recordFound = $objDB->showPopular($pg, CSessionManager::GetUserId()) ;
						}
						elseif(isset($last_week_pop))
						{
							$feature_type = 3; // last week popular has feature type = 3;
							$recordFound = $objDB->showLastWeekPopular($pg, CSessionManager::GetUserId()) ;
						}
						elseif(isset($recent_uploads))
						{
							$feature_type = 4; // Recent upload has feature type = 4;
							$recordFound = $objDB->showRecentUploads($pg, CSessionManager::GetUserId()) ;
						}

						elseif (isset($browse_album))
						{
								$feature_type = 2 ; // browse album has feature type = 2
								$recordFound = $objDB->browseAlbum($pg, CSessionManager::GetUserId(),$pageno) ;
						}
						else
					 	{
							if(CSessionManager::GetUserId() == '')
							{
								$feature_type = -1 ;
							}
							
							if(isset($strict))
							{
								$strict = 1 ;
								$recordFound = $objDB->listExact($qry, $pg, $ext, CSessionManager::GetUserId()) ;
							}
							else
							{
								$strict = 0 ;
								// Now $qry will contain search string and $pg will contain page number.
								$recordFound = $objDB->showUptoTenRecords($qry, $pg, $ext, CSessionManager::GetUserId()) ;
							}
						}
					//	}

						// Update top search table.
						$objDBAna = new CQueryManager(CConfig::DB_ANALYTICS) ;
						$objDBAna->UpdateTopSearch($qry);
					?>
				</TD>
				<TD VALIGN="TOP" ALIGN="RIGHT">
					<a href="http://www.macsindore.org" target="_blank"><IMG SRC="../images/macs_banner.jpg" WIDTH="120" HEIGHT="600" BORDER="0" ALT=""></a>
					<!--Google AdSense Advertisement Code-->
					<!--
					<script type="text/javascript">
						google_ad_client = "pub-1695545090167466";
						/* 120x600, created 8/12/09 */
						google_ad_slot = "1019819769";
						google_ad_width = 120;
						google_ad_height = 600;
					</script>
					<script type="text/javascript"
						src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
					</script>
					-->
					<!--
					[AdBrite Advertisement Code]
					<script type="text/javascript">
					   var AdBrite_Title_Color = '0000FF';
					   var AdBrite_Text_Color = '000000';
					   var AdBrite_Background_Color = 'FFFFCC';
					   var AdBrite_Border_Color = 'FFCC66';
					   var AdBrite_URL_Color = '008000';
					</script>
					<script src="http://ads.adbrite.com/mb/text_group.php?sid=614789&zs=3132305f363030" type="text/javascript"></script>
					<div><a target="_top" href="http://www.adbrite.com/mb/commerce/purchase_form.php?opid=614789&afsid=1" style="font-weight:bold;font-family:Arial;font-size:13px;">Your Ad Here</a></div>
					-->
				</TD>
			</TR>
		</TABLE>
		<?php
			//Place javascript code to update parent's search result information.
			echo ("\n<SCRIPT LANGUAGE=\"JavaScript\" TYPE=\"TEXT/JAVASCRIPT\">\n") ;
			printf ("TSR.recordFound = \"%s\";\n", $recordFound) ;
			printf ("TSR.feature_type = \"%d\";\n", $feature_type) ;
			printf ("TSR.url = \"iframe_pages/tab_search_results.php\";\n");
			echo ("TSR.UpdateResults();\n") ;
			echo ("</SCRIPT>") ;
		?>
	</BODY>
</HTML>